-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 9.1.2                                       //
-- // Date : 2021-03-20                                     //
-- ///////////////////////////////////////////////////////////
-- Patch on V9.2

INSERT INTO `${prefix}modulemenu` (`idModule`,`idMenu`,`hidden`,`active`) VALUES
(1,257,0,(select `active` from `${prefix}module` where id=1)),
(2,257,0,(select `active` from `${prefix}module` where id=2));

INSERT INTO `${prefix}habilitationother` (idProfile, scope , rightAccess) VALUES
(1,'subtask','1'),
(2,'subtask','1'),
(3,'subtask','1'),
(4,'subtask','1'),
(5,'subtask','2'),
(6,'subtask','2'),
(7,'subtask','2');