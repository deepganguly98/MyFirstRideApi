<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "featurespecsubcategoryvalue".
 *
 * @property int $FeatureSpecSubCategoryValueId
 * @property string $Value
 * @property int $FeatureSpecSubCategoryId
 * @property string $ValueEntryType E - Entered by User, S - Pre defined Selection
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Carfeaturespec[] $carfeaturespecs
 * @property Featurespecsubcategory $featureSpecSubCategory
 */
class Featurespecsubcategoryvalue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'featurespecsubcategoryvalue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FeatureSpecSubCategoryId'], 'required'],
            [['FeatureSpecSubCategoryId'], 'integer'],
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['Value'], 'string', 'max' => 45],
            [['ValueEntryType', 'DeleteTag'], 'string', 'max' => 1],
            [['FeatureSpecSubCategoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Featurespecsubcategory::className(), 'targetAttribute' => ['FeatureSpecSubCategoryId' => 'FeatureSpecSubCategoryId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'FeatureSpecSubCategoryValueId' => 'Feature Spec Sub Category Value ID',
            'Value' => 'Value',
            'FeatureSpecSubCategoryId' => 'Feature Spec Sub Category ID',
            'ValueEntryType' => 'Value Entry Type',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarfeaturespecs()
    {
        return $this->hasMany(Carfeaturespec::className(), ['FeatureSpecSubCategoryValueId' => 'FeatureSpecSubCategoryValueId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatureSpecSubCategory()
    {
        return $this->hasOne(Featurespecsubcategory::className(), ['FeatureSpecSubCategoryId' => 'FeatureSpecSubCategoryId']);
    }
}
