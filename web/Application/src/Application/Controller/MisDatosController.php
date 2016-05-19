<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;

class MisDatosController extends SecurityWebController
{
    public function indexAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }
        
        $form = $this->_getMisDatosForm();
        $form->setAttribute('action', $this->url()->fromRoute('web-mis-datos', array(
            'controller' => 'mis-datos',
        )));
        
        $mensajeRegistro = null;
        if ($this->request->isPost()) {
            //=========== Llenar los combos ===========
            $codPais = $this->request->getPost('cod_pais');
            $codDep = $this->request->getPost('cod_depa');
            $departamentos = $this->_getUbigeoService()->getDepartamentos($codPais);
            $form->get('cod_depa')->setValueOptions($departamentos);
            $distritos = $this->_getUbigeoService()->getDistritos($codPais, $codDep);
            $form->get('cod_dist')->setValueOptions($distritos);
            
            //=========== Aplicar filter ===========
            $form->setInputFilter(new \Application\Filter\RegistroFilter());
            $data = $this->request->getPost();
            
            $form->setData($data);
            
            //=========== Validar fecha ===========
            $fechaValida = false;
            $fechaNac = null;
            if (\Common\Helpers\Util::checkDate($data['mes'], $data['dia'], $data['anio'])) {
                $fechaValida = true;
                $fechaNac = $data['anio'] . '-' . $data['mes'] . '-' . $data['dia'];
            } else {
                $form->get('dia')->setMessages(array('noValido' => 'El campo fecha no es válido.'));
            }

            if ($form->isValid() && $fechaValida) {
                $data = $form->getData();
                $data['fecha_nac'] = $fechaNac;

                $repository = $this->_getUsuarioService()->getRepository();
                //verificar en base de datos
                $criteria = array('where' => array('email' => $data['email']));
                $row = $repository->findOne($criteria);
                if (!empty($row)) {
                    $form->get('email')->setMessages(array('existsEmail' => $messageExistsEmail));
                } else {
                    $saveData = $this->_saveData($data);

                    $openPopapConfRegistro = 1;
                    $mensajeRegistro = 'Lo sentimos, no se pudo completar el proceso, por favor inténtelo más tarde.';
                    if ($saveData['success']) {
                        $mensajeRegistro = '<h3>¡Felicidades!, estás a punto de ser parte de Coney Club</h3>'
                            . '<p>Te hemos enviado un correo con las instrucciones para activar tu cuenta.</p>';
                    } elseif ($saveData['code'] == 'EXISTE_EMAIL') {
                        $openPopapConfRegistro = 0;
                        $mensajeRegistro = null;
                        $form->get('email')->setMessages(array('existsEmail' => $messageExistsEmail));
                    }
                }
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'mensajeRegistro' => $mensajeRegistro,
        ));
    }
    

    private function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\UsuarioService');
    }
    
    private function _getMisDatosForm()
    {
        return $this->getServiceLocator()->get('Application\Form\MisDatosForm');
    }
}
