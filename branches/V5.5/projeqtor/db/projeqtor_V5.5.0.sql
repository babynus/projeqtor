-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.5.0                                       //
-- // Date : 2016-07-28                                     //
-- ///////////////////////////////////////////////////////////

-- INSERT INTO `${prefix}accessscope` (`id`,`name`,`accessCode`,`sortOrder`,`idle`) VALUES (6,'accessScopeClient','CLI',375,0);
-- INSERT INTO `${prefix}accessprofile` (`id`,`name`,`description`,`idAccessScopeRead`,`idAccessScopeCreate`,`idAccessScopeUpdate`,`idAccessScopeDelete`,`sortOrder`,`idle`) VALUES (11,'accessProfileClientCreator','Read his client''s projects Can create his own project',6,3,6,2,325,0);
