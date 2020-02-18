-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.4.0                                       //
-- // Date : 2020-01-14                                     //
-- ///////////////////////////////////////////////////////////


UPDATE `${prefix}menu` SET `sortOrder` = '201' WHERE `menu`.`name` = 'menuExpenses';
UPDATE `${prefix}menu` SET `sortOrder` = '202' WHERE `menu`.`name` = 'menuBudget';
UPDATE `${prefix}menu` SET `sortOrder` = '205' WHERE `menu`.`name` = 'menuCallForTender';
UPDATE `${prefix}menu` SET `sortOrder` = '206' WHERE `menu`.`name` = 'menuTender';
UPDATE `${prefix}menu` SET `sortOrder` = '207' WHERE `menu`.`name` = 'menuProviderOrder';
UPDATE `${prefix}menu` SET `sortOrder` = '208' WHERE `menu`.`name` = 'menuProviderTerm';
UPDATE `${prefix}menu` SET `sortOrder` = '209' WHERE `menu`.`name` = 'menuProviderBill';
UPDATE `${prefix}menu` SET `sortOrder` = '210' WHERE `menu`.`name` = 'menuProviderPayment';
UPDATE `${prefix}menu` SET `sortOrder` = '211' WHERE `menu`.`name` = 'menuIndividualExpense';
UPDATE `${prefix}measureunit` SET `sortOrder` = '50' WHERE `measureunit`.`name` = 'month';

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`,`menuClass`) VALUES
(228,'menuSupplierContract',151,'object', 204,'Project',0,'Financial'),
(229,'menuSupplierContractType',79,'object',926,NULL,NULL,0),
(230,'menuPeriod',36,'object',896,'ReadWriteList',0,'ListOfValues'),
(231,'menuRenewal',36,'object',897,'ReadWriteList',0,'ListOfValues'),
(232,'menuGanttSupplierContract',151,'item', 204,'Project',0,'Financial'),
(233,'menuHierarchicalBudget',151,'item', 203,'Project',0,'Financial'),
(234,'menuClientContract',152,'object', 228,'Project',0,'Financial'),
(235,'menuGanttClientContract',152,'item', 229,'Project',0,'Financial'),
(236,'menuClientContractType',79,'object',928,NULL,NULL,0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,228,1),
(1,229,1),
(1,230,1),
(1,231,1),
(1,232,1),
(1,233,1),
(1,234,1),
(1,235,1),
(1,236,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,228,8),
(1,229,8),
(1,230,8),
(1,231,8),
(1,232,8),
(1,233,8),
(1,234,8),
(1,235,8),
(1,236,8);


INSERT INTO `${prefix}modulemenu` (`idModule`,`idMenu`,`hidden`,`active`) VALUES
 (6,228,0,1),
 (6,229,0,1),
 (6,230,0,1),
 (6,231,0,1),
 (6,232,0,1),
 (6,233,0,1),
 (6,234,0,1),
 (6,235,0,1),
 (6,236,0,1);
 
 INSERT INTO `${prefix}mailable` (`id`,`name`, `idle`) VALUES 
(42,'SupplierContract', '0'),
(43,'ClientContract', 0);

INSERT INTO `${prefix}importable` (`id`, `name`, `idle`) VALUES
(58, 'SupplierContract','0'),
(59, 'ClientContract', 0);

INSERT INTO `${prefix}linkable` ( `name`, `idle`) VALUES 
('SupplierContract', 0),
('ClientContract', 0);

INSERT INTO `${prefix}copyable` ( `name`, `idle`) VALUES
('SupplierContract', 0),
('ClientContract', 0);

INSERT INTO `${prefix}notifiable` ( `name`, `idle`) VALUES
('SupplierContract', 0),
('ClientContract', 0);
 
-- ======================================
-- Supplier Contract 
-- ======================================

CREATE TABLE `${prefix}suppliercontract` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `number` varchar(100) DEFAULT NULL,
  `idSupplierContractType` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idProvider` int(12) unsigned DEFAULT NULL,
  `tenderReference` varchar(100) DEFAULT NULL,
  `startDate`  date DEFAULT NULL,
  `initialContractTerm` int(12) unsigned DEFAULT 0,
  `idUnitDurationContract` int(12) unsigned DEFAULT 2,
  `endDate` date DEFAULT NULL,
  `noticePeriod` int(12) unsigned DEFAULT 0,
  `idUnitDurationNotice` int(12) unsigned DEFAULT 2,
  `noticeDate` date DEFAULT NULL,
  `deadlineDate`date DEFAULT NULL,
  `periodicityContract` int(12) unsigned DEFAULT 0,
  `periodicityBill` int(12) unsigned DEFAULT 0,
  `idRenewal` int(12) unsigned DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `phoneNumber` int(12) unsigned DEFAULT NULL,
  `interventionStartTime` time DEFAULT NULL,
  `interventionEndTime` time DEFAULT NULL,
  `idPeriod` int(12) DEFAULT NULL,
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
CREATE INDEX suppliercontractType ON `${prefix}suppliercontract` (idSupplierContractType);
CREATE INDEX suppliercontractRenewal ON `${prefix}suppliercontract` (idRenewal);
CREATE INDEX suppliercontractPeriod ON `${prefix}suppliercontract` (idPeriod);

-- ======================================
-- Client Contract 
-- ======================================

CREATE TABLE `${prefix}clientcontract` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `number` varchar(100) DEFAULT NULL,
  `idClientContractType` int(12) unsigned DEFAULT NULL,
  `idProject` int(12) unsigned DEFAULT NULL,
  `idClient` int(12) unsigned DEFAULT NULL,
  `tenderReference` varchar(100) DEFAULT NULL,
  `startDate`  date DEFAULT NULL,
  `initialContractTerm` int(12) unsigned DEFAULT 0,
  `idUnitDurationContract` int(12) unsigned DEFAULT 2,
  `endDate` date DEFAULT NULL,
  `noticePeriod` int(12) unsigned DEFAULT 0,
  `idUnitDurationNotice` int(12) unsigned DEFAULT 2,
  `noticeDate` date DEFAULT NULL,
  `deadlineDate`date DEFAULT NULL,
  `periodicityContract` int(12) unsigned DEFAULT 0,
  `periodicityBill` int(12) unsigned DEFAULT 0,
  `idRenewal` int(12) unsigned DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `idResource` int(12) unsigned DEFAULT NULL,
  `idContact` int(12) unsigned DEFAULT NULL,
  `phoneNumber` int(12) unsigned DEFAULT NULL,
  `interventionStartTime` time DEFAULT NULL,
  `interventionEndTime` time DEFAULT NULL,
  `idPeriod` int(12) DEFAULT NULL,
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
CREATE INDEX clientcontractType ON `${prefix}clientcontract` (idClientContractType);
CREATE INDEX clientcontractRenewal ON `${prefix}clientcontract` (idRenewal);
CREATE INDEX clientcontractPeriod ON `${prefix}clientcontract` (idPeriod);

INSERT INTO `${prefix}type` (`scope`, `name`, `sortOrder`, `idWorkflow`, `idle`) VALUES 
('SupplierContract', 'management assistance',10,1, 0),
('SupplierContract', 'hosting',20,1, 0),
('SupplierContract', 'technical improvement',30,1, 0),
('SupplierContract', 'maintenance & support',40,1, 0),
('ClientContract', 'management assistance',10,1, 0),
('ClientContract', 'hosting',20,1, 0),
('ClientContract', 'technical improvement',30,1, 0),
('ClientContract', 'maintenance & support',40,1, 0);


CREATE TABLE `${prefix}renewal` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE `${prefix}period` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE `${prefix}unitcontract` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}unitcontract` ( `name`, `sortOrder`, `idle`) VALUES
('day',40,0),
('month',50,0),
('year',60,0);


INSERT INTO `${prefix}renewal` (`id`, `name`,  `sortOrder`, `idle`) VALUES
(1,'never',100,0),
(2,'tacit',200,0),
(3,'express',300,0);

INSERT INTO `${prefix}period` (`id`, `name`,  `sortOrder`, `idle`) VALUES
(1,'week',100,0),
(2,'saturday',200,0),
(3,'Sunday and off days',300,0);

-- ======================================
-- Habilitation Other
-- ======================================
INSERT INTO `${prefix}habilitationother` (`idProfile`, `scope`, `rightAccess`) SELECT `profile`.id , 'generateProjExpense', 1 FROM `profile`;

ALTER TABLE `term` ADD `idResource` int(12) unsigned DEFAULT NULL , ADD `done` int(1) unsigned DEFAULT '0';
