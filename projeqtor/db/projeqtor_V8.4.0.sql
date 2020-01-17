-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.4.0                                       //
-- // Date : 2020-01-14                                     //
-- ///////////////////////////////////////////////////////////

-- ======================================
-- Change Request
-- ======================================

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`,`menuClass`) VALUES
(228,'menuSupplierContract',151,'object', 201,'Project',0,'Financial'),
(229,'menuSupplierContractType',79,'object',926,NULL,NULL,0),
(230,'menuUnity',36,'object',896,'ReadWriteList',0,'ListOfValues'),
(231,'menuRenewal',36,'object',897,'ReadWriteList',0,'ListOfValues');

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,228,1),
(1,229,1),
(1,230,1),
(1,231,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,228,8),
(1,229,8),
(1,230,8),
(1,231,8);

INSERT INTO `${prefix}mailable` (`id`,`name`, `idle`) VALUES 
(42,'SupplierContract', '0');

INSERT INTO `${prefix}importable` (`id`, `name`, `idle`) VALUES
(56, 'SupplierContract','0');

INSERT INTO `${prefix}modulemenu` (`idModule`,`idMenu`,`hidden`,`active`) VALUES
 (6,228,0,1),
 (6,229,0,1),
 (6,230,0,1),
 (6,231,0,1);

CREATE TABLE `${prefix}suppliercontract` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `number` varchar(100) DEFAULT NULL,
  `idTypeContract` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idTender` int(12) unsigned DEFAULT NULL,
  `tenderReference` varchar(100) DEFAULT NULL,
  `startDate`  date DEFAULT NULL,
  `initialContractTerm` int(12) unsigned DEFAULT NULL,
  `idUnitDurationContract` int(12) unsigned DEFAULT 1,
  `endDate` date DEFAULT NULL,
  `noticePeriod` int(12) unsigned DEFAULT NULL,
  `idUnitDurationNotice` int(12) unsigned DEFAULT 1,
  `noticeDate` date DEFAULT NULL,
  `deadlineDate`date DEFAULT NULL,
  `periodicityContract` int(12) unsigned DEFAULT NULL,
  `periodicityBill` int(12) unsigned DEFAULT NULL,
  `idRenewal` int(12) unsigned DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idProvider` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `phoneNumber` int(12) unsigned DEFAULT NULL,
  `interventionStartTime` datetime DEFAULT NULL,
  `interventionEndTime` datetime DEFAULT NULL,
  `periode`varchar(100) DEFAULT NULL,
  `sla` int(1) unsigned DEFAULT '0',
  `origin` varchar(100) DEFAULT NULL,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idStatus` int(12) unsigned DEFAULT NULL,
  `handled` int(1) unsigned DEFAULT '0',
  `handledDate` date DEFAULT NULL,
  `done` int(1) unsigned DEFAULT '0',
  `doneDate` date DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  `idleDate` date DEFAULT NULL,
  `cancelled` INT(1) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;


INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idWorkflow`, `idle`) VALUES 
('SupplierContract', 'management assistance',10,1, 0),
('SupplierContract', 'hosting',20,1, 0),
('SupplierContract', 'technical improvement',30,1, 0),
('SupplierContract', 'maintenance & support',40,1, 0);

CREATE TABLE `${prefix}unity` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE `${prefix}renewal` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}unity` (`id`, `name`, `color`, `sortOrder`, `idle`) VALUES
(1,'days','#99FF99',100,0),
(2,'months','#87ceeb',200,0),
(3,'years','#FF0000',300,0);

