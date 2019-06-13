<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "planmaster".
 *
 * @property int $PlanId
 * @property string $PlanName
 * @property int $PlanRate
 * @property int $Duration
 * @property string $EffectiveDate
 * @property int $NumberOfAds
 * @property string $PlanType 1 - Car Sell Plan, 2 - Business Plan
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Businessad[] $businessads
 * @property Car[] $cars
 */
class Planmaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'planmaster';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PlanRate', 'Duration', 'NumberOfAds'], 'integer'],
            [['EffectiveDate', 'CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['PlanName'], 'string', 'max' => 45],
            [['PlanType', 'DeleteTag'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PlanId' => 'Plan ID',
            'PlanName' => 'Plan Name',
            'PlanRate' => 'Plan Rate',
            'Duration' => 'Duration',
            'EffectiveDate' => 'Effective Date',
            'NumberOfAds' => 'Number Of Ads',
            'PlanType' => 'Plan Type',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessads()
    {
        return $this->hasMany(Businessad::className(), ['PlanId' => 'PlanId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCars()
    {
        return $this->hasMany(Car::className(), ['PlanId' => 'PlanId']);
    }
}
