<?php

namespace app\controllers;

use app\models\User;

class UserController extends OAuth2RestController
{
    public $modelClass = 'app\models\User';

    public function createAction($action) {
        if ($action == 'create') {
            $params = \Yii::$app->getRequest()->post();

            $user = new User();
            $user->email = $params['email'];
            $user->username = $params['username'];
            $user->setPassword($params['password']);
            $user->generateAuthKey();
            $user->save();

            return $this->redirect(['view', 'id' => $user->id]);
        }

        return parent::createAction($action);
    }
}
