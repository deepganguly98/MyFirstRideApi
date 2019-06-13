<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "businessadlocality".
 *
 * @property int $BusinessAdLocalityId
 * @property int $BusinessAdId
 * @property int $StateId
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Businessad $businessAd
 * @property State $state
 */
class Businessadlocality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'businessadlocality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BusinessAdId', 'StateId'], 'required'],
            [['BusinessAdId', 'StateId'], 'integer'],
            [['CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['DeleteTag'], 'string', 'max' => 1],
            [['BusinessAdId'], 'exist', 'skipOnError' => true, 'targetClass' => Businessad::className(), 'targetAttribute' => ['BusinessAdId' => 'BusinessAdId']],
            [['StateId'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['StateId' => 'StateId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'BusinessAdLocalityId' => 'Business Ad Locality ID',
            'BusinessAdId' => 'Business Ad ID',
            'StateId' => 'State ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['StateId' => 'StateId']);
    }
}
