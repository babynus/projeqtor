-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.2.0                                       //
-- // Date : 2019-06-24                                     //
-- ///////////////////////////////////////////////////////////

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(222, 'menuDataCloning', 11, 'item', 530, Null, 0, 'Admin');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 222, 1),
(2, 222, 1),
(3, 222, 1),
(4, 222, 1),
(5, 222, 1),
(6, 222, 1),
(7, 222, 1);

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
    `plannedDate` datetime DEFAULT NULL,
		`deletedDate` datetime DEFAULT NULL,
		`requestedDeletedDate` datetime DEFAULT NULL,
		`isRequestedDelete` int(1) unsigned DEFAULT 0,
		`idle` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;