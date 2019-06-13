<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userbusinesscategory".
 *
 * @property int $UserBusinessCategoryId
 * @property int $UserId
 * @property int $BusinessCategoryId
 * @property string $Status 1 - Delete
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Businesscategory $businessCategory
 * @property Userprofile $user
 */
class Userbusinesscategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userbusinesscategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserId', 'BusinessCategoryId'], 'required'],
            [['UserId', 'BusinessCategoryId'], 'integer'],
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['Status', 'DeleteTag'], 'string', 'max' => 1],
            [['BusinessCategoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Businesscategory::className(), 'targetAttribute' => ['BusinessCategoryId' => 'BusinessCategoryId']],
            [['UserId'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::className(), 'targetAttribute' => ['UserId' => 'UserId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'UserBusinessCategoryId' => 'User Business Category ID',
            'UserId' => 'User ID',
            'BusinessCategoryId' => 'Business Category ID',
            'Status' => 'Status',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessCategory()
    {
        return $this->hasOne(Businesscategory::className(), ['BusinessCategoryId' => 'BusinessCategoryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Userprofile::className(), ['UserId' => 'UserId']);
    }
}
