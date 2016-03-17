<?php
namespace Common\Helpers;
use Zend\View\Model\ViewModel;
use Zend\View\Resolver\TemplatePathStack;
use Zend\View\Renderer\PhpRenderer;

class Mail
{
    protected $_config = array();
    protected $_options = array();

    public function __construct($config)
    {
        if (isset($config['options'])) {
            $this->_options = $config['options'];
            unset($config['options']);
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

        $transport->send($mail);
    }
    
    protected function _getView($view)
    {
        $resolver = new TemplatePathStack(array(
            'script_paths' => array(APP_PATH . '/module/TemplateMail')
        ));
        
        $renderer = new PhpRenderer();
        $renderer->setResolver($resolver);
        
        return $renderer->render($view);
    }
}
