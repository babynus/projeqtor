-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.1.0                                       //
-- // Date : 2015-07-30                                     //
-- ///////////////////////////////////////////////////////////
CREATE TABLE `${prefix}paymentdelay` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name`varchar(100),
  `days` int(3) unsigned DEFAULT NULL,
  `endOfMonth` int(1) DEFAULT 0,
  `sortOrder` int(3) DEFAULT 0,
  `idle` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}paymentdelay` (`id`, `name`, `days`, `endOfMonth`, `sortOrder`, `idle`) VALUES
(1, '15 days', 15, 0, 10, 0),
(2, '15 days end of month', 15, 1, 20, 0),
(3, '30 days', 30, 0, 30, 0),
(4, '30 days end of month', 30, 1, 40, 0),
(5, '45 days', 45, 0, 50, 0),
(6, '45 days end of month', 45, 1, 60, 0),
(7, '60 days', 60, 0, 70, 0),
(8, 'on order', 0, 0, 80, 0);

CREATE TABLE `${prefix}paymentmode` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name`varchar(100),
  `sortOrder` int(3) DEFAULT 0,
  `idle` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}paymentmode` (`id`, `name`, `sortOrder`, `idle`) VALUES
(1, 'bank transfer', 10, 0),
(2, 'cheque', 20, 0),
(3, 'credit card', 30, 0),
(4, 'virtual payment terminal', 40, 0),
(5, 'paypal', 50, 0);

CREATE TABLE `${prefix}payment` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name`varchar(100),
  `idBill` int(12) unsigned DEFAULT NULL,
  `paymentDate` date,
  `idPaymentMode` int(12) unsigned DEFAULT NULL,
  `idle` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX paymentBill ON `${prefix}payment` (idBill);

ALTER TABLE `${prefix}client` ADD `numTax` varchar(100) DEFAULT NULL,
ADD `idPaymentDelay` int(12) unsigned DEFAULT NULL,
CHANGE `designation` `designation`  varchar (100),
CHANGE `street` `street`  varchar (100),
CHANGE `complement` `complement`  varchar (100),
CHANGE `city` `city`  varchar (100),
CHANGE `state` `state`  varchar (100),
CHANGE `country` `country`  varchar (100);

CREATE TABLE `${prefix}measureunit` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name`varchar(100),
  `pluralName` varchar(100),
  `sortOrder` int(3) DEFAULT 0,
  `idle` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}measureunit` (`id`, `name`, `pluralName`, `sortOrder`, `idle`) VALUES
(1, 'piece', 'pieces', 10, 0),
(2, 'lot', 'lots', 20, 0),
(3, 'day', 'days', 30, 0),
(4, 'month', 'months', 40, 0);

ALTER TABLE `${prefix}billline` ADD `idMeasureUnit` int(12) unsigned DEFAULT NULL,
ADD `extra` int(1) UNSIGNED DEFAULT 0;

ALTER TABLE `${prefix}bill` ADD `idPaymentDelay` int(12) unsigned DEFAULT null,
ADD `paymentDueDate` date DEFAULT NULL,
ADD `idDeliveryMode` int(12) unsigned DEFAULT null,
ADD `idResource` int(12) unsigned DEFAULT null,
ADD `idUser` int(12) unsigned DEFAULT null;

UPDATE `${prefix}bill` b set `idUser` = (select idUser from `${prefix}history` h where h.refType='Bill' and h.refId=b.id order by operationDate LIMIT 1); 

ALTER TABLE `${prefix}quotation` ADD `idPaymentDelay` int(12) unsigned DEFAULT null,
CHANGE `initialWork` `untaxedAmount` DECIMAL(11,2) UNSIGNED,
ADD `tax` decimal(5,2) DEFAULT NULL,
ADD `fullAmount` decimal(12,2) DEFAULT NULL,
ADD `idDeliveryMode` int(12) unsigned DEFAULT null;

ALTER TABLE `${prefix}command` ADD `idPaymentDelay` int(12) unsigned DEFAULT null,
CHANGE `initialAmount` `untaxedAmount` DECIMAL(11,2) UNSIGNED,
ADD `tax` decimal(5,2) DEFAULT NULL,
ADD `fullAmount` decimal(12,2) DEFAULT NULL,
CHANGE `addAmount` `addUntaxedAmount` DECIMAL(11,2) UNSIGNED,
ADD `addFullAmount` decimal(12,2) DEFAULT NULL,
CHANGE `validatedAmount` `totalUntaxedAmount` DECIMAL(11,2) UNSIGNED,
ADD `totalFullAmount` decimal(12,2) DEFAULT NULL,
ADD `idDeliveryMode` int(12) unsigned DEFAULT null;

CREATE TABLE `${prefix}deliverymode` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name`varchar(100),
  `sortOrder` int(3) DEFAULT 0,
  `idle` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}deliverymode` (`id`, `name`, `sortOrder`, `idle`) VALUES
(1, 'email', 10, 0),
(2, 'postal mail', 20, 0),
(3, 'hand delivered', 30, 0),
(4, 'digital deposit', 40, 0);

INSERT INTO `${prefix}menu` (`id`, `name`, `idMenu`, `type`, `sortOrder`, `level`, `idle`, `menuClass`) VALUES
(137, 'menuPaymentDelay', 36, 'object', 785, 'ReadWriteList', 0, 'ListOfValues '),
(138, 'menuPaymentMode', 36, 'object', 786, 'ReadWriteList', 0, 'ListOfValues '),
(139, 'menuDeliveryMode', 36, 'object', 787, 'ReadWriteList', 0, 'ListOfValues '),
(140, 'menuMeasureUnit', 36, 'object', 788, 'ReadWriteList', 0, 'ListOfValues ');
INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 137, 1),
(2, 137, 0),
(3, 137, 0),
(4, 137, 0),
(5, 137, 0),
(6, 137, 0),
(7, 137, 0),
(1, 138, 1),
(2, 138, 0),
(3, 138, 0),
(4, 138, 0),
(5, 138, 0),
(6, 138, 0),
(7, 138, 0),
(1, 139, 1),
(2, 139, 0),
(3, 139, 0),
(4, 139, 0),
(5, 139, 0),
(6, 139, 0),
(7, 139, 0),
(1, 140, 1),
(2, 140, 0),
(3, 140, 0),
(4, 140, 0),
(5, 140, 0),
(6, 140, 0),
(7, 140, 0);

ALTER TABLE `${prefix}decision` ADD `done` int(1) unsigned DEFAULT 0;
UPDATE `${prefix}decision` set done=1 where idStatus in (select id from `${prefix}status` where setDoneStatus=1);

CREATE TABLE `${prefix}favorite` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(12) unsigned DEFAULT NULL,
  `scope` varchar(100) DEFAULT NULL,
  `idReport` int(12) unsigned DEFAULT NULL,
  `idMenu` int(12) unsigned DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX favoriteUser ON `${prefix}favorite` (idUser);

CREATE TABLE `${prefix}favoriteparameter` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idReport` int(12) unsigned DEFAULT NULL,
  `idFavorite` int(12) unsigned DEFAULT NULL,
  `parameterName` varchar(100) DEFAULT NULL,
  `parameterValue` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX favoriteParameterUser ON `${prefix}favoriteparameter` (idUser);
CREATE INDEX favoriteParameterReport ON `${prefix}favoriteparameter` (idReport);
CREATE INDEX favoriteParameterToday ON `${prefix}favoriteparameter` (idToday);