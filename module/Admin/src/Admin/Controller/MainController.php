<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Common\Controller\SecurityAdminController;

class MainController extends SecurityAdminController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function miPerfilAction()
    {
        $request = $this->getRequest();
        $codeUser = $this->request->getQuery('u');
        if (empty($codeUser)) {
            return $this->redirect()->toRoute('admin/crud', array('controller' => 'main'));
        }
        
        $id = \Common\Helpers\Crypto::decrypt($codeUser, \Common\Helpers\Util::VI_ENCODEID);
        $form = $this->crearCrudForm($id);

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
            $this->_prepareSave($form, $id);
        }
        
        $view = new ViewModel();
        $view->setVariable('form', $form);

        return $view;
    }
    
    protected function _prepareSave($form, $id)
    {
        $request = $this->getRequest();
        $data = $request->getPost()->toArray();

        $repeat = false;
        if (!empty($data['password']) || !empty($data['password_repeat'])) {
            $repeat = true;
        }

        $filter = new \Admin\Filter\MiPerfilFilter(array('repeat' => $repeat));

        $form->setInputFilter($filter);
        $form->setData($data);

        if ($form->isValid()) {
            $data = $form->getData();

            try {
                $paramsIn = array(
                    'fecha_edicion' => date('Y-m-d H:i:s'),
                );

                $repository = $this->_getUsuarioService()->getRepository();
                if ($repeat) {
                    $paramsIn['password'] = \Common\Helpers\Util::passwordHash($data['password']);
                }

                $repository->save($paramsIn, $id);
                
                $this->flashMessenger()->addMessage(array(
                    'success' => OK_EDITAR,
                ));
            } catch (\Exception $e) {
                var_dump($e->getMessage());exit;
                $this->flashMessenger()->addMessage(array(
                    'error' => ER_EDITAR,
                ));
            }

            $codeUser = \Common\Helpers\Crypto::encrypt($id, \Common\Helpers\Util::VI_ENCODEID);
            $this->redirect()->toRoute('admin/crud', array(
                'controller' => 'main', 'action' => 'mi-perfil'
            ), array('query' => array('u' => $codeUser)));
        }
    }
    
    public function crearCrudForm($id)
    {
        $codeUser = \Common\Helpers\Crypto::encrypt($id, \Common\Helpers\Util::VI_ENCODEID);
        $options = array(
            'controller' => 'main',
            'action' => 'mi-perfil',
        );
        $query = array('query' => array('u' => $codeUser));

        $form = $this->_getMiPerfilForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', $options, $query));

        return $form;
    }
    
    private function _getMiPerfilForm()
    {
        return $this->getServiceLocator()->get('Admin\Form\MiPerfilForm');
    }

    private function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Admin\Model\Service\UsuarioService');
    }
}
