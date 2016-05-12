<?php

namespace tests\codeception\unit\models;

use Yii;
use yii\codeception\TestCase;
use app\models\LoginForm;
use app\models\Friends;
use Codeception\Specify;

class FriendsTest extends TestCase
{
    use Specify;
    public $userId;

    protected function tearDown()
    {
        Yii::$app->user->logout();
        parent::tearDown();
    }

    protected function setUp()
    {
        parent::setUp();
        $model = new LoginForm([
            'username' => '1@mail.ru',
            'password' => '12345678',
        ]);
        $model->login();
        $this->userId = Yii::$app->user->getId();
        $model = new Friends();
        $model->removeFriend($this->userId, 2);
    }

    public function testNonExistentUser()
    {
        $model = new Friends();

        $this->specify('взаимодействие с не существующими пользователями', function () use ($model) {
            expect('модель не должна добавить не сущестующего пользователя', $model->addFriend($this->userId, -1) )->false();
        });
    }

    public function testExistentUser()
    {
        $model = new Friends();

        $this->specify('взаимодействие с существующими пользователями', function () use ($model) {
            expect('модель должна добавить сущестующего пользователя', $model->addFriend($this->userId, 2) )->true();
            expect('модель должна сообщить о наличии друга', $model->hasFriend($this->userId, 2) )->true();
            expect('модель должна сообщить о отсутствии друга', $model->hasFriend($this->userId, $this->userId) )->false();
            expect('модель не должна добавлять в друзья уже друга', $model->addFriend($this->userId, 2) )->false();
            expect('модель не должна добавлять в друзья самого себя', $model->addFriend($this->userId, $this->userId) )->false();
            expect('модель должна удалить из друзей друга', $model->removeFriend($this->userId, 2) )->true();
            expect('модель не должна удалить из друзей не друга', $model->removeFriend($this->userId, 2) )->false();
        });
    }


}
