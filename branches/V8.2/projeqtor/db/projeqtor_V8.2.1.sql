-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.2.1                                       //
-- // Date : 2019-09-20                                     //
-- ///////////////////////////////////////////////////////////
-- Patch on V8.2.0

UPDATE `${prefix}parameter` SET `parameterValue`=130 WHERE `parameterCode`='contentPaneRightDetailDivHeight' and idUser is null; 
UPDATE `${prefix}parameter` SET `parameterValue`=150 WHERE `parameterCode`='contentPaneRightDetailDivWidth' and idUser is null; 
UPDATE `${prefix}parameter` SET `parameterValue`=260 WHERE `parameterCode`='contentPaneDetailDivHeight' and idUser is null; 
UPDATE `${prefix}parameter` SET `parameterValue`=410 WHERE `parameterCode`='contentPaneDetailDivWidth' and idUser is null; 

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES 
('modeActiveStreamGlobal','false');
