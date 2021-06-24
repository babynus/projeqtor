-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 9.3.0                                       //
-- // Date : 2021-06-15                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}pokervote` ADD `flipped` INT(1) DEFAULT '0';

INSERT INTO `${prefix}planningmode` (name, code, sortOrder, mandatoryStartDate, mandatoryEndDate, applyTo, idle, mandatoryDuration) VALUES 
('PlanningModeFIXED', 'FIXED', 100, 1, 0, 'PokerSession', 0, 0);