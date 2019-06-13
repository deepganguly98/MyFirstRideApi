<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

use Yii;


/**
 * This is the model class for table "colour".
 *
 * @property int $ColourId
 * @property string $ColourName
 * @property string $ImageURL
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Car[] $cars
 */
class Colour extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'colour';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['ColourName', 'ImageURL'], 'string', 'max' => 45],
            [['DeleteTag'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ColourId' => 'Colour ID',
            'ColourName' => 'Colour Name',
            'ImageURL' => 'Image Url',
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
        return $this->hasMany(Car::className(), ['ColourId' => 'ColourId']);
    }
}
