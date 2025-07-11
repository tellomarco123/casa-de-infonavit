<?php

class Index extends ControllerBase
{

  function __construct()
  {
    parent::__construct();
  }
  function render()
  {
    $this->view->render('index/index');
  }

 
}

?>