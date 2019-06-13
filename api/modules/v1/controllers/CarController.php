<?php

namespace api\modules\v1\controllers;
use Yii;
use api\modules\v1\models\Car;
use api\modules\v1\models\Carbodytype;
use api\modules\v1\models\Carmodel;
use api\modules\v1\models\Carmake;
use api\modules\v1\models\State;
use api\modules\v1\models\City;
use api\modules\v1\models\Country;
use api\modules\v1\models\Lifestyle;
use api\modules\v1\models\Colour;
use yii\rest\ActiveController;
use yii\db\Query;


class CarController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Car';

    public function actionGetcarinfo(){
        $data = \Yii::$app->request->rawBody;
        $json = json_decode($data);


        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $sql = 'SELECT CarBodyTypeId,CarBodyTypeName,ImageURL FROM carbodytype';
        $cartype = Carbodytype::findBySql($sql)->all();

        $sql = 'SELECT CarMakeId,CarMakeName,Popularity,ImageURL FROM carmake';
        $carmake = Carmake::findBySql($sql)->all();

        /* $sql = 'SELECT state.StateId, state.StateName, city.CityId, city.CityName, country.CountryId, country.CountryName FROM country INNER JOIN state ON state.CountryId = country.CountryId INNER JOIN city ON city.stateId = state.stateId WHERE country.CountryId=:id';
        $location = Country::findBySql($sql,[':id'=>1])->all(); */
        $id = $json->CountryId;
        $rows = (new \yii\db\Query())
            ->select('state.StateId, state.StateName, city.CityId, city.CityName, country.CountryId, country.CountryName')
            ->from('country')
            ->innerjoin('state','state.CountryId = country.CountryId')
            ->innerjoin('city', 'city.stateId = state.stateId')
            ->where('country.CountryId=:id', array(':id'=>$id))
            ->all();

        $sql = 'SELECT LifeStyleId,LifeStyleName FROM lifestyle';
        $lifestyle = Lifestyle::findBySql($sql)->all();

        $sql = 'SELECT ColourId,ColourName,ImageURL FROM colour';
        $color = Colour::findBySql($sql)->all();

        $cartypejson =json_encode($cartype);
        
        //var_dump($cartype);

        if(count($rows) > 0 ){
            return array(
                '_ReturnCode' => "0",
                '_ReturnMessage' => 'Success',
                'bodyTypes'=> $cartype,
                'carMakes'=>$carmake,
                'location' => $rows,
                'lifestyles' => $lifestyle,
                'colours' => $color
            );
        }
        else{
            return array('_ReturnCode' => "1",'_ReturnMessage' => 'Failure');
        }

    }
    public function actionGetcarmodels(){
        $data = \Yii::$app->request->rawBody;
        $json = json_decode($data);


        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        /* $sql = 'SELECT CarMakeId,CarMakeName FROM carmake WHERE CarMakeId=:id';
        $carmake = Carmake::findBySql($sql,[':id'=>$json->CarMakeId])->all(); 

        $sql = 'SELECT CarBodyTypeId FROM carbodytype WHERE CarBodyTypeId=:id';
        $carbody = Carbodytype::findBySql($sql,[':id'=>$json->CarBodyTypeId])->all();
 */
        $rows = (new \yii\db\Query())
            ->select('carmodel.CarModelId,carmodel.CarModelName')
            ->from('carmodel')
            ->innerjoin('carbodytype','carbodytype.CarBodyTypeId = carmodel.CarBodyTypeId')
            ->innerjoin('carmake', 'carmake.CarMakeId = carmodel.CarMakeId')
            ->where(['and','carbodytype.CarBodyTypeId = :id','carmake.CarMakeId = :id2'],array(':id'=>$json->CarBodyTypeId,':id2'=>$json->CarMakeId))
            ->all();

        $id = $json->CarMakeId;
        $name = Carmake::find()
            ->select('CarMakeName')
            ->asArray()
            ->where(['CarMakeId' => $id])
            ->one();

        if(count($rows)>0){
            return array(
                '_ReturnCode' => '0',
                '_ReturnMessage' => 'Success',
                'carMakes'=>[
                    '_CarBodyTypeId' => $json->CarBodyTypeId,
                    '_CarMakeId' => $json->CarMakeId,
                    '_CarMakeName' => $name['CarMakeName'],
                    'modelsAvailable'=>$rows
                ]
                
            );
        }
        else{
            return array('_ReturnCode' => "1",'_ReturnMessage' => 'Failure');
        }
    }
}