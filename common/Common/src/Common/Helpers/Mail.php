<?php
namespace Common\Helpers;
use Zend\View\Model\ViewModel;
use Zend\View\Resolver\TemplatePathStack;
use Zend\View\Renderer\PhpRenderer;

class Mail
{
    protected $_config = array();
    protected $_options = array();
    protected $_dirTemplate = null;

    public function __construct($config)
    {
        if (isset($config['transport']['options'])) {
            $this->_options = $config['transport']['options'];
            unset($config['transport']);
        }
        
        $this->_config = $config;
    }

    /*
     * $view: ViewModel
     * $data: array(
     *      'fromEmail',
     *      'fromName',
     *      'toEmail',
     *      'subject',
     * )
     */
    public function send(ViewModel $view, $data)
    {
        $data = array_merge($this->_config, $data);

        if (empty($data['toEmail'])) {
            throw new \Exception('Email de destino no existe.');
        }
        
        $transport = new \Zend\Mail\Transport\Smtp();
        $options = new \Zend\Mail\Transport\SmtpOptions($this->_options);
        $transport->setOptions($options);

        $content = $this->_getView($view);

        // make a header as html  
        $html = new \Zend\Mime\Part($content);  
        $html->type = "text/html";  
        $body = new \Zend\Mime\Message();  
        $body->setParts(array($html));  

        // instance mail   
        $mail = new \Zend\Mail\Message();  
        $mail->setBody($body);
        $mail->setFrom($data['fromEmail'], $data['fromName']);  
        $mail->setTo($data['toEmail']);  
        $mail->setSubject($data['subject']);
        if (!empty($data['bcc'])) {
            $mail->setBcc($data['bcc']);
        }

        $transport->send($mail);
    }
    
    public function setDirTemplate($dirTemplate)
    {
        $this->_dirTemplate = $dirTemplate;
    }

    private function _getView($view)
    {
        $resolver = new TemplatePathStack();
        if (!empty($this->_dirTemplate)) {
            $resolver = new TemplatePathStack(array(
                'script_paths' => array($this->_dirTemplate)
            ));
        }

        $renderer = new PhpRenderer();
        $renderer->setResolver($resolver);
        
        return $renderer->render($view);
    }
}
