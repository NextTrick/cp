<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Admin\Controller;

use Admin\Model\Service\OrdenService;
use Common\Controller\SecurityAdminController;
use Usuario\Model\Service\UsuarioService;
use Zend\View\Model\ViewModel;
use PHPExcel;
use \PHPExcel_IOFactory;

class OrdenController extends SecurityAdminController
{

    public function indexAction()
    {
        try {
            $form = $this->getServiceLocator()->get('Admin\Form\OrdenBuscarForm');
            $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
                'controller' => 'orden', 'action' => 'index'
            )));

            $form->setData($this->params()->fromPost());

            $criteria  = $this->_getOrdenService()->getDataCriteria($this->params()->fromPost());
            //var_dump($criteria);exit;
            $gridList  = $this->_getOrdenService()->getRepository()->search($criteria);
            $countList = !empty($gridList)? count($gridList): 0;

            $view = new ViewModel();
            $view->setVariable('gridList', $gridList);
            $view->setVariable('countList', $countList);
            $view->setVariable('form', $form);

            return $view;
        } catch (\Exception $e) {
            echo $e->getMessage();exit;
        }
    }

    public function exportarExcelAction()
    {
        try {
            $view = new ViewModel();
            $view->setTerminal(true);
            $date = new \DateTime();

            $criteria = $this->_getOrdenService()->getDataCriteria($this->params()->fromPost());
            $data     = $this->_getOrdenService()->getRepository()->search($criteria);

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

            $objPHPExcel->setActiveSheetIndex(0);
            $sheet = $objPHPExcel->getActiveSheet();

            $style['cabecera'] = array(
                'font' => array(
                    'name'  => 'Calibri',
                    'bold'  => true,
                    'color' => array(
                        'rgb' => '1F497D'
                    )
                ),
                'fill' => array(
                    'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'DBE5F1')
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '4F81BD')
                    )
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A1:AB1')->applyFromArray($style['cabecera']);

            $sheet->setCellValue('A1', 'Id');
            $sheet->setCellValue('B1', 'Código');
            $sheet->setCellValue('C1', 'Pago Referencia');
            $sheet->setCellValue('D1', 'Correo');
            $sheet->setCellValue('E1', 'Metodo Pago');
            $sheet->setCellValue('F1', 'Monto');
            $sheet->setCellValue('G1', 'Fecha Confirmacion');
            $sheet->setCellValue('H1', 'Estado');
            $sheet->setCellValue('I1', 'Pago Estado');
            $sheet->setCellValue('J1', 'Comprobante');
            $sheet->setCellValue('K1', 'Tipo Documento');
            $sheet->setCellValue('L1', 'Nro. Documento');
            $sheet->setCellValue('M1', 'Razón Social');
            $sheet->setCellValue('N1', 'Nombres');
            $sheet->setCellValue('O1', 'Paterno');
            $sheet->setCellValue('P1', 'Materno');
            $sheet->setCellValue('Q1', 'Dirección Fiscal');
            $sheet->setCellValue('R1', 'Dirección Entrega');

            $sheet->setCellValue('S1', 'Usuario Nombres');
            $sheet->setCellValue('T1', 'Usuario Paterno');
            $sheet->setCellValue('U1', 'Usuario Materno');
            $sheet->setCellValue('V1', 'Usuario Tipo Documento');
            $sheet->setCellValue('W1', 'Usuario Nro Documento');

            $sheet->setCellValue('X1', 'Usuario País');
            $sheet->setCellValue('Y1', 'Usuario Departamento');
            $sheet->setCellValue('Z1', 'Usuario Provincia');
            $sheet->setCellValue('AA1', 'Usuario Distrito');

            $sheet->setCellValue('AB1', 'Pago Error');
            $sheet->setCellValue('AC1', 'Pago Detalle Error');


            $index = 2;
            foreach ($data as $key => $reg) {
                $sheet->setCellValue('A'.$index, $reg['id']);
                $sheet->setCellValue('B'.$index, $reg['codigo']);
                $sheet->setCellValue('C'.$index, $reg['pago_referencia']);
                $sheet->setCellValue('D'.$index, $reg['email']);
                $sheet->setCellValue('E'.$index, $reg['pago_metodo']);
                $sheet->setCellValue('F'.$index, $reg['monto']);
                $sheet->setCellValue('G'.$index, $reg['pago_fecha_confirmacion']);
                $sheet->setCellValue('H'.$index, $reg['estado']);
                $sheet->setCellValue('I'.$index, $reg['pago_estado']);
                $sheet->setCellValue('J'.$index, \Admin\Model\Service\OrdenService::getNombreTipoComprobante($reg['comprobante_tipo']));
                $sheet->setCellValue('K'.$index, \Admin\Model\Service\OrdenService::getNombreTipoDocumento($reg['documento_tipo']));
                $sheet->setCellValue('L'.$index, $reg['documento_numero']);
                $sheet->setCellValue('M'.$index, $reg['fac_razon_social']);
                $sheet->setCellValue('N'.$index, $reg['nombres']);
                $sheet->setCellValue('O'.$index, $reg['paterno']);
                $sheet->setCellValue('P'.$index, $reg['materno']);
                $sheet->setCellValue('Q'.$index, $reg['fac_direccion_fiscal']);
                $sheet->setCellValue('R'.$index, $reg['fac_direccion_entrega_factura']);

                $sheet->setCellValue('S'.$index, $reg['usu_nombres']);
                $sheet->setCellValue('T'.$index, $reg['usu_paterno']);
                $sheet->setCellValue('U'.$index, $reg['usu_materno']);
                $sheet->setCellValue('V'.$index, UsuarioService::getNombreTipoDocumento($reg['di_tipo']));

                $sheet->setCellValue('W'.$index, $reg['di_valor']);

                $sheet->setCellValue('X'.$index, $reg['nombrePais']);
                $sheet->setCellValue('Y'.$index, $reg['nombreDepa']);
                $sheet->setCellValue('Z'.$index, $reg['nombreProv']);
                $sheet->setCellValue('AA'.$index, $reg['nombreDist']);

                $sheet->setCellValue('AB'.$index, $reg['pago_error']);
                $sheet->setCellValue('AC'.$index, $reg['pago_error_detalle']);

                $index ++;
            }

            $style['body'] = array(
                'font' => array(
                    'name'  => 'Calibri'
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '4F81BD')
                    )
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A2:AB'.($index-1))->applyFromArray($style['body']);
            $nameFile = 'transacciones_'. trim($date->format('Y-m-d_His')).'.xlsx';


            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Lista de Transacciones');
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$nameFile);
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;

        } catch (\Exception $e) {
            echo $e->getMessage();exit;
        }
    }


    public function crearAction()
    {
        $request = $this->getRequest();
        $form = $this->crearCrudForm(AC_CREAR);
        
        if ($request->isPost()) {            
            $this->_prepareSave(AC_CREAR, $form);
        }
        
        $view = new ViewModel();
        $view->setVariable('form', $form);

        return $view;
    }
    
    public function editarAction()
    {
        $id = $this->params('id', null);
        $request = $this->getRequest();
        $form = $this->crearCrudForm(AC_EDITAR, $id);

        $criteria = array(
            'where' => array(
                'id' => $id
            ),
        );
        $row = $this->_getOrdenService()->getRepository()->findOne($criteria);
        if (empty($row)) {
            throw new \Exception(NO_DATA);
        }

        $form->setData($row);
        
        if ($request->isPost()) {
            $this->_prepareSave(AC_EDITAR, $form, $id);
        }
        
        $view = new ViewModel();
        $view->setVariable('form', $form);

        return $view;
    }

    public function eliminarAction()
    {
        $request = $this->getRequest();
        $results = array('success' => false, 'msg' => ER_ELIMINAR);
        if ($request->isPost()) {
            $id = $this->params('id', null);
            if (!empty($id)) {
                $this->_getOrdenService()->getRepository()
                        ->save(array('estado' => 0), $id);
                $results = array('success' => true, 'msg' => OK_ELIMINAR);
            }
            
            $key = ($results['success']) ? 'success' : 'error';
            $this->flashMessenger()->addMessage(array($key => $results['msg']));
        }
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
        $response->setContent(json_encode($results));
        return $response;
    }
    
    protected function _prepareSave($action, $form, $id = null)
    {
        $request = $this->getRequest();
        $data = $request->getPost()->toArray();

        $form->setInputFilter(new \Orden\Filter\OrdenFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();

            try {
                $paramsIn = array(
                    'usuario_id' => $data['usuario_id'],
                    'comprobante_tipo' => $data['comprobante_tipo'],
                    'comprobante_numero' => $data['comprobante_numero'],
                    'fac_razon_social' => $data['fac_razon_social'],
                    'documento_numero' => $data['documento_numero'],
                    'fac_direccion_fiscal' => $data['fac_direccion_fiscal'],
                    'fac_direccion_entrega_factura' => $data['fac_direccion_entrega_factura'],
                    'nombres' => $data['nombres'],
                    'paterno' => $data['paterno'],
                    'materno' => $data['materno'],
                    'ciudadania' => $data['ciudadania'],
                    //'doc_identidad' => $data['doc_identidad'],
                    'direccion' => $data['direccion'],
                    'pais_id' => $data['pais_id'],
                    'distrito_id' => $data['distrito_id'],
                    'pago_referencia' => $data['pago_referencia'],
                    'pago_estado' => $data['pago_estado'],
                    'pago_tarjeta' => $data['pago_tarjeta'],
                    'monto' => $data['monto'],
                    'estado' => $data['estado'],
                    'fecha_creacion' => $data['fecha_creacion'],
                    'fecha_edicion' => $data['fecha_edicion'],
                );

                $repository = $this->_getOrdenService()->getRepository();
                if (!empty($id)) {
                    $repository->save($paramsIn, $id);
                } else {
                    $repository->save($paramsIn);
                }
                
                $this->flashMessenger()->addMessage(array(
                    'success' => ($action == AC_CREAR) ? OK_CREAR : OK_EDITAR,
                ));
            } catch (\Exception $e) {
                $this->flashMessenger()->addMessage(array(
                    'error' => ($action == AC_CREAR) ? ER_CREAR : ER_EDITAR,
                ));
            }

            $this->redirect()->toRoute('admin/crud', array(
                'controller' => 'orden', 'action' => 'index'
            ));
        }
    }
    
    public function crearCrudForm($action, $id = null)
    {
        $options = array(
        'controller' => 'orden',
            'action' => $action,
        );
        
        if (!empty($id)) {
            $options['id'] = $id;
        }
        
        $form = $this->_getOrdenForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', $options));

        return $form;
    }
    
    protected function _getOrdenForm()
    {
        return $this->getServiceLocator()->get('Admin\Form\OrdenForm');
    }

    /**
     * @return OrdenService
     */
    protected function _getOrdenService()
    {
        return $this->getServiceLocator()->get('Admin\Model\Service\OrdenService');
    }
}
