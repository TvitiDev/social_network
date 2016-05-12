<?php

namespace tests\codeception\unit\models;

use Yii;
use yii\codeception\TestCase;
use app\models\LoginForm;
use Codeception\Specify;

class LoginFormTest extends TestCase
{
    use Specify;

    protected function tearDown()
    {
        Yii::$app->user->logout();
        parent::tearDown();
    }

    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        $this->specify('пользователь не должен войти в систему, если не авторизован', function () use ($model) {
            expect('модель не должна авторизовывать пользователя', $model->login())->false();
            expect('пользователь не должен быть авторизован', Yii::$app->user->isGuest)->true();
        });
    }

    public function testLoginWrongPassword()
    {
        $model = new LoginForm([
            'username' => '1@mail.ru',
            'password' => 'wrong_password',
        ]);

        $this->specify('пользователь не должен иметь возможность войти в систему с неправильным паролем', function () use ($model) {
            expect('модель не должна авторизовывать пользователя', $model->login())->false();
            expect('должно иметься сообщение об ошибке', $model->errors)->hasKey('password');
            expect('пользователь не должен быть авторизован', Yii::$app->user->isGuest)->true();
        });
    }

    public function testLoginCorrect()
    {
        $model = new LoginForm([
            'username' => '1@mail.ru',
            'password' => '12345678',
        ]);

        $this->specify('пользователь должен иметь возможность войти в систему с правильными учетными данными', function () use ($model) {
            expect('модель должна авторизовать пользователя', $model->login())->true();
            expect('не должно быть сообщений об ошибке', $model->errors)->hasntKey('password');
            expect('пользователь должен быть авторизован', Yii::$app->user->isGuest)->false();
        });
    }

}
