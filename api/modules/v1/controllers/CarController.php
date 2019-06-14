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
use api\modules\v1\models\Userprofile;
use api\modules\v1\models\MySavedcar;
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
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $data = \Yii::$app->request->rawBody;
        $json = json_decode($data);

        $result = array(
            '_ReturnCode' => '0',
            '_ReturnMessage' => 'Success',
            'carMakes'=>[
                
            ]
            
        );

        foreach($json->CarBodyTypeId as $ti){
            foreach($json->CarMakeId as $mi){
                //echo "(".$ti.",".$mi.")"."\n";
                $rows = (new \yii\db\Query())
                    ->select('carmodel.CarModelId,carmodel.CarModelName')
                    ->from('carmodel')
                    ->innerjoin('carbodytype','carbodytype.CarBodyTypeId = carmodel.CarBodyTypeId')
                    ->innerjoin('carmake', 'carmake.CarMakeId = carmodel.CarMakeId')
                    ->where(['and','carbodytype.CarBodyTypeId = :id','carmake.CarMakeId = :id2'],array(':id'=>$ti,':id2'=>$mi))
                    ->all();

                $name = Carmake::find()
                    ->select('CarMakeName')
                    ->asArray()
                    ->where(['CarMakeId' => $mi])
                    ->one();

                $subresult = array(
                    '_CarBodyTypeId' => $ti,
                    '_CarMakeId' => $mi,
                    '_CarMakeName' => $name['CarMakeName'],
                    'modelsAvailable'=>$rows
                );
                
                array_push($result['carMakes'],$subresult);
            }
        } 

        if($result != null){
            return $result;
        }
        else{
            return array('_ReturnCode' => "1",'_ReturnMessage' => 'Failure');
        }
    }

    public function actionGetsellerdetails(){
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $data = \Yii::$app->request->rawBody;
        $json = json_decode($data);

        $sql = 'SELECT FirstName, LastName, EmailId, MobileNo, Address1, ZipCode FROM userprofile WHERE UserId = :id';
        $details  = Userprofile::findBySql($sql,[':id'=>$json->_SellerUserId])->all();

        $details = (new \yii\db\Query())
                ->select('FirstName, LastName, EmailId, MobileNo, Address1, city.CityName, state.StateName, ZipCode')
                ->from('userprofile')
                ->innerjoin('city','city.CityId = userprofile.cityId')
                ->innerjoin('state','state.StateId = city.StateId')
                ->where(['UserId' => $json->_SellerUserId])
                ->all();
              

        return $details;
    }

    public function actionMakecarfavorite(){
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $data = \Yii::$app->request->rawBody;
        $json = json_decode($data);

        $tag = (new \yii\db\Query())
            ->select('FavouriteDeleteTag')
            ->from('mysavedcar')
            ->where('BuyerUserId = :id1 and SellerUserId = :id2 and CarId = :id3' ,array(':id1'=>$json->_BuyerUserId,':id2'=>$json->_SellerUserId,':id3'=>$json->_CarId))
            ->all();

        $counts = array_map('count', $tag);
        $status=1;
        for($i = 0; $i<sizeof($tag); $i++){
            if($tag[$i]['FavouriteDeleteTag']=='1'){
                $status = 0;
                \Yii::$app->db->createCommand("UPDATE mysavedcar SET FavouriteDeleteTag=:val WHERE BuyerUserId = :id1 AND SellerUserId = :id2 AND CarId = :id3")
                ->bindValue(':val',0)
                ->bindValue(':id1', $json->_BuyerUserId)
                ->bindValue(':id2', $json->_SellerUserId)
                ->bindValue(':id3', $json->_CarId)
                ->execute();
            }
            else{
                $status = 0;
                \Yii::$app->db->createCommand("UPDATE mysavedcar SET FavouriteDeleteTag=:val WHERE BuyerUserId = :id1 AND SellerUserId = :id2 AND CarId = :id3")
                ->bindValue(':val',1)
                ->bindValue(':id1', $json->_BuyerUserId)
                ->bindValue(':id2', $json->_SellerUserId)
                ->bindValue(':id3', $json->_CarId)
                ->execute();
            }
            
        }

        $sql = 'SELECT FavouriteDeleteTag FROM  mysavedcar WHERE BuyerUserId = :id1 AND SellerUserId = :id2 AND CarId = :id3';
        $tags = Mysavedcar::findBySql($sql,[':id1'=>$json->_BuyerUserId,':id2'=>$json->_SellerUserId,':id3'=>$json->_CarId])->one();

        
        if($status==0){
            return array(
                "_ReturnCode"=>$status,
                "_ReturnMessage"=>"Success",
                "_FavouriteDeleteTag"=>$tags['FavouriteDeleteTag']
            );
        }
        else{
            return array(
                "_ReturnCode"=>$status,
                "_ReturnMessage"=>"Failure",
            );
        }
        
    }
}