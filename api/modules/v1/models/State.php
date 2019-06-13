<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "state".
 *
 * @property int $StateId
 * @property string $CountryId
 * @property string $StateName
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Businessadlocality[] $businessadlocalities
 * @property Car[] $cars
 * @property Car[] $cars0
 * @property City[] $cities
 * @property Country $country
 */
class State extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'state';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CountryId'], 'required'],
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['CountryId'], 'string', 'max' => 3],
            [['StateName'], 'string', 'max' => 45],
            [['DeleteTag'], 'string', 'max' => 1],
            [['CountryId'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['CountryId' => 'CountryId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'StateId' => 'State ID',
            'CountryId' => 'Country ID',
            'StateName' => 'State Name',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessadlocalities()
    {
        return $this->hasMany(Businessadlocality::className(), ['StateId' => 'StateId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCars()
    {
        return $this->hasMany(Car::className(), ['LocationStateId' => 'StateId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCars0()
    {
        return $this->hasMany(Car::className(), ['PPlateApprovedStateId' => 'StateId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['StateId' => 'StateId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['CountryId' => 'CountryId']);
    }
}
