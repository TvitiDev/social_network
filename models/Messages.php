<?php

namespace app\models;

use Yii;

use app\models\Friends;

/**
 * This is the model class for table "messages".
 *
 * @property integer $id
 * @property integer $user_from
 * @property integer $user_to
 * @property string $text
 * @property string $time
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_from', 'user_to', 'text'], 'required'],
            [['user_from', 'user_to'], 'integer'],
            [['text'], 'string'],
            [['time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_from' => 'User From',
            'user_to' => 'User To',
            'text' => 'Text',
            'time' => 'Time',
        ];
    }

    /**
     *  Добавление сообщения
     */
    public function addMessage($userFrom, $userTo, $mes)
    {
        // if( Friends::hasFriend($user, $friend) ) {
        //
        // }
        return true;
    }

    /**
     *  Получение диалога
     * @return bool or array
     */
    public function getListMessage($userFrom, $userTo)
    {
        return true;
    }
}
