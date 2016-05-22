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
                    'status' => OrdenRepository::PAGO_ESTADO_PENDIENTE,
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

        $params = array(
            'data' => '9430D881CD7CA1AB5AE02098328ABBF1B45118A6D3A7D1805137F54B70036F48D7FC5B755E80AC4C772EAECBB0CEF574F3D23C9B67BD247C33ABFBB88E1B50CF85F0AB0B333724FBFEC068BCA52B0D09F51216F5334726F333DF9BA7E96615131706AD08A7FAA94E1FE754DF7C51B3ADF79F86E8CCE27D1DBDF4A16CDB02CCA3C265A6FF275B4E4E93ED97BE82536B607F2819578C968C1E6058FD088255C8692B175A3F9B7F8D5EA3D1DA0C553BED6F2545A4131C3A762B15C0E29FD0D02E5771D11BA769F41C0DDCD81FA83C0ACA0C1255853CC5EC193B1F8F6B45D5A5738123CD1C551AA151CBE34384F2E48CFCC0B66C5C1C57D59958D115632FC888E5CD8CF7B0369F8669D36B6874E172F71915AE5892DD21919EEB7BB45E39B1E911E3369E5891DF48D4EBA4E04B7B3D314607A4CFB4E3CAD6BEF256D40141CAEF910A90161932D537B880A3570C2EE975A4A5FF82994388FE237766F0179ECB1C64D93C07DBE0DD7F77979200D6F26E20649F7E7A1D8E85076923C265A6FF275B4E4E6B227547863EF1527428274635AF18C1AA680F98CAD0FE50B8561380DF11FF57A4ED40B8697731F49AFD45B5C339820147B78097A6DD0D9690F75560DD6F0F9E477B0694D5A537751964B7CB470A2835F6558275881467CE116A2FBCF17FA65B72439BFCD9703EBF4D7B7FA9D8F711F562ED56DA211EF7BF72439BFCD9703EBFC429B9DC497B973B7C416A4947CAF4EE2FE65D15042D9340076A2EE3AF50C6FFC265A6FF275B4E4E178758BCC83C6F11A49B70119C8A011769D92EBB16966CA7F65603B4C0ACC081C265A6FF275B4E4E416A943EE01652E0174D0140FC3B0F8A14302E919829694DC44B204965B56147031ABEEF8CDBB7197BCC5AFEDDBBE1AF2457CB7473E9914E7732715C835FC83419D7FED28D4D21207066E55D11C7C0BD49F33298156ED94E74D063D85F20EE441621A761B7744AA01F6334ECEC04DCCB0B16003A73811253D58A621A0EC56205C2CD6B3258F3DC87C265A6FF275B4E4E87710197245D9DA709F85AF8E0773B669FB488CFA51A8351DD3654D40E9967E35C12778A593B16579FF6E16DD2828C4702CFFCC379B37715E0BA008DF1E3AF3A9B22A4347F03F8934D30DBAAFB6F11F86183894A683447221097F4FDB8BA86FC59DEAF52A470B5C6ECD460D3147F56C98C30F6CDEA87802B6183894A6834472275B8503D5EB75CCBFE00E8BC59670D4E14F35D44936E3E4C7A999B0FADD98C5A188C2826609F6856A7CE82EA4DD6B043642700EC5A4DB720C881314D276E13AE75B8503D5EB75CCB931D4701A747BDAEAF893744E6137A6AA1384CDE5483DB70931D4701A747BDAEAF893744E6137A6AA32B2851E969004AB12E3A25D3902EC674D063D85F20EE4474920FAADE3898408D09B667B4DFAF7275B8503D5EB75CCBD80E0631ACAD00150D1889E10BF6C6A0DF3ACDA7C0B225BBB6C6550B6521A67A74D063D85F20EE44E2605E28B6A2F1D3FB1587603BD9291D6483D2473EEF3C7C0CAF847713707C6DF78CC61CA091555EB814CAA709CE1CBA02BF1A89424DF089039922D773F095D7A06D18A5B0633B75D9634C7D28D1797F7CC7ADAB8A535A6102BF1A89424DF089039922D773F095D762644C8791498C6FC396F48C1BFE11553B82CC728378C852BA095B5457EC5CB3C70317E452024A190D1889E10BF6C6A0E14AC140ADAC156C20AEC6D7439DBC163AEBCD1973759A7CA37BBD8390F7B44467B80CF4DAF8B000D5C75CA95C1F6AD4B8D62637F2BD24614DC9F217DBA979E7E0C2A813CA477A8F045497E3E974BA479A484E9BB4AF695A0D0891E12CC79D7510FE1CFB1F9837680E577944DA9AFC3EBB5E7895EC43DBD274D063D85F20EE44FCD50D1C49D9ACFDC93EBB399BE706C8BF3D9F9590458136C336276DE100A92A73F6FBB618F7A6783490A1736F874F1C6FF7B021A86CD7631366FE24946C0D8934CE741011D896884065726B8FD7BF2365DB1132956A5DAC94D6B78F43A1910FC11D8AAC353C7FAD84882F415ED585B615051B33A617EAA3EF6500F79A77A0FFBF3D9F959045813607F539FF1D827F6A9F8EEA95AAC93BFEFEFF5DF3E21CECF0C5092C817E976D4D07F539FF1D827F6A648CD6AAB86CEC03E0C2A813CA477A8F890CB2C46196176DBA0133BAD8D542954821B4ECF7C563863D1FB75C1CBEB86B0D0891E12CC79D75890CB2C46196176DBF3D9F9590458136B12EF6BB41C12D8DA16A946CE89449F9873B3A3DF681936105AC1502632B0371A8EF143FFE2B69A3DE512E7AC942A3E87DFC2E6614A819902C35D20C60B0AD38D025B0AFD2D95DFF1F36EF72B4CBE59D9A054534AF69F7C1450976216E6E18E34065726B8FD7BF233F0CF76EC5E777D91A0176A74EDA491EBA2D1416FFAB9B5967D582836843E0C49009C680C41AFFF966F0179ECB1C64D975042A6B7E21A9FCC11CB92F00B74F0CC39395469AF0FE0267D582836843E0C4C11CB92F00B74F0C5C8EE96FA54DD3470551D77A1C1B2F515C8EE96FA54DD3476A436782B9A9B9DE46387327974C4EFCD97F008E77D2958BF6558275881467CE8E8F272D92AB5046EBD6A8650EF659B2129262ABBF3339A7067DDD7CF6835A14184546A6E917AB70F1776591F80FECBDF56452952D300905AD559EFCE041257C2D83CD074F3BC0E0273550E080C73D8CED1B6651157C66D9C31025AE6B588D7119FDAF93FE3EBF2E293CA12E9339376020F8C99295EB3D4B8428AB8C2043BFF9F9108DAE500EA2F374D063D85F20EE44207B6AF881D3DF2C37C6001B39DD2187F2C06DD46AD5EC05F1973F0E56F1C63CB9BAF45E219B05FAF8377FC5BF02069461FA66D6018DCAC5286821C24099A5B4918A371153EF8D984E01AEECB3BBDE054D78B76A4F41F787E7E5B3097BDDF20BD47C94C834CEA8DDEFE460369578796862933BF15241ABF214266DBC9923737674D063D85F20EE44F8D6FE09E8B1E625B5114285B0BD51B697B328EA67611E9F4046CB8EF46DF0FB45986C92789D8DE54046CB8EF46DF0FBE2572523E270909DB5114285B0BD51B6A9CCE889A896AFC533DD328CA27ED5657F2FBD21C961164536B2A4754B2602D6EBC8947E325644576420695E7C3B44614032E12FB4B0EE0B|266FB63EA028B5336CAAAB857C67288022FCB30E152AFADEF97AEE88E1A0EF1DC661A9E8BAC09DFBAD154EED35115E7A2F12D30D7F1A082638EFF0D8E7E626618EF19E7B35617D45CF2FAFDFF543EF8029943281593CAC11520DB6EC5CA839567CC9592FDA6515EC4DCE36FB36480B3FB7D5CD9EB36519653741CBD19BD1085423171C50D2DB20879F5C2108675E42B8982E944E4F5574C8DA176F55B61FDD54BE94244FAD59016E0B56BDD93CEC6D575FCAE8DF104C75F107C2FADEF1FE388D503C1CB0B37413D31F1599DBEC04AC9D4979FF1C163DA37715D1D23E03F3F72976F9BC18DC702277AEE6E56C13BA6171C663B9650ECB0FBE77CBCE66805E3497',
            'version' => 2
        );

        if (!empty($params['data']) && !empty($params['version']) 
            && $params['version'] == 2) {
            
            $data = $params['data'];
            
            try {
                //desencriptar la data y darle formato
                $solData = simplexml_load_string($this->ws->desencriptarData($data));
                var_dump($solData); exit;

                $return['data']['clientReference'] = $solData->CodTrans;
                //Según el estado de la solicitud  Procesar
                Switch ($solData->Estado) {
                    case 592:                        
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_PENDIENTE;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                        $return['data']['reference'] = $solData->CIP->IdOrdenPago;
                        break;
                    case 593: //Cip Pagado
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_PAGADO;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                        $return['data']['reference'] = $solData->CIP->IdOrdenPago;
                        break;
                    case 595://Cip Vencido
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_EXPIRADO;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                        $return['data']['reference'] = $solData->CIP->IdOrdenPago;
                    default:
                        $return['data']['status'] = OrdenRepository::PAGO_ESTADO_ERROR;
                        $return['data']['cip'] = $solData->CIP->NumeroOrdenPago;
                        $return['data']['reference'] = $solData->CIP->IdOrdenPago;
                }
                // 31/12/2016 17:00:00
                // date_format(date_create_from_format("d/m/Y H:i:s",$tempData['fechayhora_tx']), 'Y-m-d H:i:s'),
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
                    'DataAdicional' => '',
                    'UsuarioNombre' => $data['perfilpago_nombres'],
                    'UsuarioApellidos' => $data['perfilpago_paterno'] . ' ' . $data['perfilpago_materno'],
                    'UsuarioLocalidad' => 'LIMA',
                    'UsuarioProvincia' => 'LIMA',
                    'UsuarioPais' => 'PERU',
                    'UsuarioAlias' => $data['perfilpago_nombres'],
                    'UsuarioTipoDoc' => $data['documento_tipo'],
                    'UsuarioNumeroDoc' => $data['documento_numero'],
                    'UsuarioEmail' => $data['usuario_email'],
                    'ConceptoPago' => 'Pago',
            ));
        
        $solicitud->addDetalle(
            array(array(
                'Cod_Origen' => 'CT',
                'TipoOrigen' => 'TO',
                'ConceptoPago' => $this->wsConfig['conceptoPago'],
                'Importe' => $data['monto'])
            ));
        
        return $solicitud;        
    }
}