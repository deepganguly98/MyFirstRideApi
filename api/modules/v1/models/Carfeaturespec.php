<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carfeaturespec".
 *
 * @property int $CarFeatureSpecId
 * @property int $CarId
 * @property int $FeatureSpecSubCategoryValueId
 * @property string $Value
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Car $car
 * @property Featurespecsubcategoryvalue $featureSpecSubCategoryValue
 */
class Carfeaturespec extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carfeaturespec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CarId', 'FeatureSpecSubCategoryValueId'], 'required'],
            [['CarId', 'FeatureSpecSubCategoryValueId'], 'integer'],
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['Value'], 'string', 'max' => 45],
            [['DeleteTag'], 'string', 'max' => 1],
            [['CarId'], 'exist', 'skipOnError' => true, 'targetClass' => Car::className(), 'targetAttribute' => ['CarId' => 'CarId']],
            [['FeatureSpecSubCategoryValueId'], 'exist', 'skipOnError' => true, 'targetClass' => Featurespecsubcategoryvalue::className(), 'targetAttribute' => ['FeatureSpecSubCategoryValueId' => 'FeatureSpecSubCategoryValueId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CarFeatureSpecId' => 'Car Feature Spec ID',
            'CarId' => 'Car ID',
            'FeatureSpecSubCategoryValueId' => 'Feature Spec Sub Category Value ID',
            'Value' => 'Value',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
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
    public function getFeatureSpecSubCategoryValue()
    {
        return $this->hasOne(Featurespecsubcategoryvalue::className(), ['FeatureSpecSubCategoryValueId' => 'FeatureSpecSubCategoryValueId']);
    }
}
