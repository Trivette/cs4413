CREATE DATABASE  IF NOT EXISTS `uniball` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `uniball`;
-- Host: localhost    Database: uniball
-- ------------------------------------------------------
-- Server version	5.1.50-community

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bets`
--

DROP TABLE IF EXISTS `bets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `who` varchar(40) DEFAULT NULL,
  `game` int(11) DEFAULT NULL,
  `team` varchar(10) DEFAULT NULL,
  `wager` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12791 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `bets` WRITE;
/*!40000 ALTER TABLE `bets` DISABLE KEYS */;
INSERT INTO `bets` VALUES (12701,'primal9',29428,'team1',5),(12702,'nokia',29428,'team1',5),(12703,'nokia',29432,'team1',3),(12704,'q8ball',29433,'team2',5),(12705,'alisonbrie',29434,'team2',5),(12706,'sergio',29435,'team1',5),(12707,'cronoh',29436,'team1',3),(12708,'sergio',29436,'team1',5),(12709,'pakman',29437,'team1',5),(12710,'nachocheese',29440,'team2',5),(12711,'sergio',29440,'team2',5),(12712,'logitech=)',29440,'team2',5),(12713,'logitech=)',29444,'team1',5),(12714,'handgun',29445,'team1',7),(12715,'fiend',29453,'team1',5),(12716,'sergio',29453,'team1',5),(12717,'handgun',29453,'team1',5),(12718,'sergio',29454,'team1',5),(12719,'logitech=)',29455,'team2',5),(12720,'alisonbrie',29455,'team2',7),(12721,'logitech=)',29456,'team1',5),(12722,'alisonbrie',29459,'team2',5),(12723,'alisonbrie',29461,'team2',5),(12724,'logitech=)',29463,'team1',5),(12725,'alisonbrie',29464,'team1',5),(12726,'ninjagaiden',29466,'team1',5),(12727,'sergio',29468,'team1',5),(12728,'nachocheese',29470,'team1',7),(12729,'rramalho',29470,'team1',7),(12730,'jman34',29472,'team2',5),(12731,'fiend',29476,'team2',5),(12732,'alisonbrie',29478,'team1',7),(12733,'fiend',29478,'team1',5),(12734,'logitech=)',29478,'team1',5),(12735,'rramalho',29478,'team1',7),(12736,'alisonbrie',29484,'team2',7),(12737,'fiend',29486,'team2',5),(12738,'ninjagaiden',29487,'team2',5),(12739,'sergio',29490,'team2',5),(12740,'rramalho',29491,'team2',7),(12741,'alisonbrie',29496,'team1',7),(12742,'handgun',29500,'team2',7),(12743,'q8ball',29500,'team2',5),(12744,'ninjagaiden',29507,'team2',7),(12745,'ninjagaiden',29520,'team1',5),(12746,'alisonbrie',29526,'team1',7),(12747,'alisonbrie',29527,'team2',7),(12748,'handgun',29543,'team1',7),(12749,'ninjagaiden',29548,'team1',5),(12750,'logitech=)',29554,'team2',5),(12751,'alisonbrie',29560,'team1',5),(12752,'alisonbrie',29571,'team2',5),(12753,'handgun',29572,'team1',4),(12754,'torque',29572,'team1',6),(12755,'logitech=)',29575,'team1',5),(12756,'ninjagaiden',29577,'team1',5),(12757,'primal9',29579,'team1',5),(12758,'sergio',29579,'team1',5),(12759,'sergio',29586,'team1',5),(12760,'cronoh',29586,'team1',5),(12761,'logitech=)',29593,'team1',7),(12762,'sergio',29593,'team1',5),(12763,'sergio',29594,'team1',7),(12764,'alisonbrie',29598,'team2',5),(12765,'sergio',29601,'team1',5),(12766,'fiend',29601,'team1',5),(12767,'logitech=)',29601,'team1',5),(12768,'logitech=)',29602,'team2',5),(12769,'logitech=)',29603,'team1',5),(12770,'logitech=)',29613,'team1',5),(12771,'frost',29614,'team1',7),(12772,'logitech=)',29630,'team2',5),(12773,'ninjagaiden',29631,'team1',5),(12774,'ninjagaiden',29633,'team1',5),(12775,'ninjagaiden',29645,'team2',7),(12776,'logitech=)',29647,'team2',5),(12777,'frost',29647,'team2',5),(12778,'ninjagaiden',29648,'team2',5),(12779,'logitech=)',29649,'team2',5),(12780,'logitech=)',29653,'team2',1),(12781,'gfc',29657,'team1',5),(12782,'handgun',29658,'team1',7),(12783,'logitech=)',29658,'team1',5),(12784,'logitech=)',29660,'team1',5),(12785,'alisonbrie',29667,'team1',5),(12786,'sergio',29671,'team1',5),(12787,'pennerup',29674,'team1',5),(12788,'sergio',29685,'team1',5),(12789,'sergio',29687,'team1',5),(12790,'logitech=)',29688,'team1',1);
/*!40000 ALTER TABLE `bets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

