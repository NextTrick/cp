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

class UsuarioadminController extends SecurityAdminController
{
    const AC_EDITAR_PASS = 'editar-password';
    
    public function indexAction()
    {
        $params = array(
            'rol_id' => String::xssClean($this->params()->fromQuery('rol_id')),
            'email' => String::xssClean($this->params()->fromQuery('email')),
        );
        
        $form = $this->crearBuscarForm();
        $form->setData($params);
        
        $criteria = array(
            'whereLike' => $params,
            'limit' => LIMIT_BUSCAR,
        );
        $gridList = $this->_getUsuarioService()->getRepository()->search($criteria);
        $countList = $this->_getUsuarioService()->getRepository()->countTotal($criteria);

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
        $row = $this->_getUsuarioService()->getRepository()->findOne($criteria);
        if (empty($row)) {
            throw new \Exception(NO_DATA);
        }
        unset($row['password']);
        
        $form->setData($row);
        
        if ($request->isPost()) {
            $this->_prepareSave(AC_EDITAR, $form, $id);
        }
        
        $view = new ViewModel();
        $view->setVariable('form', $form);
        $view->setVariable('id', $id);

        return $view;
    }

    public function editarPasswordAction()
    {
        $id = $this->params('id', null);
        $request = $this->getRequest();
        $form = $this->crearCrudForm(self::AC_EDITAR_PASS, $id);

        $criteria = array(
            'where' => array(
                'id' => $id
            ),
        );
        $row = $this->_getUsuarioService()->getRepository()->findOne($criteria);
        if (empty($row)) {
            throw new \Exception(NO_DATA);
        }
        unset($row['password']);
        
        $form->setData($row);
        
        if ($request->isPost()) {
            $this->_prepareSave(self::AC_EDITAR_PASS, $form, $id);
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

        $repeat = false;
        switch ($action) {
            case AC_CREAR:
                $repeat = true;
                break;
            case self::AC_EDITAR_PASS:
                if (!empty($data['password']) || !empty($data['password_repeat'])) {
                    $repeat = true;
                }
                break;
        }

        $filter = new \Admin\Filter\UsuarioFilter(array('repeat' => $repeat));

        $form->setInputFilter($filter);
        $form->setData($data);
        
        $valid = true;
        if (!empty($data['email'])) {
            $existsEmail = 'El Email que intenta registrar ya existe';
            $row = $this->_getUsuarioService()->getRepository()
                ->findOne(array('where' => array('email' => $data['email'])));
 
            if (isset($row['id']) && empty($id)) {
                $valid = false;
                $form->get('email')->setMessages(array('existsEmail' => $existsEmail));
            } elseif (isset($row['id']) && $row['id'] != $id) {
                $valid = false;
                $form->get('email')->setMessages(array('existsEmail' => $existsEmail));
            }
        }
        if ($form->isValid() && $valid) {
            $data = $form->getData();

            try {
                $paramsIn = array(
                    'rol_id' => $data['rol_id'],
                    'email' => $data['email'],
                    'estado' => $data['estado'],
                );

                $repository = $this->_getUsuarioService()->getRepository();
                if (!empty($id)) {
                    if ($repeat) {
                        $paramsIn['password'] = \Common\Helpers\Util::passwordHash($data['password']);
                    }
                    $paramsIn['fecha_edicion'] = date('Y-m-d H:i:s');
                    $repository->save($paramsIn, $id);
                } else {
                    $paramsIn['password'] = \Common\Helpers\Util::passwordHash($data['password']);
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
                'controller' => 'usuarioadmin', 'action' => 'index'
            ));
        }
    }
    
    public function crearCrudForm($action, $id = null)
    {
        $options = array(
        'controller' => 'usuarioadmin',
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
        'controller' => 'usuarioadmin', 'action' => 'index'
        )));
        $form->setAttribute('method', 'get');
        return $form;
    }
    
    private function _getUsuarioForm()
    {
        return $this->getServiceLocator()->get('Admin\Form\UsuarioForm');
    }

    private function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Admin\Model\Service\UsuarioService');
    }
}
