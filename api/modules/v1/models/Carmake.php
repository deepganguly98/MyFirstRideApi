<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

use Yii;


/**
 * This is the model class for table "carmake".
 *
 * @property int $CarMakeId
 * @property string $CarMakeName
 * @property string $ImageURL
 * @property string $Popularity 1- Popular, 0 - Not Popular
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Car[] $cars
 * @property Carmodel[] $carmodels
 */
class Carmake extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carmake';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CarMakeName'], 'string', 'max' => 45],
            [['ImageURL'], 'string', 'max' => 150],
            [['Popularity', 'CreateDateTime', 'ModifyDateTime', 'DeleteTag'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CarMakeId' => 'Car Make ID',
            'CarMakeName' => 'Car Make Name',
            'ImageURL' => 'Image Url',
            'Popularity' => 'Popularity',
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
        return $this->hasMany(Car::className(), ['CarMakeId' => 'CarMakeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarmodels()
    {
        return $this->hasMany(Carmodel::className(), ['CarMakeId' => 'CarMakeId']);
    }
}
