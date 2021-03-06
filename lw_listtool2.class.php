<?php

class lw_listtool2 extends lw_plugin
{
    public function __construct()
    {
        parent::__construct();
        include_once(dirname(__FILE__).'/Services/Autoloader.php');
        $autoloader = new \lwListtool\Services\Autoloader();
        $autoloader->setConfig($this->config);
    }
   
    public function deleteEntry()
    {
        $controller = new \lwListtool\Controller\BackendController();
        $controller->setCommand('delete');
        $response = $controller->execute();
        return $this->executeController($controller);
    }    
    
    public function getOutput()
    {
        $controller = new \lwListtool\Controller\BackendController();
        $controller->setCommand($this->request->getAlnum('pcmd'));
        if ($this->request->getInt('oid') > 0) {
            $controller->setConfigurationId($this->request->getInt('oid'));
        }
        $response = $controller->execute();
        if ($response->getParameterByKey('cmd')) {
            $url = $this->config['url']['client']."admin.php?obj=content&cmd=open&oid=".$this->request->getInt('oid');
            $this->pageReload($url);
        }
        else {
            return $response->getOutputByKey('output');
        }
    }    
    
    public function buildPageOutput()
    {
        $controller = new \lwListtool\Controller\FrontendController();
        if ($this->params['oid'] > 0) {
            $controller->setConfigurationId($this->params['oid']);
        }
        $response = $controller->execute();
        if ($response->getParameterByKey('cmd')) {
            $url = lw_page::getInstance()->getUrl($response->getParameterArray());
            $this->pageReload($url);
        }
        else {
            if ($response->getParameterByKey('die') == 1){
                
                $tpl = new lw_te(lw_io::loadFile(dirname(__FILE__) . '/../templates/popup.tpl.html'));

                $tpl->reg('form', $output);
                $tpl->reg('jquery', $this->response->getJQueryIncludes());

                die($response->getOutputByKey('output'));
            }
            return $response->getOutputByKey('output');
        }        
    }
}