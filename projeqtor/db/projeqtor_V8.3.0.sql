-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.3.0                                       //
-- // Date : 2019-09-27                                     //
-- ///////////////////////////////////////////////////////////

-- ======================================
-- Agregated resource
-- ======================================

ALTER TABLE `${prefix}assignment` ADD COLUMN `uniqueResource` int(1) unsigned DEFAULT 0;

CREATE TABLE `${prefix}assignmentselection` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idAssignment` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `userSelected` int(1) unsigned DEFAULT '0',
  `selected` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- ======================================
-- Change Request
-- ======================================

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`,`menuClass`) VALUES
(225,'menuChangeRequest',173,'object', 381,'ReadWritePrincipal',0,'Work Configuration EnvironmentalParameter'),
(226,'menuChangeRequestType',79,'object',1029,NULL,NULL,0);


INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,225,1),
(1,226,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,225,8),
(1,226,8);

CREATE TABLE `${prefix}changerequest` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(100) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idProduct` int(12) unsigned DEFAULT NULL,
  `idVersion` int(12) unsigned DEFAULT NULL,
  `idComponent` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `idBusinessFeature` int(12) unsigned DEFAULT NULL,
  `idMilestone` int(12) unsigned DEFAULT NULL,
  `idChangeRequestType`  int(12) unsigned DEFAULT NULL,
  `idRunStatus` int(12) unsigned DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `externalReference` varchar(100) DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `creationDateTime` datetime DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `result` mediumtext DEFAULT NULL,
  `reason` mediumtext DEFAULT NULL,
  `potentialBenefit` mediumtext DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `idTargetProductVersion` int(12) unsigned DEFAULT NULL,
  `idTargetComponentVersion` int(12) unsigned DEFAULT NULL,
  `plannedWork` decimal(14,5) UNSIGNED DEFAULT '0',
  `analysis` mediumtext DEFAULT NULL,
  `idUrgency` int(12) unsigned DEFAULT NULL,
  `idCriticality` int(12) unsigned DEFAULT NULL,
  `idFeasibility` int(12) unsigned DEFAULT NULL,
  `idRiskLevel` int(12) unsigned DEFAULT NULL,
  `initialDueDate` date DEFAULT NULL,
  `actualDueDate` date DEFAULT NULL,
  `cancelled` INT(1) UNSIGNED DEFAULT '0',
  `idPriority` int(12) unsigned DEFAULT NULL,
  `approved` int(1) unsigned DEFAULT '0',
  `approvedDate` date DEFAULT NULL,
  `idApprover__idResource` int(12) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;
CREATE INDEX changerequestProject ON `${prefix}changerequest` (idProject);
CREATE INDEX changerequestProduct ON `${prefix}changerequest` (idProduct);
CREATE INDEX changerequestVersion ON `${prefix}changerequest` (idVersion);
CREATE INDEX changerequestType ON `${prefix}changerequest` (idchangerequestType);
CREATE INDEX changerequestUser ON `${prefix}changerequest` (idUser);
CREATE INDEX changerequestStatus ON `${prefix}changerequest` (idStatus);
CREATE INDEX changerequestResource ON `${prefix}changerequest` (idResource);
CREATE INDEX changerequestTargetVersion ON `${prefix}changerequest` (idTargetProductVersion);
CREATE INDEX changerequestUrgency ON `${prefix}changerequest` (idUrgency);
CREATE INDEX changerequestCriticality ON `${prefix}changerequest` (idCriticality);
CREATE INDEX changerequestFeasibility ON `${prefix}changerequest` (idFeasibility);


INSERT INTO `${prefix}Type` (`scope`, `name`, `sortOrder`, `idWorkflow`, `idle`) VALUES 
('ChangeRequest', 'Recurring problem',10,1, 0),
('ChangeRequest', 'Improvement user',20,1, 0),
('ChangeRequest', 'Technical improvement',30,1, 0),
('ChangeRequest', 'Regulatory constraint',40,1, 0),
('ChangeRequest', 'Request of management ',50,1, 0);


CREATE TABLE `${prefix}resourceincompatible` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idIncompatible` int(12) unsigned DEFAULT NULL,
  `description`  mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8;

CREATE TABLE `${prefix}resourcesupport` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idSupport` int(12) unsigned DEFAULT NULL,
  `rate` int(3) unsigned DEFAULT NULL,
  `description`  mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8;

ALTER TABLE `${prefix}activity` ADD COLUMN `fixPlanning` int(1) unsigned default '0';
ALTER TABLE `${prefix}planningelement` ADD COLUMN `fixPlanning` int(1) unsigned default '0';
ALTER TABLE `${prefix}status` ADD COLUMN `fixPlanning` int(1) unsigned default '0';

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES 
('automaticFeedingOfTheReal','NO');

INSERT INTO `${prefix}habilitationother` (idProfile, rightAccess, scope) VALUES
(1,1,'feedingOfTheReal'),
(3,1,'feedingOfTheReal'),
(1,1,'canChangeNote'),
(3,1,'canChangeNote'),
(1,1,'canDeleteAttachement'),
(3,1,'canDeleteAttachement');