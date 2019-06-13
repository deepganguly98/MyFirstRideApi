<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mysavedcar".
 *
 * @property int $MySavedSearchId
 * @property int $BuyerUserId
 * @property int $SellerUserId
 * @property int $CarId
 * @property string $FavouriteDeleteTag 1 - Delete
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 *
 * @property Carinspectionhistory[] $carinspectionhistories
 * @property Car $car
 * @property Userprofile $sellerUser
 * @property Userprofile $buyerUser
 */
class Mysavedcar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mysavedcar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BuyerUserId', 'SellerUserId', 'CarId'], 'required'],
            [['BuyerUserId', 'SellerUserId', 'CarId'], 'integer'],
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['FavouriteDeleteTag'], 'string', 'max' => 1],
            [['CarId'], 'exist', 'skipOnError' => true, 'targetClass' => Car::className(), 'targetAttribute' => ['CarId' => 'CarId']],
            [['SellerUserId'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::className(), 'targetAttribute' => ['SellerUserId' => 'UserId']],
            [['BuyerUserId'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::className(), 'targetAttribute' => ['BuyerUserId' => 'UserId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MySavedSearchId' => 'My Saved Search ID',
            'BuyerUserId' => 'Buyer User ID',
            'SellerUserId' => 'Seller User ID',
            'CarId' => 'Car ID',
            'FavouriteDeleteTag' => 'Favourite Delete Tag',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarinspectionhistories()
    {
        return $this->hasMany(Carinspectionhistory::className(), ['MySavedSearchId' => 'MySavedSearchId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(Car::className(), ['CarId' => 'CarId']);
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
    public function getBuyerUser()
    {
        return $this->hasOne(Userprofile::className(), ['UserId' => 'BuyerUserId']);
    }
}
