<?php

use yii\db\Migration;
use app\models\User;

class m150513_053633_create_users extends Migration
{
    public function up()
    {
        $user = new User();
        $user->email = 'demo@demo.com';
        $user->username = 'demo';
        $user->password = 'password';
        $user->generateAuthKey();
        $user->save();
    }

    public function down()
    {
        $user = User::findByEmail('demo@demo.com');
        if (!empty($user)) {
        	$user->delete();
        }
    }
}
