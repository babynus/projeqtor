
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.0.0                                      //
-- // Date : 2011-04-04                                     //
-- ///////////////////////////////////////////////////////////
--
--
CREATE TABLE `${prefix}activityprice` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idActivityType` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `priceCost` decimal(10,2) DEFAULT '0',
  `subcontractor` int(1) DEFAULT NULL,
  `sortOrder` int(3) DEFAULT NULL,
  `idle` int(1) DEFAULT '0',
  `subcontractorCost` decimal(10,2) DEFAULT NULL,
  `idTeam` int(12) unsigned DEFAULT NULL,
  `commissionCost` decimal(10,2) DEFAULT NULL,
  `isRef` int(1) NOT NULL DEFAULT '0',
  `pct` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}activityprice` ADD INDEX activitypriceProject (idProject),
 ADD INDEX activitypriceActivityType (idActivityType),
 ADD INDEX activitypriceTeam (idTeam);

CREATE TABLE `${prefix}bill` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idBillType` int(12) unsigned DEFAULT NULL,
  `billingType` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idClient` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `billId` int(12) unsigned DEFAULT NULL,
  `tax` decimal(5,2) DEFAULT NULL,
  `untaxedAmount` decimal(12,2) DEFAULT NULL,
  `fullAmount` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}bill` ADD INDEX billBillType (idBillType),
 ADD INDEX billProject (idProject),
 ADD INDEX billClient (idClient),
 ADD INDEX billRecipient (idRecipient),
 ADD INDEX billStatus (idStatus),
 ADD INDEX billBillType(idBillType);
 
ALTER TABLE `${prefix}client` ADD COLUMN `paymentDelay` int(3) NULL after `clientCode`, 
 ADD COLUMN `tax` decimal(5,2) DEFAULT NULL after `paymentDelay`;
	
CREATE TABLE `${prefix}billline` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `line` int(3) unsigned DEFAULT NULL,
  `quantity` decimal(5,2) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `detail` varchar(4000) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `refType` varchar(100) NOT NULL,
  `refId` int(12) unsigned NOT NULL,
  `idTerm` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
	`idActivityPrice` int(12) unsigned DEFAULT NULL,
	`startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}billline` ADD INDEX billlineReference (refType, refId),
ADD INDEX billlineTerm (idTerm),
ADD INDEX billlineResource (idResource),
ADD INDEX billlineActivityPrice (idActivityPrice);

ALTER TABLE `${prefix}project` ADD COLUMN `idRecipient` int(12) unsigned   NULL after `idClient`, 
	ADD COLUMN `paymentDelay` int(3) NULL after `doneDate`,
	ADD COLUMN `longitude` float(15,12) NULL after `paymentDelay`,
	ADD COLUMN `latitude` float(15,12) NULL after `longitude`;

ALTER TABLE `${prefix}project` ADD INDEX projectRecipient(idRecipient);

CREATE TABLE `${prefix}recipient` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `companyNumber` varchar(14) DEFAULT NULL,
  `numTax` varchar(100) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `ibanCountry` varchar(2) DEFAULT NULL,
	`ibanKey` varchar(2) DEFAULT NULL,
	`ibanBban` varchar(34) DEFAULT NULL,
	`designation` varchar(50), 
  `street` varchar(50) , 
  `complement` varchar(50), 
  `zip` varchar(50), 
  `city` varchar(50), 
  `state` varchar(50), 
  `country` varchar(50),
  `taxFree` int(1) unsigned DEFAULT 0,
  `idle` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `${prefix}term` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `validatedAmount` decimal(10,2) DEFAULT NULL,
  `plannedAmount` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `validatedDate` date DEFAULT NULL,
  `plannedDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT NULL,
  `idBill` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}term` ADD INDEX termProject (idProject)
ADD INDEX termBill (idBillt);

ALTER TABLE `${prefix}user` ADD COLUMN `designation` varchar(50) after `isContact`, 
	ADD COLUMN `street` varchar(50) after `designation`, 
	ADD COLUMN `complement` varchar(50) after `street`, 
	ADD COLUMN `zip` varchar(50) after `complement`, 
	ADD COLUMN `city` varchar(50) after `zip`, 
	ADD COLUMN `state` varchar(50) after `city`, 
	ADD COLUMN `country` varchar(50) after `state`, 
	ADD COLUMN `idRecipient` int(12)  unsigned NULL after `idRole`;

ALTER TABLE `${prefix}user` ADD INDEX userRecipient (idRecipient);

ALTER TABLE `${prefix}work` ADD COLUMN `idBill` int(12) unsigned DEFAULT NULL after `cost`;

ALTER TABLE `${prefix}work` ADD INDEX workBill (idBill);

ALTER TABLE `${prefix}planningelement` ADD COLUMN `idBill` int(12) unsigned DEFAULT NULL after `plannedCost`;

LTER TABLE `${prefix}planningelement` ADD INDEX planningelementBill (idBill);

ALTER TABLE `${prefix}assignment` ADD COLUMN `billedWork` decimal(10,2) NOT NULL DEFAULT '0' after `plannedCost`;

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
	(94,'menuActivityPrice',74,'object',280,NULL,0),
	(95,'menuRecipient',14,'object',635,NULL,0),
	(96,'menuTerm',74,'object',262,NULL,0),
	(97,'menuBill',74,'object',267,NULL,0),
	(100,'menuBillType',79,'object',865,NULL,1);
	
UPDATE `${prefix}menu` SET `sortOrder`=10 WHERE `id`=1;

UPDATE `${prefix}menu` SET `idMenu`=0, `sortOrder`=50 WHERE `id`=16;
	
UPDATE `${prefix}menu` SET `idMenu`=2, `sortOrder`=160 WHERE `id`=4;
	
UPDATE `${prefix}menu` SET `idMenu`=0,  `sortOrder`=600 WHERE `id`=14;
	
UPDATE `${prefix}menu` SET `idMenu`=79, `sortOrder`=688 WHERE `id`=13;

UPDATE `${prefix}menu` SET `sortOrder`=610 WHERE `id`=50;

UPDATE `${prefix}menu` SET `sortOrder`=615 WHERE `id`=17;

UPDATE `${prefix}menu` SET `sortOrder`=620 WHERE `id`=44;

UPDATE `${prefix}menu` SET `sortOrder`=630 WHERE `id`=72;

UPDATE `${prefix}menu` SET `sortOrder`=635 WHERE `id`=15;

UPDATE `${prefix}menu` SET `sortOrder`=640 WHERE `id`=95;

UPDATE `${prefix}menu` SET `sortOrder`=645 WHERE `id`=57;

UPDATE `${prefix}menu` SET `sortOrder`=650 WHERE `id`=86;

UPDATE `${prefix}menu` SET `sortOrder`=655 WHERE `id`=87;

INSERT INTO `${prefix}accessright` (idProfile,idMenu,idAccessProfile) VALUES 
(1,94,8),
(1,95,8),
(1,96,8),
(1,97,8),
(1,98,8),
(1,99,8),
(1,100,8);	

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 94, 1),
(1, 95, 1),
(1, 96, 1),
(1, 97, 1),
(1, 98, 1),
(1, 99, 1),
(1, 100, 1);

INSERT INTO `${prefix}reportcategory` (`id`, `name`, `order`, `idle`) VALUES 
(7,'reportCategoryBill',60,0);
	
INSERT INTO `${prefix}report`(`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `idle`) 
VALUES (37,'reportBill',7,'bill.php',1,0);

INSERT INTO `${prefix}reportparameter` (`id`, `idReport`, `name`, `paramType`, `order`, `idle`, `defaultValue`) VALUES
(86,37,'idBill','billList',10,0,NULL),
(87,37,'idProject','projectList',20,0,'currentProject'),
(88,37,'idClient','clientList',30,0,NULL);

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES
(1,37,1),
(2,37,0),
(3,37,0),
(4,37,0),
(5,37,0),
(6,37,0),
(7,37,0);

CREATE TABLE `${prefix}documentdirectory` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(100),
  `name` varchar(100) DEFAULT NULL,
  `location` varchar(4000),
  `idProject` int(12) unsigned DEFAULT NULL,
  `idProduct` int(12) unsigned DEFAULT NULL,
  `idDocumentDirectory` int(12) unsigned,
  `idDocumentType` int(12) unsigned,
  `idle` int(1) unsigned default '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}documentdirectory` ADD INDEX documentdirectoryProject (idProject),
ADD INDEX documentdirectoryProduct (idProduct),
ADD INDEX documentdirectoryDocumentDirectory (idDocumentDirectory),
ADD INDEX documentdirectoryDocumentType (idDocumentType);

INSERT INTO `${prefix}documentdirectory` (id,name,idProject,idDocumentDirectory,location) values
(1,'Project',null,null,'/Project'),
(2,'Product',null,null,'/Product'),
(3,'Need',null,2,'/Product/Need'),
(4,'Specification',null,2,'/Product/Specification'),
(5,'Conception',null,2,'/Product/Conception'),
(7,'Testing',null,2,'/Product/Testing'),
(8,'Deployment',null,2,'/Product/Deployment'),
(9,'Exploitation',null,2,'/Product/Exploitation'),
(10,'Contract',null,1,'/Project/Contract'),
(11,'Management',null,1,'/Project/Management'),
(12,'Reviews',null,1,'/Project/Reviews'),
(13,'Follow-up',null,1,'/Project/Follow-up'),
(14,'Financial',null,1,'/Project/Financial'); 

CREATE TABLE `${prefix}document` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(100),
  `name` varchar(100) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idProduct` int(12) unsigned DEFAULT NULL,
  `idDocumentType` int(12) unsigned DEFAULT NULL,
  `idDocumentDirectory` int(12) unsigned,
  `idVersioningType` int(12) unsigned DEFAULT NULL,
  `version` int(3),
  `revision` int(3),
  `draft` int(3),
  `idStatus` int(12) unsigned,
  `idDocumentVersion` int(12) unsigned,
  `idDocumentVersionRef` int(12) unsigned,
  `idAuthor` int(12) unsigned,
  `locked` int(1) unsigned default '0',
  `idLocker` int(12) unsigned,
  `lockedDate` datetime,
  `fileName` varchar(100),
  `description` varchar(4000),
  `idle` int(1) unsigned default '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}document` ADD INDEX documentProject (idProject),
ADD INDEX documentProduct (idProduct),
ADD INDEX documentDocumentType (idDocumentType),
ADD INDEX documentDocumentDirectory (idDocumentDirectory),
ADD INDEX documentVersionType (idVersioningType),
ADD INDEX documentStatus (idStatus),
ADD INDEX documentDocumentVersion (idDocumentVersion),
ADD INDEX documentDocumentVersionRef (idDocumentVersionRef),
ADD INDEX documentAuthor (idAuthor),
ADD INDEX documentLocker (idLocker);

CREATE TABLE `${prefix}documentversion` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `fullName` varchar(200) DEFAULT NULL,
  `version` int(3),
  `revision` int(3),
  `draft` int(3),
  `fileName` varchar(400) DEFAULT NULL,
  `mimeType` varchar(100),
  `fileSize` int(12),
  `link` varchar(400) DEFAULT NULL,
  `versionDate` date,
  `createDateTime` datetime,
  `updateDateTime` datetime,
  `extension` varchar(100) DEFAULT NULL,
  `idDocument` int(12) unsigned DEFAULT NULL,
  `idAuthor` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `description` varchar(4000),
  `isRef` int(1) unsigned default '0',
  `idle` int(1) unsigned default '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `${prefix}documentversion` ADD INDEX documentversionDocument (idDocument),
ADD INDEX documentversionAuthor (idAuthor),
ADD INDEX documentversionStatus (idStatus);

INSERT INTO `${prefix}type` (scope,name,code, idWorkflow,sortOrder) values
('Document','Need expression','NEEDEXP',1,210),
('Document','General Specification','GENSPEC', 1,220),
('Document','Detailed Specification','DETSPEC', 1,230),
('Document','General Conception','GENCON', 1, 240),
('Document','Detail Conception','DETCON', 1, 250),
('Document','Test Plan','TEST', 1, 260),
('Document','Installaton manual','INST', 1,270),
('Document','Exploitation manual','EXPL', 1,280),
('Document','User manual','MANUAL', 1,290),
('Document','Contract','CTRCT', 1,110),
('Document','Management','MGT', 1,120),
('Document','Meeting Review','MEETREV', 1,130),
('Document','Follow-up','F-UP', 1,140),
('Document','Financial','FIN', 1,150); 

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
(101,'menuDocumentType',79,'object',950,NULL,1);
  
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 101, 1);

INSERT INTO `${prefix}type` (scope,name,code, idWorkflow,sortOrder) values
('Versioning','evolutive','EVO',1,10),
('Versioning','chronological','EVT',1,20),
('Versioning','sequential','SEQ',1,30),
('Versioning','external','EXT',1,40);

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
(102,'menuDocument',0,'object',60,'Project',0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 102, 1),
(2, 102, 1),
(3, 102, 1),
(4, 102, 1),
(6, 102, 1),
(7, 102, 1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1, 102, 8),
(2, 102, 2),
(3, 102, 7),
(4, 102, 7),
(6, 102, 2),
(7, 102, 2),
(5, 102, 9);

CREATE TABLE `${prefix}referencable` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}referencable` (`id`, `name`, `idle`) VALUES
(1, 'Ticket', 0),
(2, 'Activity', 0),
(3, 'Milestone', 0),
(4, 'IndividualExpense', 0),
(5, 'ProjectExpense', 0),
(6, 'Risk', 0),
(7, 'Action', 0),
(8, 'Issue', 0),
(9, 'Meeting', 0),
(10, 'Decision', 0),
(11, 'Question', 0),
(12, 'Document', 0);

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null, null, 'draftSeparator','_draft');

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null, null, 'documentRoot','../files/documents');

INSERT INTO `${prefix}habilitationother` (`idProfile`, `scope`, `rightAccess`) VALUES
(1, 'planning', 1),
(2, 'planning', 2),
(3, 'planning', 1),
(4, 'planning', 2),
(6, 'planning', 2),
(7, 'planning', 2),
(5, 'planning', 2),
(1, 'document', 1),
(2, 'document', 2),
(3, 'document', 1),
(4, 'document', 2),
(6, 'document', 2),
(7, 'document', 2),
(5, 'document', 2);

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
  (103,'menuDocumentDirectory',14,'object',686,NULL,0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 103, 1),
(3, 103, 1);

ALTER TABLE `${prefix}type` CHANGE internalData internalData VARCHAR(1);

ALTER TABLE `${prefix}dependency` CHANGE successorId successorId INT(12) UNSIGNED;

INSERT INTO `${prefix}type` (scope,name,code, idWorkflow,sortOrder, lockDone, lockIdle) values
('Bill','Partial bill','PARTIAL',1,100, 1, 1),
('Bill','Final bill','FINAL',1,200, 1, 1),
('Bill','Complete bill','COMPLETE',1,300, 1, 1);


INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null, null, 'billPrefix','BILL'),
(null, null, 'billSuffix','_FR'),
(null, null, 'billNumSize','5'),
(null, null, 'billNumStart','10000');
