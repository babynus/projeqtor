-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 9.3.0                                       //
-- // Date : 2021-06-15                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}pokervote` ADD `flipped` int(1) DEFAULT '0' COMMENT '1';

ALTER TABLE `${prefix}pokersession` ADD `idUser` int(12) unsigned DEFAULT NULL COMMENT '12';

INSERT INTO `${prefix}planningmode` (name, code, sortOrder, mandatoryStartDate, mandatoryEndDate, applyTo, idle, mandatoryDuration) VALUES 
('PlanningModeFIXED', 'FIXED', 100, 1, 0, 'PokerSession', 0, 0);

UPDATE `${prefix}navigation` SET moduleName='modulePlanning' WHERE name='navPlanning';
UPDATE `${prefix}navigation` SET moduleName='moduleReview' WHERE name='navSteering';

INSERT INTO `${prefix}navigation` (`id`, `name`, `idParent`, `idMenu`,`sortOrder`,`idReport`) VALUES
(355,'menuKanban',17,100006001,85,50);

UPDATE `${prefix}module` SET idModule=1, sortOrder=110 WHERE name ='moduleMeeting';
UPDATE `${prefix}module` SET idModule=1, sortOrder=120 WHERE name ='modulePoker';
UPDATE `${prefix}module` SET idModule=10, sortOrder=720 WHERE name='moduleAssets';
UPDATE `${prefix}module` SET idModule=10, sortOrder=730 WHERE name='moduleRisk';
UPDATE `${prefix}module` SET idModule=10, sortOrder=740 WHERE name='moduleRequirement';