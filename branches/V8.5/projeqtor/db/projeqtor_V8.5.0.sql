-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.5.0                                       //
-- // Date : 2020-03-23                                     //
-- ///////////////////////////////////////////////////////////
-- Patch on V8.4.0


INSERT INTO `${prefix}habilitationother` (idProfile,scope,rightAccess) VALUES 
(1,'validatePlanning','1'),
(2,'validatePlanning','1'),
(3,'validatePlanning','1'),
(4,'validatePlanning','2'),
(6,'validatePlanning','2'),
(7,'validatePlanning','2'),
(5,'validatePlanning','2');

DELETE FROM `${prefix}columnselector` WHERE objectClass='Recipient' and field='bank' and attribute='bank';

ALTER TABLE `${prefix}type` ADD COLUMN `icon` varchar(100);