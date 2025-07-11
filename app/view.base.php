<?php
/**
 *
 */
class ViewBase{


  /* dsd */
  public $datos;
  public $evento;
  public $valid;
  function __construct(){
    // echo "<p>Vista base</p>";
    
  }

  function render($vista){
      require("views/".$vista.".view.php");
  }
}

 ?>
