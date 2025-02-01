<?php

class BaseController {
  public function home() {

    // display errors for people trying to access restricted sections
    if(isset($_GET['error'])) {
      $error = recoge('error');
      if($error === '401') {
        $params['message'] = 'No tienes permisos para acceder a la página que buscas.';
      }
    }

    require ROOT_PATH . '/web/templates/home.php';
  }

  public function error() {
    require ROOT_PATH . '/web/templates/error.php';
  }
}