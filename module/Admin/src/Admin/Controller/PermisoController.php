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

class PermisoController extends SecurityAdminController
{
    public function indexAction()
    {
        $params = array(
            'rol_id' => String::xssClean($this->params()->fromQuery('rol_id')),
            'recurso_id' => String::xssClean($this->params()->fromQuery('recurso_id')),
        );
        
        $form = $this->crearBuscarForm();
        $form->setData($params);

        if (empty($params['rol_id'])) {
            $roles = $form->get('rol_id')->getValueOptions();
            foreach ($roles as $key => $value) {
                $params['rol_id'] = $key;
                break;
            }
        }
        $criteria = array(
            'where' => $params,
            'limit' => LIMIT_BUSCAR,
        );
        $gridList = $this->_getPermisoService()->getRepository()->search($criteria);
        $countList = $this->_getPermisoService()->getRepository()->countTotal($criteria);

        $view = new ViewModel();
        $view->setVariable('gridList', $gridList);
        $view->setVariable('countList', $countList);
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
        $row = $this->_getPermisoService()->getRepository()->findOne($criteria);
        if (empty($row)) {
            throw new \Exception(NO_DATA);
        }

        if (!empty($row['acl'])) {
            $row['listar'] = (strpos($row['acl'], 'R') === false) ? '0' : '1' ;
            $row['crear'] = (strpos($row['acl'], 'C') === false) ? '0' : '1' ;
            $row['modificar'] = (strpos($row['acl'], 'U') === false) ? '0' : '1' ;
            $row['eliminar'] = (strpos($row['acl'], 'D') === false) ? '0' : '1' ;
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
                $this->_getPermisoService()->getRepository()
                        ->delete(array('id' => $id));
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

        $form->setInputFilter(new \Admin\Filter\PermisoFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();

            try {
                $acl = '';
                if ($data['listar'] == '1') {
                    $acl = $acl . 'R';
                }
                if ($data['crear'] == '1') {
                    $acl = $acl . 'C';
                }
                if ($data['modificar'] == '1') {
                    $acl = $acl . 'U';
                }
                if ($data['eliminar'] == '1') {
                    $acl = $acl . 'D';
                }
                
                $paramsIn = array(
                    'acl' => $acl,
                    'rol_id' => $data['rol_id'],
                    'recurso_id' => $data['recurso_id'],
                );
                
                $repository = $this->_getPermisoService()->getRepository();
                if (!empty($id)) {
                    $permiso = $repository->findOne(array('where' => array(
                        'rol_id' => $data['rol_id'],
                        'recurso_id' => $data['recurso_id'],
                    )));
                    if (!empty($permiso) && $permiso['id'] == $id) {
                        $repository->save($paramsIn, $id);
                    } else {
                        $this->flashMessenger()->addMessage(array(
                            'error' => 'La combinación de recurso y rol ya fue asignado.',
                        ));
                    }
                } else {
                    $permiso = $repository->findOne(array('where' => array(
                        'rol_id' => $data['rol_id'],
                        'recurso_id' => $data['recurso_id'],
                    )));
                    if (!empty($permiso)) {
                        $this->flashMessenger()->addMessage(array(
                            'error' => 'La combinación de recurso y rol ya fue asignado.',
                        ));
                    } else {
                        $repository->save($paramsIn);
                        $this->flashMessenger()->addMessage(array(
                            'success' => ($action == AC_CREAR) ? OK_CREAR : OK_EDITAR,
                        ));
                    }
                }
            } catch (\Exception $e) {
                $this->flashMessenger()->addMessage(array(
                    'error' => ($action == AC_CREAR) ? ER_CREAR : ER_EDITAR,
                ));
            }

            $this->redirect()->toRoute('admin/crud', array(
                'controller' => 'permiso', 'action' => 'index'
            ));
        }
    }
    
    public function crearCrudForm($action, $id = null)
    {
        $options = array(
        'controller' => 'permiso',
            'action' => $action,
        );
        
        if (!empty($id)) {
            $options['id'] = $id;
        }
        
        $form = $this->_getPermisoForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', $options));

        return $form;
    }
    
    public function crearBuscarForm()
    {
        $form = $this->_getPermisoForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
        'controller' => 'permiso', 'action' => 'index'
        )));
        $form->setAttribute('method', 'get');
        return $form;
    }
    
    protected function _getPermisoForm()
    {
        return $this->getServiceLocator()->get('Admin\Form\PermisoForm');
    }

    protected function _getPermisoService()
    {
        return $this->getServiceLocator()->get('Admin\Model\Service\PermisoService');
    }
}
