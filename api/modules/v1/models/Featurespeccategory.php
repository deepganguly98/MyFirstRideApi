<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "featurespeccategory".
 *
 * @property int $FeatureSpecCategoryId
 * @property string $FeatureSpecCategoryName
 * @property string $FeatureSpecType F - Feature, S - Spec
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Featurespecsubcategory[] $featurespecsubcategories
 */
class Featurespeccategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'featurespeccategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['FeatureSpecCategoryName'], 'string', 'max' => 45],
            [['FeatureSpecType', 'DeleteTag'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'FeatureSpecCategoryId' => 'Feature Spec Category ID',
            'FeatureSpecCategoryName' => 'Feature Spec Category Name',
            'FeatureSpecType' => 'Feature Spec Type',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeaturespecsubcategories()
    {
        return $this->hasMany(Featurespecsubcategory::className(), ['FeatureSpecCategoryId' => 'FeatureSpecCategoryId']);
    }
}
