-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.6.1                                       //
-- // Date : 2020-09-21                                     //
-- ///////////////////////////////////////////////////////////
-- Patch on V8.6

-- Change index structure for audit
-- Delete duplicates (3 times in case of multi-duplicates)
DELETE FROM `${prefix}tempupdate` WHERE 1=1;
INSERT INTO `${prefix}tempupdate` (refId) SELECT min(id) from `${prefix}audit` GROUP BY sessionId HAVING count(*)>1;
DELETE FROM `${prefix}audit` WHERE id in (select refId from `${prefix}tempupdate`); 
DELETE FROM `${prefix}tempupdate` WHERE 1=1;
INSERT INTO `${prefix}tempupdate` (refId) SELECT min(id) from `${prefix}audit` GROUP BY sessionId HAVING count(*)>1;
DELETE FROM `${prefix}audit` WHERE id in (select refId from `${prefix}tempupdate`); 
DELETE FROM `${prefix}tempupdate` WHERE 1=1;
INSERT INTO `${prefix}tempupdate` (refId) SELECT min(id) from `${prefix}audit` GROUP BY sessionId HAVING count(*)>1;
DELETE FROM `${prefix}audit` WHERE id in (select refId from `${prefix}tempupdate`); 
DELETE FROM `${prefix}tempupdate` WHERE 1=1;
-- Drop index and recreate unique
ALTER TABLE `${prefix}audit` DROP INDEX auditSessionId;
CREATE UNIQUE INDEX auditSessionId ON `${prefix}audit` ( sessionId );

-- Change index structure for kpihistory
-- Delete duplicates (3 times in case of multi-duplicates)
DELETE FROM `${prefix}tempupdate` WHERE 1=1;
INSERT INTO `${prefix}tempupdate` (refId) SELECT min(id) from `${prefix}kpihistory` GROUP BY idKpiDefinition, refType, refId, kpiDate HAVING count(*)>1;
DELETE FROM `${prefix}kpihistory` WHERE id IN (select refId from `${prefix}tempupdate`); 
DELETE FROM `${prefix}tempupdate` WHERE 1=1;
INSERT INTO `${prefix}tempupdate` (refId) SELECT min(id) from `${prefix}kpihistory` GROUP BY idKpiDefinition, refType, refId, kpiDate HAVING count(*)>1;
DELETE FROM `${prefix}kpihistory` WHERE id IN (select refId from `${prefix}tempupdate`);
DELETE FROM `${prefix}tempupdate` WHERE 1=1;
INSERT INTO `${prefix}tempupdate` (refId) SELECT min(id) from `${prefix}kpihistory` GROUP BY idKpiDefinition, refType, refId, kpiDate HAVING count(*)>1;
DELETE FROM `${prefix}kpihistory` WHERE id IN (select refId from `${prefix}tempupdate`);
DELETE FROM `${prefix}tempupdate` WHERE 1=1;
-- Drop indexes and recreate unique
ALTER TABLE `${prefix}kpihistory` DROP INDEX kpihistoryKpiDefinition;
ALTER TABLE `${prefix}kpihistory` DROP INDEX kpihistoryReference;
ALTER TABLE `${prefix}kpihistory` DROP INDEX kpihistoryDate;
CREATE UNIQUE INDEX kpihistoryKpiDefinitionReferenceDate ON `${prefix}kpihistory` ( idKpiDefinition , refType, refId, kpiDate);

-- Add index on type for version (accelerate queries on type)
CREATE INDEX versionVersionType ON `${prefix}version` (idVersionType);

-- Add index on operationDate for history (accelerate activity stream)
CREATE INDEX historyOperationDate ON `${prefix}history` (operationDate);


