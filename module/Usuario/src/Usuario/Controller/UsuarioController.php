<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Controller;

use Common\Controller\SecurityAdminController;
use Zend\View\Model\ViewModel;
use \Common\Helpers\String;
use PHPExcel;
use \PHPExcel_IOFactory;

class UsuarioController extends SecurityAdminController
{
    public function indexAction()
    {
        try {
            $form = $this->getServiceLocator()->get('Usuario\Form\BuscarForm');
            $form->setAttribute('action', $this->url()->fromRoute('usuario/crud', array(
                'controller' => 'usuario', 'action' => 'index'
            )));

            $form->setDataUbigeo($this->params()->fromPost());
            $form->setData($this->params()->fromPost());

            $criteria = $this->_getUsuarioService()->getDataCriteria($this->params()->fromPost());

            $gridList  = $this->_getUsuarioService()->getRepository()->search($criteria);
            $countList = $this->_getUsuarioService()->getRepository()->countTotal($criteria);

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

            $criteria = $this->_getUsuarioService()->getDataCriteria($this->params()->fromPost());
            $data = $this->_getUsuarioService()->getRepository()->search($criteria);

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

            $sheet->setCellValue('A1', 'Email');
            $sheet->setCellValue('B1', 'Nombre');
            $sheet->setCellValue('C1', 'A. Paterno');
            $sheet->setCellValue('D1', 'A. Materno');
            $sheet->setCellValue('E1', 'Tipo Doc');
            $sheet->setCellValue('F1', 'Nro. Doc.');
            $sheet->setCellValue('G1', 'Pais');
            $sheet->setCellValue('H1', 'Departamento');
            $sheet->setCellValue('I1', 'Provincia');
            $sheet->setCellValue('J1', 'Distrito');
            $sheet->setCellValue('K1', 'Estado');

            $index = 2;
            foreach ($data as $key => $reg) {
                $estado = (!empty($row['estado']))? 'Activo': 'Baja';
                $sheet->setCellValue('A'.$index, $reg['email']);
                $sheet->setCellValue('B'.$index, $reg['nombres']);
                $sheet->setCellValue('C'.$index, $reg['paterno']);
                $sheet->setCellValue('D'.$index, $reg['materno']);
                $sheet->setCellValue('E'.$index, $reg['di_tipo']);
                $sheet->setCellValue('F'.$index, $reg['di_valor']);
                $sheet->setCellValue('G'.$index, $reg['nombrePais']);
                $sheet->setCellValue('H'.$index, $reg['nombreDepa']);
                $sheet->setCellValue('I'.$index, $reg['nombreProv']);
                $sheet->setCellValue('J'.$index, $reg['nombreDist']);
                $sheet->setCellValue('K'.$index, $estado);
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

    public function getDistritosAction()
    {
        try {
            $codPais        = String::xssClean($this->params()->fromPost('cmbPais'));
            $codDepa        = String::xssClean($this->params()->fromPost('cmbDepartamento'));
            $codProv        = String::xssClean($this->params()->fromPost('cmbProvincia'));
            $ubigeoService  = $this->getServiceLocator()->get('Sistema\Model\Service\UbigeoService');
            $result['data'] = $ubigeoService->getDistritos($codPais, $codDepa, $codProv);

            return json_encode($result);

        } catch (\Exception $e) {
            $result['data'] = array();
            return $result['data'];
        }
    }

    public function getProvinciasAction()
    {
        try {
            $codPais        = String::xssClean($this->params()->fromPost('cmbPais'));
            $codDepa        = String::xssClean($this->params()->fromPost('cmbDepa'));
            $ubigeoService  = $this->getServiceLocator()->get('Sistema\Model\Service\UbigeoService');
            $result['data'] = $ubigeoService->getProvincias($codPais, $codDepa);

            return json_encode($result);

        } catch (\Exception $e) {
            $result['data'] = array();
            return $result['data'];
        }
    }

    public function getDepartamentosAction()
    {
        try {
            $codPais        = String::xssClean($this->params()->fromPost('cmbPais'));
            $ubigeoService  = $this->getServiceLocator()->get('Sistema\Model\Service\UbigeoService');
            $result['data'] = $ubigeoService->getDepartamentos($codPais);

            return json_encode($result);

        } catch (\Exception $e) {
            $result['data'] = array();
            return $result['data'];
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
        $row = $this->_getUsuarioService()->getRepository()->findOne($criteria);
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
                $this->_getUsuarioService()->getRepository()
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

        $form->setInputFilter(new \Usuario\Filter\UsuarioFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();

            try {
                $paramsIn = array(
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'token' => $data['token'],
                    'red' => $data['red'],
                    'estado' => $data['estado'],
                    'imagen' => $data['imagen'],
                    'nombres' => $data['nombres'],
                    'paterno' => $data['paterno'],
                    'materno' => $data['materno'],
                    'fecha_nac' => $data['fecha_nac'],
                    'cod_pais' => $data['cod_pais'],
                    'cod_depa' => $data['cod_depa'],
                    'cod_prov' => $data['cod_prov'],
                    'cod_dist' => $data['cod_dist'],
                    'fecha_creacion' => $data['fecha_creacion'],
                    'fecha_edicion' => $data['fecha_edicion'],
                );

                $repository = $this->_getUsuarioService()->getRepository();
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
                'controller' => 'usuario', 'action' => 'index'
            ));
        }
    }
    
    public function crearCrudForm($action, $id = null)
    {
        $options = array(
        'controller' => 'usuario',
            'action' => $action,
        );
        
        if (!empty($id)) {
            $options['id'] = $id;
        }
        
        $form = $this->_getUsuarioForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', $options));

        return $form;
    }
    
    public function crearBuscarForm()
    {
        $form = $this->_getUsuarioForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
        'controller' => 'usuario', 'action' => 'index'
        )));
        $form->setAttribute('method', 'get');
        return $form;
    }
    
    protected function _getUsuarioForm()
    {
        return $this->getServiceLocator()->get('Usuario\Form\UsuarioForm');
    }

    protected function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\UsuarioService');
    }
}
