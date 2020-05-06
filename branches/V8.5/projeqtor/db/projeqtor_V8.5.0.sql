-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.5.0                                       //
-- // Date : 2020-03-23                                     //
-- ///////////////////////////////////////////////////////////
-- Patch on V8.4.0


INSERT INTO `${prefix}habilitationother` (idProfile,scope,rightAccess) VALUES 
(1,'validatePlanning','1'),
(2,'validatePlanning','1'),
(3,'validatePlanning','1'),
(4,'validatePlanning','2'),
(6,'validatePlanning','2'),
(7,'validatePlanning','2'),
(5,'validatePlanning','2');

DELETE FROM `${prefix}columnselector` WHERE objectClass='Recipient' and field='bank' and attribute='bank';

ALTER TABLE `${prefix}type` ADD COLUMN `icon` varchar(100);

ALTER TABLE `${prefix}globalview` ADD COLUMN `creationDate` datetime DEFAULT NULL;

ALTER TABLE `${prefix}planningelement` 
ADD COLUMN `toDeliver` int(5) unsigned DEFAULT NULL,
ADD COLUMN `toRealised` int(5) unsigned DEFAULT NULL,
ADD COLUMN `realised` int(5) unsigned DEFAULT NULL,
ADD COLUMN `rest` int(5) unsigned DEFAULT NULL,
ADD COLUMN `uoAdvancement` decimal(7,2) DEFAULT NULL,
ADD COLUMN `idAdvancement` int(12) unsigned DEFAULT NULL,
ADD COLUMN `weight` decimal(7,2) DEFAULT NULL,
ADD COLUMN `idWeight` int(12) unsigned DEFAULT NULL;

ALTER TABLE `${prefix}planningelementbaseline` 
ADD COLUMN `toDeliver` int(5) unsigned DEFAULT NULL,
ADD COLUMN `toRealised` int(5) unsigned DEFAULT NULL,
ADD COLUMN `realised` int(5) unsigned DEFAULT NULL,
ADD COLUMN `rest` int(5) unsigned DEFAULT NULL,
ADD COLUMN `uoAdvancement` decimal(7,2) DEFAULT NULL,
ADD COLUMN `idAdvancement` int(12) unsigned DEFAULT NULL,
ADD COLUMN `weight` decimal(7,2) DEFAULT NULL,
ADD COLUMN `idWeight` int(12) unsigned DEFAULT NULL;

CREATE TABLE `${prefix}advancement` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}advancement` (`id`, `name`,  `sortOrder`, `idle`) VALUES
(1,'manual',100,0),
(2,'calculated',200,0);

CREATE TABLE `${prefix}weight` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;


INSERT INTO `${prefix}weight` (`id`, `name`,  `sortOrder`, `idle`) VALUES
(1,'manual',100,0),
(2,'consolidated',200,0),
(3,'UO',300,0);

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES 
('technicalAvancement','NO');

-- ======================================
-- Email as ticket
-- ======================================

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`,`menuClass`) VALUES
(250,'menuInputMailbox',88,'object', 693,'Project',0,'Automation');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,250,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,250,8);

CREATE TABLE `${prefix}inputmailbox` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `serverImap` varchar(200) DEFAULT NULL,
  `userImap` varchar(200) DEFAULT NULL,
  `passwordImap` varchar(50) DEFAULT NULL,
  `securityConstraint` varchar(10) DEFAULT NULL,
  `allowAttach` int(1) unsigned DEFAULT '0',
  `sizeAttachment` int(12) unsigned DEFAULT '0',
  `idTicketType` int(12) unsigned DEFAULT NULL,
  `idAffectable` int(12) unsigned DEFAULT NULL,
  `idActivity` int(12) unsigned DEFAULT NULL,
  `lastInputDate` date DEFAULT NULL,
  `idTicket` int(12) unsigned DEFAULT NULL,
  `totalInputTicket` int(12) unsigned DEFAULT '0',
  `failedRead` int(1) unsigned DEFAULT '0',
  `failedMessage` int(1) unsigned DEFAULT '0',
  `limitOfInputPerHour` int(12) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;
CREATE INDEX assetType ON `${prefix}inputmailbox` (idProject);

CREATE TABLE `${prefix}inputmailboxhistory` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idInputMailbox` int(12) unsigned DEFAULT NULL,
  `adress` varchar(200) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `result` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;
