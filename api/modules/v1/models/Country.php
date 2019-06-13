<?php

namespace api\modules\v1\models;
use \yii\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property string $CountryId
 * @property string $CountryName
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property State[] $states
 */
class Country extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */

    public static function primaryKey()
    {
        return ['CountryId'];
    }
    public function rules()
    {
        return [
            [['CountryId'], 'required'],
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['CountryId'], 'string', 'max' => 3],
            [['CountryName'], 'string', 'max' => 35],
            [['DeleteTag'], 'string', 'max' => 1],
            [['CountryId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CountryId' => 'Country ID',
            'CountryName' => 'Country Name',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStates()
    {
        return $this->hasMany(State::className(), ['CountryId' => 'CountryId']);
    }
}
