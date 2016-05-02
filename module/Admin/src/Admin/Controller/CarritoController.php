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

class CarritoController extends SecurityAdminController
{
    public function indexAction()
    {

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
        $row = $this->_getCarritoService()->getRepository()->findOne($criteria);
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
                $this->_getCarritoService()->getRepository()
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

        $form->setInputFilter(new \Orden\Filter\CarritoFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();

            try {
                $paramsIn = array(
                    'usuario_id' => $data['usuario_id'],
                    'pago_referencia' => $data['pago_referencia'],
                    'pago_estado' => $data['pago_estado'],
                    'pago_tarjeta' => $data['pago_tarjeta'],
                    'monto_total' => $data['monto_total'],
                    'estado' => $data['estado'],
                    'fecha_creacion' => $data['fecha_creacion'],
                    'fecha_edicion' => $data['fecha_edicion'],
                );

                $repository = $this->_getCarritoService()->getRepository();
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
                'controller' => 'carrito', 'action' => 'index'
            ));
        }
    }
    
    public function crearCrudForm($action, $id = null)
    {
        $options = array(
        'controller' => 'carrito',
            'action' => $action,
        );
        
        if (!empty($id)) {
            $options['id'] = $id;
        }
        
        $form = $this->_getCarritoForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', $options));

        return $form;
    }

    public function crearBuscarForm()
    {
        $form = $this->_getCarritoForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
        'controller' => 'carrito', 'action' => 'index'
        )));
        $form->setAttribute('method', 'get');
        return $form;
    }

    protected function _getCarritoForm()
    {
        return $this->getServiceLocator()->get('Orden\Form\CarritoForm');
    }

    protected function _getCarritoService()
    {
        return $this->getServiceLocator()->get('Orden\Model\Service\CarritoService');
    }
}
