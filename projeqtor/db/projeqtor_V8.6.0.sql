-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.6.0                                       //
-- // Date : 2020-06-22                                     //
-- ///////////////////////////////////////////////////////////

INSERT INTO `${prefix}module` (`id`,`name`,`sortOrder`,`idModule`,`idle`,`active`) VALUES
(20,'moduleGestionCA','540',5,0,0);

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`,`menuClass`) VALUES
(254, 'menuConsultationValidation', 7, 'item', 155, Null, 0, 'Work');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,254,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,254,8);

UPDATE `${prefix}report` SET hasExcel=1 WHERE id in (1,2,3);

-- Tags Management

CREATE TABLE `${prefix}tag` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `refType` int(12) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE UNIQUE INDEX tagName ON `${prefix}tag` (name);

ALTER TABLE `${prefix}document` ADD `tags` varchar(4000) DEFAULT NULL;