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

class PaqueteController extends SecurityAdminController
{   
    public function indexAction()
    {
        try {
            $form = $this->getServiceLocator()->get('Admin\Form\PaqueteBuscarForm');
            $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
                'controller' => 'paquete', 'action' => 'index'
            )));

            $form->setData($this->params()->fromPost());

            $this->_syncPaquetes();
            $criteria  = $this->_getPaqueteService()->getDataCriteria($this->params()->fromPost());
            $gridList  = $this->_getPaqueteService()->getRepository()->search($criteria);
            $countList = !empty($gridList)? count($gridList): 0;

            $view = new ViewModel();
            $view->setVariable('gridList', $gridList);
            $view->setVariable('countList', $countList);
            $view->setVariable('form', $form);

            return $view;
        } catch (\Exception $e) {
            echo $e->getMessage();exit;
        }
    }

    private function _syncPaquetes()
    {
        $results = $this->_getPaqueteService()->promocionesEnTrueFi();
        $rows = array();
        $referencias = array();
        if ($results['success']) {
            $results = $results['result'];
            foreach ($results as $row) {
                $json = json_encode($row);
                $codigo = base64_encode($json);
                $row['referencia'] = md5($codigo);
                $referencias[] = md5($codigo);
                $rows[] = $row;
            }
        }

        $results2 = array();
        if (!empty($referencias)) {
            $results2 = $this->_getPaqueteService()->getRepository()->findByReferencia($referencias);
        }

        foreach ($rows as $key => $row) {
            $referencia = $row['referencia'];
            if (isset($results2[$referencia])) {
                unset($rows[$key]);
            }
        }
        
        foreach ($rows as $row) {
            $this->_getPaqueteService()->getRepository()->save(array(
                'referencia' => $row['referencia'],
                'emoney' => $row['emoney'],
                'bonus' => $row['bonus'],
                'promotionbonus' => isset($row['promotionbonus']) ? $row['promotionbonus'] :  null,
                'etickets' => isset($row['etickets']) ? $row['etickets'] : null,
                'gamepoints' => $row['gamepoints'],
                'fecha_creacion' => date('Y-m-d H:i:s'),
            ));
        }
    }

    public function editarAction()
    {
        $id      = $this->params('id', null);
        $request = $this->getRequest();
        $form    = $this->crearCrudForm(AC_EDITAR, $id);

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
        $view->setVariable('imagen', $row['imagen']);
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
                        ->save(array('activo' => 0), $id);
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
        $form->setInputFilter(new \Admin\Filter\PaqueteFilter(array(
            'uploadDir' => $config['fileDir']['paquete_paquete']['up'],
        )));
        $form->setData($data);

        if ($form->isValid()) {

            try {
                $data = $form->getData();

                if (!empty($data['tipo']) && $data['tipo'] == \Admin\Model\Service\PaqueteService::TIPO_RECARGA) {
                    $data['destacado'] = 0;
                }

                $paramsIn = array(
                    'titulo1'       => $data['titulo1'],
                    'titulo2'       => $data['titulo2'],
                    'legal'         => $data['legal'],
                    'activo'        => $data['activo'],
                    'destacado'     => $data['destacado'],
                    'orden'         => $data['orden'],
                    'tipo'          => $data['tipo'],
                    'imagen'        => $newFileName,
                    'fecha_edicion' => date('Y-m-d H:i:s')
                );

                if ($action == AC_CREAR) {
                    $paramsIn['emoney']         = $dataStatic['emoney'];
                    $paramsIn['bonus']          = $dataStatic['bonus'];
                    $paramsIn['promotionbonus'] = $dataStatic['promotionbonus'];
                    $paramsIn['etickets']       = $dataStatic['etickets'];
                    $paramsIn['gamepoints']     = $dataStatic['gamepoints'];
                    $paramsIn['referencia']     = $dataStatic['referencia'];
                    $paramsIn['fecha_creacion'] = date('Y-m-d H:i:s');
                }

                if (empty($paramsIn['imagen'])) {
                    unset($paramsIn['imagen']);
                }

                $repository = $this->_getPaqueteService()->getRepository();
                if (!empty($id)) {
                    $repository->save($paramsIn, $id);
                } else {
                    $repository->save($paramsIn);
                }

                $this->_getPaqueteService()->updateOrdenPaquete($paramsIn['tipo'], $paramsIn['orden'], $id);
                $this->_getPaqueteService()->updateDestacados($id, $paramsIn['destacado'], $paramsIn['tipo']);
                
                $this->flashMessenger()->addMessage(array(
                    'success' => ($action == AC_CREAR) ? OK_CREAR : OK_EDITAR,
                ));
            } catch (\Exception $e) {
                /*$this->flashMessenger()->addMessage(array(
                    'error' => ($action == AC_CREAR) ? ER_CREAR : ER_EDITAR,
                ));*/
                $this->flashMessenger()->addMessage(array(
                    'error' => $e->getMessage(),
                ));
            }

            $this->redirect()->toRoute('admin/crud', array(
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
        $url = $this->url()->fromRoute('admin/crud', $options);
        if (!empty($codigo)) {
            $url = $url . '?codigo=' . $codigo;
        }
        
        $form->setAttribute('action', $url);

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
    
    private function _getPaqueteForm()
    {
        return $this->getServiceLocator()->get('Admin\Form\PaqueteForm');
    }

    private function _getPaqueteService()
    {
        return $this->getServiceLocator()->get('Admin\Model\Service\PaqueteService');
    }

}
