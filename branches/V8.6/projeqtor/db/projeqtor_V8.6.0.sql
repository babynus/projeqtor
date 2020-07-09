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

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`, `hasCsv`,`hasExcel`) VALUES
(110, 'reportConsolidationValidation',7, 'consultationValidation.php', 889,'1','1');

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES 
(1, 110, 1);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES 
(110, 'idProject', 'projectList', 10, 'currentProject'),
(110,'idProjectType','projectTypeList',15,null),
(110, 'idOrganization', 'organizationList', 20,null),
(110,'month','month',25,'currentMonth');

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

INSERT INTO `${prefix}module` (`id`,`name`,`sortOrder`,`idModule`,`idle`,`active`) VALUES
(20,'moduleGestionCA','540',5,0,0);

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`,`menuClass`) VALUES
(255,'menuCatalogUO',152,'object', 289,'Project',0,'Financial');

INSERT INTO `${prefix}modulemenu` (`idModule`,`idMenu`,`hidden`,`active`) VALUES
(20,255,0,1);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,255,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,255,8);

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES 
('ComplexitiesNumber','3');

CREATE TABLE `${prefix}cataloguo` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `name` varchar(200) DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL COMMENT '12',
  `nomemclature` varchar(200) DEFAULT NULL,
  `numberComplexities` int(5) unsigned DEFAULT '0' COMMENT '5',
  `idle` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;
CREATE INDEX cataloguoProject ON `${prefix}cataloguo` (idProject);

CREATE TABLE `${prefix}workunit` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `idCatalog` int(12) unsigned DEFAULT NULL COMMENT '12',
  `reference` varchar(200) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `entering` varchar(200) DEFAULT NULL,
  `deliverable` varchar(200) DEFAULT NULL,
  `validityDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE `${prefix}complexity` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `idCatalog` int(12) unsigned DEFAULT NULL COMMENT '12',
  `name` varchar(200) DEFAULT NULL,
  `idZone` int(12) unsigned DEFAULT NULL COMMENT '12',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE `${prefix}complexityValues` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `idCatalog` int(12) unsigned DEFAULT NULL COMMENT '12',
  `idComplexity` int(12) unsigned DEFAULT NULL COMMENT '12',
  `idWorkUnit` int(12) unsigned DEFAULT NULL COMMENT '12',
  `charge` int(12) unsigned DEFAULT NULL COMMENT '12',
  `price` int(12) unsigned DEFAULT NULL COMMENT '12',
  `duration` int(12) unsigned DEFAULT NULL COMMENT '12',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

ALTER TABLE `${prefix}planningelement` 
ADD COLUMN `revenue` decimal(11,2) unsigned DEFAULT NULL,
ADD COLUMN `commandSum` decimal(11,2) unsigned DEFAULT NULL,
ADD COLUMN `billSum` decimal(11,2) unsigned DEFAULT NULL,
ADD COLUMN `idRevenueMode` int(12) unsigned DEFAULT NULL COMMENT '12',
ADD COLUMN `idWorkUnit` int(12) unsigned DEFAULT NULL COMMENT '12',
ADD COLUMN `idComplexity` int(12) unsigned DEFAULT NULL COMMENT '12',
ADD COLUMN `quantity` int(5) unsigned DEFAULT NULL COMMENT '5';

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

ALTER TABLE `${prefix}project` ADD COLUMN `commandOnValidWork` int(1) unsigned default 0;