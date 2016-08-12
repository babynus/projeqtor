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

ALTER TABLE `${prefix}project` ADD `lastUpdateDateTime` datetime DEFAULT NULL;
ALTER TABLE `${prefix}activity` ADD `lastUpdateDateTime` datetime DEFAULT NULL;

INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(151,'menuExpenses', 74, 'menu', 202, NULL, 0, ''),
(152,'menuIncomings', 74, 'menu', 225, NULL, 0, ''),
(153,'menuRequestForProposal', 151, 'object', 204, NULL, 0, 'Financial '),
(154,'menuProposal', 151, 'object', 206, NULL, 0, 'Financial ');

UPDATE `${prefix}menu` SET `idMenu`=151 WHERE `id` IN (75,76);
UPDATE `${prefix}menu` SET `idMenu`=152 WHERE `id` IN (131,125,96,97,78,94,146);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
SELECT `idProfile`, 153, `allowAccess` FROM `${prefix}habilitation` WHERE `idMenu`=131;
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
SELECT `idProfile`, 154, `allowAccess` FROM `${prefix}habilitation` WHERE `idMenu`=131;

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) 
SELECT `idProfile`, 153, `idAccessProfile` FROM `${prefix}accessright` WHERE `idMenu`=131;  
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) 
SELECT `idProfile`, 154, `idAccessProfile` FROM `${prefix}accessright` WHERE `idMenu`=131;

CREATE TABLE `${prefix}quotation` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idQuotationType` int(12) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idClient` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `additionalInfo` varchar(4000) DEFAULT NULL,
  `initialEndDate` date DEFAULT NULL,
  `initialWork` decimal(12,2) DEFAULT '0.00',
  `initialPricePerDayAmount` decimal(12,2) DEFAULT '0.00',
  `initialAmount` decimal(12,2) DEFAULT '0.00',
  `comment` varchar(4000) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `done` int(1) unsigned DEFAULT '0',
  `cancelled` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `doneDate` date DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `sendDate` date DEFAULT NULL,
  `validityEndDate` date DEFAULT NULL,
  `idActivityType` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX quotationProject ON `${prefix}quotation` (idProject);
CREATE INDEX quotationUser ON `${prefix}quotation` (idUser);
CREATE INDEX quotationResource ON `${prefix}quotation` (idResource);
CREATE INDEX quotationStatus ON `${prefix}quotation` (idStatus);
CREATE INDEX quotationType ON `${prefix}quotation` (idQuotationType);
CREATE INDEX quotationClient ON `${prefix}quotation` (idClient);
CREATE INDEX quotationContact ON `${prefix}quotation` (idContact);