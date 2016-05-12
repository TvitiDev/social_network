<?php

namespace app\models;

use Yii;

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
    public function addFriends($user, $friend)
    {
        # code..
        return true;
    }

    /**
     *  Удаление пользователя из друзей
     */
    public function removeFriends($user, $friend)
    {
        # code...
        return true;
    }

    /**
     *  Проверка, дружат ли пользователи
     */
    public function hasFriend($user, $friend)
    {
        # code...
        return true;
    }
}
