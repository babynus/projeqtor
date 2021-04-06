-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 9.2.0                                       //
-- // Date : 2021-06-15                                     //
-- ///////////////////////////////////////////////////////////



INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES 
('activityOnRealTime','NO');

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
`duration` datetime DEFAULT NULL,
`durationOpenTime` datetime DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}habilitationother` (idProfile, scope , rightAccess)
SELECT id , 'canWorkOnTicket', '1' from `${prefix}profile` where id in (SELECT idProfile from `${prefix}habilitationother` where scope = 'work' and rightAccess=1);

INSERT INTO `habilitationother` (idProfile, scope , rightAccess)
SELECT id , 'canWorkOnTicket', '2' from `profile` where id in (SELECT idProfile from `habilitationother` where scope = 'work' and rightAccess <> 1);

UPDATE `${prefix}status` set setHandledStatus='1' where name='paused';

ALTER TABLE `${prefix}delay` ADD `idStatus` INT(12) DEFAULT NULL COMMENT '12';

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

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,258,8),
(2,258,8),
(3,258,8);

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