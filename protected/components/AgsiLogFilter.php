<?php

class AgsiLogFilter extends CLogFilter{

   protected function getContext(){
       return $_SERVER['HTTP_HOST'];
   }

}

?>
