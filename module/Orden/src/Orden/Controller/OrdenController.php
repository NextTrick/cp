<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Controller;

use Common\Controller\SecurityAdminController;
use Zend\View\Model\ViewModel;
use PHPExcel;
use \PHPExcel_IOFactory;

class OrdenController extends SecurityAdminController
{

    public function indexAction()
    {
        try {
            $form = $this->getServiceLocator()->get('Orden\Form\BuscarForm');
            $form->setAttribute('action', $this->url()->fromRoute('orden/crud', array(
                'controller' => 'orden', 'action' => 'index'
            )));

            $form->setData($this->params()->fromPost());

            $criteria = $this->_getOrdenService()->getDataCriteria($this->params()->fromPost());

            $gridList  = $this->_getOrdenService()->getRepository()->search($criteria);
            $countList = $this->_getOrdenService()->getRepository()->countTotal($criteria);

            $view = new ViewModel();
            $view->setVariable('gridList', $gridList);
            $view->setVariable('countList', $countList);
            $view->setVariable('form', $form);

            return $view;
        } catch (\Exception $e) {
            echo $e->getMessage();exit;
        }
    }

    public function exportarAction()
    {
        try {
            $view = new ViewModel();
            $view->setTerminal(true);

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
            $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($style['cabecera']);

            $sheet->setCellValue('A1', 'Id');
            $sheet->setCellValue('B1', 'Correo');
            $sheet->setCellValue('C1', 'Correo');
            $sheet->setCellValue('D1', 'Metodo Pago');
            $sheet->setCellValue('E1', 'Monto');
            $sheet->setCellValue('F1', 'Fecha Confirmacion');
            $sheet->setCellValue('G1', 'Estado Pago');
            $sheet->setCellValue('H1', 'Tipo comprobante');
            $sheet->setCellValue('I1', 'Nro comprobante');
            $sheet->setCellValue('J1', 'R. Social');
            $sheet->setCellValue('K1', 'Nombres');

            $index = 2;
            foreach ($data as $key => $reg) {
                $estado = (!empty($row['estado']))? 'Activo': 'Baja';
                $sheet->setCellValue('A'.$index, $reg['id']);
                $sheet->setCellValue('B'.$index, $reg['email']);
                $sheet->setCellValue('C'.$index, $reg['email']);
                $sheet->setCellValue('D'.$index, $reg['pago_tarjeta']);
                $sheet->setCellValue('E'.$index, $reg['monto']);
                $sheet->setCellValue('F'.$index, $reg['fecha_creacion']);
                $sheet->setCellValue('G'.$index, $reg['pago_estado']);
                $sheet->setCellValue('H'.$index, $reg['comprobante_tipo']);
                $sheet->setCellValue('I'.$index, $reg['comprobante_numero']);
                $sheet->setCellValue('J'.$index, $reg['fac_razon_social']);
                $sheet->setCellValue('K'.$index, $reg['nombres']);
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

            $objPHPExcel->getActiveSheet()->getStyle('A2:K'.($index-1))->applyFromArray($style['body']);

            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Lista de Usuarios');
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="01simple.xlsx"');
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
                    'fac_ruc' => $data['fac_ruc'],
                    'fac_direccion_fiscal' => $data['fac_direccion_fiscal'],
                    'fac_direccion_entrega_factura' => $data['fac_direccion_entrega_factura'],
                    'nombres' => $data['nombres'],
                    'paterno' => $data['paterno'],
                    'materno' => $data['materno'],
                    'ciudadania' => $data['ciudadania'],
                    'doc_identidad' => $data['doc_identidad'],
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

            $this->redirect()->toRoute('orden/crud', array(
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
        $form->setAttribute('action', $this->url()->fromRoute('orden/crud', $options));

        return $form;
    }
    
    protected function _getOrdenForm()
    {
        return $this->getServiceLocator()->get('Orden\Form\OrdenForm');
    }

    protected function _getOrdenService()
    {
        return $this->getServiceLocator()->get('Orden\Model\Service\OrdenService');
    }
}
