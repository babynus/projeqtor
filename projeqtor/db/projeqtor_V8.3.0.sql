-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.3.0                                       //
-- // Date : 2019-09-27                                     //
-- ///////////////////////////////////////////////////////////


INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(225, 'menuChangeRequest',173, 'object', 380, 'ReadWritePrincipal', 0, 'Work Configuration EnvironmentalParameter'),
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
  `description` varchar(4000) DEFAULT NULL,
  `idChangeRequest` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `idTargetProductVersion` int(12) unsigned DEFAULT NULL,
  `idTargetComponentVersion` int(12) unsigned DEFAULT NULL,
  `plannedWork` decimal(14,5) UNSIGNED DEFAULT '0',
  `idUrgency` int(12) unsigned DEFAULT NULL,
  `idCriticality` int(12) unsigned DEFAULT NULL,
  `idFeasibility` int(12) unsigned DEFAULT NULL,
  `idRiskLevel` int(12) unsigned DEFAULT NULL,
  `result` varchar(4000) DEFAULT NULL,
  `idLocker`  int(12) unsigned DEFAULT NULL,
  `lockedDate` date DEFAULT NULL,
  `locked` int(1) unsigned default '0',
  `initialDueDate` date DEFAULT NULL,
  `actualDueDate` date DEFAULT NULL,
  `cancelled` INT(1) UNSIGNED DEFAULT '0',
  `idPriority` int(12) unsigned DEFAULT NULL,
  `countPassed` int(5) default 0,
  `countFailed` int(5) default 0,
  `countBlocked` int(5) default 0,
  `countPlanned` int(5) default 0,
  `countLinked` int(5) default 0,
  `countIssues` int(5) default 0,
  `countTotal` int(5) default 0,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;
CREATE INDEX changerequestProject ON `${prefix}changerequest` (idProject);
CREATE INDEX changerequestProduct ON `${prefix}changerequest` (idProduct);
CREATE INDEX changerequestVersion ON `${prefix}changerequest` (idVersion);
CREATE INDEX changerequestType ON `${prefix}changerequest` (idchangerequestType);
CREATE INDEX changerequestUser ON `${prefix}changerequest` (idUser);
CREATE INDEX changerequestchangerequest ON `${prefix}changerequest` (idChangeRequest);
CREATE INDEX changerequestStatus ON `${prefix}changerequest` (idStatus);
CREATE INDEX changerequestResource ON `${prefix}changerequest` (idResource);
CREATE INDEX changerequestTargetVersion ON `${prefix}changerequest` (idTargetProductVersion);
CREATE INDEX changerequestUrgency ON `${prefix}changerequest` (idUrgency);
CREATE INDEX changerequestCriticality ON `${prefix}changerequest` (idCriticality);
CREATE INDEX changerequestFeasibility ON `${prefix}changerequest` (idFeasibility);
CREATE INDEX requiremenRiskLevel ON `${prefix}changerequest` (idRiskLevel);