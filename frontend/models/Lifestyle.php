<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lifestyle".
 *
 * @property int $LifeStyleId
 * @property string $LifeStyleName
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Car[] $cars
 */
class Lifestyle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lifestyle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['LifeStyleName'], 'string', 'max' => 45],
            [['DeleteTag'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LifeStyleId' => 'Life Style ID',
            'LifeStyleName' => 'Life Style Name',
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
        return $this->hasMany(Car::className(), ['LifeStyleId' => 'LifeStyleId']);
    }
}
