
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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `comment` text,
  `subject` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tbl_action` WRITE;
/*!40000 ALTER TABLE `tbl_action` DISABLE KEYS */;
INSERT INTO `tbl_action` VALUES (1,'message_write',NULL,NULL),(2,'message_receive',NULL,NULL),(4,'video_premium','Access to Premium Videos',NULL);
/*!40000 ALTER TABLE `tbl_action` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_advertising_campaign` (
  `createtime` int(11) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL,
  `url_picture` varchar(255) NOT NULL,
  `url_link` varchar(255) DEFAULT NULL,
  `payment_date` int(11) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `script` text CHARACTER SET utf8 NOT NULL,
  `mode` enum('image','text','script') CHARACTER SET utf8 NOT NULL,
  `sponsor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `positions` varchar(255) CHARACTER SET utf8 NOT NULL,
  `countries` varchar(255) CHARACTER SET utf8 NOT NULL,
  `dimension` int(10) unsigned NOT NULL,
  `price` double(11,0) NOT NULL,
  `type` enum('period','scope') CHARACTER SET utf8 NOT NULL,
  `priority` enum('1','2','3','4','5') CHARACTER SET utf8 NOT NULL,
  `tags` varchar(255) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `sponsor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tbl_position` (
  `title` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_advertising_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text,
  `dimension` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `type` enum('PERIOD','SCOPE') NOT NULL,
  `option` enum('ROTATE','KATEGORIE') NOT NULL,
  `banner_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tbl_advertising_type` WRITE;
/*!40000 ALTER TABLE `tbl_advertising_type` DISABLE KEYS */;
INSERT INTO `tbl_advertising_type` VALUES (2,'AI - Rotierend - Paket S (BB)',NULL,'5000',40,'SCOPE','ROTATE',1),(3,'AI - Rotierend - Paket S (SB)',NULL,'5000',65,'SCOPE','ROTATE',3),(4,'AI - Rotierend - Paket S (WS)',NULL,'5000',70,'SCOPE','ROTATE',2),(5,'AI - Kategorie - Paket S (BB)',NULL,'5000',50,'SCOPE','KATEGORIE',1),(6,'AI - Kategorie - Paket S (SB)',NULL,'5000',70,'SCOPE','KATEGORIE',3),(7,'AI - Kategorie - Paket S (WS)',NULL,'5000',75,'SCOPE','KATEGORIE',2),(8,'AI - Rotierend - Paket M (BB)',NULL,'10000',80,'SCOPE','ROTATE',1),(9,'AI - Rotierend - Paket M (SB)',NULL,'10000',100,'SCOPE','ROTATE',3),(10,'AI - Rotierend - Paket M (WS)',NULL,'10000',110,'SCOPE','ROTATE',2),(11,'AI - Kategorie - Paket M (BB)',NULL,'10000',90,'SCOPE','KATEGORIE',1),(12,'AI - Kategorie - Paket M (SB)',NULL,'10000',120,'SCOPE','KATEGORIE',3),(13,'AI - Kategorie - Paket M (WS)',NULL,'10000',130,'SCOPE','KATEGORIE',2),(14,'AI - Rotierend - Paket L (BB)',NULL,'20000',120,'SCOPE','ROTATE',1),(15,'AI - Kategorie - Paket L (BB)',NULL,'20000',130,'SCOPE','KATEGORIE',1),(16,'AI - Rotierend - Paket L (SB)',NULL,'20000',170,'SCOPE','ROTATE',3),(17,'AI - Kategorie - Paket L (SB)',NULL,'20000',180,'SCOPE','KATEGORIE',3),(18,'AI - Rotierend - Paket L (WS)',NULL,'20000',180,'SCOPE','ROTATE',2),(19,'AI - Kategorie - Paket L (WS)',NULL,'20000',190,'SCOPE','KATEGORIE',2),(20,'AI - Rotierend - Paket XL (BB)',NULL,'50000',250,'SCOPE','ROTATE',1),(21,'AI - Kategorie - Paket XL (BB)',NULL,'50000',280,'SCOPE','KATEGORIE',1),(22,'AI - Rotierend - Paket XL (SB)',NULL,'50000',450,'SCOPE','ROTATE',3),(23,'AI - Kategorie - Paket XL (SB)',NULL,'50000',480,'SCOPE','KATEGORIE',3),(24,'AI - Rotierend - Paket XL (WS)',NULL,'50000',470,'SCOPE','ROTATE',2),(25,'AI - Kategorie - Paket XL (WS)',NULL,'50000',490,'SCOPE','KATEGORIE',2),(26,'Zeit - Rotierend - Paket S (BB)',NULL,'1',60,'PERIOD','ROTATE',1),(27,'Zeit - Kategorie - Paket S (BB)',NULL,'1',80,'PERIOD','KATEGORIE',1),(28,'Zeit - Rotierend - Paket S (SB)',NULL,'1',80,'PERIOD','ROTATE',3),(29,'Zeit - Kategorie - Paket S (SB)',NULL,'1',100,'PERIOD','KATEGORIE',3),(30,'Zeit - Rotierend - Paket S (WS)',NULL,'1',90,'PERIOD','ROTATE',2),(31,'Zeit - Kategorie - Paket S (WS)',NULL,'1',110,'PERIOD','KATEGORIE',2),(32,'Zeit - Rotierend - Paket M (BB)',NULL,'2',120,'PERIOD','ROTATE',1),(33,'Zeit - Kategorie - Paket M (BB)',NULL,'2',150,'PERIOD','KATEGORIE',1),(34,'Zeit - Rotierend - Paket M (SB)',NULL,'2',150,'PERIOD','ROTATE',3),(35,'Zeit - Kategorie - Paket M (SB)',NULL,'2',180,'PERIOD','KATEGORIE',3),(36,'Zeit - Rotierend - Paket M (WS)','','2',170,'PERIOD','ROTATE',2),(37,'Zeit - Kategorie - Paket M (WS)',NULL,'2',200,'PERIOD','KATEGORIE',2),(38,'Zeit - Rotierend - Paket L (BB)',NULL,'4',220,'PERIOD','ROTATE',1),(39,'Zeit - Kategorie - Paket L (BB)',NULL,'4',250,'PERIOD','KATEGORIE',1),(40,'Zeit - Rotierend - Paket XL (BB)',NULL,'8',300,'PERIOD','ROTATE',1),(41,'Zeit - Kategorie - Paket XL (BB)',NULL,'8',330,'PERIOD','KATEGORIE',1),(42,'Zeit - Rotierend - Paket L (SB)',NULL,'4',260,'PERIOD','ROTATE',3),(43,'Zeit - Kategorie - Paket L (SB)',NULL,'4',320,'PERIOD','KATEGORIE',3),(44,'Zeit - Kategorie - Paket L (WS)',NULL,'4',340,'PERIOD','KATEGORIE',2),(45,'Zeit - Rotierend - Paket L (WS)',NULL,'4',280,'PERIOD','ROTATE',2),(46,'Zeit - Rotierend - Paket XL (SB)',NULL,'8',440,'PERIOD','ROTATE',3),(47,'Zeit - Kategorie - Paket XL (SB)',NULL,'8',550,'PERIOD','KATEGORIE',3),(48,'Zeit - Rotierend - Paket XL (WS)',NULL,'8',470,'PERIOD','ROTATE',2),(49,'Zeit - Kategorie - Paket XL (WS)',NULL,'8',570,'PERIOD','KATEGORIE',2);
/*!40000 ALTER TABLE `tbl_advertising_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_seo_keywords_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(40) NOT NULL,
  `page` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - not published, 1 - published',
  `number_of_searches` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_tbl_seo_keywords_page_word_page` (`word`,`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='contains the keywords used in a google search to reach a pag';
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_stars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `letter` varchar(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2280 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tbl_stars` WRITE;
/*!40000 ALTER TABLE `tbl_stars` DISABLE KEYS */;
INSERT INTO `tbl_stars` VALUES (1,'a','Aaralyn Barra'),(2,'a','Abbey Brooks'),(3,'a','Abby Rode'),(4,'a','Abigail Clayton'),(5,'a','Addison Rose'),(6,'a','Adicktion'),(7,'a','Adina'),(8,'a','Adrenalynn'),(9,'a','Adriana'),(10,'a','Adriana Amante'),(11,'a','Adriana Malkova'),(12,'a','Adriana Nevaeh'),(13,'a','Adriana Neveah'),(14,'a','Adriana Sage'),(15,'a','Adrianna'),(16,'a','Adrianna DeVille'),(17,'a','Adrianna Faust'),(18,'a','Adrianna Nicole'),(19,'a','Africa'),(20,'a','Agatha Meirelles'),(21,'a','Agnes Zalontai'),(22,'a','Ahryan Astyn'),(23,'a','Aidan Layne'),(24,'a','Aiden Layne'),(25,'a','Aiden Starr'),(26,'a','Aika Miura'),(27,'a','Aimee Sweet'),(28,'a','Aimee Tyler'),(29,'a','Aisha'),(30,'a','AJ Bailey'),(31,'a','Akane Hotaru'),(32,'a','Alana Evans'),(33,'a','Alana Lee'),(34,'a','Alana Leigh'),(35,'a','Alaura Eden'),(36,'a','Alayah Sashu'),(37,'a','Aleera Flair'),(38,'a','Alektra Blowbang'),(39,'a','Alektra Blue'),(40,'a','Alessandra Marques'),(41,'a','Alessia Roma'),(42,'a','Aletta Alien'),(43,'a','Aletta Florancia'),(44,'a','Aletta Ocean'),(45,'a','Alette Ocean'),(46,'a','Alex'),(47,'a','Alex Del Monacco'),(48,'a','Alex Devine'),(49,'a','Alex Love'),(50,'a','Alexa'),(51,'a','Alexa May'),(52,'a','Alexa Rae'),(53,'a','Alexa Von Tess'),(54,'a','Alexa Weix'),(55,'a','Alexandra'),(56,'a','Alexandra Nice'),(57,'a','Alexandria'),(58,'a','Alexia Night'),(59,'a','Alexia Sky'),(60,'a','Alexis Amor'),(61,'a','Alexis Amore'),(62,'a','Alexis Capri'),(63,'a','Alexis Duval'),(64,'a','Alexis Golden'),(65,'a','Alexis Love'),(66,'a','Alexis Malone'),(67,'a','Alexis May'),(68,'a','Alexis Silver'),(69,'a','Alexis Taylor'),(70,'a','Alexis Texas'),(71,'a','Ali Kat'),(72,'a','Aliana Love'),(73,'a','Alicia Alighatti'),(74,'a','Alicia Angel'),(75,'a','Alicia Rhodes'),(76,'a','Alicia Tyler'),(77,'a','Alicyn Sterling'),(78,'a','Aline'),(79,'a','Alisa'),(80,'a','Alisha Klass'),(81,'a','Alison Angel'),(82,'a','Alissa'),(83,'a','Alissa Melano'),(84,'a','Allie Foster'),(85,'a','Allie Ray'),(86,'a','Allie Sin'),(87,'a','Allisa'),(88,'a','Allison Miller'),(89,'a','Allison Pierce'),(90,'a','Allison Wyte'),(91,'a','Allura Eden'),(92,'a','Allysin Chaines'),(93,'a','Allyssa Hall'),(94,'a','Alyss Jenkins'),(95,'a','Alyssa Dior'),(96,'a','Alyssa Haven'),(97,'a','Alyssa Reese'),(98,'a','Alyssa West'),(99,'a','Amanda'),(100,'a','Amanda West'),(101,'a','Amber'),(102,'a','Amber Ashley'),(103,'a','Amber Easton'),(104,'a','Amber Lynn'),(105,'a','Amber Lynn Bach'),(106,'a','Amber Michaels'),(107,'a','Amber Peach'),(108,'a','Amber Rain'),(109,'a','Amber Rayne'),(110,'a','Amber Simpson'),(111,'a','Amber Sky'),(112,'a','Ameara'),(113,'a','Amee Donovan'),(114,'a','America'),(115,'a','Amparo'),(116,'a','Amy Reid'),(117,'a','Ana Nova'),(118,'a','Ana Paula'),(119,'a','Ana Paula Oliveira'),(120,'a','Anabelle'),(121,'a','Anais Alexander'),(122,'a','Ananova'),(123,'a','Anastasia'),(124,'a','Anastasia Blue'),(125,'a','Anastasia Christ'),(126,'a','Anastasia Devine'),(127,'a','Anastasia Mayo'),(128,'a','Anastasia Pierce'),(129,'a','Ander Page'),(130,'a','Andie Valentino'),(131,'a','Andrea Anderson'),(132,'a','Andrea Ash'),(133,'a','Andrea Rincon'),(134,'a','Andy San Dimas'),(135,'a','Anetta Keys'),(136,'a','Anette Dawn'),(137,'a','Anette Shwartz'),(138,'a','Angel'),(139,'a','Angel & Ashley Long'),(140,'a','Angel Cummings'),(141,'a','Angel Dark'),(142,'a','Angel Eyes'),(143,'a','Angel Long'),(144,'a','Angel Love'),(145,'a','Angel Madrid'),(146,'a','Angela Crystal'),(147,'a','Angela Devi'),(148,'a','Angela Devine'),(149,'a','Angela Di Angelo'),(150,'a','Angela Stone'),(151,'a','Angela Winter'),(152,'a','Angelica'),(153,'a','Angelica Bella'),(154,'a','Angelica Sin'),(155,'a','Angelina'),(156,'a','Angelina Ashe'),(157,'a','Angelina Black'),(158,'a','Angelina Crow'),(159,'a','Angelina Love'),(160,'a','Angelina Rose'),(161,'a','Angelina Sky'),(162,'a','Angelina Valentine'),(163,'a','Angie George'),(164,'a','Anika Fox'),(165,'a','Anita'),(166,'a','Anita Blonde'),(167,'a','Anita Dark'),(168,'a','Anita Rinaldi'),(169,'a','Anja Juliette Laval'),(170,'a','Anjelica Sin'),(171,'a','Anna Belle'),(172,'a','Anna Malle'),(173,'a','Anna Miller'),(174,'a','Anna Nova'),(175,'a','Anna Santos'),(176,'a','Anna Sophia'),(177,'a','Anne Howe'),(178,'a','Anne Midori'),(179,'a','Anne Sophia'),(180,'a','Annette Dawn'),(181,'a','Annette Haven'),(182,'a','Annette Schwartz'),(183,'a','Annette Schwarz'),(184,'a','Annie Cruz'),(185,'a','Apple Twins'),(186,'a','April'),(187,'a','April Adams'),(188,'a','April Flowers'),(189,'a','Arcadia'),(190,'a','Arcadia Davida'),(191,'a','Aria'),(192,'a','Aria Giovanni'),(193,'a','Ariana Jollee'),(194,'a','Ariel'),(195,'a','Ariel Alexus'),(196,'a','Ariel Carmine'),(197,'a','Ariel X'),(198,'a','Arielle'),(199,'a','Arielle Piperfawn'),(200,'a','Arora Jolie'),(201,'a','Artemis Gold'),(202,'a','Asa Akira'),(203,'a','Ashely Brooks'),(204,'a','Ashley'),(205,'a','Ashley Bell'),(206,'a','Ashley Blue'),(207,'a','Ashley Brookes'),(208,'a','Ashley Fires'),(209,'a','Ashley Haze'),(210,'a','Ashley Jensen'),(211,'a','Ashley Lace'),(212,'a','Ashley Lee'),(213,'a','Ashley Long'),(214,'a','Ashley Moore'),(215,'a','Ashley Robbins'),(216,'a','Ashli Orion'),(217,'a','Ashlyn Gere'),(218,'a','Ashlynn Brook'),(219,'a','Ashlynn Brooke'),(220,'a','Ashton Moore'),(221,'a','Asia'),(222,'a','Asia Carrera'),(223,'a','Aspen Stevens'),(224,'a','Astrid'),(225,'a','Aubrey Addams'),(226,'a','Aubrey Banks'),(227,'a','Audree Jaymes'),(228,'a','Audrey Bitoni'),(229,'a','Audrey Hollande'),(230,'a','Audrey Hollander'),(231,'a','August'),(232,'a','August Night'),(233,'a','August Smith'),(234,'a','Aurora Jolie'),(235,'a','Aurora Snow'),(236,'a','Austin Kincaid'),(237,'a','Austin ORiley'),(238,'a','Austin Reines'),(239,'a','Austyn Summers'),(240,'a','Autumn'),(241,'a','Autumn Austin'),(242,'a','Autumn Bliss'),(243,'a','Ava Devine'),(244,'a','Ava Lauren'),(245,'a','Ava Miller'),(246,'a','Ava Ramon'),(247,'a','Ava Rose'),(248,'a','Aveena Lee'),(249,'a','Avena Lee'),(250,'a','Avy Lee Roth'),(251,'a','Avy Scott'),(252,'a','Aya Seto'),(253,'a','Ayana Angel'),(254,'a','Aylar Lie'),(255,'a','Azlea Antistia'),(256,'b','Babalu'),(257,'b','Bailey'),(258,'b','Bailey Brooks'),(259,'b','Bambi Dolce'),(260,'b','Bambola Ramona'),(261,'b','Bamboo'),(262,'b','Barb Cummings'),(263,'b','Barbara'),(264,'b','Barbara Dare'),(265,'b','Barbara Summer'),(266,'b','Barbara Summers'),(267,'b','Barbie Addison'),(268,'b','Barbie Belle'),(269,'b','Barbie Cummings'),(270,'b','Barreit Moore'),(271,'b','Barret Moore'),(272,'b','Beauty'),(273,'b','Beauty Dior'),(274,'b','Belicia'),(275,'b','Belicia Avalos'),(276,'b','Bella Donna'),(277,'b','Bella Marie Wolfe'),(278,'b','Bella Starr'),(279,'b','Belladonna'),(280,'b','Belle Di Notte'),(281,'b','Betty Saint'),(282,'b','Beverly Hills'),(283,'b','Bianca Golden'),(284,'b','Bianca Hill'),(285,'b','Bianca Jordan'),(286,'b','Bianca Pureheart'),(287,'b','Bianca Valentino'),(288,'b','Bibi'),(289,'b','Bibi Blue'),(290,'b','Bibi Fox'),(291,'b','Bishop'),(292,'b','Black Angelika'),(293,'b','Black Diamond'),(294,'b','Blue Angel'),(295,'b','Bobbi Blair'),(296,'b','Bobbi Bliss'),(297,'b','Bobbi Star'),(298,'b','Bobbi Starr'),(299,'b','Bonita Saint'),(300,'b','Boo Dilicious'),(301,'b','Boroka Bolls'),(302,'b','Boroka Bools'),(303,'b','Boroka Borres'),(304,'b','Brandi Belle'),(305,'b','Brandi Edwards'),(306,'b','Brandi Love'),(307,'b','Brandi Lyons'),(308,'b','Brandy Lyons'),(309,'b','Brandy Starz'),(310,'b','Brandy Talore'),(311,'b','Brandy Taylor'),(312,'b','Brea Benette'),(313,'b','Brea Bennett'),(314,'b','Brea Lynn'),(315,'b','Bree'),(316,'b','Bree Olsen'),(317,'b','Bree Olson'),(318,'b','Breezy'),(319,'b','Brenda James'),(320,'b','Brett Rockman'),(321,'b','Brian Pumper'),(322,'b','Briana Banks'),(323,'b','Brianna'),(324,'b','Brianna Beach'),(325,'b','Brianna Frost'),(326,'b','Brianna Love'),(327,'b','Bridgette Kerkove'),(328,'b','Brigitta Bulgari'),(329,'b','Brigitte Lahaie'),(330,'b','Britney Amber'),(331,'b','Britney Farren'),(332,'b','Britney Jay'),(333,'b','Britney Madison'),(334,'b','Britney Skye'),(335,'b','Britney Stevens'),(336,'b','Brittany Andrews'),(337,'b','Brittany Blue'),(338,'b','Brittany Burke'),(339,'b','Brittany Stryker'),(340,'b','Brittney'),(341,'b','Brittney Skye'),(342,'b','Brittny Blew'),(343,'b','Brodi'),(344,'b','Brodie'),(345,'b','Brook Sky'),(346,'b','Brooke Ballentyne'),(347,'b','Brooke Banner'),(348,'b','Brooke Belle'),(349,'b','Brooke Daze'),(350,'b','Brooke Haven'),(351,'b','Brooke Hunter'),(352,'b','Brooke Marks'),(353,'b','Brooke Milano'),(354,'b','Brooke Scott'),(355,'b','Brooke Skye'),(356,'b','Brown Sugar'),(357,'b','Bruna Ferraz'),(358,'b','Bruno SX'),(359,'b','Brynn Brooks'),(360,'b','Brynn Tyler'),(361,'b','Bunny Luv'),(362,'b','Byron Long'),(363,'c','Cabiria'),(364,'c','Cailey Taylor'),(365,'c','Cali Cassidy'),(366,'c','Cali Marie'),(367,'c','Calli Cox'),(368,'c','Cameron Love'),(369,'c','Camilla'),(370,'c','Camilla Ken'),(371,'c','Camille'),(372,'c','Camily'),(373,'c','Camryn Kiss'),(374,'c','Candace Nicole'),(375,'c','Candace Von'),(376,'c','Candi Summers'),(377,'c','Candice'),(378,'c','Candice Jackson'),(379,'c','Candice Michelle'),(380,'c','Candie Evans'),(381,'c','Candy'),(382,'c','Candy Apples'),(383,'c','Candy Cotton'),(384,'c','Candy Lee'),(385,'c','Candy Manson'),(386,'c','Candy Samira'),(387,'c','Capri Cavalli'),(388,'c','Caprice'),(389,'c','Carla Cox'),(390,'c','Carla Cruz'),(391,'c','Carli Banks'),(392,'c','Carly Parker'),(393,'c','Carmel Moore'),(394,'c','Carmela'),(395,'c','Carmella Bing'),(396,'c','Carmen'),(397,'c','Carmen Cocks'),(398,'c','Carmen Hayes'),(399,'c','Carmen Kinsley'),(400,'c','Carmen Luvana'),(401,'c','Carmen Mccarthy'),(402,'c','Carmen Sancha'),(403,'c','Carmyn Kiss'),(404,'c','Carol Goldnerova'),(405,'c','Caroline De Jaie'),(406,'c','Carolyn Monroe'),(407,'c','Carolyn Reese'),(408,'c','Carri Lee'),(409,'c','Carrie'),(410,'c','Carrie Lee'),(411,'c','Casey Cole'),(412,'c','Casey Hays'),(413,'c','Casey James'),(414,'c','Casey Jordan'),(415,'c','Casey Parker'),(416,'c','Cassandra'),(417,'c','Cassandra Calogera'),(418,'c','Cassandra Cruz'),(419,'c','Cassandra Lord'),(420,'c','Cassia'),(421,'c','Cassia Riley'),(422,'c','Cassidy'),(423,'c','Cassidy Essence'),(424,'c','Cassie Courtland'),(425,'c','Cassie Young'),(426,'c','Catalina'),(427,'c','Catalina Cruz'),(428,'c','Cate Harrington'),(429,'c','Cayenne'),(430,'c','Cayenne Klein'),(431,'c','Caylian Curtis'),(432,'c','Cayton Caley'),(433,'c','Cecilia Vega'),(434,'c','Celeste'),(435,'c','Celeste Star'),(436,'c','Celestia Star'),(437,'c','Celia Banco'),(438,'c','Celia Blanco'),(439,'c','Celina Cross'),(440,'c','Chandler'),(441,'c','Chandler Steele'),(442,'c','Chanel Chavez'),(443,'c','Chanel St. James'),(444,'c','Chanta Rose'),(445,'c','Charlene Aspen'),(446,'c','Charles Dera'),(447,'c','Charli'),(448,'c','Charlie'),(449,'c','Charlie Garcia'),(450,'c','Charlie Laine'),(451,'c','Charlie Lane'),(452,'c','Charlotte Stokely'),(453,'c','Charmane Star'),(454,'c','Chase Dasani'),(455,'c','Chasey Lain'),(456,'c','Chavon Taylor'),(457,'c','Chayenne'),(458,'c','Chelci Fox'),(459,'c','Chelsea Romero'),(460,'c','Chelsea Zinn'),(461,'c','Chelsea Zinns'),(462,'c','Chelsie Rae'),(463,'c','Chelsie Ray'),(464,'c','Chennin Blanc'),(465,'c','Cherie'),(466,'c','Cherokee'),(467,'c','Cherokee D Ass'),(468,'c','Cherry Chase'),(469,'c','Cherry Jul'),(470,'c','Cherry Potter'),(471,'c','Cherry Rain'),(472,'c','Cherry Rose'),(473,'c','Cheryl Lynn Khan'),(474,'c','Cheryll'),(475,'c','Cheyenne Hunter'),(476,'c','Cheyenne Silver'),(477,'c','Cheyenne-Lacroix'),(478,'c','Cheyne Collins'),(479,'c','Chiara'),(480,'c','Chikita'),(481,'c','Chiquita Lopez'),(482,'c','Chloe Black'),(483,'c','Chloe Chanel'),(484,'c','Chloe Delaure'),(485,'c','Chloe Dior'),(486,'c','Chloe Jones'),(487,'c','Chloe Nichole'),(488,'c','Chloe Sweet'),(489,'c','Chloe Vevrier'),(490,'c','Chole Dior'),(491,'c','Chris Streams'),(492,'c','Chrissy Moran'),(493,'c','Chrissy Tyler'),(494,'c','Christian XXX'),(495,'c','Christie Lee'),(496,'c','Christina Agave'),(497,'c','Christina Aguchi'),(498,'c','Christina Bella'),(499,'c','Christina Eden'),(500,'c','Christina Mendoza'),(501,'c','Christina Noir'),(502,'c','Christine'),(503,'c','Christine Alexis'),(504,'c','Christine Mendoza'),(505,'c','Christine Roberts'),(506,'c','Christine Young'),(507,'c','Christopher Clark'),(508,'c','Christy Canyon'),(509,'c','Christy Marks'),(510,'c','Chyanne Jacobs'),(511,'c','Ciera Sage'),(512,'c','Cindy Crawford'),(513,'c','Cindy Lords'),(514,'c','Cindy Sterling'),(515,'c','Claire Adams'),(516,'c','Claire Dames'),(517,'c','Claire James'),(518,'c','Claire Robbins'),(519,'c','Clara Morgane'),(520,'c','Clarissa May'),(521,'c','Claudia'),(522,'c','Claudia Antonelli'),(523,'c','Claudia Chase'),(524,'c','Claudia Ferrari'),(525,'c','Claudia Jamsson'),(526,'c','Claudia Rossi'),(527,'c','Claudia Valentine'),(528,'c','Cleo'),(529,'c','Cleopatra'),(530,'c','Cocoa Creme'),(531,'c','Codi Milo'),(532,'c','Cody Lane'),(533,'c','Cody milo'),(534,'c','Cora'),(535,'c','Cora Carina'),(536,'c','Cory Everson'),(537,'c','Courtney'),(538,'c','Courtney Cummz'),(539,'c','Courtney Devine'),(540,'c','Courtney James'),(541,'c','Courtney Johnson'),(542,'c','Courtney Simpson'),(543,'c','Crissy Moon'),(544,'c','Crissy Moran'),(545,'c','Crista Moore'),(546,'c','Cristina Mayer'),(547,'c','Crystal carter'),(548,'c','Crystal Clear'),(549,'c','Crystal Gold'),(550,'c','Crystal Rae'),(551,'c','Crystal Ray'),(552,'c','Crystal Raye'),(553,'c','Cumisha Jones'),(554,'c','Cura Curina'),(555,'c','Cynara Fox'),(556,'c','Cynthia'),(557,'c','Cynthia Fox'),(558,'c','Cythera'),(559,'c','Cytherea'),(560,'c','Cytheria'),(561,'d','Daisey Marie'),(562,'d','Daisy Chain'),(563,'d','Daisy Dukes'),(564,'d','Daisy Marie'),(565,'d','Dakoda Brookes'),(566,'d','Dakoda Brooks'),(567,'d','Dakota'),(568,'d','Dakota Brookes'),(571,'d','Dakota Brooks'),(572,'d','Dakota Cameron'),(573,'d','Dana'),(574,'d','Dana DeArmond'),(575,'d','Dana Hayes'),(576,'d','Dana Vespoli'),(577,'d','Dani Dior'),(578,'d','Dani Lopes'),(579,'d','Dani Woodward'),(580,'d','Danica'),(581,'d','Danica Collins'),(582,'d','Daniell'),(583,'d','Daniella'),(584,'d','Daniella Rush'),(585,'d','Daniella schiffer'),(586,'d','Danielle'),(587,'d','Danielle Dayne'),(588,'d','Danielle Derek'),(589,'d','Danielle Rogers'),(590,'d','Daniellia'),(591,'d','Danika'),(592,'d','Danni Ashe'),(593,'d','Danni Daire'),(594,'d','Danni Dior'),(595,'d','Danni Woodward'),(596,'d','Daphne Rosen'),(597,'d','Daria Glover'),(598,'d','Darla Crane'),(599,'d','Darlene'),(600,'d','Darryl Hanah'),(601,'d','Darryl Hannah'),(602,'d','Daryn Darby'),(603,'d','Dasani Lezian'),(604,'d','Dasha'),(605,'d','Davia Ardell'),(606,'d','Dayana Boromeo'),(607,'d','Dayton Rains'),(608,'d','Deanna'),(609,'d','Deauxma'),(610,'d','Debbie White'),(611,'d','Deborah Wells'),(612,'d','Dee'),(613,'d','Dee Baker'),(614,'d','Deedee'),(615,'d','Deedee Lynn'),(616,'d','Deena Daniels'),(617,'d','Defrancesca Gallardo'),(618,'d','Deja Daire'),(619,'d','Delfynn'),(620,'d','Delfynn Delage'),(621,'d','Delilah'),(622,'d','Delilah Stone'),(623,'d','Delilah Strong'),(624,'d','Delotta Brown'),(625,'d','Delta White'),(626,'d','Demi'),(627,'d','Demi Delia'),(628,'d','Demi More'),(629,'d','Denise K'),(630,'d','Desert Rose'),(631,'d','Desiree Cousteau'),(632,'d','Destiny'),(633,'d','Destiny Summers'),(634,'d','Devin Deray'),(635,'d','Devinn Lane'),(636,'d','Devlin Weed'),(637,'d','Devon'),(638,'d','Devon Lee'),(639,'d','Devon Michaels'),(640,'d','Devon Monroe'),(641,'d','Devyn Devine'),(642,'d','Diamond Foxxx'),(643,'d','Diamond Jackson'),(644,'d','Diamond Starr'),(645,'d','Diana Dean'),(646,'d','Diana DeVoe'),(647,'d','Diana Lane'),(648,'d','Diana Le'),(649,'d','Dillan Lauren'),(650,'d','Dina Jewel'),(651,'d','Dior'),(652,'d','Dita Von Teese'),(653,'d','Divini Rae'),(654,'d','Divinity Love'),(655,'d','Dolly Golden'),(656,'d','Dominica Leoni'),(657,'d','Dominique'),(658,'d','Dominique Dane'),(659,'d','Domino'),(660,'d','Donita Dunes'),(661,'d','Donna'),(662,'d','Donna Marie'),(663,'d','Donna Red'),(664,'d','Dora Venter'),(665,'d','Doris'),(666,'d','Dorota Rabczweska'),(667,'d','Dorothy Black'),(668,'d','Dorthy Black'),(669,'d','Dru Berrymore'),(670,'d','Dyanna Lauren'),(671,'d','Dylan Ryder'),(672,'d','Dynamite'),(673,'e','Ed Powers'),(674,'e','Eden'),(675,'e','Eden Adams'),(676,'e','Eden DD'),(677,'e','Eimi'),(678,'e','Elena'),(679,'e','Elena Grimaldi'),(680,'e','Elexis'),(681,'e','Elinor Gasset'),(682,'e','Elise'),(683,'e','Elizabeth Del Mar'),(684,'e','Elizabeth Lawrence'),(685,'e','Ellen Saint'),(686,'e','Ellie Idol'),(687,'e','Elly'),(688,'e','Emilie Davinci'),(689,'e','Emily Cartwright'),(690,'e','Emily Da Vinci'),(691,'e','Emily Davinci'),(692,'e','Emily Evermoore'),(693,'e','Emma Cummings'),(694,'e','Emma Heart'),(695,'e','Emma Starr'),(696,'e','Emy Reyes'),(697,'e','Envy'),(698,'e','Erica Campbell'),(699,'e','Erica Ellyson'),(700,'e','Erik Everhard'),(701,'e','Erika'),(702,'e','Erika Bella'),(703,'e','Erika Kole'),(704,'e','Erika Kusu'),(705,'e','Erika Lindauer'),(706,'e','Erin Avery'),(707,'e','Estelle Desanges'),(708,'e','Estelle Laurence'),(709,'e','Etna'),(710,'e','Eva'),(711,'e','Eva Angelina'),(712,'e','Eva black'),(713,'e','Eva Henger'),(714,'e','Eva Jordon'),(715,'e','Eva Karera'),(716,'e','Eva Kent'),(717,'e','Eva Lawrence'),(718,'e','Eva Ramon'),(719,'e','Eva Ramone'),(720,'e','Evan Stone'),(721,'e','Eve'),(722,'e','Eve Angel'),(723,'e','Eve Lawrence'),(724,'e','Eve Mayfair'),(725,'e','Eve Nicholson'),(726,'e','Evelyn Lin'),(727,'e','Evelyn Rhodes'),(728,'e','Evelyne foxy'),(729,'e','Ewa Sonnet'),(730,'f','Fabiane Thompson'),(731,'f','Faith'),(732,'f','Faith Adams'),(733,'f','Faith Daniels'),(734,'f','Faith Leon'),(735,'f','Fallon Sommers'),(736,'f','Fawna'),(737,'f','Faye Reagan'),(738,'f','Faye Runaway'),(739,'f','Faye Valentine'),(740,'f','Federica Hill'),(741,'f','Felecia'),(742,'f','Felicia'),(743,'f','Felony'),(744,'f','Finesse Navarro'),(745,'f','Fiona Cheeks'),(746,'f','Flick Shagwell'),(747,'f','Flower Tucci'),(748,'f','Foxy'),(749,'f','Foxy Jacky'),(750,'f','Francesca'),(751,'f','Francesca Le'),(752,'f','Franchezca Valentina'),(753,'f','Francine Dee'),(754,'f','Franco Rey'),(755,'f','Frank Major'),(756,'f','Frankie Dashwood'),(757,'f','Friday'),(758,'f','Fujiko Kano'),(759,'g','Gabriella Banks'),(760,'g','Gabriella Fox'),(761,'g','Gabriella Moon'),(762,'g','Gabriella Romano'),(763,'g','Gala Cruz'),(764,'g','Gauge'),(765,'g','Gen Padova'),(766,'g','Gena Lee Nolin'),(767,'g','Genesis Skye'),(768,'g','Georgia Peach'),(769,'g','Gia Jordan'),(770,'g','Gia Marie'),(771,'g','Gia Paloma'),(772,'g','Gianna'),(773,'g','Gianna Jolynn'),(774,'g','Gianna Lynn'),(775,'g','Gianna Michaels'),(776,'g','Gianna Micheals'),(777,'g','Gina Austin'),(778,'g','Gina B'),(779,'g','Gina Lynn'),(780,'g','Gina Ryder'),(781,'g','Gina Wild'),(782,'g','Ginger'),(783,'g','Ginger Blaze'),(784,'g','Ginger Devil'),(785,'g','Ginger Lea'),(786,'g','Ginger Lee'),(787,'g','Ginger Lynn'),(788,'g','Ginny'),(789,'g','Giovana'),(790,'g','Giovanna'),(791,'g','Giselle'),(792,'g','Giselle Correa'),(793,'g','Gisselle'),(794,'g','Glauren Star'),(795,'g','Gloria Gucci'),(796,'g','Greta Carlson'),(797,'g','Greta Milos'),(798,'g','Gwen'),(799,'g','Gwen Diamond'),(800,'g','Gwen Summers'),(801,'h','Haileey James'),(802,'h','Hailey'),(803,'h','Hailey Young'),(804,'h','Haley'),(805,'h','Haley Hunter'),(806,'h','Haley Paige'),(807,'h','Haley Scott'),(808,'h','Haley Wilde'),(809,'h','Haley Young'),(810,'h','Halia Hill'),(811,'h','Hana Slavickova'),(812,'h','Hanna Harper'),(813,'h','Hanna Hilton'),(814,'h','Hannah Callow'),(815,'h','Hannah Harper'),(816,'h','Hannah Hilton'),(817,'h','Hannah West'),(818,'h','Harlee Ryder'),(819,'h','Harmony'),(820,'h','Harmony Rose'),(821,'h','Haruka Sanada'),(822,'h','Hatuka Mei'),(823,'h','Havana Ginger'),(824,'h','Haylee'),(825,'h','Heather'),(826,'h','Heather Brooke'),(827,'h','Heather Gables'),(828,'h','Heather Hunter'),(829,'h','Heather Pink'),(830,'h','Heather Vahn'),(831,'h','Heather Vandeven'),(832,'h','Heidi Brooks'),(833,'h','Heidi Mayne'),(834,'h','Heidi Spice'),(835,'h','Helena Bush'),(836,'h','Helena Karel'),(837,'h','Herschel Savage'),(838,'h','Hidde Brooks'),(839,'h','Hidee Sin'),(840,'h','Hilary Scott'),(841,'h','Hillary Scott'),(842,'h','Hitomi Tanaka'),(843,'h','Holly'),(844,'h','Holly Body'),(845,'h','Holly Fox'),(846,'h','Holly Halston'),(847,'h','Holly Hollywood'),(848,'h','Holly Morgan'),(849,'h','Holly Sampson'),(850,'h','Holly Wellin'),(851,'h','Holly West'),(852,'h','Honey'),(853,'h','Honey Bunny'),(854,'h','Honey Comb'),(855,'h','Honey Dejour'),(856,'h','Honey Wilder'),(857,'h','Houston'),(858,'h','Howard Stern'),(859,'h','Hyapatia Lee'),(860,'h','Hypnotiq'),(861,'i','Ice La Fox'),(862,'i','Ilona'),(863,'i','Inari Vachs'),(864,'i','India'),(865,'i','Isabel Ice'),(866,'i','Isabella'),(867,'i','Isabella camille'),(868,'i','Isabella Dior'),(869,'i','Isabella Soprano'),(870,'i','Isis Love'),(871,'i','Isis Nile'),(872,'i','Italia Christie'),(873,'i','Ivana Fuckalot'),(874,'i','Ivana Fukalot'),(875,'j','Jack Napier'),(876,'j','Jackie Ashe'),(877,'j','Jackie Moore'),(878,'j','Jaclyn Case'),(879,'j','Jada Fire'),(880,'j','Jada Stevens'),(881,'j','Jade'),(882,'j','Jade Davin'),(883,'j','Jade Hsu'),(884,'j','Jade Marcela'),(885,'j','Jade Martin Hsu'),(886,'j','Jade Starr'),(887,'j','Jaden'),(888,'j','Jaelyn Case'),(889,'j','Jaelyn Fox'),(890,'j','Jaime Elle'),(891,'j','Jaime Hammer'),(892,'j','Jaimee Foxworth'),(893,'j','Jamie Brooks'),(894,'j','Jamie Elle'),(895,'j','Jamie Lamore'),(896,'j','Jamie Lynn'),(897,'j','Jamie Rae'),(898,'j','Jana'),(899,'j','Jana Cova'),(900,'j','Jana Miartusova'),(901,'j','Janaina Paes'),(902,'j','Jandi Lin'),(903,'j','Jane'),(904,'j','Jane Alfano'),(905,'j','Jane Darling'),(906,'j','Janet'),(907,'j','Janet Jacme'),(908,'j','Janet Peron'),(909,'j','Janette Desire'),(910,'j','Janine Lindemulder'),(911,'j','Jasmeen Maroc'),(912,'j','Jasmin'),(913,'j','Jasmin Sky'),(914,'j','Jasmin St. Claire'),(915,'j','Jasmine'),(916,'j','Jasmine Black'),(917,'j','Jasmine Byrne'),(918,'j','Jasmine Lynn'),(919,'j','Jasmine Rouge'),(920,'j','Jasmine Tame'),(921,'j','Jassie'),(922,'j','Jay Ashley'),(923,'j','Jay lodeeva'),(924,'j','Jayda Brook'),(925,'j','Jayden'),(926,'j','Jayden Fox'),(927,'j','Jayden James'),(928,'j','Jayden Jaymes'),(929,'j','Jayden Simone'),(930,'j','Jaylynn'),(931,'j','Jayna Oso'),(932,'j','Jazlin Diaz'),(933,'j','Jazmin'),(934,'j','Jazmine'),(935,'j','Jazmine Cashmere'),(936,'j','Jean Val Jean'),(937,'j','Jeanie Marie Sullivan'),(938,'j','Jeanie Rivers'),(939,'j','Jeanna Fine'),(940,'j','Jeannie pepper'),(941,'j','Jelena Jensen'),(942,'j','Jemeni'),(943,'j','Jemeri'),(944,'j','Jemstone'),(945,'j','Jen X'),(946,'j','Jenavere Jolie'),(947,'j','Jenaveve Jolie'),(948,'j','Jenna Brooks'),(949,'j','Jenna Fine'),(950,'j','Jenna Haze'),(951,'j','Jenna Heart'),(952,'j','Jenna Jameson'),(953,'j','Jenna Maree'),(954,'j','Jenna Presley'),(955,'j','Jenni Hendrix'),(956,'j','Jenni Lee'),(957,'j','Jennifer'),(958,'j','Jennifer Dark'),(959,'j','Jennifer Luv'),(960,'j','Jennifer Max'),(961,'j','Jennifer Stone'),(962,'j','Jennique Adams'),(963,'j','Jenny Balond'),(964,'j','Jenny Hendrix'),(965,'j','Jenny Lee'),(966,'j','Jenteal'),(967,'j','Jersey Jaxin'),(968,'j','Jesse Capelli'),(969,'j','Jesse James'),(970,'j','Jesse Jane'),(971,'j','Jessi Summers'),(972,'j','Jessica'),(973,'j','Jessica Bangkok'),(974,'j','Jessica Correa'),(975,'j','Jessica Darlin'),(976,'j','Jessica Difeo'),(977,'j','Jessica Drake'),(978,'j','Jessica Fiorentino'),(979,'j','Jessica Gayle'),(980,'j','Jessica Jammer'),(981,'j','Jessica Jaymes'),(982,'j','Jessica Lynn'),(983,'j','Jessica Moore'),(984,'j','Jessica Right'),(985,'j','Jessica Sanchez'),(986,'j','Jessica Sweet'),(987,'j','Jessica Valentino'),(988,'j','Jessie'),(989,'j','Jessie Alba'),(990,'j','Jessie J.'),(991,'j','Jessie Jolie'),(992,'j','Jessyca Valentino'),(993,'j','Jewel'),(994,'j','Jewel Denyle'),(995,'j','Jewels Jade'),(996,'j','Jezebelle Bond'),(997,'j','Jezhabelle'),(998,'j','Jill Kelly'),(999,'j','Jill Valentine'),(1000,'j','Jillian Foxxx'),(1001,'j','Joanna'),(1002,'j','Joanna Angel'),(1003,'j','Joanna Fine'),(1004,'j','Jocelyn'),(1005,'j','Jocelyn Pink'),(1006,'j','Jodi Cassidy'),(1007,'j','Jodie Moore'),(1008,'j','Joel Lawrence'),(1009,'j','John Holmes'),(1010,'j','John Strong'),(1011,'j','John West'),(1012,'j','Johnni Black'),(1013,'j','Johnny Sins'),(1014,'j','Jordan haze'),(1015,'j','Jordan Jagger'),(1016,'j','Jordan James'),(1017,'j','Jordan Page'),(1018,'j','Jordan Paige'),(1019,'j','Jordana James'),(1020,'j','Jordanna James'),(1021,'j','Jordyn Ray'),(1022,'j','Josephine James'),(1023,'j','Josette Most'),(1024,'j','joslyn james'),(1025,'j','JR carrington'),(1026,'j','Judita'),(1027,'j','Judita Jones'),(1028,'j','Judith Fox'),(1029,'j','Judy Star'),(1030,'j','Jules Jordan'),(1031,'j','Julia Ann'),(1032,'j','Julia Bond'),(1033,'j','Julia Chanel'),(1034,'j','Julia Channel'),(1035,'j','Julia Miles'),(1036,'j','Julia Paes'),(1037,'j','Julia Taylor'),(1038,'j','Julian'),(1039,'j','Juliana Grandi'),(1040,'j','Julianna'),(1041,'j','Julie'),(1042,'j','Julie Anston'),(1043,'j','Julie Ellis'),(1044,'j','Julie Knight'),(1045,'j','Julie Meadows'),(1046,'j','Julie Night'),(1047,'j','Julie Rage'),(1048,'j','Julie Silver'),(1049,'j','Juliet Anderson'),(1050,'j','Julissa Delor'),(1051,'j','Justin'),(1052,'j','Justine'),(1053,'j','Justine Ashley'),(1054,'j','Justine Joli'),(1055,'j','Justine Jolie'),(1056,'j','Jynx'),(1057,'k','Kacee'),(1058,'k','Kacey Jordan'),(1059,'k','Kaci Star'),(1060,'k','Kacie Lou'),(1061,'k','Kaede Matsushima'),(1062,'k','Kagney Linn Karter'),(1063,'k','Kaitlyn Ashley'),(1064,'k','Kaiya Lynn'),(1065,'k','Kaleah'),(1066,'k','Kami'),(1067,'k','Kamiko'),(1068,'k','Kandee Lixxx'),(1069,'k','Kapri Styles'),(1070,'k','Kara'),(1071,'k','Kara Bare'),(1072,'k','Kara Mynor'),(1073,'k','Karen Kam'),(1074,'k','Karen Lancaume'),(1075,'k','Karina Kay'),(1076,'k','Karise'),(1077,'k','Karli'),(1078,'k','Karlie Montana'),(1079,'k','Karma'),(1080,'k','Karolina'),(1081,'k','karrine steffans'),(1082,'k','Kascha'),(1083,'k','Kasey Kox'),(1084,'k','Kasia'),(1085,'k','Kassey Krystal'),(1086,'k','Kat'),(1087,'k','Katarina'),(1088,'k','Kate frost'),(1089,'k','Kate Jones'),(1090,'k','Kate More'),(1091,'k','Katerina Cox'),(1092,'k','Kates Playground'),(1093,'k','Katherine Starr'),(1094,'k','Kathleen Kruz'),(1095,'k','Kathy'),(1096,'k','Kathy Anderson'),(1097,'k','Kathy Heart'),(1098,'k','Katia  Killer'),(1099,'k','Katia Nobili'),(1100,'k','Katie Cummings'),(1101,'k','Katie Gold'),(1102,'k','Katie June'),(1103,'k','Katie Morgan'),(1104,'k','Katie Ray'),(1105,'k','Katie Thomas'),(1106,'k','Katie Tomas'),(1107,'k','Katin'),(1108,'k','Katja Kassin'),(1109,'k','Katja Kean'),(1110,'k','Katja Love'),(1111,'k','Katlyn'),(1112,'k','Katrin'),(1113,'k','Katrina'),(1114,'k','Katrina Ko'),(1115,'k','Katrina Rosebud'),(1116,'k','Katsumi'),(1117,'k','Katy'),(1118,'k','Kay Parker'),(1119,'k','Kayden Kross'),(1120,'k','Kaye Linn'),(1121,'k','Kayla Kleavage'),(1122,'k','Kayla Marie'),(1123,'k','Kayla Paige'),(1124,'k','Kayla Quinn'),(1125,'k','Kayla Synz'),(1126,'k','Kaylani'),(1127,'k','Kaylani Lei'),(1128,'k','Kaylee'),(1129,'k','Kaylee Lovkox'),(1130,'k','Kaylynn'),(1131,'k','Kea Kulani'),(1132,'k','Keani Lei'),(1133,'k','Keeani Lei'),(1134,'k','Keiko'),(1135,'k','Keiran Lee'),(1136,'k','Kelle Marie'),(1137,'k','Kelli'),(1138,'k','Kelly'),(1139,'k','Kelly Devine'),(1142,'k','Kelly Erickson'),(1143,'k','Kelly Ericson'),(1144,'k','Kelly Kline'),(1145,'k','Kelly Kroft'),(1146,'k','Kelly Lang'),(1147,'k','Kelly Madison'),(1148,'k','Kelly Skyline'),(1149,'k','Kelly Star'),(1150,'k','Kelly Tyler'),(1151,'k','Kelly Wells'),(1152,'k','Kelsey Michaels'),(1153,'k','Kelsy'),(1154,'k','Kendall Brooks'),(1155,'k','Kendra Wilkinson'),(1156,'k','Kenzi Marie'),(1157,'k','Kenzie Lee'),(1158,'k','Kenzie Marie'),(1159,'k','Keri Sable'),(1160,'k','Kerri Kraven'),(1161,'k','Kerri Sable'),(1162,'k','Keymore Cash'),(1163,'k','Kianna'),(1164,'k','Kianna Dior'),(1165,'k','Kianna Jade'),(1166,'k','Kid Jamaica'),(1167,'k','Kiki Daire'),(1168,'k','Kiki Klement'),(1169,'k','Kiki Vidis'),(1170,'k','Kikki Dial'),(1171,'k','Kim Kardashian'),(1172,'k','Kimberly Chambers'),(1173,'k','Kimberly Franklin'),(1174,'k','Kimberly Kane'),(1175,'k','Kimberly Kole'),(1176,'k','Kimberly Wood'),(1177,'k','Kimmie Cream'),(1178,'k','Kina Kai'),(1179,'k','Kinzi Marie'),(1180,'k','Kinzie Kenner'),(1181,'k','Kinzie Marie'),(1182,'k','Kira Kener'),(1183,'k','Kira Kerner'),(1184,'k','Kira Kroft'),(1185,'k','Kirsten'),(1186,'k','Kirsten Price'),(1187,'k','Kitana'),(1188,'k','Kitten'),(1189,'k','Kitty'),(1190,'k','Kitty Langdon'),(1191,'k','Kitty Marie'),(1192,'k','Kiwi Sweet'),(1193,'k','Klara Smetanova'),(1194,'k','Kobe Tai'),(1195,'k','Kozaku'),(1196,'k','Kream'),(1197,'k','Krissy Klenot'),(1198,'k','Kristal Summers'),(1199,'k','Kristen Price'),(1200,'k','Kristi Klenot'),(1201,'k','Kristi Love'),(1202,'k','Kristi Myst'),(1203,'k','Kristina Klento'),(1204,'k','Kristina Rose'),(1205,'k','Kristy Love'),(1206,'k','Krystal Jordan'),(1207,'k','Krystal Kali'),(1208,'k','Krystal Steal'),(1209,'k','Krystal Summers'),(1210,'k','Kurt Lockwood'),(1211,'k','Kyla'),(1212,'k','Kyla Cole'),(1213,'k','Kylee'),(1214,'k','Kylee King'),(1215,'k','Kylee Reese'),(1216,'k','Kylee Strutt'),(1217,'k','Kylie'),(1218,'k','Kylie G Worthy'),(1219,'k','Kylie Ireland'),(1220,'k','Kylie Marie'),(1221,'k','Kylie Reese'),(1222,'k','Kylie Rey'),(1223,'k','Kylie Wild'),(1224,'k','Kylie worthy'),(1225,'k','Kylie Wylde'),(1226,'k','Kyra'),(1227,'k','Kyra Black'),(1228,'k','Kyra Tyelar'),(1229,'l','Lacey Duvalle'),(1230,'l','Lacey Luv'),(1231,'l','Lacey Maguire'),(1232,'l','Lachelle marie'),(1233,'l','Lacie Heart'),(1234,'l','Lady Armani'),(1235,'l','Lady Snow'),(1236,'l','Laetitia Bisset'),(1237,'l','Lain Oi'),(1238,'l','Lainey Baron'),(1239,'l','Lakeisha'),(1240,'l','Lana Croft'),(1241,'l','Lana Laine'),(1242,'l','Lani Lane'),(1243,'l','Lanni Barbie'),(1244,'l','Lanny Barbie'),(1245,'l','Lara Cox'),(1246,'l','Lara Croft'),(1247,'l','Lara Stevens'),(1248,'l','Larissa Blond'),(1249,'l','Larissa Mendes'),(1250,'l','Larissa Vendramini'),(1251,'l','Laura Angel'),(1252,'l','Laura Bellini'),(1253,'l','Laura Lion'),(1254,'l','Laura Perego'),(1255,'l','Laure Sainclair'),(1256,'l','Lauren Foxxx'),(1257,'l','Lauren Kain'),(1258,'l','Lauren Phoenix'),(1259,'l','Lauren Vaughn'),(1260,'l','Laurie Vargas'),(1261,'l','Laurie Wallace'),(1262,'l','Laycee James'),(1263,'l','Layla'),(1264,'l','Layla Jade'),(1265,'l','Layla Lei'),(1266,'l','Layla Rivera'),(1267,'l','Laylani Lee'),(1268,'l','Lea'),(1269,'l','Lea De Mae'),(1270,'l','Lea Stevenson'),(1271,'l','Lea Walker'),(1272,'l','Leah Dizion'),(1273,'l','Leah Jaye'),(1274,'l','Leah Livington'),(1275,'l','Leah Luv'),(1276,'l','Leah Moore'),(1277,'l','Leah Wilde'),(1278,'l','Leandra Lee'),(1279,'l','Leanna Heart'),(1280,'l','Lee Ann'),(1281,'l','Lee Stone'),(1282,'l','Lee-Ann'),(1283,'l','Leighlani Red'),(1284,'l','Lela Star'),(1285,'l','Lena Juliett'),(1286,'l','Lena Juliette'),(1287,'l','Lena Sunshine'),(1288,'l','Lenka Gaborova'),(1289,'l','Lenny Rabbit'),(1290,'l','Leonie'),(1291,'l','Leslie Taylor'),(1292,'l','Leticia'),(1293,'l','Leticia Cline'),(1294,'l','Lex'),(1295,'l','Lex Steele'),(1296,'l','Lexani Banks'),(1297,'l','Lexi'),(1298,'l','Lexi Bardot'),(1299,'l','Lexi Bell'),(1300,'l','Lexi Belle'),(1301,'l','Lexi Cruz'),(1302,'l','Lexi Erickson'),(1303,'l','Lexi Foxx'),(1304,'l','Lexi Love'),(1305,'l','Lexi Matthews'),(1306,'l','Lexington Steele'),(1307,'l','Lexus Locklear'),(1308,'l','Lexxi Rain'),(1309,'l','Lexxi Rippa'),(1310,'l','Lexxi Tyler'),(1311,'l','Lezley Zen'),(1312,'l','Lichelle Marie'),(1313,'l','Lielani'),(1314,'l','Lilian Tiger'),(1315,'l','Liliana Moreno'),(1316,'l','Liliane Tiger'),(1317,'l','Lilly Thai'),(1318,'l','Lily Love'),(1319,'l','Lily Paige'),(1320,'l','Lily Thai'),(1321,'l','Lindsay Kay'),(1322,'l','Lindsay Marie'),(1323,'l','Lindsay Meadows'),(1324,'l','Lindsey Meadows'),(1325,'l','Linsey Dawn Mckenzie'),(1326,'l','Lisa Ann'),(1327,'l','Lisa Bella'),(1328,'l','Lisa Boyle'),(1329,'l','Lisa Daniels'),(1330,'l','Lisa Demarco'),(1331,'l','Lisa Harper'),(1332,'l','Lisa Lipps'),(1333,'l','Lisa Marie'),(1334,'l','Lisa Rose'),(1335,'l','Lisa Sommer'),(1336,'l','Lisa Sparkle'),(1337,'l','Lisa Sparxxx'),(1338,'l','Little Cinderella'),(1339,'l','Little Lupe'),(1340,'l','Liv Wylder'),(1341,'l','Liz Vicious'),(1342,'l','Liza'),(1343,'l','Liza Harper'),(1344,'l','Loan Laure'),(1345,'l','Lola'),(1346,'l','Lola Banks'),(1347,'l','Lola Lane'),(1348,'l','Lola Martin'),(1349,'l','Lolly Badcock'),(1350,'l','Loni'),(1351,'l','Loni Bunny'),(1352,'l','Lonnie Waters'),(1353,'l','Loona Lux'),(1354,'l','Lora Craft'),(1355,'l','Loredana Bontempi'),(1356,'l','Lorena Aquino'),(1357,'l','Lorena Couture'),(1358,'l','Lorena Sanchez'),(1359,'l','Lori Alexia'),(1360,'l','Lorna Morgan'),(1361,'l','Lou Charmelle'),(1362,'l','Lovely Anne'),(1363,'l','Lovely Irene'),(1364,'l','Luanda Boaz'),(1365,'l','Luba Shumeyko'),(1366,'l','Luccia Reyes'),(1367,'l','Lucia LaPiedra'),(1368,'l','Lucia Tovar'),(1369,'l','Lucianna'),(1370,'l','Lucie Lee'),(1371,'l','Lucie Theodorova'),(1372,'l','Lucious Lopez'),(1373,'l','Lucy Belle'),(1374,'l','Lucy Lee'),(1375,'l','Lucy Love'),(1376,'l','Lucy Lux'),(1377,'l','Lucy Thai'),(1378,'l','Luisa de Marco'),(1379,'l','Lulu Martinez'),(1380,'l','Luna Lane'),(1381,'l','Luoy Mai'),(1382,'l','Luscious Lopez'),(1383,'l','Luscious Louis'),(1384,'l','Lyla Lei'),(1385,'m','Mackenzee Pierce'),(1386,'m','Mackenzie Pierce'),(1387,'m','Mackenzie Star'),(1388,'m','Maddy'),(1389,'m','Madison'),(1390,'m','Madison Day'),(1391,'m','Madison Ivy'),(1392,'m','Madison Monroe'),(1393,'m','Madison Scott'),(1394,'m','Madison Sins'),(1395,'m','Madison Young'),(1396,'m','Maeva Exel'),(1397,'m','Maggie Star'),(1398,'m','Maiko Oshiro'),(1399,'m','Makenzie Piers'),(1400,'m','Malezia'),(1401,'m','Malezia Marley'),(1402,'m','Mallory Knoxx'),(1403,'m','Malorie Marx'),(1404,'m','Malory Marx'),(1405,'m','Mandi Belle'),(1406,'m','ManDingo'),(1407,'m','Mandy'),(1408,'m','Mandy Bright'),(1409,'m','Mandy Fox'),(1410,'m','Mandy Lee'),(1411,'m','Mandy May'),(1412,'m','Mandy Saxo'),(1413,'m','Marcelinha Moraes'),(1414,'m','Marcelli Ferraz'),(1415,'m','Marcellinha Moraes'),(1416,'m','Marco Banderas'),(1417,'m','Marcus'),(1418,'m','Maria'),(1419,'m','Maria Bellucci'),(1420,'m','Maria Moore'),(1421,'m','Maria Ogura'),(1422,'m','Maria Ozawa'),(1423,'m','Mariah'),(1424,'m','Mariah Milano'),(1425,'m','Mariana Sato'),(1426,'m','Marie Luv'),(1427,'m','Marie McCray'),(1428,'m','Marika'),(1429,'m','Marilyn Chambers'),(1430,'m','Marina Mae'),(1431,'m','Mark Ashley'),(1432,'m','Mark Davis'),(1433,'m','Marketa Belonoha'),(1434,'m','Marketa Brymova'),(1435,'m','Marlena'),(1436,'m','Marlie Moore'),(1437,'m','Marquetta Jewel'),(1438,'m','Marsha Lord'),(1439,'m','Martina'),(1440,'m','Mary Anne'),(1441,'m','Mary Carey'),(1442,'m','Mary Jane'),(1443,'m','Maryam'),(1444,'m','Masha World'),(1445,'m','Mason Marconi'),(1446,'m','Mason Storm'),(1447,'m','Mathilda'),(1448,'m','Max Hardcore'),(1449,'m','Max Sunset'),(1450,'m','Maya Divine'),(1451,'m','Maya Gold'),(1452,'m','Maya Hill'),(1453,'m','Maya Hills'),(1454,'m','Mayara Rodrigues'),(1455,'m','Mayara Rodriguez'),(1456,'m','Mayara Shelson'),(1457,'m','Mayra Shelsom'),(1458,'m','McKenzie Lee'),(1459,'m','McKenzie Miles'),(1460,'m','Meadow'),(1461,'m','Megan Cole'),(1462,'m','Megan Jones'),(1463,'m','Megan Madsen'),(1464,'m','Megan Monroe'),(1465,'m','Megan Moore'),(1466,'m','Megane'),(1467,'m','Meggan Powers'),(1468,'m','meine_muschi'),(1469,'m','Melanie Crush'),(1470,'m','Melanie Jagger'),(1471,'m','Melanie Jayne'),(1472,'m','Melanie Skyy'),(1473,'m','Melanie Stone'),(1474,'m','Melanie Sugarcube'),(1475,'m','Melany Jolie'),(1476,'m','Melissa'),(1477,'m','Melissa Ashley'),(1478,'m','Melissa Black'),(1479,'m','Melissa Lauren'),(1480,'m','Melissa Martinez'),(1481,'m','Melissa Milano'),(1482,'m','Melissa Monet'),(1483,'m','Melissa Pitanga'),(1484,'m','Mellie D'),(1485,'m','Mellisa Lauren'),(1486,'m','Melodee Bliss'),(1487,'m','Melody'),(1488,'m','Melody Max'),(1489,'m','Memphis Monroe'),(1490,'m','Mercedes'),(1491,'m','Mercedes Ashley'),(1492,'m','Mercedez'),(1493,'m','Meridian'),(1494,'m','Meriesa'),(1495,'m','Mia'),(1496,'m','Mia Bang'),(1497,'m','Mia Bangg'),(1498,'m','Mia Diamond'),(1499,'m','Mia Fuji'),(1500,'m','Mia Lina'),(1501,'m','Mia Park'),(1502,'m','Mia Rose'),(1503,'m','Mia Smiles'),(1504,'m','Mia Stone'),(1505,'m','Micah May'),(1506,'m','Micah Moore'),(1507,'m','Michaela Mancini'),(1508,'m','Michaela Soto'),(1509,'m','Michele Raven'),(1510,'m','Michelle'),(1511,'m','Michelle B'),(1512,'m','Michelle Barrett'),(1513,'m','Michelle Ferrari'),(1514,'m','Michelle Lay'),(1515,'m','Michelle Marsh'),(1516,'m','Michelle Maylene'),(1517,'m','Michelle Pantoliano'),(1518,'m','Michelle Thorne'),(1519,'m','Michelle Tucker'),(1520,'m','Michelle Wild'),(1521,'m','Mika Brown'),(1522,'m','Mika Tan'),(1523,'m','Mikayla'),(1524,'m','Mikey Butters'),(1525,'m','Miko Lee'),(1526,'m','Miko Sinz'),(1527,'m','Milena'),(1528,'m','Milena Santos'),(1529,'m','Milena Velba'),(1530,'m','Mili Jay'),(1531,'m','Millian Blu'),(1532,'m','Milly d abbraccio'),(1533,'m','Milly Moris'),(1534,'m','Milton Twins'),(1535,'m','Mina'),(1536,'m','Mindy Lee'),(1537,'m','Mindy Main'),(1538,'m','Mindy Vega'),(1539,'m','Minka'),(1540,'m','Mio Komori'),(1541,'m','Misha'),(1542,'m','Misha McKinnon'),(1543,'m','Miss Platinum'),(1544,'m','Miss Simone'),(1545,'m','Missy Blue'),(1546,'m','Missy Mae'),(1547,'m','Missy Monroe'),(1548,'m','Missy S'),(1549,'m','Missy Stone'),(1550,'m','Misti Love'),(1551,'m','Misty Knight'),(1552,'m','Misty Love'),(1553,'m','Misty Magenta'),(1554,'m','Misty Mendez'),(1555,'m','Misty Mild'),(1556,'m','Misty Stone'),(1557,'m','Mizuki Hana'),(1558,'m','Modi'),(1559,'m','Molly Madison'),(1560,'m','Molly Rome'),(1561,'m','Mona Lisa'),(1562,'m','Mona Love'),(1563,'m','Mone Divine'),(1564,'m','Monica'),(1565,'m','Monica Blonde'),(1566,'m','Monica Breeze'),(1567,'m','Monica Lion'),(1568,'m','Monica Mattos'),(1569,'m','Monica Mayhem'),(1570,'m','Monica Mendez'),(1571,'m','Monica Roccaforte'),(1572,'m','Monica Santhiago'),(1573,'m','Monica Sweet'),(1574,'m','Monica Sweethard'),(1575,'m','Monica Sweetheart'),(1576,'m','Monika'),(1577,'m','Monika Star'),(1578,'m','Monique'),(1579,'m','Monique Alexander'),(1580,'m','Monique Dane'),(1581,'m','Montanna Rae'),(1582,'m','Morgan March'),(1583,'m','Morgan Reigns'),(1584,'m','Mr Marcus'),(1585,'m','Mr Pete'),(1586,'m','Mr.Marcus'),(1587,'m','Ms. Juicy'),(1588,'m','Ms. Panther'),(1589,'m','Mya Diamond'),(1590,'m','Mya G'),(1591,'m','Mya Gates'),(1592,'m','Mya Lovely'),(1593,'m','Mya Luanna'),(1594,'m','Mya Mason'),(1595,'m','Mya Nichole'),(1596,'m','Myah Monroe'),(1597,'m','Myka Rain'),(1598,'m','Myra Luxe'),(1599,'m','Mysti May'),(1600,'n','Nacho Vidal'),(1601,'n','Nadi Phuket'),(1602,'n','Nadia'),(1603,'n','Nadia Foster'),(1604,'n','Nadia Hilton'),(1605,'n','Nadia Marie'),(1606,'n','Nadia Sin'),(1607,'n','Nadia Styles'),(1608,'n','Nadia Stylez'),(1609,'n','Nadia Taylor'),(1610,'n','Nadine Jansen'),(1611,'n','Nancy Sweet'),(1612,'n','Naomi'),(1613,'n','Naomi Cruise'),(1614,'n','Naomi Marcela'),(1615,'n','Naomi Russell'),(1616,'n','Naomi St Claire'),(1617,'n','Natalia Rossi'),(1618,'n','Natalia Zeta'),(1619,'n','Natalie'),(1620,'n','Natalie Minx'),(1621,'n','Natalie Sparks'),(1622,'n','Natalli Di Angelo'),(1623,'n','Natalli Diangelo'),(1624,'n','Natasha Babich'),(1625,'n','Natasha Nice'),(1626,'n','Nathalie'),(1627,'n','Natie'),(1628,'n','Naudia Nyce'),(1629,'n','Naughty Allie'),(1630,'n','Naughty Julie'),(1631,'n','Naughty Sarah'),(1632,'n','Nautica Binx'),(1633,'n','Nautica Thorn'),(1634,'n','Nella'),(1635,'n','Nella Von Hells'),(1636,'n','Nella Von Wells'),(1637,'n','Nelly Hunter'),(1638,'n','Nessa Devil'),(1639,'n','Next Door Nikki'),(1640,'n','Nici Sterling'),(1641,'n','Nick Manning'),(1642,'n','Nicki Hunter'),(1643,'n','Nicky'),(1644,'n','Nicky Angel'),(1645,'n','Nicky Reed'),(1646,'n','Nicole'),(1647,'n','Nicole Graves'),(1648,'n','Nicole London'),(1649,'n','Nicole Moderna'),(1650,'n','Nicole Ray'),(1651,'n','Nicole Sheridan'),(1652,'n','Nika'),(1653,'n','Nika Mamic'),(1654,'n','Nika Noir'),(1655,'n','Nikara'),(1656,'n','Nike'),(1657,'n','Niki Blond'),(1658,'n','Niki Dark'),(1659,'n','Niki Voss'),(1660,'n','Nikita Denise'),(1661,'n','Nikki'),(1662,'n','Nikki Anderson'),(1663,'n','Nikki Benz'),(1664,'n','Nikki Blaze'),(1665,'n','Nikki Blond'),(1666,'n','Nikki Blonde'),(1667,'n','Nikki Charm'),(1668,'n','Nikki Coxxx'),(1669,'n','Nikki Hillton'),(1670,'n','Nikki Hunter'),(1671,'n','Nikki Jayne'),(1672,'n','Nikki Kane'),(1673,'n','Nikki Loren'),(1674,'n','Nikki Luv'),(1675,'n','Nikki Montana'),(1676,'n','Nikki Newgate'),(1677,'n','Nikki Nievez'),(1678,'n','Nikki Rhodes'),(1679,'n','Nikki Rider'),(1680,'n','Nikki Ryder'),(1681,'n','Nikki Sun'),(1682,'n','Nikki Tyler'),(1683,'n','Niky Blue'),(1684,'n','Nina'),(1685,'n','Nina Belle'),(1686,'n','Nina Ferrari'),(1687,'n','Nina Hartley'),(1688,'n','Nina Mercedez'),(1689,'n','Nina Robert'),(1690,'n','Nina Roberts'),(1691,'n','Niya Yu'),(1692,'n','Nomi'),(1693,'n','Nora Davis'),(1694,'n','Nyomi Banxxx'),(1695,'n','Nyomi Marcella'),(1696,'n','Nyomi Zen'),(1697,'o','Oasis Starlight'),(1698,'o','Obsession'),(1699,'o','Odessa Marley'),(1700,'o','Oksana'),(1701,'o','Olga Martinez'),(1702,'o','Olivia'),(1703,'o','Olivia De Treville'),(1704,'o','Olivia Del Rio'),(1705,'o','Olivia La Roche'),(1706,'o','Olivia Olovely'),(1707,'o','Olivia O`Lovely'),(1708,'o','Olivia Winters'),(1709,'o','Ollie'),(1710,'o','Osa Lovely'),(1713,'p','Page Morgan'),(1714,'p','Paige'),(1715,'p','Paige Taylor'),(1716,'p','Paige Turner'),(1717,'p','Paisley Adams'),(1718,'p','Paizley Adams'),(1719,'p','pamela'),(1720,'p','Pamela Ann'),(1721,'p','Pamela Butt'),(1722,'p','Pamela French'),(1723,'p','Pamela London'),(1724,'p','Pandemonia'),(1725,'p','Pantera'),(1726,'p','Paola'),(1727,'p','Paola Rey'),(1728,'p','Paradice'),(1729,'p','Paradise'),(1730,'p','Paris'),(1731,'p','Paris Gables'),(1732,'p','Paris Lee'),(1733,'p','Paris Parker'),(1734,'p','Pason'),(1735,'p','Patricia'),(1736,'p','Patricia Diamon'),(1737,'p','Patricia Diamond'),(1738,'p','Patricia Petite'),(1739,'p','Patricia Santana'),(1740,'p','Paulina'),(1741,'p','Paulina James'),(1742,'p','Paulinha'),(1743,'p','Payton Lafferty'),(1744,'p','Peaches'),(1745,'p','Pebbles'),(1746,'p','Penny Flame'),(1747,'p','Penny Porsche'),(1748,'p','Pepper Foxxx'),(1749,'p','Persia'),(1750,'p','Persia DeCarlo'),(1751,'p','Peter North'),(1752,'p','Petra'),(1753,'p','Petra Pearl'),(1754,'p','Phoebe'),(1755,'p','Phoenix Marie'),(1756,'p','Pinky'),(1757,'p','Pinky Swear'),(1758,'p','Piper Fawn'),(1759,'p','Pleasure'),(1760,'p','Pleasure Bunny'),(1761,'p','Pocahontas'),(1762,'p','Poppy Morgan'),(1763,'p','Porsha'),(1764,'p','Presley Maddox'),(1765,'p','Princess Adina'),(1766,'p','Princyany Carvahlo'),(1767,'p','Priscila'),(1768,'p','Priscilla Milan'),(1769,'p','Priscilla Salerno'),(1770,'p','Priscilla Taylor'),(1771,'p','Priva'),(1772,'p','Priya Rai'),(1773,'p','Promise'),(1774,'p','Puma Black'),(1775,'p','Puma Swede'),(1776,'q','Queeni'),(1777,'q','Quincy May'),(1778,'r','Rachel'),(1779,'r','Rachel Love'),(1780,'r','Rachel Milan'),(1781,'r','Rachel Rotten'),(1782,'r','Rachel Roxx'),(1783,'r','Rachel Roxxx'),(1784,'r','Rachel Salori'),(1785,'r','Rachel Solari'),(1786,'r','Rachel Starr'),(1787,'r','Rachell Ann'),(1788,'r','Racquel Darrian'),(1789,'r','Rady'),(1790,'r','Rainy'),(1791,'r','Ramona Luv'),(1792,'r','Randi Storm'),(1793,'r','Randi Wright'),(1794,'r','Randy Angelika'),(1795,'r','Raven Riley'),(1796,'r','Raylene'),(1797,'r','Raylin'),(1798,'r','Rebeca Linares'),(1799,'r','Rebecca Bardoux'),(1800,'r','Rebecca Linares'),(1801,'r','Rebecca Lord'),(1802,'r','Rebecca Love'),(1803,'r','Rebecca Wild'),(1804,'r','Red Haven'),(1805,'r','Red Heaven'),(1806,'r','Regan Reese'),(1807,'r','Regina Hall'),(1808,'r','Regina Ice'),(1809,'r','Regina Moon'),(1810,'r','Regina Ryder'),(1811,'r','Regina Sipos'),(1812,'r','Reina Leone'),(1813,'r','Renae Cruz'),(1814,'r','Renata'),(1815,'r','Renata Angel'),(1816,'r','Renata Daninsky'),(1817,'r','Renea Cruz'),(1818,'r','Renee LaRue'),(1819,'r','Renee Porneiro'),(1820,'r','Renee Pornero'),(1821,'r','Renee Richards'),(1822,'r','Renna Ryanns'),(1823,'r','Reyna cruz'),(1824,'r','Rhiannon Bray'),(1825,'r','Ria Lynn'),(1826,'r','Ricki White'),(1827,'r','Ricky White'),(1828,'r','Rico Strong'),(1829,'r','Rika Sakurai'),(1830,'r','Riley Evans'),(1831,'r','Riley Mason'),(1832,'r','Rio'),(1833,'r','Rio Mariah'),(1834,'r','Risi Sims'),(1835,'r','Rita Faltoya'),(1836,'r','Rita Faltoyano'),(1837,'r','Rita G.'),(1838,'r','Rita Neri'),(1839,'r','Rob Rotten'),(1840,'r','Roberta Missoni'),(1841,'r','Rocco'),(1842,'r','Rocco Siffre'),(1843,'r','Rocco Siffredi'),(1844,'r','Rodney Moore'),(1845,'r','Rogue'),(1846,'r','Rogue Lee'),(1847,'r','Ron Jeremy'),(1848,'r','Rosanna Rose'),(1849,'r','Rose'),(1850,'r','Roxanna'),(1851,'r','Roxanne Hall'),(1852,'r','Roxetta'),(1853,'r','Roxi Ray'),(1854,'r','Roxxxy Rush'),(1855,'r','Roxy'),(1856,'r','Roxy Carter'),(1857,'r','Roxy Deville'),(1858,'r','Roxy Jezel'),(1859,'r','Roxy Panther'),(1860,'r','Roxy Reynolds'),(1861,'r','Rozy Jezel'),(1862,'r','Ruby Knox'),(1863,'r','Ruby Luxe'),(1864,'r','Rucca Page'),(1865,'r','Rucca Paige'),(1866,'r','Rukhsana'),(1867,'r','Ryaan Reynolds'),(1868,'r','Ryaan-Reynolds'),(1869,'r','Ryan Conner'),(1870,'r','Ryder Skye'),(1871,'s','Saana'),(1872,'s','Sabara'),(1873,'s','Sabina Black'),(1874,'s','Sabine Mallory'),(1875,'s','Sabrina Jade'),(1876,'s','Sabrina Lins'),(1877,'s','Sabrina Ricci'),(1878,'s','Sabrina Rose'),(1879,'s','Sabrina Summers'),(1880,'s','Sabrine Maui'),(1881,'s','Sadie Jones'),(1882,'s','Sadie West'),(1883,'s','Sahara Knite'),(1884,'s','Sakura Sena'),(1885,'s','Sam'),(1886,'s','Samantha'),(1887,'s','Samantha Gauge'),(1888,'s','Samantha Ryan'),(1889,'s','Samantha Sin'),(1890,'s','Samantha South'),(1891,'s','Samantha Stylle'),(1892,'s','Samira'),(1893,'s','Sammie Rhodes'),(1894,'s','Sammie Sparks'),(1895,'s','Sammy Cruz'),(1896,'s','Samone Taylor'),(1897,'s','Sana Fey'),(1898,'s','Sandee Westgate'),(1899,'s','Sandra'),(1900,'s','Sandra Brown'),(1901,'s','Sandra Kalerman'),(1902,'s','Sandra Kalermen'),(1903,'s','Sandra Kay'),(1904,'s','Sandra Mark'),(1905,'s','Sandra Romain'),(1906,'s','Sandra Russo'),(1907,'s','Sandra Sanchez'),(1908,'s','Sandra Shine'),(1909,'s','Sandy'),(1910,'s','Sandy Joy'),(1911,'s','Sandy Knight'),(1912,'s','Sandy Simmers'),(1913,'s','Sandy Style'),(1914,'s','Sandy Summer'),(1915,'s','Sandy Summers'),(1916,'s','Sandy Sweet'),(1917,'s','Sandy Westgate'),(1918,'s','Saphire Rae'),(1919,'s','Sara Faye'),(1920,'s','Sara Jay'),(1921,'s','sara muller'),(1922,'s','Sara Stone'),(1923,'s','Sarah'),(1924,'s','Sarah Blake'),(1925,'s','Sarah Blue'),(1926,'s','Sarah Connor'),(1927,'s','Sarah Jay'),(1928,'s','Sarah Jessie'),(1929,'s','Sarah Moon'),(1930,'s','Sarah Sinn'),(1931,'s','Sarah Stone'),(1932,'s','Sarah Twain'),(1933,'s','Sarah Vandella'),(1934,'s','Sarah Young'),(1935,'s','Sascha Sin'),(1936,'s','Sasha Blonde'),(1937,'s','Sasha Grey'),(1938,'s','Sasha Knox'),(1939,'s','Satine Phoenix'),(1940,'s','Sativa Rose'),(1941,'s','Savanah Gold'),(1942,'s','Savanna Samson'),(1943,'s','Savannah Gold'),(1944,'s','Savannah Stern'),(1945,'s','Sayaka Ando'),(1946,'s','Scarlet Owhora'),(1947,'s','Scarlett Ash'),(1948,'s','Scarlett Pain'),(1949,'s','Scarlett Ventura'),(1950,'s','Scott Nails'),(1951,'s','Sean Michaels'),(1952,'s','Seattle'),(1953,'s','Selena spice'),(1954,'s','Serena South'),(1955,'s','Sexy Luna'),(1956,'s','Shai Lee'),(1957,'s','Shannon Kelly'),(1958,'s','Sharka Blue'),(1959,'s','Sharon Babe'),(1960,'s','Sharon Wild'),(1961,'s','Shawna Lenee'),(1962,'s','Shawnie'),(1963,'s','Shay Lamar'),(1964,'s','Shay Laren'),(1965,'s','Shay Sights'),(1966,'s','Shay Sweet'),(1967,'s','Shayla LaVeaux'),(1968,'s','Shayna Knight'),(1969,'s','Sheila Marie'),(1970,'s','Sheila Rossi'),(1971,'s','Shelby Belle'),(1972,'s','Sherilyn'),(1973,'s','Sheryl Ann'),(1974,'s','Shi Reeves'),(1975,'s','Shine'),(1976,'s','Shiori Fujitani'),(1977,'s','Shy Love'),(1978,'s','Shyla Carmella'),(1979,'s','Shyla Styles'),(1980,'s','Shyla Stylez'),(1981,'s','Sibel Kekili'),(1982,'s','Sidney Kapri'),(1983,'s','Sienna West'),(1984,'s','Sierra'),(1985,'s','Sierra Sinn'),(1986,'s','Sierra Snow'),(1987,'s','Silvia Saint'),(1988,'s','Simona Sun'),(1989,'s','Simona Valli'),(1990,'s','Simone'),(1991,'s','Simone Claire'),(1992,'s','Simone Peach'),(1993,'s','Simone Riley'),(1994,'s','Simone Styles'),(1995,'s','Simony'),(1996,'s','Simony Diamond'),(1997,'s','Sindee Cox'),(1998,'s','sindee coxx'),(1999,'s','Sindee Jennings'),(2000,'s','Sinn Sage'),(2001,'s','Sinnamon Love'),(2002,'s','SinNye Lang'),(2003,'s','Sky Jolie'),(2004,'s','Sky Lopez'),(2005,'s','Skyy Black'),(2006,'s','Slovana'),(2007,'s','Smokie Flame'),(2008,'s','Sofia Gucci'),(2009,'s','Sofia Sandobar'),(2010,'s','Sofia Valentine'),(2011,'s','Soma'),(2012,'s','Soma Snakeoil'),(2013,'s','Sondra Hall'),(2014,'s','Sonia'),(2015,'s','Sonia Eyes'),(2016,'s','Sonia Red'),(2017,'s','Sophia'),(2018,'s','Sophia Castello'),(2019,'s','Sophia Dee'),(2020,'s','Sophia Gently'),(2021,'s','Sophia Lynn'),(2022,'s','Sophia Rain'),(2023,'s','Sophia Young'),(2024,'s','Sophie Dee'),(2025,'s','Sophie Evans'),(2026,'s','Sophie Moone'),(2027,'s','Sophie Santi'),(2028,'s','Sophie Sweet'),(2029,'s','Soraya Rico'),(2030,'s','Stacey Cash'),(2031,'s','Stacey Donovan'),(2032,'s','Staci Thorn'),(2033,'s','Stacy Adams'),(2034,'s','Stacy Silver'),(2035,'s','Stacy Valentine'),(2036,'s','Star E Knight'),(2037,'s','Stella'),(2038,'s','Stella Delcroix'),(2039,'s','Stella Hot'),(2040,'s','Stephanie'),(2041,'s','Stephanie Cane'),(2042,'s','Stephanie Kane'),(2043,'s','Stephanie Sartori'),(2044,'s','Stephanie Swift'),(2045,'s','Stephanie Tripp'),(2046,'s','Steve Holmes'),(2047,'s','Stormy Daniels'),(2048,'s','Stormy Waters'),(2049,'s','Stoya'),(2050,'s','Stoya Doll'),(2051,'s','Stracy'),(2052,'s','Strockahontas'),(2053,'s','Succubus'),(2054,'s','Sue Diamond'),(2055,'s','Sugar Kain'),(2056,'s','Sumay'),(2057,'s','Summer'),(2058,'s','Summer Breeze'),(2059,'s','Summer Cummings'),(2060,'s','Summer Nyte'),(2061,'s','Summer Sinn'),(2062,'s','Summer Storm'),(2063,'s','Sunny Blue'),(2064,'s','Sunny Lane'),(2065,'s','Sunny Leone'),(2066,'s','Sunny Maine'),(2067,'s','Sunrise Adams'),(2068,'s','Sunshine'),(2069,'s','Susana Spears'),(2070,'s','Susanna White'),(2071,'s','Susie Diamond'),(2072,'s','Suzana'),(2073,'s','Suzie Carina'),(2074,'s','Suzie Diamond'),(2075,'s','Swan'),(2076,'s','Sweet Nicky'),(2077,'s','Sweety'),(2078,'s','Sybia'),(2079,'s','Sydnee Capri'),(2080,'s','Sydnee Steel'),(2081,'s','Sydnee Steele'),(2082,'s','Sydney'),(2083,'s','Sydney Capri'),(2084,'s','Sydney Moon'),(2085,'s','Sylvia'),(2086,'t','Tabitha Stern'),(2087,'t','Tabitha Stevens'),(2088,'t','Tami Monroe'),(2089,'t','Tamiry Chiarari'),(2090,'t','Tania Russof'),(2091,'t','Tanya Danielle'),(2092,'t','Tanya James'),(2093,'t','Tara'),(2094,'t','Tara Polston'),(2095,'t','Tarah White'),(2096,'t','Tarra White'),(2097,'t','Taryn Thomas'),(2098,'t','Tasia'),(2099,'t','Tatiana'),(2100,'t','Tawny'),(2101,'t','Tawny Roberts'),(2102,'t','Taya Cruz'),(2103,'t','Taylor Bow'),(2104,'t','Taylor Chanel'),(2105,'t','Taylor Hayes'),(2106,'t','Taylor Hill'),(2107,'t','Taylor Lynn'),(2108,'t','Taylor Rain'),(2109,'t','Taylor St. Claire'),(2110,'t','Taylor Starr'),(2111,'t','Taylor Wane'),(2112,'t','Taylor Wayne'),(2113,'t','Teagan Presely'),(2114,'t','Teagan Presley'),(2115,'t','Teanna Kai'),(2116,'t','Teena'),(2117,'t','Tera Joy'),(2118,'t','Tera Patrick'),(2119,'t','Tera White'),(2120,'t','Tereza Sweet'),(2121,'t','Teri Weigel'),(2122,'t','Terri'),(2123,'t','Terri Summers'),(2124,'t','Texas Presley'),(2125,'t','Thai Michelle'),(2126,'t','Thi Michele'),(2127,'t','Tia'),(2128,'t','Tia Bella'),(2129,'t','Tia Ling'),(2130,'t','Tia Sweets'),(2131,'t','Tia Tanaka'),(2132,'t','Tiana Lynn'),(2133,'t','Tianna Lynn'),(2134,'t','Tiffany'),(2135,'t','Tiffany Brookes'),(2136,'t','Tiffany Diamond'),(2137,'t','Tiffany Holida'),(2138,'t','Tiffany Holiday'),(2139,'t','Tiffany Hopkins'),(2140,'t','Tiffany Mason'),(2141,'t','Tiffany Mynx'),(2142,'t','Tiffany Preston'),(2143,'t','Tiffany Price'),(2144,'t','Tiffany Rayne'),(2145,'t','Tiffany Rousso'),(2146,'t','Tiffany Roxxx'),(2147,'t','Tiffany Taylor'),(2148,'t','Tiger'),(2149,'t','Tila Tequila'),(2150,'t','Tina Gabriel'),(2151,'t','Tinkerbell'),(2152,'t','Titney Spheres'),(2153,'t','Tj Hart'),(2154,'t','Tolly Cristall'),(2155,'t','Tommi Rose'),(2156,'t','Toni Salas'),(2157,'t','Tony Eveready'),(2158,'t','Tori Black'),(2159,'t','Tori Lane'),(2160,'t','Tori Secrets'),(2161,'t','Tori Welles'),(2162,'t','Tory Lane'),(2163,'t','Totally Tabitha'),(2164,'t','Tracey Adams'),(2165,'t','Tricia Oaks'),(2166,'t','Trina Michael'),(2167,'t','Trina Michaels'),(2168,'t','Trinity'),(2169,'t','Trinity James'),(2170,'t','Trinity Morgana'),(2171,'t','Trinity Post'),(2172,'t','Trisha'),(2173,'t','Trisha Brill'),(2174,'t','Trisha Ray'),(2175,'t','Trisha Rey'),(2176,'t','Tristal'),(2177,'t','Tristan Kingsley'),(2178,'t','Trixie Cas'),(2179,'t','TT-boy'),(2180,'t','Tyana Mils'),(2181,'t','Tyce Bune'),(2182,'t','Tyla Wynn'),(2183,'t','Tyler'),(2184,'t','Tyler Faith'),(2185,'t','Tyler Stevenz'),(2186,'t','Tyra Banxxx'),(2187,'t','Tyra Misoux'),(2188,'t','Tyra Moore'),(2189,'v','Valentina'),(2190,'v','Valentina Blue'),(2191,'v','Valentina Rossini'),(2192,'v','Valentina Velasques'),(2193,'v','Valentine Demy'),(2194,'v','Valerie Vasquez'),(2195,'v','Valleria Jones'),(2196,'v','Vanessa'),(2197,'v','Vanessa Blue'),(2198,'v','Vanessa Figueroa'),(2199,'v','Vanessa G'),(2200,'v','Vanessa Lane'),(2201,'v','Vanessa Lynn'),(2202,'v','Vanessa Monet'),(2203,'v','Vanessa Paradise'),(2204,'v','Vanessa Rubec'),(2205,'v','Vanessa Valenzuela'),(2206,'v','Vanilla De Ville'),(2207,'v','Vanilla Skye'),(2208,'v','Velicity Von'),(2209,'v','Venus'),(2210,'v','Veronica Caine'),(2211,'v','Veronica Clinton'),(2212,'v','Veronica Da Souza'),(2213,'v','Veronica Hill'),(2214,'v','Veronica Ianoza'),(2215,'v','Veronica Jett'),(2216,'v','Veronica Lynn'),(2217,'v','Veronica Raquel'),(2218,'v','Veronica Rayne'),(2219,'v','Veronica Rose'),(2220,'v','Veronica Sanchez'),(2221,'v','Veronica Simon'),(2222,'v','Veronica Stone'),(2223,'v','Veronica Vanoza'),(2224,'v','Veronica Zemanova'),(2225,'v','Veronika'),(2226,'v','Veronika Raquel'),(2227,'v','Veronika Simon'),(2228,'v','Veronika Zemanova'),(2229,'v','Veronique Vega'),(2230,'v','Vianey Cruz'),(2231,'v','Vica Ryder'),(2232,'v','Vickie Powell'),(2233,'v','Vicky'),(2234,'v','Vicky Vette'),(2235,'v','Victoria'),(2236,'v','Victoria Allure'),(2237,'v','Victoria Brown'),(2238,'v','Victoria Del Rio'),(2239,'v','Victoria Givens'),(2240,'v','Victoria Lan'),(2241,'v','Victoria Red'),(2242,'v','Victoria Rose'),(2243,'v','Victoria Rush'),(2244,'v','Victoria Sin'),(2245,'v','Victoria Sinn'),(2246,'v','Victoria Sweet'),(2247,'v','Vida Guerra'),(2248,'v','Violet Blue'),(2249,'v','Virginie Gervais'),(2250,'v','Vivian Schmitt'),(2251,'v','Vivian Valentine'),(2252,'v','Vixen'),(2253,'v','Voodoo'),(2254,'w','Wanda Curtis'),(2255,'w','Wendy'),(2256,'w','Wendy James'),(2257,'w','Wesley Pipes'),(2258,'w','Whitney Stevens'),(2259,'w','Whitney Wonders'),(2260,'w','Winter Sky'),(2261,'w','Wolfie'),(2262,'y','Yana'),(2263,'y','Yasmene Milan'),(2264,'y','Yasmine'),(2265,'y','Yasmine Gold'),(2266,'y','Yasmine Love'),(2267,'y','Yasmyne Fitzgerald'),(2268,'y','Yumi'),(2269,'y','Yvette'),(2270,'z','Zafira'),(2271,'z','Zdenka Podkapova'),(2272,'z','Zeina Heart'),(2273,'z','Zenza Raggi'),(2274,'z','Zoe'),(2275,'z','Zoe Britton'),(2276,'z','Zoe Matthews'),(2277,'z','Zoe Stunner'),(2278,'z','Zoey Andrews'),(2279,'z','Zuzana Zeleznovova');
/*!40000 ALTER TABLE `tbl_stars` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tag_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_has_usergroup` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `jointime` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tbl_user_has_usergroup` WRITE;
/*!40000 ALTER TABLE `tbl_user_has_usergroup` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_user_has_usergroup` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_yumtextsettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` enum('en_us','de','fr','pl','ru','es','ro') NOT NULL DEFAULT 'en_us',
  `text_email_registration` text,
  `subject_email_registration` text,
  `text_email_recovery` text,
  `text_email_activation` text,
  `text_friendship_new` text,
  `text_friendship_confirmed` text,
  `text_profilecomment_new` text,
  `text_message_new` text,
  `text_membership_ordered` text,
  `text_payment_arrived` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tbl_yumtextsettings` WRITE;
/*!40000 ALTER TABLE `tbl_yumtextsettings` DISABLE KEYS */;
INSERT INTO `tbl_yumtextsettings` VALUES (1,'en_us','You have registered for this Application. To confirm your E-Mail address, please visit {activation_url}','You have registered for an application','You have requested a new Password. To set your new Password,\n										please go to {activation_url}','Your account has been activated. Thank you for your registration.','New friendship Request from {username}: {message}. To accept or ignore this request, go to your friendship page: {link_friends} or go to your profile: {link_profile}','The User {username} has accepted your friendship request','You have a new profile comment from {username}: {message} visit your profile: {link_profile}','You have received a new message from {username}: {message}','Your order of membership {membership} on {order_date} has been taken. Your order Number is {id}. You have choosen the payment style {payment}.','Your payment has been received on {payment_date} and your Membership {id} is now active'),(2,'de','Sie haben sich für unsere Applikation registriert. Bitte bestätigen Sie ihre E-Mail adresse mit diesem Link: {activation_url}','Sie haben sich für eine Applikation registriert.','Sie haben ein neues Passwort angefordert. Bitte klicken Sie diesen link: {activation_url}','Ihr Konto wurde freigeschaltet.','Der Benutzer {username} hat Ihnen eine Freundschaftsanfrage gesendet. \n\n							 Nachricht: {message}\n\n							 Klicken sie <a href=\"{link_friends}\">hier</a>, um diese Anfrage zu bestätigen oder zu ignorieren. Alternativ können sie <a href=\"{link_profile}\">hier</a> auf ihre Profilseite zugreifen.','Der Benutzer {username} hat ihre Freundschaftsanfrage bestätigt.','\n							 Benutzer {username} hat Ihnen eine Nachricht auf Ihrer Pinnwand hinterlassen: \n\n							 {message}\n\n							 <a href=\"{link}\">hier</a> geht es direkt zu Ihrer Pinnwand!','Sie haben eine neue Nachricht von {username} bekommen: {message}','Ihre Bestellung der Mitgliedschaft {membership} wurde am {order_date} entgegen genommen. Die gewählte Zahlungsart ist {payment}. Die Auftragsnummer lautet {id}.','Ihre Zahlung wurde am {payment_date} entgegen genommen. Ihre Mitgliedschaft mit der Nummer {id} ist nun Aktiv.'),(3,'es','Te has registrado en esta aplicación. Para confirmar tu dirección de correo electrónico, por favor, visita {activation_url}.','Te has registrado en esta aplicación.','Has solicitado una nueva contraseña. Para establecer una nueva contraseña, por favor ve a {activation_url}','Tu cuenta ha sido activada. Gracias por registrarte.','Has recibido una nueva solicitud de amistad de {user_from}: {message} Ve a tus contactos: {link}','Tienes un nuevo comentario en tu perfil de {username}: {message} visita tu perfil: {link}','Please translatore thisse hiere toh tha espagnola langsch {username}','Has recibido un mensaje de {username}: {message}','Tu orden de membresía {membership} de fecha {order_date} fué tomada. Tu número de orden es {id}. Escogiste como modo de pago {payment}.','Tu pago fué recibido en fecha {payment_date}. Ahora tu Membresía {id} ya está activa'),(4,'fr','','','','','','','','','',''),(5,'ro','','','','','','','','','','');
/*!40000 ALTER TABLE `tbl_yumtextsettings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;



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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_advertising_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `dimension` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `banner_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_advertising_sponsor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `priority` enum('1','2','3','4','5') NOT NULL,
  `percent` tinyint(4) NOT NULL COMMENT 'what percent of the total ad views should be received by this sponsor',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_advertising_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `template` text NOT NULL,
  `css` text NOT NULL,
  `position_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_video_categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `slug` varchar(100) NOT NULL DEFAULT '',
  `total_videos` int(11) NOT NULL DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `parent_cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `image_name` varchar(50)  NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `name` (`name`),
  KEY `slug` (`slug`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_banner_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_video` (
  `video_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` text NOT NULL,
  `description` text NOT NULL,
  `rating` float NOT NULL DEFAULT '0',
  `rated_by` bigint(20) NOT NULL DEFAULT '0',
  `duration` float NOT NULL DEFAULT '0',
  `thumb` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `thumbs` tinyint(2) unsigned NOT NULL DEFAULT '20',
  `embed_code` text NOT NULL,
  `allow_embed` enum('0','1') NOT NULL DEFAULT '1',
  `allow_rating` enum('0','1') NOT NULL DEFAULT '1',
  `allow_comment` enum('0','1') NOT NULL DEFAULT '1',
  `allow_download` enum('0','1') NOT NULL DEFAULT '1',
  `total_views` bigint(20) NOT NULL DEFAULT '0',
  `total_comments` int(11) unsigned NOT NULL DEFAULT '0',
  `total_downloads` int(11) unsigned NOT NULL DEFAULT '0',
  `total_favorites` int(11) unsigned NOT NULL DEFAULT '0',
  `type` enum('public','private') NOT NULL DEFAULT 'public',
  `ext` enum('flv','mp4') NOT NULL DEFAULT 'flv',
  `size` int(11) NOT NULL DEFAULT '0',
  `add_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `view_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `server` int(11) NOT NULL DEFAULT '0',
  `sponsor` int(11) unsigned NOT NULL DEFAULT '0',
  `flagged` enum('0','1') NOT NULL DEFAULT '0',
  `locked` enum('0','1') NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `adv` int(11) unsigned NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT '',
  `premium` enum('0','1') NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0',
  `slug` varchar(100) NOT NULL DEFAULT '',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0',
  `thumb_url` varchar(255) NOT NULL,
  `sponsor_page` varchar(255) NOT NULL,
  `rated_up` int(10) unsigned NOT NULL DEFAULT '0',
  `rated_down` int(10) unsigned NOT NULL DEFAULT '0',
  `publish_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `custom_fields` text NOT NULL,
  `video_source` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - displayed using another site player, 1 - hosted on our server, 2 - hotlinked from another server',
  `master_control_id` int(10) unsigned NOT NULL,
  `thumbs_hosted_on_master_control` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`video_id`),
  UNIQUE KEY `uq_video_master_control_id` (`master_control_id`),
  KEY `user_id` (`user_id`),
  KEY `add_date` (`add_date`),
  KEY `view_date` (`view_date`),
  KEY `rating` (`rating`),
  KEY `duration` (`duration`),
  KEY `total_views` (`total_views`),
  KEY `total_comments` (`total_comments`),
  KEY `total_downloads` (`total_downloads`),
  KEY `total_favorites` (`total_favorites`),
  KEY `status` (`status`),
  KEY `idx_video_title` (`title`(150))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_video_category` (
  `cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `video_id` int(11) unsigned NOT NULL DEFAULT '0',
  `parent_cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `video_id` (`video_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_video_grabber` (
  `video_id` int(11) NOT NULL DEFAULT '0',
  `site` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`video_id`),
  KEY `site` (`site`),
  KEY `url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_video_tags` (
  `tag_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`tag_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_video_tags_lookup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `video_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_video_tags_lookup` (`video_id`,`tag_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_visit` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `advertising_campaign_id` int(11) NOT NULL,
  `ip_addr` varchar(12) NOT NULL,
  `country` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_agent` varchar(255) NOT NULL,
  `visittime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_saved_search_words` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL COMMENT '0 - video',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_keywords_blacklist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_tbl_keywords_blacklist_word` (`word`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_managed_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_managed_links_url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

