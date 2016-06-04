<?php

namespace PaymentProcessor\Model\Gateway\Processor;

use PaymentProcessor\Model\Gateway\Processor\Ws\PagoEfectivo;
use PaymentProcessor\Model\Gateway\Processor\Base\AbstractProcessor;
use PaymentProcessor\Model\Gateway\Processor\Ws\PagoEfectivo\Solicitud;
use Orden\Model\Repository\OrdenRepository;
use Util\Model\Service\ErrorService;

class PagoEfectivoProcessor extends AbstractProcessor
{
    const ALIAS = 'PE';    
    
    public function __construct($serviceLocator)
    {
        parent::__construct($serviceLocator);
        
        $config = $this->getServiceLocator()->get('config');
        $wsConfig = $config['app']['paymentProcessor']['pagoEfectivo'];
        $this->wsConfig = $wsConfig;
                                
        $this->ws = new PagoEfectivo($wsConfig);
    }
    
    public function createCharge($data) 
    {
        $return = array(
            'success' => true,            
        );
        
        //Creación de la solicitud        
        $xml = $this->getSolicitud($data);
                        
        try {            
            //Obtención del valor del Cip                                    
            $paymentResponse = $this->ws->solicitarPago($xml);
            $estado = (string) $paymentResponse->Estado;
            if ($estado == '1') {
                $return['data'] = array(
                    'status' => OrdenRepository::PAGO_ESTADO_NUEVO,
                    'token' => (string) $paymentResponse->Token,
                    'cip' => (string) $paymentResponse->CIP->NumeroOrdenPago,
                    'reference' => (string) $paymentResponse->CIP->IdOrdenPago,
                    'clientReference' => (string) $paymentResponse->CodTrans,
                    'redirect' => $this->wsConfig['baseUrl'] . $this->wsConfig['wsgenpago'] . '?token='
                        . (string) $paymentResponse->Token
                );
            } else {
                $return['success'] = false;
                $return['error']['code'] = 900;
                $return['error']['message'] = (string) $paymentResponse->Mensaje;
            }
        } catch (\Exception $e) {
            $return['success'] = false;
            $return['error']['code'] = ErrorService::GENERAL_CODE;
            $return['error']['message'] = $e->getMessage();
            $return['error']['detail'] = $e->getTraceAsString();
        }

        $requestHistorialData = array(
            'ordenId' => $data['id'],
            'method' => self::METHOD_CREATECHARGE,
            'reference' => !empty($return['data']['reference']) ? $return['data']['reference'] : null,
        );

        $this->saveResquestHistorial($requestHistorialData);
                
        return $return; 
    }
    
    public function processCallback($params)
    {
        $return = array(
            'success' => true,            
        );

        $cDate = date('Y-m-d H:i:s');

        if (!empty($params['data']) && !empty($params['version']) 
            && $params['version'] == 2) {
            
            $data = $params['data'];
            
            try {
                //desencriptar la data y darle formato
                $solData = simplexml_load_string($this->ws->desencriptarData($data));

                $return['data']['clientReference'] = (string) $solData->CodTrans;
                //Según el estado de la solicitud  Procesar
                Switch ($solData->Estado) {
                    case 592:                        
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_EXTORNADO;
                        $return['error']['erroCode'] = 592;
                        $return['error']['errorDescription'] = 'El CIP fué extornado, el banco realizó reversa de Pago';
                        break;
                    case 593: //Cip Pagado
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_PAGADO;
                        break;
                    case 595://Cip Vencido
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_EXPIRADO;
                        $return['error']['erroCode'] = 595;
                        $return['error']['errorDescription'] = 'Sobrepasó el tiempo de expiración';
                    default:
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_ERROR;
                        $return['error']['erroCode'] = 900;
                        $return['error']['errorDescription'] = ErrorService::GENERAL_CODE;
                }
                // 31/12/2016 17:00:00
                // date_format(date_create_from_format("d/m/Y H:i:s",$tempData['fechayhora_tx']), 'Y-m-d H:i:s'),
                $return['data']['cip'] = (string) $solData->CIP->NumeroOrdenPago;
                $return['data']['reference'] = (string) $solData->CIP->IdOrdenPago;
                $return['data']['confirmationDate'] = $cDate;

                
            } catch (\Exception $e) {
                $return['success'] = false;
                $return['error']['code'] = ErrorService::GENERAL_CODE;
                $return['error']['message'] = $e->getMessage();
                $return['error']['detail'] = $e->getTraceAsString();
            }
        } else {
            $return['success'] = false;
            $return['error']['code'] = ErrorService::GENERAL_CODE;
            $return['error']['message'] = ErrorService::GENERAL_MESSAGE;
        }

        $requestHistorialData = array(
            'method' => self::METHOD_PROCESSCALLBACK,
            'reference' => !empty($return['data']['reference']) ? $return['data']['reference'] : null,
        );

        $this->saveResquestHistorial($requestHistorialData);
        
        return $return;
    }
    
    public function getSolicitud($data)
    {
        $options = $this->ws->getOptions();
        $expirationDays = $this->wsConfig['cipExpiracionDias'];

        $cDate = date('Y-m-d H:i:s');
        $expirationDate = date('d/m/Y H:i:s', strtotime($cDate. " + $expirationDays days"));
        
        $solicitud = new Solicitud();                        
        $solicitud->addContenido(array(
                'IdMoneda' => 1,
                'Total' => $data['monto'],
                    'MetodosPago' => $options['medioPago'],
                    'CodServicio' => $options['apiKey'],
                    'Codtransaccion' => $data['id'],
                    'EmailComercio' => $options['mailAdmin'],
                    'FechaAExpirar' => $expirationDate,
                    'UsuarioId' => $data['usuario_id'],
                    'DataAdicional' => !empty($data['data_adicional']) ? $data['data_adicional'] : '',
                    'UsuarioNombre' => $data['perfilpago_nombres'],
                    'UsuarioApellidos' => $data['perfilpago_paterno'] . ' ' . $data['perfilpago_materno'],
                    'UsuarioLocalidad' => 'LIMA',
                    'UsuarioProvincia' => 'LIMA',
                    'UsuarioPais' => 'PERU',
                    'UsuarioAlias' => $data['perfilpago_nombres'],
                    'UsuarioTipoDoc' => $data['documento_tipo'],
                    'UsuarioNumeroDoc' => $data['documento_numero'],
                    'UsuarioEmail' => $data['usuario_email'],
                    'ConceptoPago' => $this->wsConfig['conceptoPago'] . ': ' . $data['id'],
            ));
        
        $solicitud->addDetalle(
            array(array(
                'Cod_Origen' => 'CT',
                'TipoOrigen' => 'TO',
                'ConceptoPago' => $this->wsConfig['conceptoPago'] . ': ' . $data['id'],
                'Importe' => $data['monto'])
            ));
        
        return $solicitud;        
    }

    private function getTestData()
    {
        $params = array(
            //PAGADO
            'data' => '9430D881CD7CA1AB5AE02098328ABBF1B45118A6D3A7D1805137F54B70036F48D7FC5B755E80AC4C772EAECBB0CEF574F3D23C9B67BD247C33ABFBB88E1B50CF85F0AB0B333724FBFEC068BCA52B0D09F51216F5334726F333DF9BA7E96615131706AD08A7FAA94E1FE754DF7C51B3ADF79F86E8CCE27D1DBDF4A16CDB02CCA3C265A6FF275B4E4E93ED97BE82536B607F2819578C968C1E6058FD088255C8692B175A3F9B7F8D5EA3D1DA0C553BED6F2545A4131C3A762B15C0E29FD0D02E5771D11BA769F41C0DDCD81FA83C0ACA0C1255853CC5EC193B1F8F6B45D5A5738123CD1C551AA151CBE34384F2E48CFCC0B66C5C1C57D59958D115632FC888E5CD8CF7B0369F8669D36B6874E172F71915AE5892DD21919EEB7BB45E39B1E911E3369E5891DF48D4EBA4E04B7B3D314607A4CFB4E3CAD6BEF256D40141CAEF910A90161932D537B880A3570C2EE975A4A5FF82994388FE237766F0179ECB1C64D93C07DBE0DD7F77979200D6F26E20649F7E7A1D8E85076923C265A6FF275B4E4E6B227547863EF1527428274635AF18C1AA680F98CAD0FE50B8561380DF11FF57A4ED40B8697731F49AFD45B5C339820147B78097A6DD0D9690F75560DD6F0F9E477B0694D5A537751964B7CB470A2835F6558275881467CE116A2FBCF17FA65B72439BFCD9703EBF4D7B7FA9D8F711F562ED56DA211EF7BF72439BFCD9703EBFC429B9DC497B973B7C416A4947CAF4EE2FE65D15042D9340076A2EE3AF50C6FFC265A6FF275B4E4E178758BCC83C6F11A49B70119C8A011769D92EBB16966CA7F65603B4C0ACC081C265A6FF275B4E4E416A943EE01652E0174D0140FC3B0F8A14302E919829694DC44B204965B56147031ABEEF8CDBB7197BCC5AFEDDBBE1AF2457CB7473E9914E7732715C835FC83419D7FED28D4D21207066E55D11C7C0BD49F33298156ED94E74D063D85F20EE441621A761B7744AA01F6334ECEC04DCCB0B16003A73811253D58A621A0EC56205C2CD6B3258F3DC87C265A6FF275B4E4E87710197245D9DA709F85AF8E0773B669FB488CFA51A8351DD3654D40E9967E35C12778A593B16579FF6E16DD2828C4702CFFCC379B37715E0BA008DF1E3AF3A9B22A4347F03F8934D30DBAAFB6F11F86183894A683447221097F4FDB8BA86FC59DEAF52A470B5C6ECD460D3147F56C98C30F6CDEA87802B6183894A6834472275B8503D5EB75CCBFE00E8BC59670D4E14F35D44936E3E4C7A999B0FADD98C5A188C2826609F6856A7CE82EA4DD6B043642700EC5A4DB720C881314D276E13AE75B8503D5EB75CCB931D4701A747BDAEAF893744E6137A6AA1384CDE5483DB70931D4701A747BDAEAF893744E6137A6AA32B2851E969004AB12E3A25D3902EC674D063D85F20EE4474920FAADE3898408D09B667B4DFAF7275B8503D5EB75CCBD80E0631ACAD00150D1889E10BF6C6A0DF3ACDA7C0B225BBB6C6550B6521A67A74D063D85F20EE44E2605E28B6A2F1D3FB1587603BD9291D6483D2473EEF3C7C0CAF847713707C6DF78CC61CA091555EB814CAA709CE1CBA02BF1A89424DF089039922D773F095D7A06D18A5B0633B75D9634C7D28D1797F7CC7ADAB8A535A6102BF1A89424DF089039922D773F095D762644C8791498C6FC396F48C1BFE11553B82CC728378C852BA095B5457EC5CB3C70317E452024A190D1889E10BF6C6A0E14AC140ADAC156C20AEC6D7439DBC163AEBCD1973759A7CA37BBD8390F7B44467B80CF4DAF8B000D5C75CA95C1F6AD4B8D62637F2BD24614DC9F217DBA979E7E0C2A813CA477A8F045497E3E974BA479A484E9BB4AF695A0D0891E12CC79D7510FE1CFB1F9837680E577944DA9AFC3EBB5E7895EC43DBD274D063D85F20EE44FCD50D1C49D9ACFDC93EBB399BE706C8BF3D9F9590458136C336276DE100A92A73F6FBB618F7A6783490A1736F874F1C6FF7B021A86CD7631366FE24946C0D8934CE741011D896884065726B8FD7BF2365DB1132956A5DAC94D6B78F43A1910FC11D8AAC353C7FAD84882F415ED585B615051B33A617EAA3EF6500F79A77A0FFBF3D9F959045813607F539FF1D827F6A9F8EEA95AAC93BFEFEFF5DF3E21CECF0C5092C817E976D4D07F539FF1D827F6A648CD6AAB86CEC03E0C2A813CA477A8F890CB2C46196176DBA0133BAD8D542954821B4ECF7C563863D1FB75C1CBEB86B0D0891E12CC79D75890CB2C46196176DBF3D9F9590458136B12EF6BB41C12D8DA16A946CE89449F9873B3A3DF681936105AC1502632B0371A8EF143FFE2B69A3DE512E7AC942A3E87DFC2E6614A819902C35D20C60B0AD38D025B0AFD2D95DFF1F36EF72B4CBE59D9A054534AF69F7C1450976216E6E18E34065726B8FD7BF233F0CF76EC5E777D91A0176A74EDA491EBA2D1416FFAB9B5967D582836843E0C49009C680C41AFFF966F0179ECB1C64D975042A6B7E21A9FCC11CB92F00B74F0CC39395469AF0FE0267D582836843E0C4C11CB92F00B74F0C5C8EE96FA54DD3470551D77A1C1B2F515C8EE96FA54DD3476A436782B9A9B9DE46387327974C4EFCD97F008E77D2958BF6558275881467CE8E8F272D92AB5046EBD6A8650EF659B2129262ABBF3339A7067DDD7CF6835A14184546A6E917AB70F1776591F80FECBDF56452952D300905AD559EFCE041257C2D83CD074F3BC0E0273550E080C73D8CED1B6651157C66D9C31025AE6B588D7119FDAF93FE3EBF2E293CA12E9339376020F8C99295EB3D4B8428AB8C2043BFF9F9108DAE500EA2F374D063D85F20EE44207B6AF881D3DF2C37C6001B39DD2187F2C06DD46AD5EC05F1973F0E56F1C63CB9BAF45E219B05FAF8377FC5BF02069461FA66D6018DCAC5286821C24099A5B4918A371153EF8D984E01AEECB3BBDE054D78B76A4F41F787E7E5B3097BDDF20BD47C94C834CEA8DDEFE460369578796862933BF15241ABF214266DBC9923737674D063D85F20EE44F8D6FE09E8B1E625B5114285B0BD51B697B328EA67611E9F4046CB8EF46DF0FB45986C92789D8DE54046CB8EF46DF0FBE2572523E270909DB5114285B0BD51B6A9CCE889A896AFC533DD328CA27ED5657F2FBD21C961164536B2A4754B2602D6EBC8947E325644576420695E7C3B44614032E12FB4B0EE0B|266FB63EA028B5336CAAAB857C67288022FCB30E152AFADEF97AEE88E1A0EF1DC661A9E8BAC09DFBAD154EED35115E7A2F12D30D7F1A082638EFF0D8E7E626618EF19E7B35617D45CF2FAFDFF543EF8029943281593CAC11520DB6EC5CA839567CC9592FDA6515EC4DCE36FB36480B3FB7D5CD9EB36519653741CBD19BD1085423171C50D2DB20879F5C2108675E42B8982E944E4F5574C8DA176F55B61FDD54BE94244FAD59016E0B56BDD93CEC6D575FCAE8DF104C75F107C2FADEF1FE388D503C1CB0B37413D31F1599DBEC04AC9D4979FF1C163DA37715D1D23E03F3F72976F9BC18DC702277AEE6E56C13BA6171C663B9650ECB0FBE77CBCE66805E3497',
            'version' => 2
        );

        //EXTORNO
        //$params['data'] = '1CFDB4338790A53753B6F246E0CBB4736268242AAFC2A2A0822595A9A452B232593792D33D323959E20FD0CA1AD06A5719838D3DE6BC9A94560EA871430B678BB366381D50A3B4250654B16147847846F23625F5A5ECE5448286C59825720133FD71E24C1C47DCAB4AB2988654D49836D32FD34593138E60A4B475651A834B979D825CB5513916C53900E9CCD42471FDEFE3DC27796E4A6D8C8F33905653C2F0F721340EBD1957F9762E31E1E420A73702FE5356D9827367F8D885AAE9C835864CF74F53F0C8B13513FB4766E0C98C6392A0AD0AC1B7D330EEB681E5C0C9E79B934558EC2ED6CBC3708B403750D4CB4DE7048CE880CE1D133F2CF8B1F1C485D59A164904696AC7BD65820418CCBEB0279B4E7C6C8820273E7EBAA73BDBBB5FC10A341D5C8AE2BB55F20E6EE7BAEE73A3E0DBF8AB7B32F0CEE0411AB62A866F92688CF129494D58B3690E023C7A8BE04A0C724115967F81DFB95E80EB35454F890F19F2F4BAF9C16AF02A8F79815AECFCCBB34E254291E5A09D825CB5513916C5E29AB1F681A9F542A6A26DB63D0B6F477907EF62770DE60603129A9B2BD90B5A52547D3BDA0EDDDCE2DF0E7FDCB0012C44DABA4E7F52ECD7849236CD3CA5FF2C8DB20D96192F84E327983D1C2000AD02E813A3A57299DDEB91D63C436792B5FC7148382A49BA4DF316F9CCC96A9BCB190217FCDE68DC9ECB7148382A49BA4DF3B95C169C9C71756E7583EE75C91CD660D3C2EABED58DC68C831F50C82FEFC1139D825CB5513916C5BFC06AB882B3069A040AC13242DDEDD9648F2C31D28311B848390709E3C2A68C9D825CB5513916C509D221D37280AB744B78C5065D676FBC1ACA6C701C53830C006CDAC6C73ABC76582811F71F87C1D2BB9E77730E765C59704E9CDF1A95A227E452ABBC6FEDE0068A0D8382C2F63108F7FC40EF6DAC13925E19E913844A548AA1A395BB9661E35DFD7A2C04D180DD4685A542193ACCCD02C128598649FC296C14FDE130A435E3260499F0A5DE79B1219D825CB5513916C58DAC804224B41CE41E939EF3B6DEE6B3762711C7AE5C3697B13BAF974AF528D49C46879F9B475FE671B9CF8A78F4ADD7785FCC6FEBC0295AC3B34F62CC17DF20221EE5D71947DDB364C7B56B39B8B7423B25D59F3A6CCB6D9A9D4F7CEC9EE4E0C2024F291C58FCC59289583C602709B5B12B4F88354CDBA73B25D59F3A6CCB6D28294E320E355BB3E677C78BE4770C51C2CE957CE3F1BBB60C724115967F81DFE9114A13F3FBF69362DDC58C41F800E2483A4F8A950833742958ABD14E62A9649D825CB5513916C5E6D8518BD074A7ED2958ABD14E62A9649D825CB5513916C5D239D9F5EE2662E207FDDC775F1A2FFF9A9D4F7CEC9EE4E0BC1F814B58CA9FB4216AD1AAC800791CE9E4058EF69E33EA07FDDC775F1A2FFF28294E320E355BB3EDD99168B194B89F62DDC58C41F800E2CC6522017557F2B153B9A2706B23E335A1A395BB9661E35DFB483CC07322C1D947E9095238E132B4DD9E486095E52D8EF1B49646B38AF566AABE09078DFBB7A4213F03A5BD0143C907E5E722DBD3DF4B99DD43884EF564C677DB611DD2EBE56B6EC8DB08F21F8F58D5E4E470EBBC3B3C07E5E722DBD3DF4B99DD43884EF564C69232A6211783CB32D654C4247D24EB55C2CE957CE3F1BBB673E9C8BEE93BCE4FEFD57CC6CA5624B662DDC58C41F800E2226020A7282CCC2E9112239D434A1CA4350AA24403DE0152E5D7EF84A3EF664DD29F4F530E9806C1FAC6151FE12B0DFC530837793E44A497E36D0ACB662A7890353A9E9E1C2C3290479D2A0B9D58CECA3D23010F1F841C7DE02905C5B0E0D6F2E37D68A4A436E3A2C0AD470DB13637CCA97979DE46DF909DA1A395BB9661E35DA0A8B671288A50917951F56E6E7961C7D9F27B1F5F65013D8F27BF1E81CAD187CF7F2F02435774CA03108DB4B516CC36404810B97019F384780927F0D434942B73B5FEA68AB3DD41F71B7BB164DA10BB645D7A2602A581FE994ACA9E5449F1804E34B8FD4B4E2E70884E4296649428BBF8B8023CB0C7B4EC624DB59ED55B2633D9F27B1F5F65013D02D2418F61129F8DCD292D10A013361CEE6D31BA82B19DABE58AC3C6BB51E13E02D2418F61129F8D7965B3623368C19D353A9E9E1C2C329069F001DB54EC67DD019E4E9254D77150CD56B8A32EE47CDF9E1DA00ADAE6B776E02905C5B0E0D6F269F001DB54EC67DDD9F27B1F5F65013D383ED3605B57D63A90A79D12EFBC5EB9AD7E52DD07591F436A322E5A4F70455F93FEAB709EDC5E6285EBF1CB1656619257A18448999ADF89276723789E58639DE9062DC9C971B4918D7146DE1D2D51EF91D99D41DB27BC9D54758E9A57734911F71B7BB164DA10BBB99A42BA1238C1C6C91AC5E18A2A8E7250A6653057372274444A0E2E86FA54C4B85A42D93F91893DB95E80EB35454F89CFCD5E5ED637F4F9CB5779457AB9394FBD313B3354E695C3444A0E2E86FA54C4CB5779457AB9394F8B5E5EB23A788868C6BC0381EA3FA9808B5E5EB23A788868B9F6248D27097292FCEC3DCA5EACBEA4F3886DB3B66988EFE813A3A57299DDEBEC0B39D833C62376076575E0AF3DB447D87D1F30325C658451D4ED3BE3A8707F0D1066FD854B440236FABD149E8C3509DB052E36FBE60F81ECD89C9F3F4E18A2D6F8B1569FC6913B6E343294A41D99ED3AEBB7B23B90FDFADAB6E58018BF40EED3DC027C60ECD318A5C219AB0C5686B51F23C7A404E643A7F4E456D9A9D1C9360D18A77FADA0FE4AA1A395BB9661E35DA82A6EEBF0A77DAEC6C200C478125986EBE8ACD71FA96DFA2113DE27C7643DBC8E542FA22B89E7B2A3F3D669BEE6218826EE89675EEF7990A7B2CA1A25B69D58D52C68EA52B063AE8F3877596ED55A9B4565B29E582C51C21303DB1AF05CE6A6430586221B7C88ED116CCD7A4AE3EE2AE772337C7BD26B449A287B8C41EC2BF1A1A395BB9661E35D53085456C569FEA0EA23B03715042BB7E87A9B72466B3E5172989C66BA1983EF662F86F3F68C00D372989C66BA1983EFC9AAC032A4F4785DEA23B03715042BB72923CCE88CBDA2C3BEA4987730A9240D0BB4FDB69A2ADD784D7FFA278FB1FBD1107EF5848970CE0C2B5F5A3E8EF269CB20F99D247B84474E|A205E81FC7025CCFB3787D359BFA792A0817AD21F5854983EE1653CBFB1965F8EF45EF90F31E75619B73223F0D1B6E6733B1B1E0EC8904FF7429284BBC940D41C909E0CEF9ABCADBB5EC188B5DD9A3CD47E62CCA9D19104A7486CA55305C80E3EE0C5BDE5FE67ECA99BC826427665A9B04D0B3D8BCF85525D388C0B29607A8D509A0137C96900837584E6EEC9BC8BD6119A2152D07FA156FCD629C1D0AE04061FAD3A6CD69227D1F3DD63FD89F79E69DE75ECFA3759A48879EDBA9FF792F60552ABE804830CD28219BD4B596B844393F27BD19AD53B51F917C1BC84B0BB8F1CBD6CAA9D85239D8617B19694D1B71F15AFCC2748F2C321E926CA990FF0A922B18';

        //EXPIRADO
        //$params['data'] = '04BD3AFDC1D87C290DB72F5FD6AE396B2B88D98236CAA3100CC1E8203F0D6A84E475BCBE1DB8DC05CB4BEEB4E8F88AA905A9BFF779C3D5C1B2350EA4DA7AF96C002B9E207AE4B3629D2907CAFF0CD49939461BD4C13DAE09894D2C893F4309A66E9099C3FCE4CD135082409BAAE97624A430CD97429F7467375300D7C7B9B8037C027B9E0BA3BB7D0752961BAF2E672F3A70AF8A0DA54F7306293D7E59692D2195C8A44178D7810A0F89D93201ADD75A0E33B3B1006750F8AEF41471E69510C7D42341DD80E807D36AD013E2501C1E7F3BB922A35B5CED720D4425A5D602E2CCB8BC1EE7E1AE11A43FE500B0642DD128D59014E9ABDD9678F7B9F33953337F869A5C278B061961BDB363D827C2F03AE044D2AA39720E47C7E210D715DE5495132B11617326C745BA5788EF6D973F43B18B824ACF3E1A46EF10E367CAC72A5BEA0F5868B649B55038DD43EFA579FE6F1CB662ABE033BCE14050A2E0EB025EE81537FD1DA05D08CD021D90FBC0F9F989999F644B2C8B55FEED7C027B9E0BA3BB7D6F03248E57CE323512AC47B6BD8C8ED776D8B5B3CBED4D461AB6F7135576A4E2CED18FFEDA49A6F37750C7CDA298DE41DD5C581833184016D7CA78E5FD075CCD56AAA0AA8D516E15E2159BE7B23DCE81947AF965002D45E46FEBD1BDD9A29367D308DCF99CAB4AACE0C7CA0051B967D761CED10DBBA417C6D308DCF99CAB4AAC9C28D9375E4C18EE1A7F267FB88B4032D406DCDF85F9FC69817F538F7BD5B37C7C027B9E0BA3BB7DBD161A97A01923CB66C28626BADED6427F01335160FE340D3F3466A3A71DC2FD7C027B9E0BA3BB7DB668C1CF85E18B2435C877B25517C83B80096D2D2F1E04C5D98682C6AFF5AAC123F62F67F1D03A871822A74F4ACEE9FBCC26FEC6F81EFDF7E20AEE76D869E3889BF39AFEF708EBE965B7B81A0E9C54CC0E7F310378FD2BD656D744BCB89DB4F9D3F5D25738EDDA44D6B96EE8DE7CC9550BD3DD1A2A95397805A0A5D3DBA169A0FA042F9908719E107C027B9E0BA3BB7D1610D05E3DAD17423A5DC4FBCEA162DC34047A761984AB2288F770F5BBDCAFCBF951F0974C5560151E457AA100763BA6EEB634C4072077DDE6B9490F1815248633549000A1CE05A6EB8B33FC32CB2C7A3CC75CC5E2DD2FA887D43EF36BA06D93FACA8CA2920546277F64013E1E37B728100B98BD9936375F3CC75CC5E2DD2FA862EF029735ADB348B45068CA6186A719F3332A6AD8C4BF59B662ABE033BCE140E594EB902111B4005723AB37BE4674D074B62363FD415F31A4D0AAF73FBA2EEE7C027B9E0BA3BB7D3CADF93D025C58D7A4D0AAF73FBA2EEE7C027B9E0BA3BB7D4CA2BFAAB64E34C48E72175F36CCF005496029B3B453249B602683F7C586C11F5723AB37BE4674D0AC9668E4F90054A61DB9CFD12BF13D3F257D6FF893D83FE73AE3C5B0D366CC5B3D631F81BFA0404BC095B8F3485B644004AABE537EBF5EEB56D744BCB89DB4F9162D3A1CAF8887FF66D9B16F20D368F816727D6FA84FDBA037C087A9B49AB741609A052A8931C621B0A431EADFA8E4BCA98B1121A1673577BC81D3631AE4AEC470BEB072DCE93F8DAF93729F52D685A33CD1C738D9AEB987A98B1121A1673577BC81D3631AE4AEC4C9873C3DB9ADC349825F8DCB4E6E633BF3332A6AD8C4BF5947D4FAABC72F7FA21D6804DB16E7FDFD5723AB37BE4674D0E90DFF32F660DD5F7483E62BE6A7BD8E923CEF424688C036DF106421D89D8CD82A7530EF54F1CAE606A23E2419D219F760E5ABF6B4315ACF17C3F31A15A38698E05C8A03BB3E6EF7F82C36CFEB49F2BBD838623FBBD0B33B4AAC22AA0726C1712F8C28AF1E1EE33A2EDE9EB9B52126E8F39845F9868BFEFC56D744BCB89DB4F9A422DA623BE42CB7B35A0CFAF4CB3FADB8C72840E5B3AE2D21597B8F57311A17FEEC186D2A37950281AB795965BFE36465C62B7C544D478D4969ED8BBDCF65E1CA465749DA50756198EF5982A32FECC3184910DAFA4030B9FEA5AC839419FC35A81BE87316E0BD79A9A5652FAB85BB238DC356C84269B936058410A04C1F367BB8C72840E5B3AE2D4A2EC82ED0F28AA81C471152343A5ACAFBDC78925C69E080DD229A8F0C90D9264A2EC82ED0F28AA818D1334DEB30A99EE05C8A03BB3E6EF79315D37461AC9E5878D37EF1C0C847CE4B19463E058E5D33F8B1CF261E5467814AAC22AA0726C1719315D37461AC9E58B8C72840E5B3AE2DFBE548B0EF42087A882FB8DB843C10BBBAEC30CAE5707285727A1580C6306BBF26FF87A4DCD2D73BB61D62CE76215DCCA2261F0EC1DDD798B8F9241B400BC22D2325167E92D444E4EC516693647D6952E619E1BDBD0DFC54F6EB5016AFCDCD0198EF5982A32FECC3BDB307AD9E35CEF98F93D057BC705D1B5957F227D3FFAA29AB6D415588853EA6F0F0AD5F8394AFB250A2E0EB025EE815A5B41338AE621B6B0F522CBD3D70C491BE06C95B751AC115AB6D415588853EA60F522CBD3D70C491E604EC14A29F0BE08CDBDB42D0CC8FD1E604EC14A29F0BE0EA12D5425E1E2149F0F5D0D4EE50EA4F4181597289A8E453947AF965002D45E46AFDDF2281D779CF2C7680AD897A73A096192F7AEC66954F235890E247081F9E6AF3B43D9CB83E11F1110E23A15AF5434E38A864D3E0D1FB75352B2CFC97710B59C833F9E18D3FE3F442A102167E368342A7C2F0F8C59114F5DBFBE50A65A3E904395985EB413BA318995797EB8FD0C01FB88993CB6B929741E3C2489E6B549D1D4B0BCD0878987456D744BCB89DB4F924CD72234869A62D5D88BB98981B5EEC18EB9F0C4A526AC2C3FCB90B09A3152EBC0E73A6715F2F8910119FDF441C4D0F17354933FF50199BC44616860A3D10AC6F5E206EE58540F86201C415E47201B865D7CCE92128C0398260F3CFA940512C6E7B0EFA132B2153AB0A4B224FA9E5635ECC3521693F114AA87B3BD330F0E22256D744BCB89DB4F9D27FC866812427ACD5447A04DBEFF855F0EDAA00FF162AD2B631164DF1FDDE379C211D3CE12BDA5EB631164DF1FDDE376887DB96EE06ADE7D5447A04DBEFF855075FF5CE535B8FE7FB81A9D54C3C7B6F2BB4B1AE72C9F748FE3D43B0D64DF95002A4B35E8AB9C24A0B7D249FDD8B8E41466E5EE38D8C88DE|552692270E5AD63C779D3876526A5C58A318AFBD6FA1651E27F7D48C45C491C0E58F55E406AF823AC6D8FE3C7CD3064E3CAF0CC638D870BB7DBA90525281DD484EC6A946C2F2DB4035487010CF6271CDDA61DDFB64C794BB0D5D076FD85051CBA1CF5DFC9FFCB12D0EAC351528BBBFF64A981738923FB2DD179729786B57B560C5C8DDCD2B646F5D3D70BBF53173E067C724BEC82ECD5EB5BFCA5E43A2DF029958D64449107462E3ACB714EE1AEA5D98C3160B0370045BA96060AECC39B92E32989B2DD4E74CAD7FA5A92F55D369E847E2A24AB648B0DB3A0F394478AA567089B17E703FC385791853F2485C67B1AE8A44062FCBEA5A1362F420DE457C4E7BF0';

        return $params;
    }

}