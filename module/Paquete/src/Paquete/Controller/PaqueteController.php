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
            'nombre' => String::xssClean($this->params()->fromQuery('nombre')),
            'coney_bonos' => String::xssClean($this->params()->fromQuery('coney_bonos')),
            'coney_bonos_plus' => String::xssClean($this->params()->fromQuery('coney_bonos_plus')),
            'tickets' => String::xssClean($this->params()->fromQuery('tickets')),
            'monto_total' => String::xssClean($this->params()->fromQuery('monto_total')),
            'fecha_creacion' => String::xssClean($this->params()->fromQuery('fecha_creacion')),
            'fecha_edicion' => String::xssClean($this->params()->fromQuery('fecha_edicion')),
        );
        
        $form = $this->crearBuscarForm();
        $form->setData($params);
        
        $criteria = array(
            'where' => $params,
        );
        $gridList = $this->_getPaqueteService()->getRepository()->search($criteria);

        $view = new ViewModel();
        $view->setVariable('gridList', $gridList);
        $view->setVariable('form', $form);
        return $view;
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
    
    protected function _prepareSave($action, $form, $id = null)
    {
        $request = $this->getRequest();
        $data = $request->getPost()->toArray();

        $form->setInputFilter(new \Paquete\Filter\PaqueteFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();

            try {
                $paramsIn = array(
                    'nombre' => $data['nombre'],
                    'coney_bonos' => $data['coney_bonos'],
                    'coney_bonos_plus' => $data['coney_bonos_plus'],
                    'tickets' => $data['tickets'],
                    'monto_total' => $data['monto_total'],
                    'fecha_creacion' => $data['fecha_creacion'],
                    'fecha_edicion' => $data['fecha_edicion'],
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

            $this->redirect()->toRoute('admin/crud', array(
                'controller' => 'paquete', 'action' => 'index'
            ));
        }
    }
    
    public function crearCrudForm($action, $id = null)
    {
        $options = array(
        'controller' => 'paquete',
            'action' => $action,
        );
        
        if (!empty($id)) {
            $options['id'] = $id;
        }
        
        $form = $this->_getPaqueteForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', $options));

        return $form;
    }
    
    public function crearBuscarForm()
    {
        $form = $this->_getPaqueteForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
        'controller' => 'paquete', 'action' => 'index'
        )));
        $form->setAttribute('method', 'get');
        return $form;
    }
    
    protected function _getPaqueteForm()
    {
        return $this->getServiceLocator()->get('Paquete\Form\PaqueteForm');
    }

    protected function _getPaqueteService()
    {
        return $this->getServiceLocator()->get('Paquete\Model\Service\PaqueteService');
    }
}
