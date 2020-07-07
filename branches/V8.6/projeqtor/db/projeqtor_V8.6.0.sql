-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.6.0                                       //
-- // Date : 2020-06-22                                     //
-- ///////////////////////////////////////////////////////////

-- START FUNCTIONAL UPDATES

INSERT INTO `${prefix}module` (`id`,`name`,`sortOrder`,`idModule`,`idle`,`active`) VALUES
(20,'moduleGestionCA','540',5,0,0);

UPDATE `${prefix}menu` SET `sortOrder`='120' WHERE `id`='252';

INSERT INTO `${prefix}modulemenu` (`idModule`,`idMenu`,`hidden`,`active`) VALUES
(20,254,1,1);
 
INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`,`menuClass`) VALUES
(254, 'menuConsultationValidation', 7, 'item', 119, Null, 0, 'Work');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,254,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,254,8);

UPDATE `${prefix}report` SET hasExcel=1 WHERE id in (1,2,3);

CREATE TABLE `${prefix}consolidationvalidation` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `idProject` int(12) DEFAULT NULL COMMENT '12',
  `idResource` int(12) DEFAULT NULL COMMENT '12',
  `revenue` decimal(11,2) unsigned DEFAULT NULL,
  `validatedWork` decimal(14,5) unsigned DEFAULT NULL,
  `realWork` decimal(14,5) unsigned DEFAULT NULL,
  `realWorkConsumed` decimal(14,5) unsigned DEFAULT NULL,
  `leftWork` decimal(14,5) unsigned DEFAULT NULL,
  `plannedWork` decimal(14,5) unsigned DEFAULT NULL,
  `margin` decimal(14,5) unsigned DEFAULT NULL,
  `validationDate` date,
  `month` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;


CREATE TABLE `${prefix}lockedImputation` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `idProject` int(12) DEFAULT NULL COMMENT '12',
  `idResource` int(12) DEFAULT NULL COMMENT '12',
  `month` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}habilitationother` (idProfile,scope,rightAccess) VALUES 
(1,'lockedImputation','1'),
(2,'lockedImputation','1'),
(3,'lockedImputation','1'),
(4,'lockedImputation','2'),
(5,'lockedImputation','2'),
(6,'lockedImputation','2'),
(7,'lockedImputation','2'),
(1,'validationImputation','1'),
(2,'validationImputation','1'),
(3,'validationImputation','1'),
(4,'validationImputation','2'),
(5,'validationImputation','2'),
(6,'validationImputation','2'),
(7,'validationImputation','2');

-- Tags Management

CREATE TABLE `${prefix}tag` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `name` varchar(100) DEFAULT NULL,
  `refType` varchar(100) DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT 0  COMMENT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE UNIQUE INDEX tagName ON `${prefix}tag` (name);

ALTER TABLE `${prefix}document` ADD `tags` varchar(4000) DEFAULT NULL;

ALTER TABLE `${prefix}planningelement` 
ADD COLUMN `revenue` decimal(11,2) unsigned DEFAULT NULL,
ADD COLUMN `commandSum` decimal(11,2) unsigned DEFAULT NULL,
ADD COLUMN `billSum` decimal(11,2) unsigned DEFAULT NULL,
ADD COLUMN `idRevenueMode` int(12) unsigned DEFAULT NULL COMMENT '12';

CREATE TABLE `${prefix}revenuemode` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}revenuemode` (`id`, `name`,  `sortOrder`, `idle`) VALUES
(1,'fixed',100,0),
(2,'variable',200,0);

INSERT INTO `${prefix}indicator` (`id`, `code`, `type`, `name`, `sortOrder`, `idle`, `targetDateColumnName`) VALUES
(29, 'CACS', 'percent', 'CaMoreThanCommandSum', 430, 0, null),
(30, 'CABS', 'percent', 'CaLessThanBillSum', 440, 0, null);

INSERT INTO `${prefix}indicatorableindicator` (`idIndicatorable`, `nameIndicatorable`, `idIndicator`, `idle`) VALUES 
('8', 'Project', '29', '0'),
('8', 'Project', '30', '0');