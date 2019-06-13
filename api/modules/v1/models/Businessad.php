<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "businessad".
 *
 * @property int $BusinessAdId
 * @property int $UserId
 * @property string $AdName
 * @property string $ExpiresOn
 * @property string $Description
 * @property string $AdImageURL
 * @property resource $QRCodeURL
 * @property int $PlanId
 * @property string $PlanStartDate
 * @property string $AdStatus 1 - Delete
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Planmaster $plan
 * @property Userprofile $user
 * @property Businessadlocality[] $businessadlocalities
 * @property Glovebox[] $gloveboxes
 */
class Businessad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'businessad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserId', 'PlanId'], 'required'],
            [['UserId', 'PlanId'], 'integer'],
            [['ExpiresOn', 'PlanStartDate', 'CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['QRCodeURL'], 'string'],
            [['AdName', 'Description'], 'string', 'max' => 45],
            [['AdImageURL'], 'string', 'max' => 150],
            [['AdStatus', 'DeleteTag'], 'string', 'max' => 1],
            [['PlanId'], 'exist', 'skipOnError' => true, 'targetClass' => Planmaster::className(), 'targetAttribute' => ['PlanId' => 'PlanId']],
            [['UserId'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::className(), 'targetAttribute' => ['UserId' => 'UserId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'BusinessAdId' => 'Business Ad ID',
            'UserId' => 'User ID',
            'AdName' => 'Ad Name',
            'ExpiresOn' => 'Expires On',
            'Description' => 'Description',
            'AdImageURL' => 'Ad Image Url',
            'QRCodeURL' => 'Qr Code Url',
            'PlanId' => 'Plan ID',
            'PlanStartDate' => 'Plan Start Date',
            'AdStatus' => 'Ad Status',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Planmaster::className(), ['PlanId' => 'PlanId']);
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
    public function getBusinessadlocalities()
    {
        return $this->hasMany(Businessadlocality::className(), ['BusinessAdId' => 'BusinessAdId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGloveboxes()
    {
        return $this->hasMany(Glovebox::className(), ['BusinessAdId' => 'BusinessAdId']);
    }
}
