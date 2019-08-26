-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.2.0                                       //
-- // Date : 2019-07-01                                     //
-- ///////////////////////////////////////////////////////////

CREATE TABLE `${prefix}messagelegal` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` mediumtext,
  `idUser` int(12) unsigned DEFAULT NULL,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(223, 'menuMessageLegal', 11, 'object', 521, Null, 0, 'Admin');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,223,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,223,8);

CREATE TABLE `${prefix}messagelegalFollowup` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idMessageLegal` INT(12) NOT NULL,
  `idUser` INT(12) NOT NULL,
  `firstViewDate` datetime DEFAULT NULL,
  `lastViewDate` datetime DEFAULT NULL,
  `acceptedDate` datetime DEFAULT NULL,
  `accepted` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(222, 'menuDataCloning', 11, 'item', 530, Null, 0, 'Admin');

INSERT INTO `${prefix}habilitation` (idProfile, idMenu, allowAccess) VALUES
(1,222,1),
(2,222,1),
(3,222,1),
(4,222,1),
(5,222,0),
(6,222,0),
(7,222,0);

INSERT INTO `${prefix}habilitationother` (idProfile, rightAccess, scope) VALUES
(1,4,'dataCloningRight'),
(2,2,'dataCloningRight'),
(3,6,'dataCloningRight'),
(4,2,'dataCloningRight'),
(5,1,'dataCloningRight'),
(6,2,'dataCloningRight'),
(7,2,'dataCloningRight'),
(1,10,'dataCloningTotal'),
(2,1,'dataCloningTotal'),
(3,3,'dataCloningTotal'),
(4,1,'dataCloningTotal'),
(5,1,'dataCloningTotal'),
(6,1,'dataCloningTotal'),
(7,1,'dataCloningTotal');

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,222,8),
(2,222,2);

CREATE TABLE `${prefix}datacloning` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `nameDir` varchar(100) DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idOrigin` int(12) unsigned DEFAULT NULL,
  `versionCode` varchar(100) DEFAULT NULL,
  `requestedDate` datetime DEFAULT NULL,
  `plannedDate` varchar(100) DEFAULT NULL,
  `deletedDate` datetime DEFAULT NULL,
  `requestedDeletedDate` datetime DEFAULT NULL,
  `isRequestedDelete` int(1) unsigned DEFAULT 0,
  `codeError` varchar(100) DEFAULT NULL,
  `isActive` int(1) unsigned DEFAULT 0,
  `idle` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(224, 'menuDataCloningParameter', 11, 'item', 531, Null, 0, 'Admin');

INSERT INTO `${prefix}habilitation` (idProfile, idMenu, allowAccess) VALUES
(1,224,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,224,8);

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES 
('dataCloningCreationRequest','5'),
('dataCloningPerDay','5'),
('paramPasswordStrength','1'),
('paramAttachmentNum',''),
('paramScreen','0'),
('paramRightDiv','0'),
('contentPaneRightDetailDivHeight','0'),
('contentPaneDetailDivHeight','0'),
('contentPaneRightDetailDivHeightPlanning','0'),
('contentPaneRightDetailDivHeightGlobalPlanning','0'),
('paramLayoutObjectDetail','5');

INSERT INTO `${prefix}cronExecution` (`cron`, `fileExecuted`, `idle` ,`fonctionName`) VALUES
('*/5 * * * *', '../tool/cronExecutionStandard.php', 0, 'dataCloningCheckRequest');

DROP TABLE `${prefix}noteflux`;
DROP TABLE `${prefix}absence`;

INSERT INTO `${prefix}importable` (`id`, `name`, `idle`) VALUES
(54, 'Budget', 0);

ALTER TABLE `${prefix}expense` CHANGE `realTaxAmount` `realTaxAmount` DECIMAL(14,5);

INSERT INTO `${prefix}module`(`id`, `name`, `sortOrder`, `idModule`, `idle`, `active`) VALUES 
(17,'moduleDataCloning',1200,null,0,1);

INSERT INTO `${prefix}modulemenu`(`idModule`, `idMenu`, `hidden`, `active`) VALUES 
(17,222,0,1),
(17,224,0,1);

ALTER TABLE `${prefix}planningelement` ADD COLUMN `indivisibility` int(1) UNSIGNED DEFAULT 0,
ADD COLUMN `minimumThreshold` decimal(5,2) UNSIGNED DEFAULT NULL;