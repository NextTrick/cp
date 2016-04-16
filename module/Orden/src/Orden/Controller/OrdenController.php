<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Controller;

use Common\Controller\SecurityAdminController;
use Zend\View\Model\ViewModel;
use \Common\Helpers\String;

class OrdenController extends SecurityAdminController
{
    public function indexAction()
    {
        $params = array(
            'comprobante_tipo' => String::xssClean($this->params()->fromQuery('comprobante_tipo')),
            'comprobante_numero' => String::xssClean($this->params()->fromQuery('comprobante_numero')),
        );
        
        $form = $this->crearBuscarForm();
        $form->setData($params);
        
        $criteria = array(
            'where' => $params,
        );
        $gridList = $this->_getOrdenService()->getRepository()->search($criteria);

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
        $row = $this->_getOrdenService()->getRepository()->findOne($criteria);
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
                $this->_getOrdenService()->getRepository()
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

        $form->setInputFilter(new \Orden\Filter\OrdenFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();

            try {
                $paramsIn = array(
                    'usuario_id' => $data['usuario_id'],
                    'comprobante_tipo' => $data['comprobante_tipo'],
                    'comprobante_numero' => $data['comprobante_numero'],
                    'fac_razon_social' => $data['fac_razon_social'],
                    'fac_ruc' => $data['fac_ruc'],
                    'fac_direccion_fiscal' => $data['fac_direccion_fiscal'],
                    'fac_direccion_entrega_factura' => $data['fac_direccion_entrega_factura'],
                    'nombres' => $data['nombres'],
                    'paterno' => $data['paterno'],
                    'materno' => $data['materno'],
                    'ciudadania' => $data['ciudadania'],
                    'doc_identidad' => $data['doc_identidad'],
                    'direccion' => $data['direccion'],
                    'pais_id' => $data['pais_id'],
                    'distrito_id' => $data['distrito_id'],
                    'pago_referencia' => $data['pago_referencia'],
                    'pago_estado' => $data['pago_estado'],
                    'pago_tarjeta' => $data['pago_tarjeta'],
                    'monto' => $data['monto'],
                    'estado' => $data['estado'],
                    'fecha_creacion' => $data['fecha_creacion'],
                    'fecha_edicion' => $data['fecha_edicion'],
                );

                $repository = $this->_getOrdenService()->getRepository();
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

            $this->redirect()->toRoute('orden/crud', array(
                'controller' => 'orden', 'action' => 'index'
            ));
        }
    }
    
    public function crearCrudForm($action, $id = null)
    {
        $options = array(
        'controller' => 'orden',
            'action' => $action,
        );
        
        if (!empty($id)) {
            $options['id'] = $id;
        }
        
        $form = $this->_getOrdenForm();
        $form->setAttribute('action', $this->url()->fromRoute('orden/crud', $options));

        return $form;
    }
    
    public function crearBuscarForm()
    {
        $form = $this->_getOrdenForm();
        $form->setAttribute('action', $this->url()->fromRoute('orden/crud', array(
        'controller' => 'orden', 'action' => 'index'
        )));
        $form->setAttribute('method', 'get');
        return $form;
    }
    
    protected function _getOrdenForm()
    {
        return $this->getServiceLocator()->get('Orden\Form\OrdenForm');
    }

    protected function _getOrdenService()
    {
        return $this->getServiceLocator()->get('Orden\Model\Service\OrdenService');
    }
}
