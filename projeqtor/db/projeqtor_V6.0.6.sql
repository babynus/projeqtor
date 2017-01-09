-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 6.0.6                                       //
-- // Date : 2017-09-01                                     //
-- ///////////////////////////////////////////////////////////

DELETE FROM `${prefix}tempupdate` WHERE 1=1;

INSERT INTO `${prefix}tempupdate` (SELECT max(id), scope, idType, null, null, null FROM `${prefix}extrahiddenfield` 
group by scope, idType, field
having count(*) >1 or scope not like '%#%');

delete from `${prefix}extrahiddenfield` where id in (select id from `${prefix}tempupdate`);