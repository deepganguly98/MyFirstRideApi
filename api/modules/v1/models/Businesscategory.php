<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "businesscategory".
 *
 * @property int $BusinessCategoryId
 * @property string $BusinessCategoryDesc
 * @property string $ImageURL
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Userbusinesscategory[] $userbusinesscategories
 */
class Businesscategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'businesscategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['BusinessCategoryDesc'], 'string', 'max' => 25],
            [['ImageURL'], 'string', 'max' => 150],
            [['DeleteTag'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'BusinessCategoryId' => 'Business Category ID',
            'BusinessCategoryDesc' => 'Business Category Desc',
            'ImageURL' => 'Image Url',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserbusinesscategories()
    {
        return $this->hasMany(Userbusinesscategory::className(), ['BusinessCategoryId' => 'BusinessCategoryId']);
    }
}
