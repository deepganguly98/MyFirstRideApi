<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "glovebox".
 *
 * @property int $GloveBoxId
 * @property int $BusinessAdId
 * @property string $AdDate
 * @property string $GloveBoxDelete
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Businessad $businessAd
 */
class Glovebox extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'glovebox';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BusinessAdId'], 'required'],
            [['BusinessAdId'], 'integer'],
            [['AdDate', 'CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['GloveBoxDelete', 'DeleteTag'], 'string', 'max' => 1],
            [['BusinessAdId'], 'exist', 'skipOnError' => true, 'targetClass' => Businessad::className(), 'targetAttribute' => ['BusinessAdId' => 'BusinessAdId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'GloveBoxId' => 'Glove Box ID',
            'BusinessAdId' => 'Business Ad ID',
            'AdDate' => 'Ad Date',
            'GloveBoxDelete' => 'Glove Box Delete',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessAd()
    {
        return $this->hasOne(Businessad::className(), ['BusinessAdId' => 'BusinessAdId']);
    }
}
