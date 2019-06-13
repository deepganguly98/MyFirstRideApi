<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carmodel".
 *
 * @property int $CarModelId
 * @property int $CarMakeId
 * @property string $CarModelName
 * @property int $CarBodyTypeId
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Car[] $cars
 * @property Carbodytype $carBodyType
 * @property Carmake $carMake
 */
class Carmodel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carmodel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CarMakeId', 'CarBodyTypeId'], 'required'],
            [['CarMakeId', 'CarBodyTypeId'], 'integer'],
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['CarModelName'], 'string', 'max' => 45],
            [['DeleteTag'], 'string', 'max' => 1],
            [['CarBodyTypeId'], 'exist', 'skipOnError' => true, 'targetClass' => Carbodytype::className(), 'targetAttribute' => ['CarBodyTypeId' => 'CarBodyTypeId']],
            [['CarMakeId'], 'exist', 'skipOnError' => true, 'targetClass' => Carmake::className(), 'targetAttribute' => ['CarMakeId' => 'CarMakeId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CarModelId' => 'Car Model ID',
            'CarMakeId' => 'Car Make ID',
            'CarModelName' => 'Car Model Name',
            'CarBodyTypeId' => 'Car Body Type ID',
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
        return $this->hasMany(Car::className(), ['CarModelId' => 'CarModelId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarBodyType()
    {
        return $this->hasOne(Carbodytype::className(), ['CarBodyTypeId' => 'CarBodyTypeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarMake()
    {
        return $this->hasOne(Carmake::className(), ['CarMakeId' => 'CarMakeId']);
    }
}
