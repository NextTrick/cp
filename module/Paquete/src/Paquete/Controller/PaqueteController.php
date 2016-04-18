<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Paquete\Controller;

use Common\Controller\SecurityAdminController;
use Zend\View\Model\ViewModel;
use \Common\Helpers\String;

class PaqueteController extends SecurityAdminController
{   
    public function indexAction()
    {
        $params = array(
            'titulo1' => String::xssClean($this->params()->fromQuery('titulo1')),
            'titulo2' => String::xssClean($this->params()->fromQuery('titulo2')),
        );
        
        $form = $this->crearBuscarForm();
        $form->setData($params);
        
        $criteria = array(
            'whereLike' => $params,
            'limit' => LIMIT_BUSCAR,
        );
        $gridList = $this->_getPaqueteService()->getRepository()->search($criteria);
        $countList = $this->_getPaqueteService()->getRepository()->countTotal($criteria);

        $view = new ViewModel();
        $view->setVariable('gridList', $gridList);
        $view->setVariable('countList', $countList);
        $view->setVariable('form', $form);
        return $view;
    }

    public function preCrearAction()
    {
        $results = $this->_getPaqueteService()->promocionesEnTrueFi();
        $rows = array();
        $referencias = array();
        if ($results['success']) {
            $results = $results['result'];
            foreach ($results as $row) {
                $json = json_encode($row);
                $codigo = base64_encode($json);
                $row['codigo'] = $codigo;
                $row['referencia'] = md5($codigo);
                $referencias[] = md5($codigo);
                $rows[] = $row;
            }
        }

        $results2 = $this->_getPaqueteService()->getRepository()->findByReferencia($referencias);
        
        foreach ($rows as $key => $row) {
            $referencia = $row['referencia'];
            if (isset($results2[$referencia])) {
                unset($rows[$key]);
            }
        }

        $view = new ViewModel();
        $view->setVariable('rows', $rows);

        return $view;
    }
    
    public function crearAction()
    {
        $request = $this->getRequest();
        $codigo = $this->params()->fromQuery('codigo');
        $dataStatic = (array)json_decode(base64_decode($codigo), true);
        if (empty($dataStatic)) {
            throw new \Exception('Datos de promoción es inconsistente.');
        }

        $form = $this->crearCrudForm(AC_CREAR, null, $codigo);
        $form->get('importe_minimo')->setValue($dataStatic['value']);
        $form->get('importe_emoney')->setValue($dataStatic['emoney']);
        $form->get('importe_bonus')->setValue($dataStatic['bonus']);
        $form->get('tickets')->setValue($dataStatic['gamepoints']);
        $form->get('fecha_creacion')->setValue(date('Y-m-d H:i:s'));

        if ($request->isPost()) {
            $dataStatic['referencia'] = md5($codigo);
            $this->_prepareSave(AC_CREAR, $form, null, $dataStatic);
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
        $row = $this->_getPaqueteService()->getRepository()->findOne($criteria);
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
                $this->_getPaqueteService()->getRepository()
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
    
    protected function _prepareSave($action, $form, $id = null, $dataStatic = array())
    {
        $request = $this->getRequest();

        $data = array_merge_recursive(
            $request->getPost()->toArray(),
            $request->getFiles()->toArray()
        );

        $newFileName = null;
        if (!empty($data['imagen']['name'])) {
            $nombreImg = md5($request->getPost('titulo1'));
            $ext = strtolower(pathinfo($data['imagen']['name'], PATHINFO_EXTENSION));   
            $newFileName = \Common\Helpers\String::parseSlugName($nombreImg)
                    . '-'  . date('Ymd') . '.' . $ext;

            $data['imagen']['name'] = $newFileName;
        }

        $config = $this->getServiceLocator()->get('config');
        $form->setInputFilter(new \Paquete\Filter\PaqueteFilter(array(
            'uploadDir' => $config['fileDir']['paquete_paquete']['up'],
        )));
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();
            try {
                $paramsIn = array(
                    'titulo1' => $data['titulo1'],
                    'titulo2' => $data['titulo2'],
                    'legal' => $data['legal'],
                    'activo' => $data['activo'],
                    'destacado' => $data['destacado'],
                    'imagen' => $newFileName,
                );

                if ($action == AC_CREAR) {
                    $paramsIn['monto_total'] = (float)$dataStatic['emoney'] + (float)$dataStatic['bonus'];
                    $paramsIn['importe_minimo'] = $dataStatic['value'];
                    $paramsIn['importe_emoney'] = $dataStatic['emoney'];
                    $paramsIn['importe_bonus'] = $dataStatic['bonus'];
                    $paramsIn['tickets'] = $dataStatic['gamepoints'];
                    $paramsIn['referencia'] = $dataStatic['referencia'];
                    $paramsIn['fecha_creacion'] = date('Y-m-d H:i:s');
                }
                
                $repository = $this->_getPaqueteService()->getRepository();
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

            $this->redirect()->toRoute('paquete/crud', array(
                'controller' => 'paquete', 'action' => 'index'
            ));
        }
    }
    
    public function crearCrudForm($action, $id = null, $codigo = null)
    {
        $options = array(
        'controller' => 'paquete',
            'action' => $action,
        );
        
        if (!empty($id)) {
            $options['id'] = $id;
        }
        
        $form = $this->_getPaqueteForm();        
        $url = $this->url()->fromRoute('paquete/crud', $options);
        if (!empty($codigo)) {
            $url = $url . '?codigo=' . $codigo;
        }
        
        $form->setAttribute('action', $url);

        return $form;
    }
    
    public function crearBuscarForm()
    {
        $form = $this->_getPaqueteForm();
        $form->setAttribute('action', $this->url()->fromRoute('paquete/crud', array(
        'controller' => 'paquete', 'action' => 'index'
        )));
        $form->setAttribute('method', 'get');
        return $form;
    }
    
    private function _getPaqueteForm()
    {
        return $this->getServiceLocator()->get('Paquete\Form\PaqueteForm');
    }

    private function _getPaqueteService()
    {
        return $this->getServiceLocator()->get('Paquete\Model\Service\PaqueteService');
    }
}
