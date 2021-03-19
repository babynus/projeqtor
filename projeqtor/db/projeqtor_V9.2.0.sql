-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 9.2.0                                       //
-- // Date : 2021-06-15                                     //
-- ///////////////////////////////////////////////////////////

CREATE TABLE `${prefix}statusperiod` (
`id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
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

ALTER TABLE `${prefix}project` ADD `startAM` varchar(100) DEFAULT NULL, 
							   ADD `endAM` varchar(100) DEFAULT NULL,
							   ADD `startPM` varchar(100) DEFAULT NULL,
							   ADD `endPM` varchar(100) DEFAULT NULL;