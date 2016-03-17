<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Admin\Controller;

use Common\Controller\SecurityAdminController;
use Zend\View\Model\ViewModel;
use \Common\Helpers\String;

class RolController extends SecurityAdminController
{
    public function indexAction()
    {
        $params = array(
            'nombre' => String::xssClean($this->params()->fromQuery('nombre')),
        );
        
        $form = $this->crearBuscarForm();
        $form->setData($params);
        
        $criteria = array(
            'whereLike' => $params,
        );
        $gridList = $this->_getRolService()->getRepository()->search($criteria);
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
        $row = $this->_getRolService()->getRepository()->findOne($criteria);
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
                $exist = $this->_getRolService()->getRepository()->existsChildren($id);
                if ($exist == false) {
                    $this->_getRolService()->getRepository()
                        ->delete(array('id' => $id));
                } else {
                    $this->_getRolService()->getRepository()
                        ->save(array('estado' => 0), $id);
                }
                
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

        $form->setInputFilter(new \Admin\Filter\RolFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();

            try {
                $paramsIn = array(
                    'nombre' => $data['nombre'],
                    'estado' => (int)$data['estado'],
                );

                $repository = $this->_getRolService()->getRepository();
                if (!empty($id)) {
                    $paramsIn['fecha_edicion'] = date('Y-m-d H:i:s');
                    $repository->save($paramsIn, $id);
                } else {
                    $paramsIn['fecha_creacion'] = date('Y-m-d H:i:s');
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
                'controller' => 'rol', 'action' => 'index'
            ));
        }
    }
    
    public function crearCrudForm($action, $id = null)
    {
        $options = array(
        'controller' => 'rol',
            'action' => $action,
        );
        
        if (!empty($id)) {
            $options['id'] = $id;
        }
        
        $form = $this->_getRolForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', $options));

        return $form;
    }
    
    public function crearBuscarForm()
    {
        $form = $this->_getRolForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
        'controller' => 'rol', 'action' => 'index'
        )));
        $form->setAttribute('method', 'get');
        return $form;
    }
    
    protected function _getRolForm()
    {
        return $this->getServiceLocator()->get('Admin\Form\RolForm');
    }

    protected function _getRolService()
    {
        return $this->getServiceLocator()->get('Admin\Model\Service\RolService');
    }
}
