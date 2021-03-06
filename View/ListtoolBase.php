<?php

namespace lwListtool\View;

class ListtoolBase extends \LWmvc\View
{
    public function __construct($type)
    {
        $this->view = new \lw_view(dirname(__FILE__).'/templates/listbase.tpl.phtml');
    }

    public function render()
    {
        $this->view->addurlfile = \lw_page::getInstance()->getUrl(array("cmd"=>"showAddFileForm"));
        $this->view->addurllink = \lw_page::getInstance()->getUrl(array("cmd"=>"showAddLinkForm"));
        $this->view->sorturl = \lw_page::getInstance()->getUrl();
        $this->view->baseurl = \lw_page::getInstance()->getUrl();
        $this->view->cmdIdentifier = "";
        $this->view->idIdentifier = "";
        return $this->view->render();
    }
}