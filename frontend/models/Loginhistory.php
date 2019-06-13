<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loginhistory".
 *
 * @property int $LoginHistoryId
 * @property int $UserId
 * @property string $LoginTimeStamp
 * @property string $LogoutTimeStamp
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Userprofile $user
 */
class Loginhistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loginhistory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserId'], 'required'],
            [['UserId'], 'integer'],
            [['LoginTimeStamp', 'LogoutTimeStamp', 'CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['DeleteTag'], 'string', 'max' => 1],
            [['UserId'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::className(), 'targetAttribute' => ['UserId' => 'UserId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LoginHistoryId' => 'Login History ID',
            'UserId' => 'User ID',
            'LoginTimeStamp' => 'Login Time Stamp',
            'LogoutTimeStamp' => 'Logout Time Stamp',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Userprofile::className(), ['UserId' => 'UserId']);
    }
}
