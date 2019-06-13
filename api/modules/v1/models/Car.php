<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "car".
 *
 * @property int $CarId
 * @property int $UserId
 * @property int $CarMakeId
 * @property int $CarModelId
 * @property string $Edition
 * @property string $MfgYYYYMM
 * @property int $Km
 * @property string $FuelType Diesel Electric LPG Petrol  Petrol - Premium ULP Petrol - Unleaded ULP Petrol of LPG (Dual) 
 * @property string $Transmission A - Automatic, M - Manual
 * @property int $ColourId
 * @property string $FirstOwner
 * @property int $Price
 * @property int $LocationStateId
 * @property int $LocationCityId
 * @property string $DatePurchased
 * @property string $AdStatus 1 - Removed
 * @property string $DateRemoved Date when car ad was removed before expiration of ad
 * @property int $PlanId
 * @property int $PPlateApprovedStateId
 * @property int $PPlateApprvedCityId
 * @property string $ANCAPSafetyRating
 * @property int $LifeStyleId
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Carmake $carMake
 * @property Carmodel $carModel
 * @property City $locationCity
 * @property City $pPlateApprvedCity
 * @property Colour $colour
 * @property Lifestyle $lifeStyle
 * @property Planmaster $plan
 * @property State $locationState
 * @property State $pPlateApprovedState
 * @property Userprofile $user
 * @property Carfeaturespec[] $carfeaturespecs
 * @property Carimage[] $carimages
 * @property Mysavedcar[] $mysavedcars
 */
class Car extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserId', 'CarMakeId', 'CarModelId', 'ColourId', 'LocationStateId', 'LocationCityId', 'PlanId', 'PPlateApprovedStateId', 'PPlateApprvedCityId', 'LifeStyleId'], 'required'],
            [['UserId', 'CarMakeId', 'CarModelId', 'Km', 'ColourId', 'Price', 'LocationStateId', 'LocationCityId', 'PlanId', 'PPlateApprovedStateId', 'PPlateApprvedCityId', 'LifeStyleId'], 'integer'],
            [['DatePurchased', 'DateRemoved', 'CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['Edition'], 'string', 'max' => 45],
            [['MfgYYYYMM'], 'string', 'max' => 6],
            [['FuelType'], 'string', 'max' => 10],
            [['Transmission', 'FirstOwner', 'AdStatus', 'ANCAPSafetyRating', 'DeleteTag'], 'string', 'max' => 1],
            [['CarMakeId'], 'exist', 'skipOnError' => true, 'targetClass' => Carmake::className(), 'targetAttribute' => ['CarMakeId' => 'CarMakeId']],
            [['CarModelId'], 'exist', 'skipOnError' => true, 'targetClass' => Carmodel::className(), 'targetAttribute' => ['CarModelId' => 'CarModelId']],
            [['LocationCityId'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['LocationCityId' => 'CityId']],
            [['PPlateApprvedCityId'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['PPlateApprvedCityId' => 'CityId']],
            [['ColourId'], 'exist', 'skipOnError' => true, 'targetClass' => Colour::className(), 'targetAttribute' => ['ColourId' => 'ColourId']],
            [['LifeStyleId'], 'exist', 'skipOnError' => true, 'targetClass' => Lifestyle::className(), 'targetAttribute' => ['LifeStyleId' => 'LifeStyleId']],
            [['PlanId'], 'exist', 'skipOnError' => true, 'targetClass' => Planmaster::className(), 'targetAttribute' => ['PlanId' => 'PlanId']],
            [['LocationStateId'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['LocationStateId' => 'StateId']],
            [['PPlateApprovedStateId'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['PPlateApprovedStateId' => 'StateId']],
            [['UserId'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::className(), 'targetAttribute' => ['UserId' => 'UserId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CarId' => 'Car ID',
            'UserId' => 'User ID',
            'CarMakeId' => 'Car Make ID',
            'CarModelId' => 'Car Model ID',
            'Edition' => 'Edition',
            'MfgYYYYMM' => 'Mfg Yyyymm',
            'Km' => 'Km',
            'FuelType' => 'Fuel Type',
            'Transmission' => 'Transmission',
            'ColourId' => 'Colour ID',
            'FirstOwner' => 'First Owner',
            'Price' => 'Price',
            'LocationStateId' => 'Location State ID',
            'LocationCityId' => 'Location City ID',
            'DatePurchased' => 'Date Purchased',
            'AdStatus' => 'Ad Status',
            'DateRemoved' => 'Date Removed',
            'PlanId' => 'Plan ID',
            'PPlateApprovedStateId' => 'P Plate Approved State ID',
            'PPlateApprvedCityId' => 'P Plate Apprved City ID',
            'ANCAPSafetyRating' => 'Ancap Safety Rating',
            'LifeStyleId' => 'Life Style ID',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarMake()
    {
        return $this->hasOne(Carmake::className(), ['CarMakeId' => 'CarMakeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarModel()
    {
        return $this->hasOne(Carmodel::className(), ['CarModelId' => 'CarModelId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocationCity()
    {
        return $this->hasOne(City::className(), ['CityId' => 'LocationCityId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPPlateApprvedCity()
    {
        return $this->hasOne(City::className(), ['CityId' => 'PPlateApprvedCityId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColour()
    {
        return $this->hasOne(Colour::className(), ['ColourId' => 'ColourId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLifeStyle()
    {
        return $this->hasOne(Lifestyle::className(), ['LifeStyleId' => 'LifeStyleId']);
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
    public function getLocationState()
    {
        return $this->hasOne(State::className(), ['StateId' => 'LocationStateId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPPlateApprovedState()
    {
        return $this->hasOne(State::className(), ['StateId' => 'PPlateApprovedStateId']);
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
    public function getCarfeaturespecs()
    {
        return $this->hasMany(Carfeaturespec::className(), ['CarId' => 'CarId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarimages()
    {
        return $this->hasMany(Carimage::className(), ['CarId' => 'CarId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMysavedcars()
    {
        return $this->hasMany(Mysavedcar::className(), ['CarId' => 'CarId']);
    }
}
