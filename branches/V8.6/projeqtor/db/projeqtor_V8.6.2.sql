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