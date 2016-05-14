<?php

namespace app\models;

use Yii;

use app\models\User;
/**
 * This is the model class for table "friends".
 *
 * @property integer $user_id
 * @property integer $friend_id
 */
class Friends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'friend_id'], 'required'],
            [['user_id', 'friend_id'], 'integer'],
            [['user_id', 'friend_id'], 'unique', 'targetAttribute' => ['user_id', 'friend_id'], 'message' => 'The combination of User ID and Friend ID has already been taken.'],
            [['user_id', 'friend_id'], 'unique', 'targetAttribute' => ['user_id', 'friend_id'], 'message' => 'The combination of User ID and Friend ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'friend_id' => 'Friend ID',
        ];
    }

    /**
     *  Добавление пользовалеля в друзья
     */
    public function addFriend($user, $friend)
    {
        $friendModel = User::findOne($friend);
        if(!$friendModel || $user == $friend) {
            // пользователя не существует или мы пытаеся добавить сами себя
            return false;
        }
        if( $this->hasFriend($user, $friend) ) {
            // пользователи уже друзья
            return false;
        }

        $this->user_id = $user;
        $this->friend_id = $friend;

        if($this->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  Удаление пользователя из друзей
     */
    public function removeFriend($user, $friend)
    {
        $model = $this->findOne(['user_id' => $user, 'friend_id' => $friend]);
        if($model && $model->delete()){
            return true;
        } else {
            return false;
        }

    }

    /**
     *  Проверка, дружат ли пользователи
     */
    public function hasFriend($user, $friend)
    {
        if( Friends::findOne(['user_id' => $user, 'friend_id' => $friend]) || Friends::findOne(['user_id' => $friend, 'friend_id' => $user]) ){
            // если такая пара найдена
            return true;
        }

        return false;
    }
}
