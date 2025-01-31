<?php

class BaseController {
  public function home() {
    require ROOT_PATH . '/web/templates/home.php';
  }

  public function error() {
    require ROOT_PATH . '/web/templates/error.php';
  }
}