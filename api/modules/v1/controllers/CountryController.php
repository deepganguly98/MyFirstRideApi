<?php

namespace api\modules\v1\controllers;
use Yii;
use api\modules\v1\models\Country;
use api\modules\v1\models\State;
use yii\rest\ActiveController;
use yii\db\Query;


class CountryController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Country';

    public function actionList(){
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $sql = 'SELECT * FROM country';

        $states = Country::findBySql($sql)->all();

        if(count($states) > 0 ){
            return array('status' => true, 'data'=> $states);
        }
        else{
            return array('status'=>false,'data'=> 'No Student Found');
        }

    }
}