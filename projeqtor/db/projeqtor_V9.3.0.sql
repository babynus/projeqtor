-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 9.3.0                                       //
-- // Date : 2021-06-15                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}pokeritem` ADD `flipped` int(1) DEFAULT '0' COMMENT '1';

ALTER TABLE `${prefix}pokersession` ADD `idUser` int(12) unsigned DEFAULT NULL COMMENT '12';
ALTER TABLE `${prefix}pokersession` CHANGE `handledDate` `handledDate` DATE DEFAULT NULL;
ALTER TABLE `${prefix}pokersession` CHANGE `doneDate` `doneDate` DATE DEFAULT NULL;
ALTER TABLE `${prefix}pokersession` CHANGE `idleDate` `idleDate` DATE DEFAULT NULL;

ALTER TABLE `${prefix}pokerresource` ADD `idAssignment` int(12) unsigned DEFAULT NULL COMMENT '12';

INSERT INTO `${prefix}planningmode` (name, code, sortOrder, mandatoryStartDate, mandatoryEndDate, applyTo, idle, mandatoryDuration) VALUES 
('PlanningModeFIXED', 'FIXED', 100, 1, 0, 'PokerSession', 0, 0);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(4, 259, 9),
(5, 259, 9),
(6, 259, 9),
(7, 259, 9);

UPDATE `${prefix}navigation` SET moduleName='modulePlanning' WHERE name='navPlanning';
UPDATE `${prefix}navigation` SET moduleName='moduleReview' WHERE name='navSteering';

INSERT INTO `${prefix}navigation` (`id`, `name`, `idParent`, `idMenu`,`sortOrder`,`idReport`) VALUES
(356,'menuKanban',17,100006001,85,50);

CREATE TABLE `${prefix}highlight` (
`id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
`idUser` int(12) unsigned DEFAULT NULL COMMENT '12',
`scope` varchar(100) DEFAULT NULL,
`date` date,
`reference` varchar(100) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}cronexecution` (`cron`, `fileExecuted`, `idle` ,`fonctionName`) VALUES
('0 1 * * *', '../tool/cronExecutionStandard.php', 1, 'cronDeleteLogfile');

--Module 
INSERT INTO `${prefix}module` (`id`,`name`,`sortOrder`,`idModule`,`idle`,`active`) VALUES 
(23,'moduleTargetMilestone','112',1,0,0),
(24,'moduleTechnicalProgress','114',1,0,0),  
(25,'moduleFollowUp','300',null,0,(SELECT `active` from `${prefix}module` as m WHERE m.name='moduleImputation' )),
(26,'moduleBugetFunctionOfOrga','1110',14,0,0), 
(27,'moduleTodoList','320',25,0,0), 
(28,'moduleChecklist','330',25,0,1);

UPDATE `${prefix}module` SET idModule=1, sortOrder=110 WHERE name ='moduleMeeting';
UPDATE `${prefix}module` SET idModule=1, sortOrder=120 WHERE name ='modulePoker';
UPDATE `${prefix}module` SET idModule=10, sortOrder=720 WHERE name='moduleAssets';
UPDATE `${prefix}module` SET idModule=10, sortOrder=730 WHERE name='moduleRisk';
UPDATE `${prefix}module` SET idModule=10, sortOrder=740 WHERE name='moduleRequirement';
UPDATE `${prefix}module` SET idModule=25, sortOrder=310 WHERE name='moduleImputation';

INSERT INTO `${prefix}modulemenu` (`id`,`idModule`,`idMenu`,`hidden`,`active`) VALUES
(208,27,257,0,0),
(209,28,130,0,0);

CREATE INDEX historyarchiveRef ON `${prefix}historyarchive` (`refType`, `refId`);