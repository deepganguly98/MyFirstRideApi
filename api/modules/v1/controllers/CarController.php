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

    public static function allowedDomains()
    {
        return [
            '*',
        ];
    }

/**
 * @inheritdoc
 */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

            // For cross-domain AJAX request
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
                'cors'  => [
                    // restrict access to domains:
                    'Origin' => ['*'],
                    'Access-Control-Allow-Headers'     => ['*'],
                    'Access-Control-Allow-Methods'     => ['HEAD','GET','OPTIONS','POST'],
                    'Access-Control-Max-Age'           => 1000,                 // Cache (seconds)
                ],
            ],

        ]);
    }

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

       /*  $sql = 'SELECT FirstName, LastName, EmailId, MobileNo, Address1, ZipCode FROM userprofile WHERE UserId = :id';
        $details  = Userprofile::findBySql($sql,[':id'=>$json->_SellerUserId])->all();
 */
        $details = (new \yii\db\Query())
                ->select('FirstName, LastName, EmailId, MobileNo, Address1, city.CityName, state.StateName, ZipCode')
                ->from('userprofile')
                ->innerjoin('city','city.CityId = userprofile.cityId')
                ->innerjoin('state','state.StateId = city.StateId')
                ->where(['UserId' => $json->_SellerUserId])
                ->all();
              
        if(count($details)>0){
            return array(
                "_ReturnCode"=>"0",
                "_ReturnMessage"=>"Success",
                "_FirstName"=>$details[0]['FirstName'],
                "_LastName"=>$details[0]['LastName'],
                "_EmailId"=>$details[0]['EmailId'],
                "_MobileNumber"=>$details[0]['MobileNo'],
                "_AddressLine1"=>$details[0]['Address1'],
                "_CityName"=>$details[0]['CityName'],
                "_StateName"=>$details[0]['StateName'],
                "_ZipCode"=>$details[0]['ZipCode']
            );
        }else{
            return array(
                "_ReturnCode"=>"1",
                "_ReturnMessage"=>"Failure"
            );
        }

        
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

    public function actionInitiatechat(){
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $data = \Yii::$app->request->rawBody;
        $json = json_decode($data);

        $tag = (new \yii\db\Query())
            ->select('FavouriteDeleteTag,MySavedSearchId')
            ->from('mysavedcar')
            ->where('BuyerUserId = :id1 and SellerUserId = :id2 and CarId = :id3' ,array(':id1'=>$json->_BuyerUserId,':id2'=>$json->_SellerUserId,':id3'=>$json->_CarId))
            ->all();

        $counts = array_map('count', $tag);
        $status=1;
        for($i = 0; $i<sizeof($tag); $i++){
            if($tag[$i]['FavouriteDeleteTag']=='0'){
                $status = 0;
                \Yii::$app->db->createCommand("UPDATE  carinspectionhistory SET BuyerComment=:com,BuyerAppointmentDate=:dat,BuyerUserId=:bid,SellerUserId=:id WHERE MySavedSearchId=:s")
                ->bindValue(':com', $json->_BuyerComment)
                ->bindValue(':dat', $json->_BuyerAppointmentDate)
                ->bindValue(':bid', $json->_BuyerUserId)
                ->bindValue(':id', $json->_SellerUserId)
                ->bindValue(':s', $tag[$i]['MySavedSearchId'])
                ->execute();
            }
            else{
                $status = 1;
                
            }
            
        }
        
        if($status==0){
            return array(
                "_ReturnCode"=>$status,
                "_ReturnMessage"=>"Success",
            );
        }
        else{
            return array(
                "_ReturnCode"=>$status,
                "_ReturnMessage"=>"Failure",
            );
        }
        
        
    }
    
	
	public function actionGetcars(){
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $data = \Yii::$app->request->rawBody;
        $json = json_decode($data);

        $cars = array(
            '_ReturnCode'=>0,
            '_ReturnMessage'=>"Success",
            'cars'=>[]

        );

        $makeIds = $json->carMakeIds;
        $bodyIds = $json->carBodyTypeIds;
        $modIds = $json->carModelIds;
        $colIds = $json->colourIds;
        $fueltypes = $json->fuelTypes;
        $lifsids = $json->lifestyleIds;
		$city = array();
		if($json->pPlateApprovedLocations != null){
			$pplloc = array($json->pPlateApprovedLocations);
			
			$count = count($pplloc[0]);
			$c=0;
			while($c<$count){
			   if($pplloc[0][$c] != null){
				   array_push($city,intval($pplloc[0][$c]->_CityId));
			   }
				
				$c++; 
			}
			
		}
        

        $rows = (new \yii\db\Query())
            ->select('car.CarId,cm.CarModelName,cm.CarModelId,mysavedcar.SellerUserId,car.CarMakeId,mysavedcar.FavouriteDeleteTag,car.CarModelId,Edition,MfgYYYYMM,Km,FuelType,Transmission,FirstOwner,Price,ANCAPSafetyRating,cc.ColourName,cc.ColourId,cc.ImageURL cURL,city.CityName,city.CityId,state.StateId,state.StateName,country.CountryName,country.CountryId')
            ->distinct()
            ->from('car')
            ->innerjoin('mysavedcar','mysavedcar.CarId = car.CarId')
            ->innerjoin('colour cc','cc.ColourId = car.ColourId')
            ->innerjoin('carimage ci','ci.CarId = car.CarId')
            ->innerjoin('city','city.CityId = car.LocationCityId')
            ->innerjoin('state','state.StateId = car.LocationStateId')
            ->innerjoin('country','country.CountryId = state.CountryId')
            ->innerjoin('carmodel cm','cm.CarMakeId = car.CarMakeId')
            ->innerjoin('carmake','carmake.CarMakeId = car.CarMakeId')
            ->innerjoin('lifestyle','lifestyle.LifeStyleId = car.LifeStyleId')
            ->innerjoin('carbodytype','carbodytype.CarBodyTypeId = cm.CarBodyTypeId')
            ->where('LocationStateId=:id' ,array(':id'=>$json->_LocationStateId))
            ->where(['between','Price', $json->_PriceFrom,$json->_PriceTo])
            ->orWhere(['between','Km', $json->_KilometersFrom,$json->_KilometersTo])
            ->orWhere(['between', 'SUBSTRING(MfgYYYYMM,1,4)', $json->_YearFrom, $json->_YearTo])
            ->orWhere('mysavedcar.BuyerUserId=:id',array(':id'=>$json->_BuyerUserId))
            ->orWhere('Transmission = :t',array(':t'=>$json->_Transmission))
            ->orWhere('ANCAPSafetyRating = :r',array(':r'=>$json->_AncapSafetyRating))
            ->orFilterWhere(['or',
                ['cm.CarMakeId'=>$makeIds],
                ['cm.CarBodyTypeId'=>$bodyIds],
                ['cm.CarModelId'=>$modIds],
                ['cc.ColourId'=>$colIds],
                ['FuelType'=>$fueltypes],
                ['car.LifeStyleId'=>$lifsids],
                ['PPlateApprvedCityId'=>$city]
                ])
            ->orFilterWhere(['or',
                ['cc.ColourName'=>$json->_SearchKeywords],
                ['cm.CarModelName'=>$json->_SearchKeywords],
                ['city.CityName'=>$json->_SearchKeywords],
                ['state.StateName'=>$json->_SearchKeywords],
                ['country.CountryName'=>$json->_SearchKeywords],
                ['Edition'=>$json->_SearchKeywords],
                ['FuelType'=>$json->_SearchKeywords],
                ['carmake.CarMakeName'=>$json->_SearchKeywords],
                ['carbodytype.CarBodyTypeName'=>$json->_SearchKeywords],
                ['lifestyle.LifeStyleName'=>$json->_SearchKeywords],
                ])
            ->all();
        
        $images = (new \yii\db\Query())
            ->select('ci.ImageId _ImageId,ci.ImageURL _ImageUrl')
            ->distinct()
            ->from('car')
            ->innerjoin('mysavedcar','mysavedcar.CarId = car.CarId')
            ->innerjoin('colour cc','cc.ColourId = car.ColourId')
            ->innerjoin('carimage ci','ci.CarId = car.CarId')
            ->innerjoin('city','city.CityId = car.LocationCityId')
            ->innerjoin('state','state.StateId = car.LocationStateId')
            ->innerjoin('country','country.CountryId = state.CountryId')
            ->innerjoin('carmodel cm','cm.CarMakeId = car.CarModelId')
            ->innerjoin('carmake','carmake.CarMakeId = car.CarMakeId')
            ->innerjoin('lifestyle','lifestyle.LifeStyleId = car.LifeStyleId')
            ->innerjoin('carbodytype','carbodytype.CarBodyTypeId = cm.CarBodyTypeId')
            ->where('LocationStateId=:id' ,array(':id'=>$json->_LocationStateId))
            ->where(['between','Price', $json->_PriceFrom,$json->_PriceTo])
            ->orWhere(['between','Km', $json->_KilometersFrom,$json->_KilometersTo])
            ->orWhere(['between', 'SUBSTRING(MfgYYYYMM,1,4)', $json->_YearFrom, $json->_YearTo])
            ->orWhere('mysavedcar.BuyerUserId=:id',array(':id'=>$json->_BuyerUserId))
            ->orWhere('Transmission = :t',array(':t'=>$json->_Transmission))
            ->orWhere('ANCAPSafetyRating = :r',array(':r'=>$json->_AncapSafetyRating))
            ->orFilterWhere(['or',
                ['cm.CarMakeId'=>$makeIds],
                ['cm.CarBodyTypeId'=>$bodyIds],
                ['cm.CarModelId'=>$modIds],
                ['cc.ColourId'=>$colIds],
                ['FuelType'=>$fueltypes],
                ['car.LifeStyleId'=>$lifsids],
                ['PPlateApprvedCityId'=>$city]
                ])
            ->orFilterWhere(['or',
                ['cc.ColourName'=>$json->_SearchKeywords],
                ['cm.CarModelName'=>$json->_SearchKeywords],
                ['city.CityName'=>$json->_SearchKeywords],
                ['state.StateName'=>$json->_SearchKeywords],
                ['country.CountryName'=>$json->_SearchKeywords],
                ['Edition'=>$json->_SearchKeywords],
                ['FuelType'=>$json->_SearchKeywords],
                ['carmake.CarMakeName'=>$json->_SearchKeywords],
                ['carbodytype.CarBodyTypeName'=>$json->_SearchKeywords],
                ['lifestyle.LifeStyleName'=>$json->_SearchKeywords],
                ])
            ->all();

        $result = array([]);
        for($i=0;$i<sizeof($rows);$i++){
            if($rows[$i]['FavouriteDeleteTag']==0){
                $tag = "true";
            }
            else{
                $tag = "false";
            }
            $result = array(
                '_CarId' => $rows[$i]['CarId'],
                '_SellerUserId' => $rows[$i]['SellerUserId'],
                '_IsFavourite' => $tag,
                '_CarMakeId' => $rows[$i]['CarMakeId'],
                "_CarModelId"=>$rows[$i]['CarModelId'],
                 "_CarModelName"=>$rows[$i]['CarModelName'],
                '_Edition' => $rows[$i]['Edition'],
                '_MfgDate' => $rows[$i]['MfgYYYYMM'],
                '_Km' => $rows[$i]['Km'],
                '_FuelType' => $rows[$i]['FuelType'],
                '_Transmission' => $rows[$i]['Transmission'],
                'colour'=>[
                    '_Name' => $rows[$i]['ColourName'],
                    '_ImageURL' => $rows[$i]['cURL'],
                    '_Id' => $rows[$i]['ColourId']
                ],
                '_FirstOwner' => $rows[$i]['FirstOwner'],
                '_Price' => $rows[$i]['Price'],
                '_ANCAPSafetyRating' => $rows[$i]['ANCAPSafetyRating'],
                'location'=>[
                    '_StateId' => $rows[$i]['StateId'],
                    '_StateName' => $rows[$i]['StateName'],
                    '_CityId' => $rows[$i]['CityId'],
                    '_CityName' => $rows[$i]['CityName'],
                    '_CountryId' => $rows[$i]['CountryId'],
                    '_CountryName' => $rows[$i]['CountryName']
                ],
                'images' => $images
            );
            array_push($cars['cars'],$result);
        }
        //return $rows;
        if(count($rows)>0){
            return $cars;
        }
        else{
            return array(
            '_ReturnCode'=>1,
            '_ReturnMessage'=>"Failure"
            );
        }
        
    }
    

    public function actionGetcardetails(){
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $data = \Yii::$app->request->rawBody;
        $json = json_decode($data);

        $cars = array(
            '_ReturnCode'=>0,
            '_ReturnMessage'=>"Success",
            'cars'=>[]

        );

        $rows = (new \yii\db\Query())
            ->select('car.ModifyDateTime,car.CarId,mysavedcar.SellerUserId,car.CarMakeId,mysavedcar.FavouriteDeleteTag,cm.CarModelName,cm.CarModelId,Edition,MfgYYYYMM Year,Km,FuelType,Transmission,FirstOwner,Price,ANCAPSafetyRating,cc.ColourName,cc.ColourId,cc.ImageURL cURL,city.CityName,city.CityId,state.StateId,state.StateName,country.CountryName,country.CountryId')
            ->distinct()
            ->from('car')
            ->innerjoin('mysavedcar','mysavedcar.CarId = car.CarId')
            ->innerjoin('colour cc','cc.ColourId = car.ColourId')
            ->innerjoin('carimage ci','ci.CarId = car.CarId')
            ->innerjoin('city','city.CityId = car.LocationCityId')
            ->innerjoin('state','state.StateId = car.LocationStateId')
            ->innerjoin('country','country.CountryId = state.CountryId')
            ->innerjoin('carmake','carmake.CarMakeId = car.CarMakeId')
            ->innerjoin('carmodel cm','cm.CarModelId = car.CarModelId')
            ->innerjoin('lifestyle','lifestyle.LifeStyleId = car.LifeStyleId')
            ->innerjoin('carbodytype','carbodytype.CarBodyTypeId = cm.CarBodyTypeId')
            ->where('car.CarId=:id' ,array(':id'=>$json->_CarId))
            ->all();

            $images = (new \yii\db\Query())
                ->select('ci.ImageId _ImageId,ci.ImageURL _ImageUrl')
                ->distinct()
                ->from('car')
                ->innerjoin('carimage ci','ci.CarId = car.CarId')
                ->where('car.CarId=:id' ,array(':id'=>$json->_CarId))
                ->all();
            
            $features = (new \yii\db\Query())
                ->select('*')
                ->distinct()
                ->from('carfeaturespec')
                ->innerjoin('FeatureSpecSubCategoryValue','carfeaturespec.FeatureSpecSubCategoryValueId = featurespecsubcategoryvalue.FeatureSpecSubCategoryValueId')
                ->innerjoin('featurespecsubcategory','featurespecsubcategory.FeatureSpecSubCategoryId = featurespecsubcategoryvalue.FeatureSpecSubCategoryId')
                ->innerjoin('featurespeccategory','featurespeccategory.FeatureSpecCategoryId = featurespecsubcategory.FeatureSpecCategoryId')
                ->where('CarId=:id' ,array(':id'=>$json->_CarId))
                ->all();

            
            $featurevalues=array("X"=>"X");
            for($i=0;$i<count($features);$i++){
                if($features[$i]['FeatureSpecType']=='F'){
                    $featurevalues = array_merge_recursive($featurevalues,
                        array($features[$i]['FeatureSpecCategoryName']=>$features[$i]['FeatureSpecSubCategoryName'])
                        
                    );
                } 
            }
            $keyname= array();
            foreach($featurevalues as $key=>$value){
                if($key != "X"){
                    array_push($keyname,array('_FeatureHeading'=>$key,'featureValues'=>$value));
                }
                
                //echo "<br/>";   
            }


            $specs = (new \yii\db\Query())
                ->select('FeatureSpecType,cfs.Value val,FeatureSpecCategoryName,FeatureSpecSubCategoryName')
                ->distinct()
                ->from('carfeaturespec cfs')
                ->innerjoin('FeatureSpecSubCategoryValue','cfs.FeatureSpecSubCategoryValueId = featurespecsubcategoryvalue.FeatureSpecSubCategoryValueId')
                ->innerjoin('featurespecsubcategory','featurespecsubcategory.FeatureSpecSubCategoryId = featurespecsubcategoryvalue.FeatureSpecSubCategoryId')
                ->innerjoin('featurespeccategory','featurespeccategory.FeatureSpecCategoryId = featurespecsubcategory.FeatureSpecCategoryId')
                ->where('CarId=:id' ,array(':id'=>$json->_CarId))
                ->all();
            
            $specvalues=array("X"=>"X");
            for($i=0;$i<count($specs);$i++){
                if($specs[$i]['FeatureSpecType']=='S'){
                    $specvalues = array_merge_recursive($specvalues,array($specs[$i]['FeatureSpecCategoryName']=>
                    [
                        '_SubHeading'=>$specs[$i]['FeatureSpecSubCategoryName'],
                        '_Value'=>$specs[$i]['val']
                    ]
                )); 
                }
            }

            $keyname2 = array();
            foreach($specvalues as $key=>$value){
                if($key != "X"){
                    array_push($keyname2,array('_SpecificationName'=>$key,'specificationValues'=>[$value]));
                }
                
                //echo "<br/>";   
            }


            $result = array([]);
            for($i=0;$i<sizeof($rows);$i++){
                if($rows[$i]['FavouriteDeleteTag']==0){
                    $tag = "true";
                }
                else{
                    $tag = "false";
                }
                $result = array(
                    "_ReturnCode"=>"0",
                    "_ReturnMessage"=>"Success",
                    '_CarId' => $rows[$i]['CarId'],
                    '_IsFavourite' => $tag,
                    "_CarModelName"=>$rows[$i]['CarModelName'],
                    '_Edition' => $rows[$i]['Edition'],
                    '_Year' => substr($rows[$i]['Year'],0,4),
                    '_ModifiedDateTime' => $rows[$i]['ModifyDateTime'],
                    '_Km' => $rows[$i]['Km'],
                    '_FuelType' => $rows[$i]['FuelType'],
                    '_Transmission' => $rows[$i]['Transmission'],
                    'colour'=>[
                        '_Name' => $rows[$i]['ColourName'],
                        '_ImageURL' => $rows[$i]['cURL'],
                        '_Id' => $rows[$i]['ColourId']
                    ],
                    '_FirstOwner' => $rows[$i]['FirstOwner'],
                    '_Price' => $rows[$i]['Price'],
                    '_ANCAPSafetyRating' => $rows[$i]['ANCAPSafetyRating'],
                    'location'=>[
                        '_StateId' => $rows[$i]['StateId'],
                        '_StateName' => $rows[$i]['StateName'],
                        '_CityId' => $rows[$i]['CityId'],
                        '_CityName' => $rows[$i]['CityName'],
                        '_CountryId' => $rows[$i]['CountryId'],
                        '_CountryName' => $rows[$i]['CountryName']
                    ],
                    'images' => $images,
                    'features' => $keyname,
                    'specifications' => $keyname2
                );
                array_push($cars['cars'],$result);
            }
            //return $cars;
            if(count($result)>0){
                return $result;
            }
            else{
                return array(
                '_ReturnCode'=>1,
                '_ReturnMessage'=>"Failure"
                );
            }
    }
}