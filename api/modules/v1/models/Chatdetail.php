<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chatdetail".
 *
 * @property int $ChatDetailId
 * @property int $UserId
 * @property int $FriendId
 * @property string $ReadTag 0 - not read, 1 - read
 * @property string $MessageDateTime
 * @property string $MessageText
 * @property string $MessageDeleteTag
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 *
 * @property Userprofile $user
 * @property Userprofile $friend
 */
class Chatdetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chatdetail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserId', 'FriendId'], 'required'],
            [['UserId', 'FriendId'], 'integer'],
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['ReadTag', 'MessageDeleteTag'], 'string', 'max' => 1],
            [['MessageDateTime'], 'string', 'max' => 45],
            [['MessageText'], 'string', 'max' => 1000],
            [['UserId'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::className(), 'targetAttribute' => ['UserId' => 'UserId']],
            [['FriendId'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::className(), 'targetAttribute' => ['FriendId' => 'UserId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ChatDetailId' => 'Chat Detail ID',
            'UserId' => 'User ID',
            'FriendId' => 'Friend ID',
            'ReadTag' => 'Read Tag',
            'MessageDateTime' => 'Message Date Time',
            'MessageText' => 'Message Text',
            'MessageDeleteTag' => 'Message Delete Tag',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Userprofile::className(), ['UserId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFriend()
    {
        return $this->hasOne(Userprofile::className(), ['UserId' => 'FriendId']);
    }
}
