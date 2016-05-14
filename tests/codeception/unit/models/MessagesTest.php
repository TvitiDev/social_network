<?php

namespace tests\codeception\unit\models;

use Yii;
use yii\codeception\TestCase;
use app\models\Friends;
use app\models\LoginForm;
use app\models\Messages;
use Codeception\Specify;

class MessagesTest extends TestCase
{
    use Specify;
    public $userId;

    protected function tearDown()
    {
        Yii::$app->user->logout();
        $model = new Friends();
        // $model->removeFriend($this->userId, 2);
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
        $model->addFriend($this->userId, 2);
    }
    /*
    можно отправлять только другу
    нельзя отправлять недругу
    нельзя отправлять пустое сообщение
    получение существующего списка сообщений
    получение не существующего списка сообщений
    */
    public function testMessages()
    {
        $model = new Messages();

        $this->specify('отправка сообщений', function () use ($model) {
            expect('можно отправлять только другу', $model->addMessage($this->userId, 2, 'нормальое сообщение') )->true();
            expect('нельзя отправлять не другу', $model->addMessage($this->userId, 1, 'кривое сообщение') )->false();
            expect('нельзя отправлять пустые сообщений', $model->addMessage($this->userId, 2, '') )->false();
        });
    }

    public function testExistentUser()
    {
        $model = new Messages();

        $this->specify('получение списка сообщений', function () use ($model) {
            expect('получение существующего списка сообщений', $model->getListMessage($this->userId, 2) )->internalType('array');
            expect('получение не существующего списка сообщений', $model->getListMessage($this->userId, 1) )->false();
        });
    }


}
