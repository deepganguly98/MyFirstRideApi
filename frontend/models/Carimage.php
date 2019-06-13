<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carimage".
 *
 * @property int $ImageId
 * @property int $CarId
 * @property string $ImageURL
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Car $car
 */
class Carimage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carimage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CarId'], 'required'],
            [['CarId'], 'integer'],
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['ImageURL'], 'string', 'max' => 150],
            [['DeleteTag'], 'string', 'max' => 1],
            [['CarId'], 'exist', 'skipOnError' => true, 'targetClass' => Car::className(), 'targetAttribute' => ['CarId' => 'CarId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ImageId' => 'Image ID',
            'CarId' => 'Car ID',
            'ImageURL' => 'Image Url',
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
}
