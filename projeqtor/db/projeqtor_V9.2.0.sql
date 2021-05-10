-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 9.2.0                                       //
-- // Date : 2021-06-15                                     //
-- ///////////////////////////////////////////////////////////



INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES 
('activityOnRealTime','NO'),
('showDonePlannedWork','1'),
('notStartBeforeValidatedStartDate','NO');

ALTER TABLE `${prefix}type` ADD COLUMN `activityOnRealTime` int(1) unsigned DEFAULT 0 COMMENT '1';

ALTER TABLE `${prefix}activity` ADD COLUMN `workOnRealTime` int(1) unsigned DEFAULT 0 COMMENT '1';

CREATE TABLE `${prefix}statusperiod` (
`id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
`name` varchar(100) DEFAULT NULL,
`refType` varchar(100) DEFAULT NULL,
`refId` int(12) unsigned DEFAULT NULL COMMENT '12',
`active` int(1) unsigned DEFAULT NULL COMMENT '1',
`type` varchar(10) DEFAULT NULL,
`startDate` datetime DEFAULT NULL,
`endDate` datetime DEFAULT NULL,
`idStatusStart` int(12) unsigned DEFAULT NULL COMMENT '12',
`idStatusEnd` int(12) unsigned DEFAULT NULL COMMENT '12',
`idUserStart` int(12) unsigned DEFAULT NULL COMMENT '12',
`idUserEnd` int(12) unsigned DEFAULT NULL COMMENT '12',
`duration` varchar(100) DEFAULT NULL,
`durationOpenTime` varchar(100) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}habilitationother` (idProfile, scope , rightAccess)
SELECT id , 'canWorkOnTicket', '1' from `${prefix}profile` where id in (SELECT idProfile from `${prefix}habilitationother` where scope = 'work' and rightAccess=4);

INSERT INTO `${prefix}habilitationother` (idProfile, scope , rightAccess)
SELECT id , 'canWorkOnTicket', '2' from `${prefix}profile` where id in (SELECT idProfile from `${prefix}habilitationother` where scope = 'work' and rightAccess <> 4);

UPDATE `${prefix}status` set setHandledStatus='1' where name='paused';

ALTER TABLE `${prefix}delay` ADD `idMacroStatus` int(12) unsigned DEFAULT 2 COMMENT '12';

ALTER TABLE `${prefix}project` ADD `startAM` time DEFAULT NULL, 
							   ADD `endAM` time DEFAULT NULL,
							   ADD `startPM` time DEFAULT NULL,
							   ADD `endPM` time DEFAULT NULL;

CREATE TABLE `${prefix}activityworkunit` (
`id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
`refType` varchar(100) DEFAULT NULL,
`refId` int(12) unsigned DEFAULT NULL COMMENT '12',
`idWorkUnit` int(12) unsigned DEFAULT NULL COMMENT '12',
`idComplexity` int(12) unsigned DEFAULT NULL COMMENT '12',
`quantity` decimal(8,3) unsigned DEFAULT NULL,
`idWorkCommand` INT(12) DEFAULT NULL COMMENT '12',
PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}activityworkunit` (refType, refId, idWorkUnit, idComplexity , quantity , idWorkCommand)
SELECT refType, refId, idWorkUnit, idComplexity , quantity , idWorkCommand
FROM `${prefix}planningelement` WHERE idWorkUnit is not null and idComplexity is not null and quantity is not null;

ALTER TABLE `${prefix}planningelement` ADD COLUMN `hasWorkUnit` int(1) unsigned DEFAULT 0 COMMENT '1';
ALTER TABLE `${prefix}planningelementbaseline` ADD COLUMN `hasWorkUnit` int(1) unsigned DEFAULT 0 COMMENT '1';

ALTER TABLE `${prefix}workcommanddone` ADD COLUMN `idActivityWorkUnit` int(12) unsigned DEFAULT NULL COMMENT '12';

UPDATE `${prefix}planningelement` SET hasWorkUnit=1 
WHERE `idWorkUnit` is not null and `idComplexity` is not null and `quantity` is not null;

DELETE FROM `${prefix}workcommanddone`;

INSERT INTO `${prefix}workcommanddone` (idWorkCommand, refType, refId , doneQuantity, idActivityWorkUnit )
SELECT idWorkCommand, refType, refId , quantity, id
FROM `${prefix}activityworkunit` 
WHERE idWorkCommand is not null;

ALTER TABLE `${prefix}planningelement` DROP COLUMN `idWorkUnit`;
ALTER TABLE `${prefix}planningelement` DROP COLUMN `idComplexity`;
ALTER TABLE `${prefix}planningelement` DROP COLUMN `quantity`;
ALTER TABLE `${prefix}planningelement` DROP COLUMN `idWorkCommand`;
ALTER TABLE `${prefix}planningelementbaseline` DROP COLUMN `idWorkUnit`;
ALTER TABLE `${prefix}planningelementbaseline` DROP COLUMN `idComplexity`;
ALTER TABLE `${prefix}planningelementbaseline` DROP COLUMN `quantity`;
ALTER TABLE `${prefix}planningelementbaseline` DROP COLUMN `idWorkCommand`;

ALTER TABLE `${prefix}ticket` ADD COLUMN `paused` int(1) unsigned DEFAULT 0 COMMENT '1';
ALTER TABLE `${prefix}ticket` ADD COLUMN `pausedDateTime` datetime DEFAULT NULL;

ALTER TABLE `${prefix}type` ADD COLUMN `lockPaused` int(1) unsigned DEFAULT 0 COMMENT '1';

--acces right to repository

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`,`menuClass`) VALUES
(258, 'menuDocumentRight', 37, 'item', 1275, Null, 0, 'HabilitationParameter ');

INSERT INTO `${prefix}navigation` (`id`, `name`, `idParent`, `idMenu`,`sortOrder`,`idReport`) VALUES
(338,'menuDocumentRight',130,258,85,0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,258,1),
(2,258,1),
(3,258,1);

ALTER TABLE `${prefix}documentdirectory` ADD COLUMN `idResource` int(12) unsigned DEFAULT NULL COMMENT '12';
ALTER TABLE `${prefix}documentdirectory` ADD COLUMN `idUser` int(12) unsigned DEFAULT NULL COMMENT '12';
CREATE INDEX `documentdirectoryResource` ON `${prefix}documentdirectory` (`idResource`);
CREATE INDEX `documentdirectoryUser` ON `${prefix}documentdirectory` (`idUser`);
UPDATE `${prefix}documentdirectory` set idUser=(select min(id) from `${prefix}resource`);
UPDATE `${prefix}menu` set level='ReadWritePrincipal' where id=103;

CREATE TABLE `${prefix}documentright` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `idDocumentDirectory` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idProfile` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idAccessMode` int(12)  unsigned DEFAULT NULL COMMENT '12',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;


INSERT INTO `${prefix}documentright` (idDocumentDirectory, idProfile , idAccessMode)
SELECT d.id, p.id, a.idAccessProfile FROM `${prefix}documentdirectory` as d CROSS JOIN `${prefix}profile` as p INNER JOIN `${prefix}accessright` as a ON p.id = a.idProfile and a.idMenu=102;

UPDATE `${prefix}type` set lockPaused=lockDone where scope='Ticket';

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `hasExcel`) VALUES
(119, 'reportTicketHandledMonthSynthesis',3, 'ticketHandledMonthSynthesis.php', 396,'1'),
(120, 'reportTicketDoneMonthSynthesis',3, 'ticketDoneMonthSynthesis.php', 397,'1'),
(121, 'reportYearlyResourcePlan',2, 'yearlyResourcePlan.php', 245,'0'),
(122, 'reportYearlyPlanResource',2, 'yearlyPlanResource.php', 251,'0'),
(123, 'reportSynthesisOrdersInvoiceClient',7, 'synthesisOrdersInvoiceClient.php', 770,'0');

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES 
(1, 119, 1),
(1, 120, 1),
(1, 121, 1),
(1, 122, 1),
(1, 123, 1);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(119, 'idProject', 'projectList', 10, 'currentProject'),
(119,'idTicketType','ticketType',15,null),
(119, 'month', 'month', 20,'currentMonth'),
(119,'issuer','userList',25,null),
(119, 'requestor', 'requestorList', 30, null),
(119,'responsible','resourceList',35,null),
(119,'ticketWithoutDelay','boolean',40,null),
(120, 'idProject', 'projectList', 10, 'currentProject'),
(120,'idTicketType','ticketType',15,null),
(120, 'month', 'month', 20,'currentMonth'),
(120,'issuer','userList',25,null),
(120, 'requestor', 'requestorList', 30, null),
(120,'responsible','resourceList',35,null),
(120,'ticketWithoutDelay','boolean',40,null),
(121, 'idProject', 'projectList', 10, 'currentProject'),
(121, 'idOrganization', 'organizationList', 20,null),
(121,'idTeam','teamList',30,null),
(121, 'year', 'year', 40,'currentYear'),
(122, 'idProject', 'projectList', 10, 'currentProject'),
(122, 'idOrganization', 'organizationList', 20,null),
(122,'idTeam','teamList',30,null),
(122, 'year', 'year', 40,'currentYear'),
(123, 'idProject', 'projectList', 10, 'currentProject'),
(123,'idClient','clientList',20,null),
(123,'showClosedItems','boolean',30,null),
(123,'showReference','boolean',40,null);


INSERT INTO `${prefix}modulereport` (`idModule`,`idReport`,`hidden`,`active`) VALUES
(2,119,0,1),
(2,120,0,1),
(1,121,0,1),
(1,122,0,1),
(7,123,0,1);

CREATE TABLE `${prefix}macrostatus` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}macrostatus` (`id`,`name`) VALUES
(1,'handled'),
(2,'colDone'),
(3,'idle');

-- Fix issue for 
DELETE FROM `${prefix}accessright` where idMenu=222;

ALTER TABLE `${prefix}subtask` CHANGE `name` `name` varchar(4000) DEFAULT NULL;

ALTER TABLE ${prefix}workcommanddone MODIFY doneQuantity decimal(8,3) unsigned DEFAULT NULL;
ALTER TABLE ${prefix}workcommandbilled MODIFY billedQuantity decimal(8,3) unsigned DEFAULT NULL;
ALTER TABLE ${prefix}workcommand MODIFY commandQuantity decimal(8,3) unsigned DEFAULT NULL;
ALTER TABLE ${prefix}workcommand MODIFY doneQuantity decimal(8,3) unsigned DEFAULT NULL;
ALTER TABLE ${prefix}workcommand MODIFY billedQuantity decimal(8,3) unsigned DEFAULT NULL;
ALTER TABLE ${prefix}workcommand MODIFY unitAmount decimal(14,2) unsigned DEFAULT NULL;
ALTER TABLE ${prefix}workcommand MODIFY commandAmount decimal(14,2) unsigned DEFAULT NULL;
ALTER TABLE ${prefix}workcommand MODIFY doneAmount decimal(14,2) unsigned DEFAULT NULL;
ALTER TABLE ${prefix}workcommand MODIFY billedAmount decimal(14,2) unsigned DEFAULT NULL;

-- Access rights on assets

ALTER TABLE `${prefix}asset` ADD COLUMN `idResource` int(12) unsigned DEFAULT NULL COMMENT '12';

-- PERFOMANCE IMPROVMENTS

CREATE TABLE `${prefix}kpivaluerequest` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL COMMENT '12',
  `requestDate` date,
  `requestDateTime` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE INDEX `kpivaluerequestReference` ON `${prefix}kpivalue` (`refType`, `refId`);

INSERT INTO `${prefix}cronexecution` (`cron`, `fileExecuted`, `idle` ,`fonctionName`) VALUES
('01 * * * *', '../tool/cronExecutionStandard.php', 0, 'kpiCalculate');

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null,null, 'paramTryToHackObjectMail', 'Try to hack detected');

CREATE TABLE `${prefix}pokercomplexity` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `name` varchar(100) DEFAULT NULL,
  `value` int(2) unsigned DEFAULT NULL COMMENT '2',
  `work` decimal(9,5) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT 0 COMMENT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `${prefix}pokersession` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL COMMENT '12',
  `idResource` int(2) unsigned DEFAULT NULL COMMENT '2',
  `handled` int(1) unsigned DEFAULT 0 COMMENT '1',
  `handledDate` datetime DEFAULT NULL,
  `done` int(1) unsigned DEFAULT 0 COMMENT '1',
  `doneDate` datetime DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT 0 COMMENT '1',
  `idleDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `${prefix}pokerresource` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `idPokerSession` int(12) unsigned DEFAULT NULL COMMENT '12',
  `idResource` int(12) unsigned DEFAULT NULL COMMENT '12',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `${prefix}pokeritem` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `name` varchar(100) DEFAULT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned DEFAULT NULL COMMENT '12',
  `idPokerSession` int(12) unsigned DEFAULT NULL COMMENT '12',
  `value` int(2) unsigned DEFAULT NULL COMMENT '2',
  `work` decimal(9,5) unsigned DEFAULT NULL,
  `comment` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `${prefix}pokervote` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `idPokerItem` int(12) unsigned DEFAULT NULL COMMENT '12',
  `idResource` int(12) unsigned DEFAULT NULL COMMENT '12',
  `idPokerSession` int(12) unsigned DEFAULT NULL COMMENT '12',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`,`menuClass`) VALUES
(259, 'menuPokerSessionDefinition', 7, 'object', 155, Null, 0, 'Work '),
(260, 'menuPokerSession', 7, 'object', 160, Null, 0, 'Work ');

INSERT INTO `${prefix}navigation` (`id`, `name`, `idParent`, `idMenu`,`sortOrder`,`idReport`) VALUES
(339,'menuPokerSessionDefinition',3,259,115,0),
(340,'menuPokerSession',3,260,120,0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,259,1),
(2,259,1),
(3,259,1),
(1,260,1),
(2,260,1),
(3,260,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,259,8),
(2,259,2),
(3,259,7),
(1,260,8),
(2,260,2),
(3,260,7);

ALTER TABLE `${prefix}workunit` ADD COLUMN `idle` int(1) unsigned DEFAULT 0 COMMENT '1';