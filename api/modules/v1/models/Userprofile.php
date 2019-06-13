<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userprofile".
 *
 * @property int $UserId
 * @property string $UserName
 * @property string $FirstName
 * @property string $LastName
 * @property string $EmailId
 * @property string $MobileNo
 * @property string $SellerType 1 - Individual, 2 - Dealer, 0 - Normal User/Buyer
 * @property int $Age
 * @property string $DOB
 * @property string $Gender M - Male, F - Female, O - Other
 * @property string $LearnerProvisional
 * @property string $Website
 * @property string $FaceBookLink
 * @property string $TwitterLink
 * @property string $InstagramLink
 * @property string $OtherSocialMedia
 * @property string $Pwd
 * @property string $Address1
 * @property int $CityId
 * @property string $ZipCode
 * @property string $BusinessName
 * @property string $BusinessDetails
 * @property string $BusinessInd 1 -  Business, 0 - non Business
 * @property string $Approved If BusinessInd = Y
 * @property string $MobileVerified Y - verified, N - not Verified
 * @property string $EmailVerified Y - verified, N - not Verified
 * @property string $BusinessLogoURL
 * @property string $OpeningHours
 * @property string $ABN
 * @property string $ACN
 * @property string $CreateDateTime
 * @property string $ModifyDateTime
 * @property string $DeleteTag
 *
 * @property Businessad[] $businessads
 * @property Car[] $cars
 * @property Carinspectionhistory[] $carinspectionhistories
 * @property Carinspectionhistory[] $carinspectionhistories0
 * @property Chatdetail[] $chatdetails
 * @property Chatdetail[] $chatdetails0
 * @property Chatfriend[] $chatfriends
 * @property Chatfriend[] $chatfriends0
 * @property Loginhistory[] $loginhistories
 * @property Mysavedcar[] $mysavedcars
 * @property Mysavedcar[] $mysavedcars0
 * @property Userbusinesscategory[] $userbusinesscategories
 * @property City $city
 */
class Userprofile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userprofile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Age', 'CityId'], 'integer'],
            [['DOB', 'CreateDateTime', 'ModifyDateTime'], 'safe'],
            [['UserName', 'OpeningHours'], 'string', 'max' => 25],
            [['FirstName', 'LastName', 'Address1', 'ABN', 'ACN'], 'string', 'max' => 35],
            [['EmailId', 'Website', 'BusinessName'], 'string', 'max' => 45],
            [['MobileNo', 'ZipCode'], 'string', 'max' => 15],
            [['SellerType', 'Gender', 'LearnerProvisional', 'BusinessInd', 'Approved', 'MobileVerified', 'EmailVerified', 'DeleteTag'], 'string', 'max' => 1],
            [['FaceBookLink', 'TwitterLink', 'InstagramLink', 'OtherSocialMedia', 'BusinessDetails', 'BusinessLogoURL'], 'string', 'max' => 150],
            [['Pwd'], 'string', 'max' => 255],
            [['CityId'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['CityId' => 'CityId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'UserId' => 'User ID',
            'UserName' => 'User Name',
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'EmailId' => 'Email ID',
            'MobileNo' => 'Mobile No',
            'SellerType' => 'Seller Type',
            'Age' => 'Age',
            'DOB' => 'Dob',
            'Gender' => 'Gender',
            'LearnerProvisional' => 'Learner Provisional',
            'Website' => 'Website',
            'FaceBookLink' => 'Face Book Link',
            'TwitterLink' => 'Twitter Link',
            'InstagramLink' => 'Instagram Link',
            'OtherSocialMedia' => 'Other Social Media',
            'Pwd' => 'Pwd',
            'Address1' => 'Address1',
            'CityId' => 'City ID',
            'ZipCode' => 'Zip Code',
            'BusinessName' => 'Business Name',
            'BusinessDetails' => 'Business Details',
            'BusinessInd' => 'Business Ind',
            'Approved' => 'Approved',
            'MobileVerified' => 'Mobile Verified',
            'EmailVerified' => 'Email Verified',
            'BusinessLogoURL' => 'Business Logo Url',
            'OpeningHours' => 'Opening Hours',
            'ABN' => 'Abn',
            'ACN' => 'Acn',
            'CreateDateTime' => 'Create Date Time',
            'ModifyDateTime' => 'Modify Date Time',
            'DeleteTag' => 'Delete Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessads()
    {
        return $this->hasMany(Businessad::className(), ['UserId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCars()
    {
        return $this->hasMany(Car::className(), ['UserId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarinspectionhistories()
    {
        return $this->hasMany(Carinspectionhistory::className(), ['BuyerUserId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarinspectionhistories0()
    {
        return $this->hasMany(Carinspectionhistory::className(), ['SellerUserId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatdetails()
    {
        return $this->hasMany(Chatdetail::className(), ['UserId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatdetails0()
    {
        return $this->hasMany(Chatdetail::className(), ['FriendId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatfriends()
    {
        return $this->hasMany(Chatfriend::className(), ['UserId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatfriends0()
    {
        return $this->hasMany(Chatfriend::className(), ['FriendId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoginhistories()
    {
        return $this->hasMany(Loginhistory::className(), ['UserId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMysavedcars()
    {
        return $this->hasMany(Mysavedcar::className(), ['SellerUserId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMysavedcars0()
    {
        return $this->hasMany(Mysavedcar::className(), ['BuyerUserId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserbusinesscategories()
    {
        return $this->hasMany(Userbusinesscategory::className(), ['UserId' => 'UserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['CityId' => 'CityId']);
    }
}
