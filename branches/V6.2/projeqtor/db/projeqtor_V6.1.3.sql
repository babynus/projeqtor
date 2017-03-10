-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 6.1.3                                       //
-- // Date : 2017-03-09                                   //
-- ///////////////////////////////////////////////////////////

UPDATE `${prefix}accessright` SET `idAccessProfile`=1000001 WHERE `idAccessProfile`=8 and idMenu in 
(select id from `${prefix}menu` where `level` like 'ReadWrite%');

ALTER TABLE `${prefix}type` ADD `priority` int(3) unsigned DEFAULT NULL;
