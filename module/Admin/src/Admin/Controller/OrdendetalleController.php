<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Common\Controller\SecurityAdminController;
use PHPExcel;
use \PHPExcel_IOFactory;

class OrdendetalleController extends SecurityAdminController
{

    public function indexAction()
    {
        $view = new ViewModel();
        $view->setTerminal(true);

        try {
            $form = $this->getServiceLocator()->get('Admin\Form\DetalleOrdenBuscarForm');
            $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
                'controller' => 'ordendetalle', 'action' => 'index'
            )));

            $form->setData($this->params()->fromPost());

            $criteria  = $this->_getDetalleOrdenService()->getDataCriteria($this->params()->fromPost());
            $gridList  = $this->_getDetalleOrdenService()->getRepository()->search($criteria);
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

            $criteria = $this->_getDetalleOrdenService()->getDataCriteria($this->params()->fromPost());
            $data     = $this->_getDetalleOrdenService()->getRepository()->search($criteria);

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
            $sheet->setCellValue('B1', 'Paquete');
            $sheet->setCellValue('C1', 'Estado Pago');
            $sheet->setCellValue('D1', 'Nro. Tarjeta');
            $sheet->setCellValue('E1', 'Emoney');
            $sheet->setCellValue('F1', 'Bonus');
            $sheet->setCellValue('G1', 'Promotionbonus');
            $sheet->setCellValue('H1', 'Etickets');
            $sheet->setCellValue('I1', 'Gamepoints');
            $sheet->setCellValue('J1', 'Monto');
            $sheet->setCellValue('K1', 'Fecha Creacion');

            $index = 2;
            foreach ($data as $key => $reg) {
                $sheet->setCellValue('A'.$index, $reg['id']);
                $sheet->setCellValue('B'.$index, $reg['titulo1']);
                $sheet->setCellValue('C'.$index, \Orden\Model\Service\OrdenService::getNombreEstadoPago($reg['pago_estado']));
                $sheet->setCellValue('D'.$index, $reg['numero']);
                $sheet->setCellValue('E'.$index, $reg['emoney']);
                $sheet->setCellValue('F'.$index, $reg['bonus']);
                $sheet->setCellValue('G'.$index, $reg['promotionbonus']);
                $sheet->setCellValue('H'.$index, $reg['etickets']);
                $sheet->setCellValue('I'.$index, $reg['gamepoints']);
                $sheet->setCellValue('J'.$index, $reg['monto']);
                $sheet->setCellValue('K'.$index, $reg['fecha_creacion']);

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
            $nameFile = 'operaciones'. trim($date->format('Y-m-d_His')).'.xlsx';


            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Lista de Operaciones');
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

    protected function _getDetalleOrdenService()
    {
        return $this->getServiceLocator()->get('Admin\Model\Service\DetalleOrdenService');
    }
}
