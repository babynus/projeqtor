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