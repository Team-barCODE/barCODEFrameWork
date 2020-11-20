<?php
abstract class Contoller
{
    protected $controller_name;
    protected $action_name;
    protected $application;
    protected $request;
    protected $response;
    protected $session;
    protected $db_manager;

    public function __contruct()
    {
        $this->controller_name = strtolower( substr ( get_class($this) , 0 , 10 ));

        $this->application = $application;
        $this->request = $application->getRequest();
        $this->response = $application->getResponse();
        $this->session = $application->getSession();
        $this->db_manager = $application->getDbManager();
    }

    public function run($action , $params = array())
    {
        $this->action_name = $action;
        $action_method = $action . 'Action';
        if(!method_exist($this , $action_method)){
            $this->forward404();
        }
        $content = $this->$action_method($params);

        return $content;
    }

    protected function render ($valiables = array() , $template = null , $layout = 'layout')
    {
        $default = [
            'request' => $this->request,
            'base_url' => $this->request->getBaseUrl(),
            'session' => $this->session,
        ];

        $view = new View($this->application->getViewDir() ,$defaults);

        if(is_null($template)){
            $template = $this->action_name;
        }
        $path = $this->controller_name . '/' . $template;
        return $view->render($path,$valiables,$layout);

    }

    protected function forward404()
    {
        throw new HttpNotFoundException('Forward 404 Page from ' . $this->controller_name . '/' . $this->action_name);
    }
    protected function redirect($url)
    {
        if(!preg_match('#https?://#' , $url)){
            $protocol = $this->request->isSsl() ? 'https://' : 'http://';
            $host = $this->request->getHost();
            $base_url =$this->request->getBaseUrl();
            $url = $protocol . $host . $base_url . $url;
        }
        $this->response->setStatusCode(302 , 'FOUND');
        $this->response->setHttpHeader('Location' , $url);
    }

    protected function generateCsrfToken($form_name)
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->session->get($key, array());
        if(count($tokens) >= 10){
            array_shift($tokens);
        }
        $token = sha256($form_name . session_id() . microtime());
        $token[] = $token ;

        $this->session->set($key , $token);
        return $token;

    }

    protected function checkCsrfToken($form_name , $token)
    {
        $key = 'csrf_tokens/' . $form_name ;
        $tokens = $this->session->get($key , array());

        if(false !== ($pos = array_search($token , $tokens , true) ) ){
            unset($tokens[$pos]);
            $this->session->set($key,$tokens);
            return true;
        }
        return false;
    }

}