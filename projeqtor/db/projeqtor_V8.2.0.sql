-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.2.0                                       //
-- // Date : 2019-07-01                                     //
-- ///////////////////////////////////////////////////////////

CREATE TABLE `${prefix}messagelegal` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` mediumtext,
  `idUser` int(12) unsigned DEFAULT NULL,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(223, 'menuMessageLegal', 11, 'object', 521, Null, 0, 'Admin');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,223,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,223,8);

CREATE TABLE `${prefix}messagelegalFollowup` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `idMessageLegal` INT(12) NOT NULL,
  `idUser` INT(12) NOT NULL,
  `firstViewDate` datetime DEFAULT NULL,
  `lastViewDate` datetime DEFAULT NULL,
  `acceptedDate` datetime DEFAULT NULL,
  `accepted` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(222, 'menuDataCloning', 11, 'item', 530, Null, 0, 'Admin');

INSERT INTO `${prefix}habilitation` (idProfile, idMenu, allowAccess) VALUES
(1,222,1),
(2,222,1),
(3,222,1),
(4,222,1),
(5,222,1),
(6,222,1),
(7,222,1);

INSERT INTO `${prefix}habilitationother` (idProfile, rightAccess, scope) VALUES
(1,4,'dataCloning'),
(2,2,'dataCloning'),
(3,2,'dataCloning'),
(4,2,'dataCloning'),
(5,2,'dataCloning'),
(6,2,'dataCloning'),
(7,2,'dataCloning');

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,222,8),
(2,222,2);

CREATE TABLE `${prefix}datacloning` (
    `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(100) DEFAULT NULL,
    `idResource` int(12) unsigned DEFAULT NULL,
    `idOrigine` int(12) unsigned DEFAULT NULL,
		`versionCode` varchar(100) DEFAULT NULL,
    `requestedDate` datetime DEFAULT NULL,
    `plannedDate` varchar(100) DEFAULT NULL,
		`deletedDate` datetime DEFAULT NULL,
		`requestedDeletedDate` datetime DEFAULT NULL,
		`isRequestedDelete` int(1) unsigned DEFAULT 0,
		`isActive` int(1) unsigned DEFAULT 0,
		`idle` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(224, 'menuDataCloningParameter', 11, 'item', 531, Null, 0, 'Admin');

INSERT INTO `${prefix}habilitation` (idProfile, idMenu, allowAccess) VALUES
(1,224,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,224,8);

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES ('paramPasswordStrength','1');

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES ('paramAttachmentNum','');