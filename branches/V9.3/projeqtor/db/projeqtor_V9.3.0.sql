-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 9.3.0                                       //
-- // Date : 2021-06-15                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}pokeritem` ADD `flipped` int(1) DEFAULT '0' COMMENT '1';

ALTER TABLE `${prefix}pokersession` ADD `idUser` int(12) unsigned DEFAULT NULL COMMENT '12';
ALTER TABLE `${prefix}pokersession` CHANGE `handledDate` `handledDate` DATE  DEFAULT NULL;
ALTER TABLE `${prefix}pokersession` CHANGE `doneDate` `doneDate` DATE  DEFAULT NULL;
ALTER TABLE `${prefix}pokersession` CHANGE `idleDate` `idleDate` DATE  DEFAULT NULL;

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

UPDATE `${prefix}module` SET idModule=1, sortOrder=110 WHERE name ='moduleMeeting';
UPDATE `${prefix}module` SET idModule=1, sortOrder=120 WHERE name ='modulePoker';
UPDATE `${prefix}module` SET idModule=10, sortOrder=720 WHERE name='moduleAssets';
UPDATE `${prefix}module` SET idModule=10, sortOrder=730 WHERE name='moduleRisk';
UPDATE `${prefix}module` SET idModule=10, sortOrder=740 WHERE name='moduleRequirement';

CREATE TABLE `${prefix}highlight` (
`id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
`idUser` int(12) unsigned DEFAULT NULL COMMENT '12',
`scope` varchar(100) DEFAULT NULL,
`date` date,
`reference` varchar(100) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;