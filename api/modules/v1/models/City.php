<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $CityId
 * @property string $CityName
 * @property int $StateId
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Car[] $cars
 * @property Car[] $cars0
 * @property State $state
 * @property Userprofile[] $userprofiles
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['StateId'], 'required'],
            [['StateId'], 'integer'],
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['CityName'], 'string', 'max' => 45],
            [['DeleteTag'], 'string', 'max' => 1],
            [['StateId'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['StateId' => 'StateId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CityId' => 'City ID',
            'CityName' => 'City Name',
            'StateId' => 'State ID',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCars()
    {
        return $this->hasMany(Car::className(), ['LocationCityId' => 'CityId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCars0()
    {
        return $this->hasMany(Car::className(), ['PPlateApprvedCityId' => 'CityId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['StateId' => 'StateId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserprofiles()
    {
        return $this->hasMany(Userprofile::className(), ['CityId' => 'CityId']);
    }
}
