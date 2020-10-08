-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.6.2                                       //
-- // Date : 2020-09-28                                     //
-- ///////////////////////////////////////////////////////////
-- Patch on V8.6

UPDATE `${prefix}menu` SET `idle`=0 WHERE `idle` IS NULL;

UPDATE `${prefix}affectation` SET idResourceSelect=idResource 
where exists (select 'x' from `${prefix}resource` res where res.id=idResource and isResource=1);

ALTER TABLE `${prefix}complexityvalues` CHANGE `charge` `charge` DECIMAL(14,5);
ALTER TABLE `${prefix}complexityvalues` CHANGE `price` `price` DECIMAL(11,2);
ALTER TABLE `${prefix}complexityvalues` CHANGE `duration` `duration` int(5) unsigned COMMENT '5';

DELETE FROM `${prefix}accessright` WHERE `idMenu`=254;