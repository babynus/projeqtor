-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.5.0                                       //
-- // Date : 2016-07-28                                     //
-- ///////////////////////////////////////////////////////////

-- INSERT INTO `${prefix}accessscope` (`id`,`name`,`accessCode`,`sortOrder`,`idle`) VALUES (6,'accessScopeClient','CLI',375,0);
-- INSERT INTO `${prefix}accessprofile` (`id`,`name`,`description`,`idAccessScopeRead`,`idAccessScopeCreate`,`idAccessScopeUpdate`,`idAccessScopeDelete`,`sortOrder`,`idle`) VALUES (11,'accessProfileClientCreator','Read his client''s projects Can create his own project',6,3,6,2,325,0);

CREATE TABLE `${prefix}productproject` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idProduct` int(12) unsigned DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE INDEX productprojectProject ON `${prefix}productproject` (idProject);
CREATE INDEX productprojectProduct ON `${prefix}productproject` (idProduct);

INSERT INTO `${prefix}textable` (`id`,`name`,`idle`) VALUES 
(20,'Quotation',0);

ALTER TABLE `${prefix}project` ADD `lastUpdateDateTime` datetime DEFAULT NULL;
ALTER TABLE `${prefix}activity` ADD `lastUpdateDateTime` datetime DEFAULT NULL;

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(151,'menuExpenses', 74, 'menu', 202, NULL, 0, ''),
(152,'menuIncomings', 74, 'menu', 225, NULL, 0, ''),
(153,'menuCallForTender', 151, 'object', 204, 'Project', 0, 'Financial '),
(154,'menuTender', 151, 'object', 206, 'Project', 0, 'Financial '),
(155,'menuCallForTenderType', 79, 'object', 825, 'Project', 0, 'Type '),
(156,'menuTenderType', 79, 'object', 829, 'Project', 0, 'Type ');

UPDATE `${prefix}menu` SET `idMenu`=151 WHERE `id` IN (75,76);
UPDATE `${prefix}menu` SET `idMenu`=152 WHERE `id` IN (131,125,96,97,78,94,146);
UPDATE `${prefix}menu` SET `sortOrder`=833 WHERE `id`=80;
UPDATE `${prefix}menu` SET `sortOrder`=837 WHERE `id`=81;
UPDATE `${prefix}menu` SET `sortOrder`=841 WHERE `id`=84;
UPDATE `${prefix}menu` SET `sortOrder`=845 WHERE `id`=132;
UPDATE `${prefix}menu` SET `sortOrder`=849 WHERE `id`=126;
UPDATE `${prefix}menu` SET `sortOrder`=853 WHERE `id`=100;
UPDATE `${prefix}menu` SET `sortOrder`=857 WHERE `id`=83;

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`)
SELECT `idProfile`, 153, `allowAccess` FROM `${prefix}habilitation` WHERE `idMenu`=131;
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`)
SELECT `idProfile`, 154, `allowAccess` FROM `${prefix}habilitation` WHERE `idMenu`=131;
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`)
SELECT `idProfile`, 155, `allowAccess` FROM `${prefix}habilitation` WHERE `idMenu`=132;
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`)
SELECT `idProfile`, 156, `allowAccess` FROM `${prefix}habilitation` WHERE `idMenu`=132;

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) 
SELECT `idProfile`, 153, `idAccessProfile` FROM `${prefix}accessright` WHERE `idMenu`=131;  
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) 
SELECT `idProfile`, 154, `idAccessProfile` FROM `${prefix}accessright` WHERE `idMenu`=131;

CREATE TABLE `${prefix}tender` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `idTenderType` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idCallForTender` int(12) unsigned DEFAULT NULL,
  `idCallForTenderRequest` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idProvider` int(12) unsigned DEFAULT NULL,
  `externalReference` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `receptionDate` date DEFAULT NULL,
  `validityEndDate` date DEFAULT NULL,
  `plannedAmount` decimal(11,2) UNSIGNED,
  `taxPct` decimal(5,2) DEFAULT NULL,
  `plannedTaxAmount` decimal(11,2) UNSIGNED,
  `plannedFullAmount` decimal(11,2) UNSIGNED,
  `expensePlannedDate` date DEFAULT NULL,
  `evaluation` decimal(7,2) DEFAULT NULL,
  `result` mediumtext DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `cancelled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `idleDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX tenderProject ON `${prefix}tender` (idProject);
CREATE INDEX tenderType ON `${prefix}tender` (idTenderType);
CREATE INDEX tenderProvider ON `${prefix}tender` (idProvider);
CREATE INDEX tenderStatus ON `${prefix}tender` (idStatus);
CREATE INDEX tenderCallForTender ON `${prefix}tender` (idCallForTender);
CREATE INDEX tenderCallForTenderRequest ON `${prefix}tender` (idCallForTenderRequest);

CREATE TABLE `${prefix}callfortender` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `idCallForTenderType` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `technicalRequirements` mediumtext DEFAULT NULL,
  `functionalRequirements` mediumtext DEFAULT NULL,
  `financialRequirements` mediumtext DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `sendDate` date DEFAULT NULL,
  `expectedTenderDate` date DEFAULT NULL,
  `maxAmount` decimal(11,2) UNSIGNED,
  `deliveryDate` date DEFAULT NULL,
  `expensePlannedDate` date DEFAULT NULL,
  `evaluationMaxValue` decimal(7,2) DEFAULT NULL,
  `result` mediumtext DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `idle` int(1) unsigned DEFAULT '0',
  `cancelled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `idleDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX callfortenderProject ON `${prefix}callfortender` (idProject);
CREATE INDEX callfortenderType ON `${prefix}callfortender` (idCallForTenderType);
CREATE INDEX callfortenderStatus ON `${prefix}callfortender` (idStatus);
CREATE INDEX callfortenderResource ON `${prefix}callfortender` (idResource);

CREATE TABLE `${prefix}callfortenderrequest` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idCallForTender` int(12) unsigned DEFAULT NULL,
  `idProvider` int(12) unsigned DEFAULT NULL,
  `sendDate` date DEFAULT NULL,
  `expectedTenderDate` date DEFAULT NULL,
  `received` int(1) unsigned DEFAULT '0',
  `receptionDate` date DEFAULT NULL,
  `evaluationValue` decimal(7,2) DEFAULT NULL,
  `winner` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX callfortenderrequestCallForTender ON `${prefix}callfortenderrequest` (idCallForTender);
CREATE INDEX callfortenderrequestProvider ON `${prefix}callfortenderrequest` (idProvider);

CREATE TABLE `${prefix}tenderevaluationcriteria` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idCallForTender` int(12) unsigned DEFAULT NULL,
  `criteriaName` varchar(100) DEFAULT NULL,
  `criteriaMaxValue` int(3) unsigned DEFAULT 10,
  `criteriaCoef` int(3) unsigned DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX tenderevaluationcriteriaCallForTender ON `${prefix}tenderevaluationcriteria` (idCallForTender);

CREATE TABLE `${prefix}tenderevaluation` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idTenderEvaluationCriteria` int(12) unsigned DEFAULT NULL,
  `idTender` int(12) unsigned DEFAULT NULL,
  `evaluationValue` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX tenderevaluationTenderEvaluationCriteria ON `${prefix}tenderevaluation` (idTenderEvaluationCriteria);
CREATE INDEX tenderevaluationTender ON `${prefix}tenderevaluation` (idTender);