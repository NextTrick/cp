<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Admin\Controller;

use Common\Controller\SecurityAdminController;
use Zend\View\Model\ViewModel;
use \Common\Helpers\String;
use Cms\Model\Service\ContenidoService;

class ContenidoController extends SecurityAdminController
{
    public function indexAction()
    {
        try {
            $params = array(
                String::xssClean($this->params()->fromPost('cmbFiltro')) => String::xssClean($this->params()->fromPost('txtBuscar')),
            );

            $form = $this->getServiceLocator()->get('Cms\Form\BuscarForm');
            $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
                'controller' => 'contenido', 'action' => 'index'
            )));

            $form->setData($this->params()->fromPost());

            $criteria = array(
                'whereLike' => $params,
                'limit' => LIMIT_BUSCAR,
            );

            $gridList       = $this->_getContenidoService()->getRepository()->search($criteria);
            $countList      = $this->_getContenidoService()->getRepository()->countTotal($criteria);
            $dataTipoPagina = ContenidoService::getAllTipos();

            $view = new ViewModel();
            $view->setVariable('gridList', $gridList);
            $view->setVariable('countList', $countList);
            $view->setVariable('form', $form);
            $view->setVariable('dataTipoPagina', $dataTipoPagina);

            return $view;

        } catch (\Exception $e) {
            echo $e->getMessage();exit;
        }
    }

    public function crearAction()
    {
        $request = $this->getRequest();
        $form    = $this->crearCrudForm(AC_CREAR);
        
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
        $row = $this->_getContenidoService()->getRepository()->findOne($criteria);
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
                $this->_getContenidoService()->getRepository()
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

        $form->setInputFilter(new \Cms\Filter\ContenidoFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();

            try {
                $paramsIn = array(
                    'codigo' => $data['codigo'],
                    'tipo' => $data['tipo'],
                    'titulo' => $data['titulo'],
                    'contenido' => $data['contenido'],
                    'estado' => $data['estado'],
                );

                $repository = $this->_getContenidoService()->getRepository();
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
                'controller' => 'contenido', 'action' => 'index'
            ));
        }
    }
    
    public function crearCrudForm($action, $id = null)
    {
        $options = array(
        'controller' => 'contenido',
            'action' => $action,
        );
        
        if (!empty($id)) {
            $options['id'] = $id;
        }
        
        $form = $this->_getContenidoForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', $options));

        return $form;
    }
    
    public function crearBuscarForm()
    {
        $form = $this->_getContenidoForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
        'controller' => 'contenido', 'action' => 'index'
        )));
        $form->setAttribute('method', 'post');
        return $form;
    }
    
    protected function _getContenidoForm()
    {
        return $this->getServiceLocator()->get('Cms\Form\ContenidoForm');
    }

    protected function _getContenidoService()
    {
        return $this->getServiceLocator()->get('Cms\Model\Service\ContenidoService');
    }
}
