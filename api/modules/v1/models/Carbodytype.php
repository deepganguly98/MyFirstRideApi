<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

use Yii;


/**
 * This is the model class for table "carbodytype".
 *
 * @property int $CarBodyTypeId
 * @property string $CarBodyTypeName
 * @property string $ImageURL
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Carmodel[] $carmodels
 */
class Carbodytype extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carbodytype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['CarBodyTypeName'], 'string', 'max' => 45],
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
            'CarBodyTypeId' => 'Car Body Type ID',
            'CarBodyTypeName' => 'Car Body Type Name',
            'ImageURL' => 'Image Url',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarmodels()
    {
        return $this->hasMany(Carmodel::className(), ['CarBodyTypeId' => 'CarBodyTypeId']);
    }
}
