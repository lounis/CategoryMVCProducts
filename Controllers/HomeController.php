<?php
/**
 * HomeController 
 */ 
require_once('BaseController.php');

class HomeController extends Controller
{
    public function index()
    {
        $this->view( __FUNCTION__);
    }

    public function actionLogin ()
    {
        $login = Yii::app()->request->getParam('login', '');
        $password = Yii::app()->request->getParam('password', '');
        if (empty($login) || empty($password)) {
          $this->redirect('/');
          return;
        }
        $identity = new UserIdentity(trim($login), trim($password));
        if($identity->authenticate()) {
          Yii::app()->user->login($identity);
          $this->redirect('/home/disclaimer', false);
        } else {
          $this->_error = _("Mauvais pseudo/password");
          $this->forward('index');
        }
    }
}

