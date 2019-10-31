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
-- Auto input of real work
-- ======================================

ALTER TABLE `${prefix}work` ADD COLUMN `inputUser` int(12) unsigned DEFAULT NULL;
ALTER TABLE `${prefix}work` ADD COLUMN `inputDateTime` datetime DEFAULT NULL;

-- ======================================
-- Support Resource
-- ======================================

ALTER TABLE `${prefix}assignment` ADD COLUMN `supportedAssignment` int(12) unsigned DEFAULT NULL;
ALTER TABLE `${prefix}assignment` ADD COLUMN `supportedResource` int(12) unsigned DEFAULT NULL;

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

INSERT INTO `${prefix}modulemenu` (`idModule`,`idMenu`,`hidden`,`active`) VALUES
 (11,225,0,1),
 (11,226,1,1);
 
-- ======================================
-- Small improvements
-- ======================================
 
-- Improve display of duration in Audit list
ALTER TABLE `${prefix}audit` ADD COLUMN `durationSeconds` int(10) unsigned default '0';
ALTER TABLE `${prefix}audit` ADD COLUMN `durationDisplay` varchar(20);

-- Hide some affectations implicitely stored from pool affectation
ALTER TABLE `${prefix}affectation` ADD COLUMN `hideAffectation` int(1) unsigned DEFAULT 0,
ADD COLUMN `idResourceTeam` int(12) unsigned DEFAULT NULL;

-- Fix display of helpers in notification screen
UPDATE `${prefix}notifiable` set name=notifiableItem where notifiableItem in ('EmployeeLeaveEarned', 'Leave');
DELETE FROM `${prefix}notifiable` WHERE notifiableItem in ('Workflow', 'Status', 'LeaveType');

-- Set Call for tender as mailable
INSERT INTO `${prefix}mailable` (`id`,`name`, `idle`) VALUES 
(40,'CallForTender', '0');

--ARCHIVEHISTORY
CREATE TABLE `${prefix}historyarchive` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100) NOT NULL,
  `refId` int(12) unsigned NOT NULL,
  `operation` varchar(10) DEFAULT NULL,
  `colName` varchar(200) DEFAULT NULL,
  `oldValue` mediumtext DEFAULT NULL,
  `newValue` mediumtext DEFAULT NULL,
  `operationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUser` int(12) unsigned DEFAULT NULL,
  `isWorkHistory` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES 
('cronArchiveTime','365'),
('cronArchiveCloseItems','YES'),
('cronArchivePlannedDate','18:30');

INSERT INTO `${prefix}cronexecution` (`cron`, `fileExecuted`, `idle` ,`fonctionName`) VALUES
('*/5 * * * *', '../tool/cronExecutionStandard.php', 0, 'archiveHistoryIdle'),
('30 18 * * *', '../tool/cronExecutionStandard.php', 0, 'archiveHistory');
