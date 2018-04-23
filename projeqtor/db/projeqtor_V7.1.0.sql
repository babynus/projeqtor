-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.1.0                                       //
-- // Date : 2018-04-23                                     //
-- ///////////////////////////////////////////////////////////

-- ===========================================================
-- #3343 - Multi Client
-- ===========================================================

CREATE TABLE `${prefix}otherclient` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12) unsigned NOT NULL,
  `idClient` int(12) unsigned NOT NULL,
  `comment` varchar(4000), 
  `creationDate` datetime, 
  `idUser` int(12) unsigned default null,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE INDEX otherclientRef ON `${prefix}otherclient` (refType, refId);
CREATE INDEX otherclientVersion ON `${prefix}otherclient` (idClient);
CREATE INDEX otherclientUser ON `${prefix}otherclient` (idUser);

-- ===========================================================
-- #3344 - New Report : Ticket by Customer
-- ===========================================================

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`) VALUES 
(83, 'clientsForVersion', 3, 'clientsForVersion.php', 399);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `idle`, `defaultValue`, `multiple`) VALUES
(83,'idProduct','productList',10,0,null,0),
(83,'idProductVersion','productVersionList',20,0,null,0),
(83,'listTickets','boolean',30,0,null,0),
(83,'idStatus','statusList',40,0,null,1);

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES 
(1, 83, 1);

-- ===========================================================
-- #3339 Resource Team - gautier 
-- ===========================================================
INSERT INTO `${prefix}menu` (`id`,`name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(188,'menuResourceTeam', 14, 'object', 505, 'ReadWriteEnvironment', 0, 'Work EnvironmentalParameter');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES 
(1,188,1);
INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES 
(1,188, 1000001);

ALTER TABLE `${prefix}resource` ADD `isResourceTeam` int(1) UNSIGNED DEFAULT 0;
