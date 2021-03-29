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

INSERT INTO `${prefix}habilitationother` (idProfile, scope , rightAccess) VALUES
(1,'canWorkOnTicket','2'),
(2,'canWorkOnTicket','2'),
(3,'canWorkOnTicket','2'),
(4,'canWorkOnTicket','2'),
(5,'canWorkOnTicket','2'),
(6,'canWorkOnTicket','2'),
(7,'canWorkOnTicket','2');

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

UPDATE `${prefix}planningelement` SET hasWorkUnit=1 
WHERE `idWorkUnit` is not null and `idComplexity` is not null and `quantity` is not null;

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