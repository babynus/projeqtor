-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.5.0                                       //
-- // Date : 2016-07-28                                     //
-- ///////////////////////////////////////////////////////////

-- INSERT INTO `${prefix}accessscope` (`id`,`name`,`accessCode`,`sortOrder`,`idle`) VALUES (6,'accessScopeClient','CLI',375,0);
-- INSERT INTO `${prefix}accessprofile` (`id`,`name`,`description`,`idAccessScopeRead`,`idAccessScopeCreate`,`idAccessScopeUpdate`,`idAccessScopeDelete`,`sortOrder`,`idle`) VALUES (11,'accessProfileClientCreator','Read his client''s projects Can create his own project',6,3,6,2,325,0);

CREATE TABLE `${prefix}productproject` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idProduct` int(12) unsigned DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE INDEX productprojectProject ON `${prefix}productproject` (idProject);
CREATE INDEX productprojectProduct ON `${prefix}productproject` (idProduct);

ALTER TABLE `${prefix}project` ADD `lastUpdateDateTime` datetime DEFAULT NULL;
ALTER TABLE `${prefix}activity` ADD `lastUpdateDateTime` datetime DEFAULT NULL;