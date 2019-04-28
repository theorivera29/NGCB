DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `accounts_id` int(11) NOT NULL AUTO_INCREMENT,
  `accounts_fname` varchar(45) NOT NULL,
  `accounts_lname` varchar(45) NOT NULL,
  `accounts_username` varchar(45) NOT NULL,
  `accounts_password` varchar(255) NOT NULL,
  `accounts_type` varchar(45) NOT NULL,
  `accounts_email` varchar(45) NOT NULL,
  `accounts_image` longblob,
  `accounts_deletable` varchar(45) NOT NULL,
  `accounts_status` varchar(45) NOT NULL,
  PRIMARY KEY (`accounts_id`),
  UNIQUE KEY `accounts_id_UNIQUE` (`accounts_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
LOCK TABLES `accounts` WRITE;
INSERT INTO `accounts` VALUES (1,'admin','admin','admin','$2y$10$1wlaSq5G8Fvv4WydcAF4L.H6wCVkO.p5J3GdtXWEHqGWRDlXZPEaG','Admin','benzservidad13@gmail.com',NULL,'no','active'),(2,'materials_engineer','materials_engineer','materials_engineer','$2y$10$5qNGMvsm7wEwUCdF2v5pYeadU5woLEhIP9gRreHyHl350N0JuFwie','MatEng','jamspica@gmail.com',NULL,'no','active'),(3,'view_only','view_only','view_only','$2y$10$IBUx9N2bKy.mObs8ZquGPeD/RqQlP/8toMeOfQW0EOxd8dMiJcfNm','ViewOnly','theorivera@gmail.com',NULL,'no','active'),(4,'trial','sample','mat_eng','sample','MatEng','sample@gmail.com',NULL,'yes','active');
UNLOCK TABLES;
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(45) NOT NULL,
  PRIMARY KEY (`unit_id`),
  UNIQUE KEY `unit_id_UNIQUE` (`unit_id`),
  UNIQUE KEY `unit_name_UNIQUE` (`unit_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
LOCK TABLES `unit` WRITE;
INSERT INTO `unit` VALUES (3,'mtrs'),(1,'pcs'),(2,'rolls'),(4,'set');
UNLOCK TABLES;
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `projects_id` int(11) NOT NULL AUTO_INCREMENT,
  `projects_name` varchar(45) NOT NULL,
  `projects_address` varchar(45) NOT NULL,
  `projects_sdate` date NOT NULL,
  `projects_edate` date NOT NULL,
  `projects_status` varchar(45) NOT NULL,
  `projects_mateng` int(11) NOT NULL,
  PRIMARY KEY (`projects_id`),
  UNIQUE KEY `projects_id_UNIQUE` (`projects_id`),
  KEY `proj_mateng_idx` (`projects_mateng`),
  CONSTRAINT `proj_mateng` FOREIGN KEY (`projects_mateng`) REFERENCES `accounts` (`accounts_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
LOCK TABLES `projects` WRITE;
INSERT INTO `projects` VALUES (1,'SM Baguio Expansion','Luneta Hill, Baguio City','2017-07-12','2019-03-17','open',2),(2,'SOGO Hotel Baguio','Engineers Hill, Baguio City','2018-03-06','2020-12-13','closed',2),(3,'Hyatt Hotel Baguio','Bakakeng, Baguio City','2015-11-22','2017-05-30','open',2);
UNLOCK TABLES;
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(45) NOT NULL,
  `categories_project` int(11) NOT NULL,
  PRIMARY KEY (`categories_id`),
  UNIQUE KEY `categories_id_UNIQUE` (`categories_id`),
  KEY `cat_projects_idx` (`categories_project`),
  CONSTRAINT `cat_projects` FOREIGN KEY (`categories_project`) REFERENCES `projects` (`projects_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
LOCK TABLES `categories` WRITE;
INSERT INTO `categories` VALUES (1,'Formworks',1),(2,'Electrical',3),(3,'Plumbing',1),(4,'Blades',1),(5,'Lubricants',1),(6,'Table Forms',3),(7,'Office',3),(8,'Tower Crane',1),(9,'Consumables',3),(10,'Heavy Equipment',1),(11,'Others',1),(14,'Trial',3);
UNLOCK TABLES;
DROP TABLE IF EXISTS `materials`;
CREATE TABLE `materials` (
  `mat_id` int(11) NOT NULL AUTO_INCREMENT,
  `mat_name` varchar(45) NOT NULL,
  `mat_prevStock` varchar(45) DEFAULT NULL,
  `mat_project` int(11) NOT NULL,
  `mat_unit` int(11) NOT NULL,
  `mat_categ` int(11) NOT NULL,
  `mat_notif` int(11) NOT NULL,
  `currentQuantity` int(11) NOT NULL,
  PRIMARY KEY (`mat_id`),
  UNIQUE KEY `mat_id_UNIQUE` (`mat_id`),
  UNIQUE KEY `mat_name_UNIQUE` (`mat_name`),
  KEY `categories_idx` (`mat_categ`),
  KEY `projects_idx` (`mat_project`),
  KEY `categories_id` (`mat_categ`),
  KEY `matunit_idx` (`mat_unit`),
  CONSTRAINT `categories` FOREIGN KEY (`mat_categ`) REFERENCES `categories` (`categories_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `matunit` FOREIGN KEY (`mat_unit`) REFERENCES `unit` (`unit_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `projects` FOREIGN KEY (`mat_project`) REFERENCES `projects` (`projects_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
LOCK TABLES `materials` WRITE;
INSERT INTO `materials` VALUES (1,'A-Clamp Assembly','100',1,1,1,50,10),(2,'Bolt & Nut 1/2x4 w/ washer','100',1,1,1,50,20),(3,'Grounding Wire 60mmsg','100',3,3,2,50,30),(4,'THHN Wire 3.5mm2','100',3,2,2,50,40),(5,'Bushing 3\"','100',1,1,3,50,50),(6,'PVC Pipe 3\" x 3m','100',3,1,3,50,60),(7,'Cup Brush 4\"','100',1,1,4,50,70),(8,'Cutting Disc 4\"','100',1,1,4,50,80),(9,'Beam Hanger','100',3,1,6,50,90),(10,'Table Form T1 (3.353 x 6.990)','100',3,1,6,50,100),(11,'Christmas Gift','100',1,1,11,50,110),(12,'Anchor Bolt w/ Nut 20mm x 50mm','100',1,1,11,50,120);
UNLOCK TABLES;
DROP TABLE IF EXISTS `hauling`;
CREATE TABLE `hauling` (
  `hauling_id` int(11) NOT NULL AUTO_INCREMENT,
  `hauling_no` int(11) NOT NULL,
  `hauling_date` date NOT NULL,
  `hauling_deliverTo` varchar(45) NOT NULL,
  `hauling_hauledFrom` varchar(45) NOT NULL,
  `hauling_quantity` int(11) NOT NULL,
  `hauling_unit` int(11) NOT NULL,
  `hauling_matname` int(11) NOT NULL,
  `hauling_hauledBy` varchar(45) NOT NULL,
  `hauling_requestedBy` int(11) NOT NULL,
  `hauling_warehouseman` varchar(45) NOT NULL,
  `hauling_approvedBy` varchar(45) NOT NULL,
  `hauling_truckDetailsType` varchar(45) NOT NULL,
  `hauling_truckDetailsPlateNo` varchar(45) NOT NULL,
  `hauling_truckDetailsPo` varchar(45) NOT NULL,
  `hauling_truckDetailsHaulerDr` varchar(45) NOT NULL,
  PRIMARY KEY (`hauling_id`),
  UNIQUE KEY `hauling_id_UNIQUE` (`hauling_id`),
  KEY `haulingmat_idx` (`hauling_matname`),
  KEY `haulingunit_idx` (`hauling_unit`),
  KEY `haulingreq_idx` (`hauling_requestedBy`),
  CONSTRAINT `haulingeq` FOREIGN KEY (`hauling_requestedBy`) REFERENCES `accounts` (`accounts_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `haulingmat` FOREIGN KEY (`hauling_matname`) REFERENCES `materials` (`mat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `haulingunit` FOREIGN KEY (`hauling_unit`) REFERENCES `unit` (`unit_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
LOCK TABLES `hauling` WRITE;
INSERT INTO `hauling` VALUES (1,1,'2019-03-03','Rimando Inc.','NGCB Expansion Site',250,1,9,'Caryl Oficiar',2,'Vincent Ibalio','Jam Rocafort','HOWO Dump Truck','QWE 1990','171036','1234');
UNLOCK TABLES;
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `logs_id` int(11) NOT NULL AUTO_INCREMENT,
  `logs_datetime` datetime NOT NULL,
  `logs_activity` varchar(45) NOT NULL,
  `logs_logsOf` int(11) NOT NULL,
  PRIMARY KEY (`logs_id`),
  UNIQUE KEY `logs_id_UNIQUE` (`logs_id`),
  KEY `logsmateng_idx` (`logs_logsOf`),
  CONSTRAINT `logsmateng` FOREIGN KEY (`logs_logsOf`) REFERENCES `accounts` (`accounts_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
LOCK TABLES `logs` WRITE;
INSERT INTO `logs` VALUES (1,'2019-04-09 14:53:30','Created Hauling',2),(2,'2019-03-18 11:27:40','Created Material',4);
UNLOCK TABLES;
DROP TABLE IF EXISTS `request`;
CREATE TABLE `request` (
  `req_id` int(11) NOT NULL AUTO_INCREMENT,
  `req_username` int(11) NOT NULL,
  `req_date` date NOT NULL,
  PRIMARY KEY (`req_id`),
  UNIQUE KEY `req_id_UNIQUE` (`req_id`),
  KEY `requsername_idx` (`req_username`),
  CONSTRAINT `requsername` FOREIGN KEY (`req_username`) REFERENCES `accounts` (`accounts_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
LOCK TABLES `request` WRITE;
INSERT INTO `request` VALUES (1,2,'2019-04-12'),(2,3,'2019-04-13');
UNLOCK TABLES;
DROP TABLE IF EXISTS `todo`;
CREATE TABLE `todo` (
  `todo_id` int(11) NOT NULL AUTO_INCREMENT,
  `todo_date` date NOT NULL,
  `todo_task` varchar(50) NOT NULL,
  `todo_status` varchar(45) NOT NULL,
  `todoOf` int(11) NOT NULL,
  PRIMARY KEY (`todo_id`),
  UNIQUE KEY `todo_id_UNIQUE` (`todo_id`),
  KEY `todomateng_idx` (`todoOf`),
  CONSTRAINT `todomateng` FOREIGN KEY (`todoOf`) REFERENCES `accounts` (`accounts_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
LOCK TABLES `todo` WRITE;
INSERT INTO `todo` VALUES (2,'2019-01-21','Delivery day','in progress',4),(4,'2019-07-08','Delivery day','done',4),(10,'2019-05-19','as','in progress',2),(11,'2019-05-19','asdasdasd','in progress',2),(12,'2019-04-04','trial','in progress',2),(13,'2019-04-04','trial','in progress',2),(14,'2019-04-16','fssf','in progress',2);
UNLOCK TABLES;
DROP TABLE IF EXISTS `usagein`;
CREATE TABLE `usagein` (
  `usage_id` int(11) NOT NULL AUTO_INCREMENT,
  `usage_date` date NOT NULL,
  `usage_quantity` int(11) NOT NULL,
  `usage_unit` int(11) NOT NULL,
  `pulledOutBy` varchar(45) NOT NULL,
  `usage_areaOfUsage` varchar(45) NOT NULL,
  `usage_matname` int(11) NOT NULL,
  PRIMARY KEY (`usage_id`),
  UNIQUE KEY `usage_id_UNIQUE` (`usage_id`),
  KEY `usageunit_idx` (`usage_unit`),
  KEY `usagemat_idx` (`usage_matname`),
  CONSTRAINT `usagemat` FOREIGN KEY (`usage_matname`) REFERENCES `materials` (`mat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `usageunit` FOREIGN KEY (`usage_unit`) REFERENCES `unit` (`unit_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
LOCK TABLES `usagein` WRITE;
INSERT INTO `usagein` VALUES (1,'2018-11-23',3,1,'Laroza','SM B-up',1),(2,'2018-11-24',45,2,'Dulce','PH-2',2),(3,'2018-11-24',17,1,'Bisaya','PH-2 B-3',1),(4,'2018-11-24',3,1,'Vinaya','Foot',1),(5,'2018-11-24',59,2,'Pepito','B-up',2),(6,'2018-11-24',69,1,'Pepito','PH-1 B-up',1);
UNLOCK TABLES;
DROP TABLE IF EXISTS `deliveredin`;
CREATE TABLE `deliveredin` (
  `delivered_id` int(11) NOT NULL AUTO_INCREMENT,
  `delivered_date` date NOT NULL,
  `delivered_quantity` int(11) NOT NULL,
  `delivered_unit` int(11) NOT NULL,
  `suppliedBy` varchar(45) NOT NULL,
  `delivered_matName` int(11) NOT NULL,
  PRIMARY KEY (`delivered_id`),
  UNIQUE KEY `delivered_id_UNIQUE` (`delivered_id`),
  KEY `deliveredmat_idx` (`delivered_matName`),
  KEY `deliveredunit_idx` (`delivered_unit`),
  CONSTRAINT `deliveredmat` FOREIGN KEY (`delivered_matName`) REFERENCES `materials` (`mat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `deliveredunit` FOREIGN KEY (`delivered_unit`) REFERENCES `unit` (`unit_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
LOCK TABLES `deliveredin` WRITE;
INSERT INTO `deliveredin` VALUES (1,'2019-03-05',350,1,'Rimando Inc.',1),(2,'2019-01-01',69,2,'Dela Peña Inc.',2),(3,'2019-02-13',95,1,'Vinluan Corp.',1),(5,'2019-12-12',100,1,'lebron',1);
UNLOCK TABLES;