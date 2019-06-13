<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "featurespecsubcategory".
 *
 * @property int $FeatureSpecSubCategoryId
 * @property string $FeatureSpecSubCategoryName
 * @property int $FeatureSpecCategoryId
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Featurespeccategory $featureSpecCategory
 * @property Featurespecsubcategoryvalue[] $featurespecsubcategoryvalues
 */
class Featurespecsubcategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'featurespecsubcategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FeatureSpecCategoryId'], 'required'],
            [['FeatureSpecCategoryId'], 'integer'],
            [['CreateDateTime'], 'safe'],
            [['FeatureSpecSubCategoryName'], 'string', 'max' => 45],
            [['ModifyDateTime', 'DeleteTag'], 'string', 'max' => 1],
            [['FeatureSpecCategoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Featurespeccategory::className(), 'targetAttribute' => ['FeatureSpecCategoryId' => 'FeatureSpecCategoryId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'FeatureSpecSubCategoryId' => 'Feature Spec Sub Category ID',
            'FeatureSpecSubCategoryName' => 'Feature Spec Sub Category Name',
            'FeatureSpecCategoryId' => 'Feature Spec Category ID',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatureSpecCategory()
    {
        return $this->hasOne(Featurespeccategory::className(), ['FeatureSpecCategoryId' => 'FeatureSpecCategoryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeaturespecsubcategoryvalues()
    {
        return $this->hasMany(Featurespecsubcategoryvalue::className(), ['FeatureSpecSubCategoryId' => 'FeatureSpecSubCategoryId']);
    }
}
