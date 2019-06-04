-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.1.0                                       //
-- // Date : 2019-05-14                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}statusmail` CHANGE `idEvent` `idEventForMail` INT(12) UNSIGNED DEFAULT NULL;

RENAME TABLE `${prefix}event` TO `${prefix}eventformail`;

UPDATE `${prefix}columnselector` set field='nameEventForMail', attribute='idEventForMail' where attribute='idEvent';
UPDATE `${prefix}history` set colName='idEventForMail' where colName='idEvent';

-- /Flo
INSERT INTO `${prefix}originable`( `name`, `idle`) VALUES ('DocumentVersion', 0);

ALTER TABLE `${prefix}message` ADD COLUMN `startDate` datetime DEFAULT NULL,
ADD COLUMN `endDate` datetime DEFAULT NULL;
