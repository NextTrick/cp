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
        );
        $gridList = $this->_getPaqueteService()->getRepository()->search($criteria);

        $view = new ViewModel();
        $view->setVariable('gridList', $gridList);
        $view->setVariable('form', $form);
        return $view;
    }

    public function preCrearAction()
    {
        $results = $this->_getPaqueteService()->promocionesEnTrueFi();
        $rows = array();
        $referencia = array();
        if ($results['success']) {
            $results = $results['result'];
            foreach ($results as $row) {
                $json = json_encode($row);
                $codigo = base64_encode($json);
                $row['codigo'] = $codigo;
                $row['referencia'] = md5($codigo);
                $referencia[] = md5($codigo);
                $rows[] = $row;
            }
        }

        $results2 = $this->_getPaqueteService()->getRepository()->findByReferencia($referencia);
        
        foreach ($rows as $key => $row) {
            $referencia = $row['referencia'];
            if (isset($results2[$referencia]) && $referencia == $results2[$referencia]) {
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
        $data = (array)json_decode(base64_decode($codigo), true);
        if (empty($data)) {
            throw new \Exception('Datos de promoción es inconsistente.');
        }

        $form = $this->crearCrudForm(AC_CREAR, null, $codigo);
        $form->get('importe_minimo')->setValue($data['value']);
        $form->get('importe_emoney')->setValue($data['emoney']);
        $form->get('importe_bonus')->setValue($data['bonus']);
        $form->get('tickets')->setValue($data['gamepoints']);

        if ($request->isPost()) {
            $input = array(
                'referencia' => md5($codigo),
                'importe_minimo' => $data['value'],
                'importe_emoney' => $data['emoney'],
                'importe_bonus' => $data['bonus'],
                'tickets' => $data['gamepoints'],
                'monto_total' => (float)$data['emoney'] + (float)$data['bonus'],
            );
            $this->_prepareSave(AC_CREAR, $form, null, $input);
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
    
    protected function _prepareSave($action, $form, $id = null, $input = array())
    {
        $request = $this->getRequest();

        $data1 = array_merge_recursive(
            $input,
            $request->getPost()->toArray()
        );
        
        $data = array_merge_recursive(
            $data1,
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
                    'referencia' => $data['referencia'],
                    'titulo1' => $data['titulo1'],
                    'titulo2' => $data['titulo2'],
                    'importe_minimo' => $data['importe_minimo'],
                    'importe_emoney' => $data['importe_emoney'],
                    'importe_bonus' => $data['importe_bonus'],
                    'tickets' => $data['tickets'],
                    'monto_total' => $data['monto_total'],
                    'imagen' => $newFileName,
                );

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
