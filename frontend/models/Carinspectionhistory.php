<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carinspectionhistory".
 *
 * @property int $CarInspectionHistoryId
 * @property int $MySavedSearchId
 * @property string $SellerComment
 * @property string $SellerAppointmentDate
 * @property string $BuyerComment
 * @property string $BuyerAppointmentDate
 * @property string $TransactionDate
 * @property int $BuyerUserId
 * @property int $SellerUserId
 * @property string $BuyerDeleteTag 1 - Delete
 * @property string $SellerDeleteTag 1 - Delete
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 *
 * @property Userprofile $buyerUser
 * @property Userprofile $sellerUser
 * @property Mysavedcar $mySavedSearch
 */
class Carinspectionhistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carinspectionhistory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MySavedSearchId', 'BuyerUserId', 'SellerUserId'], 'required'],
            [['MySavedSearchId', 'BuyerUserId', 'SellerUserId'], 'integer'],
            [['BuyerAppointmentDate', 'TransactionDate', 'CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['SellerComment', 'BuyerComment'], 'string', 'max' => 250],
            [['SellerAppointmentDate'], 'string', 'max' => 45],
            [['BuyerDeleteTag', 'SellerDeleteTag'], 'string', 'max' => 1],
            [['BuyerUserId'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::className(), 'targetAttribute' => ['BuyerUserId' => 'UserId']],
            [['SellerUserId'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::className(), 'targetAttribute' => ['SellerUserId' => 'UserId']],
            [['MySavedSearchId'], 'exist', 'skipOnError' => true, 'targetClass' => Mysavedcar::className(), 'targetAttribute' => ['MySavedSearchId' => 'MySavedSearchId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CarInspectionHistoryId' => 'Car Inspection History ID',
            'MySavedSearchId' => 'My Saved Search ID',
            'SellerComment' => 'Seller Comment',
            'SellerAppointmentDate' => 'Seller Appointment Date',
            'BuyerComment' => 'Buyer Comment',
            'BuyerAppointmentDate' => 'Buyer Appointment Date',
            'TransactionDate' => 'Transaction Date',
            'BuyerUserId' => 'Buyer User ID',
            'SellerUserId' => 'Seller User ID',
            'BuyerDeleteTag' => 'Buyer Delete Tag',
            'SellerDeleteTag' => 'Seller Delete Tag',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyerUser()
    {
        return $this->hasOne(Userprofile::className(), ['UserId' => 'BuyerUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSellerUser()
    {
        return $this->hasOne(Userprofile::className(), ['UserId' => 'SellerUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMySavedSearch()
    {
        return $this->hasOne(Mysavedcar::className(), ['MySavedSearchId' => 'MySavedSearchId']);
    }
}
