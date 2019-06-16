/*
SQLyog Community v13.1.1 (64 bit)
MySQL - 10.1.32-MariaDB : Database - mydb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mydb` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `mydb`;

/*Table structure for table `businessad` */

DROP TABLE IF EXISTS `businessad`;

CREATE TABLE `businessad` (
  `BusinessAdId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `AdName` varchar(45) DEFAULT NULL,
  `ExpiresOn` date DEFAULT NULL,
  `Description` varchar(45) DEFAULT NULL,
  `AdImageURL` varchar(150) DEFAULT NULL,
  `QRCodeURL` blob,
  `PlanId` smallint(6) NOT NULL,
  `PlanStartDate` date DEFAULT NULL,
  `AdStatus` char(1) DEFAULT '0' COMMENT '1 - Delete',
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` date DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`BusinessAdId`),
  KEY `fk_BusinessAd_UserProfile1_idx` (`UserId`),
  KEY `fk_BusinessAd_PlanMaster1_idx` (`PlanId`),
  CONSTRAINT `fk_BusinessAd_PlanMaster1` FOREIGN KEY (`PlanId`) REFERENCES `planmaster` (`PlanId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_BusinessAd_UserProfile1` FOREIGN KEY (`UserId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `businessad` */

insert  into `businessad`(`BusinessAdId`,`UserId`,`AdName`,`ExpiresOn`,`Description`,`AdImageURL`,`QRCodeURL`,`PlanId`,`PlanStartDate`,`AdStatus`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,3,'Cool Cars','0000-00-00','Buy now ',NULL,NULL,9,'0000-00-00','1',NULL,NULL,'0');

/*Table structure for table `businessadlocality` */

DROP TABLE IF EXISTS `businessadlocality`;

CREATE TABLE `businessadlocality` (
  `BusinessAdLocalityId` int(11) NOT NULL AUTO_INCREMENT,
  `BusinessAdId` int(11) NOT NULL,
  `StateId` int(11) NOT NULL,
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` date DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`BusinessAdLocalityId`),
  KEY `fk_BusinessAdLocality_BusinessAd1_idx` (`BusinessAdId`),
  KEY `fk_BusinessAdLocality_State1_idx` (`StateId`),
  CONSTRAINT `fk_BusinessAdLocality_BusinessAd1` FOREIGN KEY (`BusinessAdId`) REFERENCES `businessad` (`BusinessAdId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_BusinessAdLocality_State1` FOREIGN KEY (`StateId`) REFERENCES `state` (`StateId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `businessadlocality` */

insert  into `businessadlocality`(`BusinessAdLocalityId`,`BusinessAdId`,`StateId`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,1,1,NULL,NULL,'0');

/*Table structure for table `businesscategory` */

DROP TABLE IF EXISTS `businesscategory`;

CREATE TABLE `businesscategory` (
  `BusinessCategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `BusinessCategoryDesc` varchar(25) DEFAULT NULL,
  `ImageURL` varchar(150) DEFAULT NULL,
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`BusinessCategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `businesscategory` */

insert  into `businesscategory`(`BusinessCategoryId`,`BusinessCategoryDesc`,`ImageURL`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'Auto Parts ',NULL,NULL,NULL,'0'),
(2,'Insurance ',NULL,NULL,NULL,'0'),
(3,'Mechanics',NULL,NULL,NULL,'0'),
(4,'Car Service ',NULL,NULL,NULL,'0'),
(5,'Car Dealership ',NULL,NULL,NULL,'0'),
(6,'Car Wash ',NULL,NULL,NULL,'0'),
(7,'Driver Training ',NULL,NULL,NULL,'0'),
(8,'Car Rentals',NULL,NULL,NULL,'0'),
(9,'Auto Detailing ',NULL,NULL,NULL,'0'),
(10,'Mobile Mechanics ',NULL,NULL,NULL,'0'),
(11,'Locksmith ',NULL,NULL,NULL,'0'),
(12,'Finance ',NULL,NULL,NULL,'0'),
(13,'Car Parks ',NULL,NULL,NULL,'0'),
(14,'Tyres ',NULL,NULL,NULL,'0');

/*Table structure for table `car` */

DROP TABLE IF EXISTS `car`;

CREATE TABLE `car` (
  `CarId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `CarMakeId` int(11) NOT NULL,
  `CarModelId` int(11) NOT NULL,
  `Edition` varchar(45) DEFAULT NULL,
  `MfgYYYYMM` varchar(6) DEFAULT NULL,
  `Km` int(11) DEFAULT NULL,
  `FuelType` char(10) DEFAULT NULL COMMENT 'Diesel\nElectric\nLPG\nPetrol \nPetrol - Premium ULP\nPetrol - Unleaded ULP\nPetrol of LPG (Dual)\n',
  `Transmission` char(1) DEFAULT NULL COMMENT 'A - Automatic, M - Manual',
  `ColourId` int(11) NOT NULL,
  `FirstOwner` char(1) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `LocationStateId` int(11) NOT NULL,
  `LocationCityId` int(11) NOT NULL,
  `DatePurchased` date DEFAULT NULL,
  `AdStatus` char(1) DEFAULT '0' COMMENT '1 - Removed',
  `DateRemoved` date DEFAULT NULL COMMENT 'Date when car ad was removed before expiration of ad',
  `PlanId` smallint(6) NOT NULL,
  `PPlateApprovedStateId` int(11) NOT NULL,
  `PPlateApprvedCityId` int(11) NOT NULL,
  `ANCAPSafetyRating` char(1) DEFAULT NULL,
  `LifeStyleId` int(11) NOT NULL,
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`CarId`),
  KEY `fk_Car_UserProfile1_idx` (`UserId`),
  KEY `fk_Car_CarModel1_idx` (`CarModelId`),
  KEY `fk_Car_CarMake1_idx` (`CarMakeId`),
  KEY `fk_Car_City1_idx` (`LocationCityId`),
  KEY `fk_Car_City2_idx` (`PPlateApprvedCityId`),
  KEY `fk_Car_LifeStyle1_idx` (`LifeStyleId`),
  KEY `fk_Car_State1_idx` (`LocationStateId`),
  KEY `fk_Car_State2_idx` (`PPlateApprovedStateId`),
  KEY `fk_Car_Colour1_idx` (`ColourId`),
  KEY `fk_Car_PlanMaster1_idx` (`PlanId`),
  CONSTRAINT `fk_Car_CarMake1` FOREIGN KEY (`CarMakeId`) REFERENCES `carmake` (`CarMakeId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_CarModel1` FOREIGN KEY (`CarModelId`) REFERENCES `carmodel` (`CarModelId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_City1` FOREIGN KEY (`LocationCityId`) REFERENCES `city` (`CityId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_City2` FOREIGN KEY (`PPlateApprvedCityId`) REFERENCES `city` (`CityId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_Colour1` FOREIGN KEY (`ColourId`) REFERENCES `mfr`.`colour` (`ColourId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_LifeStyle1` FOREIGN KEY (`LifeStyleId`) REFERENCES `lifestyle` (`LifeStyleId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_PlanMaster1` FOREIGN KEY (`PlanId`) REFERENCES `planmaster` (`PlanId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_State1` FOREIGN KEY (`LocationStateId`) REFERENCES `state` (`StateId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_State2` FOREIGN KEY (`PPlateApprovedStateId`) REFERENCES `state` (`StateId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Car_UserProfile1` FOREIGN KEY (`UserId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `car` */

insert  into `car`(`CarId`,`UserId`,`CarMakeId`,`CarModelId`,`Edition`,`MfgYYYYMM`,`Km`,`FuelType`,`Transmission`,`ColourId`,`FirstOwner`,`Price`,`LocationStateId`,`LocationCityId`,`DatePurchased`,`AdStatus`,`DateRemoved`,`PlanId`,`PPlateApprovedStateId`,`PPlateApprvedCityId`,`ANCAPSafetyRating`,`LifeStyleId`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,2,7,1,'xyz','201704',10000,'Diesel','4',1,'Y',34000,1,1,'0000-00-00','1',NULL,1,1,2,'1',1,NULL,NULL,NULL),
(2,3,3,4,'abc','201800',20000,'Petrol','5',2,'N',25000,2,5,'0000-00-00','1',NULL,1,2,4,'5',2,NULL,NULL,NULL);

/*Table structure for table `carbodytype` */

DROP TABLE IF EXISTS `carbodytype`;

CREATE TABLE `carbodytype` (
  `CarBodyTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `CarBodyTypeName` varchar(45) DEFAULT NULL,
  `ImageURL` varchar(150) DEFAULT NULL,
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` date DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`CarBodyTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `carbodytype` */

insert  into `carbodytype`(`CarBodyTypeId`,`CarBodyTypeName`,`ImageURL`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'Hatch','...',NULL,NULL,'0'),
(2,'Sedan ','...',NULL,NULL,'0'),
(3,'SUV','...',NULL,NULL,'0'),
(4,'Wagon','...',NULL,NULL,'0'),
(5,'Ute','...',NULL,NULL,'0'),
(6,'Cab Chassis','...',NULL,NULL,'0'),
(7,'Convertible','...',NULL,NULL,'0'),
(8,'Coupe ','...',NULL,NULL,'0'),
(9,'People Mover ','...',NULL,NULL,'0'),
(10,'Van ','...',NULL,NULL,'0'),
(11,'Light Truck ','...',NULL,NULL,'0');

/*Table structure for table `carfeaturespec` */

DROP TABLE IF EXISTS `carfeaturespec`;

CREATE TABLE `carfeaturespec` (
  `CarFeatureSpecId` int(12) NOT NULL AUTO_INCREMENT,
  `CarId` int(11) NOT NULL,
  `FeatureSpecSubCategoryValueId` int(11) NOT NULL,
  `Value` varchar(45) DEFAULT NULL,
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`CarFeatureSpecId`),
  KEY `fk_CarFeatureSpec_Car1_idx` (`CarId`),
  KEY `fk_CarFeatureSpec_FeatureSpecSubCategoryValue1_idx` (`FeatureSpecSubCategoryValueId`),
  CONSTRAINT `fk_CarFeatureSpec_Car1` FOREIGN KEY (`CarId`) REFERENCES `car` (`CarId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CarFeatureSpec_FeatureSpecSubCategoryValue1` FOREIGN KEY (`FeatureSpecSubCategoryValueId`) REFERENCES `featurespecsubcategoryvalue` (`FeatureSpecSubCategoryValueId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `carfeaturespec` */

insert  into `carfeaturespec`(`CarFeatureSpecId`,`CarId`,`FeatureSpecSubCategoryValueId`,`Value`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,1,1,'xyz',NULL,NULL,'0'),
(2,1,3,'xyz',NULL,NULL,'0'),
(3,1,5,'xyz',NULL,NULL,'0'),
(4,1,7,'xyz',NULL,NULL,'0'),
(5,1,9,'xyz',NULL,NULL,'0');

/*Table structure for table `carimage` */

DROP TABLE IF EXISTS `carimage`;

CREATE TABLE `carimage` (
  `ImageId` int(12) NOT NULL AUTO_INCREMENT,
  `CarId` int(11) NOT NULL,
  `ImageURL` varchar(150) DEFAULT NULL,
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  `DeleteTag` varchar(1) DEFAULT '0',
  PRIMARY KEY (`ImageId`),
  KEY `fk_CarImage_Car1_idx` (`CarId`),
  CONSTRAINT `fk_CarImage_Car1` FOREIGN KEY (`CarId`) REFERENCES `car` (`CarId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `carimage` */

insert  into `carimage`(`ImageId`,`CarId`,`ImageURL`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,1,'asd',NULL,NULL,'0'),
(2,2,'asda',NULL,NULL,'0'),
(3,1,'sda',NULL,NULL,'0');

/*Table structure for table `carinspectionhistory` */

DROP TABLE IF EXISTS `carinspectionhistory`;

CREATE TABLE `carinspectionhistory` (
  `CarInspectionHistoryId` int(11) NOT NULL AUTO_INCREMENT,
  `MySavedSearchId` int(11) NOT NULL,
  `SellerComment` varchar(250) DEFAULT NULL,
  `SellerAppointmentDate` varchar(45) DEFAULT NULL,
  `BuyerComment` varchar(250) DEFAULT NULL,
  `BuyerAppointmentDate` date DEFAULT NULL,
  `TransactionDate` date DEFAULT NULL,
  `BuyerUserId` int(11) NOT NULL,
  `SellerUserId` int(11) NOT NULL,
  `BuyerDeleteTag` char(1) DEFAULT NULL COMMENT '1 - Delete',
  `SellerDeleteTag` char(1) DEFAULT NULL COMMENT '1 - Delete',
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` date DEFAULT NULL,
  PRIMARY KEY (`CarInspectionHistoryId`),
  KEY `fk_CarInspection_MySavedCar1` (`MySavedSearchId`),
  KEY `fk_CarInspectionHistory_UserProfile1_idx` (`BuyerUserId`),
  KEY `fk_CarInspectionHistory_UserProfile2_idx` (`SellerUserId`),
  CONSTRAINT `fk_CarInspectionHistory_UserProfile1` FOREIGN KEY (`BuyerUserId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CarInspectionHistory_UserProfile2` FOREIGN KEY (`SellerUserId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CarInspection_MySavedCar1` FOREIGN KEY (`MySavedSearchId`) REFERENCES `mysavedcar` (`MySavedSearchId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `carinspectionhistory` */

insert  into `carinspectionhistory`(`CarInspectionHistoryId`,`MySavedSearchId`,`SellerComment`,`SellerAppointmentDate`,`BuyerComment`,`BuyerAppointmentDate`,`TransactionDate`,`BuyerUserId`,`SellerUserId`,`BuyerDeleteTag`,`SellerDeleteTag`,`CreateDateTime`,`ModifyDateTime`) values 
(1,1,'','','Hi','2019-06-16','0000-00-00',1,2,'','','0000-00-00','0000-00-00');

/*Table structure for table `carmake` */

DROP TABLE IF EXISTS `carmake`;

CREATE TABLE `carmake` (
  `CarMakeId` int(11) NOT NULL AUTO_INCREMENT,
  `CarMakeName` varchar(45) DEFAULT NULL,
  `ImageURL` varchar(150) DEFAULT NULL,
  `Popularity` char(1) DEFAULT NULL COMMENT '1- Popular, 0 - Not Popular',
  `CreateDateTime` char(1) DEFAULT NULL,
  `ModifyDateTime` char(1) DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`CarMakeId`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

/*Data for the table `carmake` */

insert  into `carmake`(`CarMakeId`,`CarMakeName`,`ImageURL`,`Popularity`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'Abarth','...','0',NULL,NULL,'0'),
(2,'Alfa Romeo','...','0',NULL,NULL,'0'),
(3,'Alpine','...','0',NULL,NULL,'0'),
(4,'Aston Martin','...','0',NULL,NULL,'0'),
(5,'Audi','...','1',NULL,NULL,'0'),
(6,'Bentley','...','0',NULL,NULL,'0'),
(7,'BMW','...','1',NULL,NULL,'0'),
(8,'Chevrolet','...','0',NULL,NULL,'0'),
(9,'Chrysler','...','0',NULL,NULL,'0'),
(10,'Citroen','...','0',NULL,NULL,'0'),
(11,'Ferrari','...','0',NULL,NULL,'0'),
(12,'Fiat','...','0',NULL,NULL,'0'),
(13,'Ford','...','1',NULL,NULL,'0'),
(14,'Foton','...','0',NULL,NULL,'0'),
(15,'Great Wall','...','0',NULL,NULL,'0'),
(16,'Haval','...','0',NULL,NULL,'0'),
(17,'Holden ','...','0',NULL,NULL,'0'),
(18,'Honda ','...','0',NULL,NULL,'0'),
(19,'HSV','...','0',NULL,NULL,'0'),
(20,'Hyundai ','...','0',NULL,NULL,'0'),
(21,'Infiniti','...','0',NULL,NULL,'0'),
(22,'Isuzu ','...','0',NULL,NULL,'0'),
(23,'Jaguar ','...','1',NULL,NULL,'0'),
(24,'Jeep','...','0',NULL,NULL,'0'),
(25,'Kia ','...','0',NULL,NULL,'0'),
(26,'Lamborgini','...','0',NULL,NULL,'0'),
(27,'Landrover ','...','1',NULL,NULL,'0'),
(28,'LDV','...','0',NULL,NULL,'0'),
(29,'Lotus ','...','0',NULL,NULL,'0'),
(30,'Mahindra ','...','0',NULL,NULL,'0'),
(31,'Maserati ','...','1',NULL,NULL,'0'),
(32,'Mazda ','...','0',NULL,NULL,'0'),
(33,'McClaren ','...','0',NULL,NULL,'0'),
(34,'Mercedes Benz ','...','1',NULL,NULL,'0'),
(35,'MG','...','0',NULL,NULL,'0'),
(36,'Mini ','...','0',NULL,NULL,'0'),
(37,'Mitsubishi ','...','0',NULL,NULL,'0'),
(38,'Nissan ','...','0',NULL,NULL,'0'),
(39,'Peugeot','...','1',NULL,NULL,'0'),
(40,'Porsche ','...','1',NULL,NULL,'0'),
(41,'RAM ','...','0',NULL,NULL,'0'),
(42,'Renault','...','0',NULL,NULL,'0'),
(43,'Rolls Royce ','...','0',NULL,NULL,'0'),
(44,'Skoda ','...','1',NULL,NULL,'0'),
(45,'Ssangyong','...','0',NULL,NULL,'0'),
(46,'Subaru ','...','0',NULL,NULL,'0'),
(47,'Suzuki ','...','0',NULL,NULL,'0'),
(48,'Tata ','...','0',NULL,NULL,'0'),
(49,'Tesla ','...','0',NULL,NULL,'0'),
(50,'Toyota ','...','1',NULL,NULL,'0'),
(51,'Volkswagen','...','0',NULL,NULL,'0'),
(52,'Volvo ','...','1',NULL,NULL,'0');

/*Table structure for table `carmodel` */

DROP TABLE IF EXISTS `carmodel`;

CREATE TABLE `carmodel` (
  `CarModelId` int(11) NOT NULL AUTO_INCREMENT,
  `CarMakeId` int(11) NOT NULL,
  `CarModelName` varchar(45) DEFAULT NULL,
  `CarBodyTypeId` int(11) NOT NULL,
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` date DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`CarModelId`),
  KEY `fk_CarModel_CarMake1_idx` (`CarMakeId`),
  KEY `fk_CarModel_CarBodyType1_idx` (`CarBodyTypeId`),
  CONSTRAINT `fk_CarModel_CarBodyType1` FOREIGN KEY (`CarBodyTypeId`) REFERENCES `carbodytype` (`CarBodyTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CarModel_CarMake1` FOREIGN KEY (`CarMakeId`) REFERENCES `carmake` (`CarMakeId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `carmodel` */

insert  into `carmodel`(`CarModelId`,`CarMakeId`,`CarModelName`,`CarBodyTypeId`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,7,'BMW 1 Series Hatchback',1,NULL,NULL,'0'),
(2,7,'BMW 2 Series Active Tourer',1,NULL,NULL,'0'),
(3,7,'BMW i3 Hatchback',1,NULL,NULL,'0'),
(4,7,'BMW 2 Series Coupe',8,NULL,NULL,'0'),
(5,7,'BMW 4 Series Coupe',8,NULL,NULL,'0'),
(6,7,'BMW M2 Coupe',8,NULL,NULL,'0'),
(7,7,'BMW M4 Coupe',8,NULL,NULL,'0'),
(8,7,'BMW M850i Coupe',8,NULL,NULL,'0'),
(9,7,'BMW i8 Coupe',8,NULL,NULL,'0'),
(10,0,'CarModelName',0,'0000-00-00','0000-00-00','D');

/*Table structure for table `chatdetail` */

DROP TABLE IF EXISTS `chatdetail`;

CREATE TABLE `chatdetail` (
  `ChatDetailId` int(12) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `FriendId` int(11) NOT NULL,
  `ReadTag` varchar(1) DEFAULT NULL COMMENT '0 - not read, 1 - read',
  `MessageDateTime` varchar(45) DEFAULT NULL,
  `MessageText` varchar(1000) DEFAULT NULL,
  `MessageDeleteTag` char(1) DEFAULT '0',
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`ChatDetailId`),
  KEY `fk_ChatDetail_UserProfile1_idx` (`UserId`),
  KEY `fk_ChatDetail_UserProfile2_idx` (`FriendId`),
  CONSTRAINT `fk_ChatDetail_UserProfile1` FOREIGN KEY (`UserId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ChatDetail_UserProfile2` FOREIGN KEY (`FriendId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `chatdetail` */

insert  into `chatdetail`(`ChatDetailId`,`UserId`,`FriendId`,`ReadTag`,`MessageDateTime`,`MessageText`,`MessageDeleteTag`,`CreateDateTime`,`ModifyDateTime`) values 
(1,1,2,'1','31-12-2019 23:59','hdsdsjdgjgds','0',NULL,NULL),
(2,2,1,'1','31-12-2019 23:59','ifdgidfvj ifbihivd','0',NULL,NULL),
(3,1,3,'0','31-12-2019 23:59','idsfhivhfdc idhvih ijsdbv','0',NULL,NULL),
(4,3,1,'1','31-12-2019 23:59','kjsdhvg isdgidf jhd','0',NULL,NULL);

/*Table structure for table `chatfriend` */

DROP TABLE IF EXISTS `chatfriend`;

CREATE TABLE `chatfriend` (
  `ChatFriendId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `FriendId` int(11) NOT NULL,
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`ChatFriendId`),
  KEY `fk_ChatFriend - Delete_UserProfile1_idx` (`UserId`),
  KEY `fk_ChatFriend - Delete_UserProfile2_idx` (`FriendId`),
  CONSTRAINT `fk_ChatFriend - Delete_UserProfile1` FOREIGN KEY (`UserId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ChatFriend - Delete_UserProfile2` FOREIGN KEY (`FriendId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `chatfriend` */

insert  into `chatfriend`(`ChatFriendId`,`UserId`,`FriendId`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,1,2,NULL,NULL,'0'),
(2,2,1,NULL,NULL,'0'),
(3,1,3,NULL,NULL,'0'),
(4,3,1,NULL,NULL,'0');

/*Table structure for table `city` */

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `CityId` int(11) NOT NULL AUTO_INCREMENT,
  `CityName` varchar(45) DEFAULT NULL,
  `StateId` int(11) NOT NULL,
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` date DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`CityId`),
  KEY `fk_City_State1_idx` (`StateId`),
  CONSTRAINT `fk_City_State1` FOREIGN KEY (`StateId`) REFERENCES `state` (`StateId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `city` */

insert  into `city`(`CityId`,`CityName`,`StateId`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'Sydney',1,NULL,NULL,'0'),
(2,'Newcastle-Maitland',1,NULL,NULL,'0'),
(3,'Brisbane',2,NULL,NULL,'0'),
(4,'Sunshine Coast',2,NULL,NULL,'0'),
(5,'Adelaide',3,NULL,NULL,'0'),
(6,'Mount Gambier',3,NULL,NULL,'0'),
(7,'Hobart',4,NULL,NULL,'0'),
(8,'Devonport',4,NULL,NULL,'0'),
(9,'Melbourne ',5,NULL,NULL,'0'),
(10,'Echuca-Moama',5,NULL,NULL,'0'),
(11,'Perth',6,NULL,NULL,'0'),
(12,'Albany',6,NULL,NULL,'0'),
(13,'Kolkata ',7,NULL,NULL,'0'),
(14,'Howrah ',7,NULL,NULL,'0'),
(15,'Patna ',8,NULL,NULL,'0'),
(16,'Gaya',8,NULL,NULL,'0'),
(17,'Puri ',9,NULL,NULL,'0'),
(18,'Bhuvaneshwar',9,NULL,NULL,'0'),
(19,'Guwahati ',10,NULL,NULL,'0'),
(20,'Dispur ',10,NULL,NULL,'0');

/*Table structure for table `colour` */

DROP TABLE IF EXISTS `colour`;

CREATE TABLE `colour` (
  `ColourId` int(11) NOT NULL AUTO_INCREMENT,
  `ColourName` varchar(45) DEFAULT NULL,
  `ImageURL` varchar(45) DEFAULT NULL,
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT NULL,
  PRIMARY KEY (`ColourId`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `colour` */

insert  into `colour`(`ColourId`,`ColourName`,`ImageURL`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'Beige',NULL,NULL,NULL,NULL),
(2,'Black ',NULL,NULL,NULL,NULL),
(3,'Blue ',NULL,NULL,NULL,NULL),
(4,'Bronze ',NULL,NULL,NULL,NULL),
(5,'Brown ',NULL,NULL,NULL,NULL),
(6,'Burgundy ',NULL,NULL,NULL,NULL),
(7,'Gold ',NULL,NULL,NULL,NULL),
(8,'Green ',NULL,NULL,NULL,NULL),
(9,'Grey ',NULL,NULL,NULL,NULL),
(10,'Magenta ',NULL,NULL,NULL,NULL),
(11,'Maroon ',NULL,NULL,NULL,NULL),
(12,'Orange ',NULL,NULL,NULL,NULL),
(13,'Pink ',NULL,NULL,NULL,NULL),
(14,'Purple ',NULL,NULL,NULL,NULL),
(15,'Red ',NULL,NULL,NULL,NULL),
(16,'Silver ',NULL,NULL,NULL,NULL),
(17,'Unknown ',NULL,NULL,NULL,NULL),
(18,'White ',NULL,NULL,NULL,NULL),
(19,'Yellow',NULL,NULL,NULL,NULL);

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `CountryId` char(3) NOT NULL,
  `CountryName` varchar(35) DEFAULT NULL,
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`CountryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `country` */

insert  into `country`(`CountryId`,`CountryName`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
('1','Australia',NULL,NULL,'0'),
('2','India',NULL,NULL,'0');

/*Table structure for table `featurespeccategory` */

DROP TABLE IF EXISTS `featurespeccategory`;

CREATE TABLE `featurespeccategory` (
  `FeatureSpecCategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `FeatureSpecCategoryName` varchar(45) DEFAULT NULL,
  `FeatureSpecType` char(1) DEFAULT NULL COMMENT 'F - Feature, S - Spec',
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` date DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`FeatureSpecCategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `featurespeccategory` */

insert  into `featurespeccategory`(`FeatureSpecCategoryId`,`FeatureSpecCategoryName`,`FeatureSpecType`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'Safety','F',NULL,NULL,'0'),
(2,'Braking & Traction','F',NULL,NULL,'0'),
(3,'Locks & Security','F',NULL,NULL,'0'),
(4,'Comfort & Convenience ','F',NULL,NULL,'0'),
(5,'Seats & Upholstery ','F',NULL,NULL,'0'),
(6,'Storage','F',NULL,NULL,'0'),
(7,'Doors, Windows, Mirrors & Wipers','F',NULL,NULL,'0'),
(8,'Exterior','F',NULL,NULL,'0'),
(9,'Lighting ','F',NULL,NULL,'0'),
(10,'Instrumentaion ','F',NULL,NULL,'0'),
(11,'Entertainment, Information & Communication ','F',NULL,NULL,'0'),
(12,'Dimension & Weight','S',NULL,NULL,'0'),
(13,'Capacity','S',NULL,NULL,'0'),
(14,'Engine & Transmission ','S',NULL,NULL,'0'),
(15,'Suspensions, Brakes, Steering & Tyres','S',NULL,NULL,'0');

/*Table structure for table `featurespecsubcategory` */

DROP TABLE IF EXISTS `featurespecsubcategory`;

CREATE TABLE `featurespecsubcategory` (
  `FeatureSpecSubCategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `FeatureSpecSubCategoryName` varchar(45) DEFAULT NULL,
  `FeatureSpecCategoryId` int(11) NOT NULL,
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` char(1) DEFAULT '0',
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`FeatureSpecSubCategoryId`),
  KEY `fk_FeatureSpecSubCategory_FeatureSpecCategory1_idx` (`FeatureSpecCategoryId`),
  CONSTRAINT `fk_FeatureSpecSubCategory_FeatureSpecCategory1` FOREIGN KEY (`FeatureSpecCategoryId`) REFERENCES `featurespeccategory` (`FeatureSpecCategoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `featurespecsubcategory` */

insert  into `featurespecsubcategory`(`FeatureSpecSubCategoryId`,`FeatureSpecSubCategoryName`,`FeatureSpecCategoryId`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'Airbags',1,NULL,NULL,'0'),
(2,'Dual Stage Airbags',1,NULL,NULL,'0'),
(3,'Middle Rear Three Point Seat Belt',1,NULL,NULL,'0'),
(4,'Middle Rear Head Rest',1,NULL,NULL,'0'),
(5,'No Tyre Pressure Monitoring System',1,NULL,NULL,'0'),
(6,'No Child Seat Anchor Point',1,NULL,NULL,'0'),
(7,'Seat Belt Warning',1,NULL,NULL,'0'),
(8,'Length',12,NULL,NULL,'0'),
(9,'Width',12,NULL,NULL,'0'),
(10,'Height ',12,NULL,NULL,'0'),
(11,'Wheel Base',12,NULL,NULL,'0'),
(12,'Doors ',13,NULL,NULL,'0'),
(13,'Seating Capacity ',13,NULL,NULL,'0'),
(14,'Fuel Tank Capacity',13,NULL,NULL,'0'),
(15,'Cylinders ',14,NULL,NULL,'0'),
(16,'Displacement',14,NULL,NULL,'0'),
(17,'Valves per cylinder ',14,NULL,NULL,'0'),
(18,'Fuel Type',14,NULL,NULL,'0'),
(19,'Fuel System ',14,NULL,NULL,'0'),
(20,'Engine Type ',14,NULL,NULL,'0'),
(21,'Max Power (bhp@rpm)',14,NULL,NULL,'0'),
(22,'Max Torque (nm@rpm)',14,NULL,NULL,'0'),
(23,'Mileage (ARAI)',14,NULL,NULL,'0'),
(24,'No Of Gears',14,NULL,NULL,'0'),
(25,'Transmission',14,NULL,NULL,'0'),
(26,'DriveTrain',14,NULL,NULL,'0'),
(27,'Suspensions',15,NULL,NULL,'0'),
(28,'Suspension Rear',15,NULL,NULL,'0'),
(29,'Front Brake',15,NULL,NULL,'0'),
(30,'Minimum Turning',15,NULL,NULL,'0'),
(31,'Front Tyres',15,NULL,NULL,'0'),
(32,'Rear Tyres',15,NULL,NULL,'0');

/*Table structure for table `featurespecsubcategoryvalue` */

DROP TABLE IF EXISTS `featurespecsubcategoryvalue`;

CREATE TABLE `featurespecsubcategoryvalue` (
  `FeatureSpecSubCategoryValueId` int(11) NOT NULL AUTO_INCREMENT,
  `Value` varchar(45) DEFAULT NULL,
  `FeatureSpecSubCategoryId` int(11) NOT NULL,
  `ValueEntryType` varchar(1) DEFAULT NULL COMMENT 'E - Entered by User, S - Pre defined Selection',
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` date DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`FeatureSpecSubCategoryValueId`),
  KEY `fk_FeatureSpecSubCategoryValue_FeatureSpecSubCategory1_idx` (`FeatureSpecSubCategoryId`),
  CONSTRAINT `fk_FeatureSpecSubCategoryValue_FeatureSpecSubCategory1` FOREIGN KEY (`FeatureSpecSubCategoryId`) REFERENCES `featurespecsubcategory` (`FeatureSpecSubCategoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `featurespecsubcategoryvalue` */

insert  into `featurespecsubcategoryvalue`(`FeatureSpecSubCategoryValueId`,`Value`,`FeatureSpecSubCategoryId`,`ValueEntryType`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'Yes',1,'S',NULL,NULL,'0'),
(2,'No',1,'S',NULL,NULL,'0'),
(3,'Yes',2,'S',NULL,NULL,'0'),
(4,'No',2,'S',NULL,NULL,'0'),
(5,'Yes',3,'S',NULL,NULL,'0'),
(6,'No',3,'S',NULL,NULL,'0'),
(7,'Yes',4,'S',NULL,NULL,'0'),
(8,'No',4,'S',NULL,NULL,'0'),
(9,NULL,8,'E',NULL,NULL,'0'),
(10,NULL,9,'E',NULL,NULL,'0'),
(11,NULL,10,'E',NULL,NULL,'0'),
(12,NULL,11,'E',NULL,NULL,'0');

/*Table structure for table `glovebox` */

DROP TABLE IF EXISTS `glovebox`;

CREATE TABLE `glovebox` (
  `GloveBoxId` int(11) NOT NULL AUTO_INCREMENT,
  `BusinessAdId` int(11) NOT NULL,
  `AdDate` date DEFAULT NULL,
  `GloveBoxDelete` char(1) DEFAULT '0',
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` date DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`GloveBoxId`),
  KEY `fk_GloveBox_BusinessAd1_idx` (`BusinessAdId`),
  CONSTRAINT `fk_GloveBox_BusinessAd1` FOREIGN KEY (`BusinessAdId`) REFERENCES `businessad` (`BusinessAdId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `glovebox` */

insert  into `glovebox`(`GloveBoxId`,`BusinessAdId`,`AdDate`,`GloveBoxDelete`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,1,'0000-00-00','0',NULL,NULL,'0');

/*Table structure for table `lifestyle` */

DROP TABLE IF EXISTS `lifestyle`;

CREATE TABLE `lifestyle` (
  `LifeStyleId` int(11) NOT NULL AUTO_INCREMENT,
  `LifeStyleName` varchar(45) DEFAULT NULL,
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` date DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`LifeStyleId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `lifestyle` */

insert  into `lifestyle`(`LifeStyleId`,`LifeStyleName`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'Family',NULL,NULL,'0'),
(2,'First Car',NULL,NULL,'0'),
(3,'Green ',NULL,NULL,'0'),
(4,'Off-Road',NULL,NULL,'0'),
(5,'Performance',NULL,NULL,'0'),
(6,'Prestige ',NULL,NULL,'0'),
(7,'Tradie',NULL,NULL,'0'),
(8,'Unique',NULL,NULL,'0');

/*Table structure for table `loginhistory` */

DROP TABLE IF EXISTS `loginhistory`;

CREATE TABLE `loginhistory` (
  `LoginHistoryId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `LoginTimeStamp` datetime DEFAULT NULL,
  `LogoutTimeStamp` datetime DEFAULT NULL,
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`LoginHistoryId`),
  KEY `fk_LoginHistory_Login_idx` (`UserId`),
  CONSTRAINT `fk_LoginHistory_Login` FOREIGN KEY (`UserId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `loginhistory` */

insert  into `loginhistory`(`LoginHistoryId`,`UserId`,`LoginTimeStamp`,`LogoutTimeStamp`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL,'0'),
(2,2,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL,'0'),
(3,3,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL,'0');

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values 
('m000000_000000_base',1560331879),
('m130524_201442_init',1560331888),
('m190124_110200_add_verification_token_column_to_user_table',1560331888);

/*Table structure for table `mysavedcar` */

DROP TABLE IF EXISTS `mysavedcar`;

CREATE TABLE `mysavedcar` (
  `MySavedSearchId` int(11) NOT NULL AUTO_INCREMENT,
  `BuyerUserId` int(11) NOT NULL,
  `SellerUserId` int(11) NOT NULL,
  `CarId` int(11) NOT NULL,
  `FavouriteDeleteTag` char(1) DEFAULT NULL COMMENT '1 - Delete',
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`MySavedSearchId`),
  KEY `fk_MySavedSearch_UserProfile1_idx` (`BuyerUserId`),
  KEY `fk_MySavedCar_Car1_idx` (`CarId`),
  KEY `fk_MySavedCar_UserProfile1_idx` (`SellerUserId`),
  CONSTRAINT `fk_MySavedCar_Car1` FOREIGN KEY (`CarId`) REFERENCES `car` (`CarId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_MySavedCar_UserProfile1` FOREIGN KEY (`SellerUserId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_MySavedSearch_UserProfile1` FOREIGN KEY (`BuyerUserId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `mysavedcar` */

insert  into `mysavedcar`(`MySavedSearchId`,`BuyerUserId`,`SellerUserId`,`CarId`,`FavouriteDeleteTag`,`CreateDateTime`,`ModifyDateTime`) values 
(1,1,2,1,'0',NULL,NULL),
(2,1,3,2,'0',NULL,NULL);

/*Table structure for table `planmaster` */

DROP TABLE IF EXISTS `planmaster`;

CREATE TABLE `planmaster` (
  `PlanId` smallint(6) NOT NULL AUTO_INCREMENT,
  `PlanName` varchar(45) DEFAULT NULL,
  `PlanRate` smallint(6) DEFAULT NULL,
  `Duration` int(11) DEFAULT NULL,
  `EffectiveDate` date DEFAULT NULL,
  `NumberOfAds` smallint(6) DEFAULT NULL,
  `PlanType` char(1) DEFAULT NULL COMMENT '1 - Car Sell Plan, 2 - Business Plan',
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`PlanId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `planmaster` */

insert  into `planmaster`(`PlanId`,`PlanName`,`PlanRate`,`Duration`,`EffectiveDate`,`NumberOfAds`,`PlanType`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'Monthly',6,30,NULL,1,'1',NULL,NULL,'0'),
(2,'Yearly',1000,365,NULL,300,'2',NULL,NULL,'0');

/*Table structure for table `state` */

DROP TABLE IF EXISTS `state`;

CREATE TABLE `state` (
  `StateId` int(11) NOT NULL AUTO_INCREMENT,
  `CountryId` char(3) NOT NULL,
  `StateName` varchar(45) DEFAULT NULL,
  `CreateDateTime` date DEFAULT NULL,
  `ModifyDateTime` date DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`StateId`),
  KEY `fk_State_Country1_idx` (`CountryId`),
  CONSTRAINT `fk_State_Country1` FOREIGN KEY (`CountryId`) REFERENCES `country` (`CountryId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `state` */

insert  into `state`(`StateId`,`CountryId`,`StateName`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'1','New South Wales',NULL,NULL,'0'),
(2,'1','Queensland',NULL,NULL,'0'),
(3,'1','South Australia',NULL,NULL,'0'),
(4,'1','Tasmania',NULL,NULL,'0'),
(5,'1',' Victoria ',NULL,NULL,'0'),
(6,'1','Western Australia',NULL,NULL,'0'),
(7,'2','West Bengal ',NULL,NULL,'0'),
(8,'2','Bihar ',NULL,NULL,'0'),
(9,'2','Odisha ',NULL,NULL,'0'),
(10,'2','Assam ',NULL,NULL,'0');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

/*Table structure for table `userbusinesscategory` */

DROP TABLE IF EXISTS `userbusinesscategory`;

CREATE TABLE `userbusinesscategory` (
  `UserBusinessCategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `BusinessCategoryId` int(11) NOT NULL,
  `Status` char(1) DEFAULT NULL COMMENT '1 - Delete',
  `CreateDateTime` datetime DEFAULT NULL,
  `ModifyDateTime` datetime DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`UserBusinessCategoryId`),
  KEY `fk_UserBusinessCategory_UserProfile1_idx` (`UserId`),
  KEY `fk_UserBusinessCategory_BusinessCategory1_idx` (`BusinessCategoryId`),
  CONSTRAINT `fk_UserBusinessCategory_BusinessCategory1` FOREIGN KEY (`BusinessCategoryId`) REFERENCES `businesscategory` (`BusinessCategoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_UserBusinessCategory_UserProfile1` FOREIGN KEY (`UserId`) REFERENCES `userprofile` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `userbusinesscategory` */

insert  into `userbusinesscategory`(`UserBusinessCategoryId`,`UserId`,`BusinessCategoryId`,`Status`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,3,5,'1',NULL,NULL,'0');

/*Table structure for table `userprofile` */

DROP TABLE IF EXISTS `userprofile`;

CREATE TABLE `userprofile` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(25) DEFAULT NULL,
  `FirstName` varchar(35) DEFAULT NULL,
  `LastName` varchar(35) DEFAULT NULL,
  `EmailId` varchar(45) DEFAULT NULL,
  `MobileNo` varchar(15) DEFAULT NULL,
  `SellerType` char(1) DEFAULT '0' COMMENT '1 - Individual, 2 - Dealer, 0 - Normal User/Buyer',
  `Age` smallint(3) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Gender` char(1) DEFAULT NULL COMMENT 'M - Male, F - Female, O - Other',
  `LearnerProvisional` char(1) DEFAULT NULL,
  `Website` varchar(45) DEFAULT NULL,
  `FaceBookLink` varchar(150) DEFAULT NULL,
  `TwitterLink` varchar(150) DEFAULT NULL,
  `InstagramLink` varchar(150) DEFAULT NULL,
  `OtherSocialMedia` varchar(150) DEFAULT NULL,
  `Pwd` varchar(255) DEFAULT NULL,
  `Address1` varchar(35) DEFAULT NULL,
  `CityId` int(11) DEFAULT NULL,
  `ZipCode` varchar(15) DEFAULT NULL,
  `BusinessName` varchar(45) DEFAULT NULL,
  `BusinessDetails` varchar(150) DEFAULT NULL,
  `BusinessInd` char(1) DEFAULT NULL COMMENT '1 -  Business, 0 - non Business',
  `Approved` char(1) DEFAULT NULL COMMENT 'If BusinessInd = Y',
  `MobileVerified` char(1) DEFAULT NULL COMMENT 'Y - verified, N - not Verified',
  `EmailVerified` char(1) DEFAULT NULL COMMENT 'Y - verified, N - not Verified',
  `BusinessLogoURL` varchar(150) DEFAULT NULL,
  `OpeningHours` varchar(25) DEFAULT NULL,
  `ABN` varchar(35) DEFAULT NULL,
  `ACN` varchar(35) DEFAULT NULL,
  `CreateDateTime` datetime DEFAULT CURRENT_TIMESTAMP,
  `ModifyDateTime` datetime DEFAULT NULL,
  `DeleteTag` char(1) DEFAULT '0',
  PRIMARY KEY (`UserId`),
  KEY `fk_UserProfile_City1_idx` (`CityId`),
  CONSTRAINT `fk_UserProfile_City1` FOREIGN KEY (`CityId`) REFERENCES `city` (`CityId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `userprofile` */

insert  into `userprofile`(`UserId`,`UserName`,`FirstName`,`LastName`,`EmailId`,`MobileNo`,`SellerType`,`Age`,`DOB`,`Gender`,`LearnerProvisional`,`Website`,`FaceBookLink`,`TwitterLink`,`InstagramLink`,`OtherSocialMedia`,`Pwd`,`Address1`,`CityId`,`ZipCode`,`BusinessName`,`BusinessDetails`,`BusinessInd`,`Approved`,`MobileVerified`,`EmailVerified`,`BusinessLogoURL`,`OpeningHours`,`ABN`,`ACN`,`CreateDateTime`,`ModifyDateTime`,`DeleteTag`) values 
(1,'Jake001','Jake ','Peralta','jake.peralta@gmail.com','0491 570 156','0',34,'0000-00-00','M','0','www.abc.com','www.abc.com','www.abc.com','www.abc.com','www.abc.com','xyz123','63 Illoura Rd, Romaine, TAS 7320',1,'4006',NULL,NULL,NULL,NULL,'1','1',NULL,NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,'0'),
(2,'Raymond002','Raymond ','Holt','raymond.holt@gmail.com','(08) 9472 0346','1',53,'0000-00-00','M','0','www.abc.com','www.abc.com','www.abc.com','www.abc.com','www.abc.com','xyz123','86 B Kooyong Rd, Rivervale, WA 6103',3,'4005',NULL,NULL,NULL,'N','N','Y',NULL,NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,'0'),
(3,'Terry003','Terrence ','Jefferds','terrence.jefferds@gmail.com','123456789','2',45,'0000-00-00','M','0','www.abc.com','www.abc.com','www.abc.com','www.abc.com','www.abc.com','xyz123','10 Merion Crs, North Lakes',4,'4004',NULL,NULL,NULL,'Y','Y','Y',NULL,NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,'0');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
