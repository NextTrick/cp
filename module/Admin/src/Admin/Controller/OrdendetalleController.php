<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Admin\Controller;

use Admin\Model\Service\DetalleOrdenService;
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

            $objPHPExcel->getActiveSheet()->getStyle('A1:R1')->applyFromArray($style['cabecera']);

            $sheet->setCellValue('A1', 'Id');
            $sheet->setCellValue('B1', 'Cód. Transacción');
            $sheet->setCellValue('C1', 'Correo');
            $sheet->setCellValue('D1', 'Paquete');
            $sheet->setCellValue('E1', 'Monto');
            $sheet->setCellValue('F1', 'Cantidad');
            $sheet->setCellValue('G1', 'Fecha Creación');
            $sheet->setCellValue('H1', 'Nro Tarjeta');
            $sheet->setCellValue('I1', 'Estado');
            $sheet->setCellValue('J1', 'Pago estado');
            $sheet->setCellValue('K1', 'Dinero');
            $sheet->setCellValue('L1', 'Coney Bonos');

            $sheet->setCellValue('M1', 'Game Points');
            $sheet->setCellValue('N1', 'Tickets');
            $sheet->setCellValue('O1', 'Coney Bonos Plus');
            $sheet->setCellValue('P1', 'Paquete Título 2');
            $sheet->setCellValue('Q1', 'Paquete Tipo');
            $sheet->setCellValue('R1', 'Recarga Cantidad');
            $sheet->setCellValue('S1', 'Recarga Error');


            $index = 2;
            foreach ($data as $key => $reg) {
                $sheet->setCellValue('A'.$index, $reg['id']);
                $sheet->setCellValue('B'.$index, $reg['codigo']);
                $sheet->setCellValue('C'.$index, $reg['email']);
                $sheet->setCellValue('D'.$index, $reg['titulo1']);
                $sheet->setCellValue('E'.$index, $reg['monto']);
                $sheet->setCellValue('F'.$index, $reg['cantidad']);
                $sheet->setCellValue('G'.$index, $reg['fecha_creacion']);
                $sheet->setCellValue('H'.$index, $reg['numero']);
                $sheet->setCellValue('I'.$index, $reg['estado']);
                $sheet->setCellValue('J'.$index, $reg['pago_estado']);
                $sheet->setCellValue('K'.$index, $reg['emoney']);
                $sheet->setCellValue('L'.$index, $reg['bonus']);

                $sheet->setCellValue('M'.$index, $reg['gamepoints']);
                $sheet->setCellValue('N'.$index, $reg['etickets']);
                $sheet->setCellValue('O'.$index, $reg['promotionbonus']);
                $sheet->setCellValue('P'.$index, $reg['titulo2']);
                $sheet->setCellValue('Q'.$index, $reg['tipo']);

                $sheet->setCellValue('R'.$index, $reg['recarga_cantidad']);
                $sheet->setCellValue('S'.$index, $reg['recarga_error']);

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

            $objPHPExcel->getActiveSheet()->getStyle('A2:R'.($index-1))->applyFromArray($style['body']);
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

    /**
     * @return DetalleOrdenService
     */
    protected function _getDetalleOrdenService()
    {
        return $this->getServiceLocator()->get('Admin\Model\Service\DetalleOrdenService');
    }
}
