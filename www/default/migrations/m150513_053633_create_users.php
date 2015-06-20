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

        $user2 = new User();
        $user2->email = 'test@test.com';
        $user2->username = 'test';
        $user2->password = 'password';
        $user2->generateAuthKey();
        $user2->save();
    }

    public function down()
    {
        $user = User::findByEmail('demo@demo.com');
        if (!empty($user)) {
            $user->delete();
        }
        $user2 = User::findByEmail('test@test.com');
        if (!empty($user2)) {
            $user2->delete();
        }
    }
}
