-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 9.1.0                                       //
-- // Date : 2020-01-11                                     //
-- ///////////////////////////////////////////////////////////


INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`,`menuClass`) VALUES
(257, 'menuViewAllSubTask', 7, 'item', 121, Null, 0, 'Work');

INSERT INTO `${prefix}modulemenu` (`idModule`,`idMenu`,`hidden`,`active`) VALUES
(3,257,0,(select `active` from `${prefix}module` where id=3));

INSERT INTO `${prefix}navigation` (`id`, `name`, `idParent`, `idMenu`,`sortOrder`,`idReport`) VALUES
(334,'menuViewAllSubTask',3,257,55,0),
(335,'menuViewAllSubTask',5,257,35,0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1,257,1),
(2,257,1),
(3,257,1);

INSERT INTO `${prefix}accessright` (`idProfile`, `idMenu`, `idAccessProfile`) VALUES
(1,257,8),
(2,257,8),
(3,257,8);

INSERT INTO `${prefix}habilitationother` (`idProfile`, `scope`, `rightAccess`) VALUES
(1, 'subtask', 1),
(2, 'subtask', 1),
(3, 'subtask', 1),
(4, 'subtask', 1),
(6, 'subtask', 2),
(7, 'subtask', 2),
(5, 'subtask', 2);  

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES 
('displaySubTask','YES');

CREATE TABLE `${prefix}subtask` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idProject` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idTargetProductVersion` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `sortOrder` int(5) unsigned DEFAULT NULL COMMENT '5',
  `name` varchar(200) DEFAULT NULL,
  `idPriority` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idResource` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `handled` int(1) unsigned DEFAULT 0  COMMENT '1',
  `done` int(1) unsigned DEFAULT 0  COMMENT '1',
  `idle` int(1) unsigned DEFAULT 0  COMMENT '1',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;


CREATE TABLE `${prefix}WorkCommand` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `idCommand` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idWorkUnit` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idComplexity` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `name` varchar(200) DEFAULT NULL,
  `unitAmount` int(12) unsigned DEFAULT NULL COMMENT '12',
  `commandQuantity` int(5) unsigned DEFAULT '0' COMMENT '5',
  `commandAmount` int(12) unsigned DEFAULT NULL COMMENT '12',
  `doneQuantity` int(5) unsigned DEFAULT '0' COMMENT '5',
  `doneAmount` int(12) unsigned DEFAULT NULL COMMENT '12',
  `billedQuantity` int(5) unsigned DEFAULT '0' COMMENT '5',
  `billedAmound` int(12) unsigned DEFAULT NULL COMMENT '12',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE `${prefix}WorkCommandDone` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `idCommand` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idWorkCommand` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `doneQuantity` int(5) unsigned DEFAULT '0' COMMENT '5',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE `${prefix}WorkCommandBilled` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `idCommand` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idWorkCommand` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idBill` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `billedQuantity` int(5) unsigned DEFAULT '0' COMMENT '5',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

ALTER TABLE `${prefix}planningElement` ADD `idWorkCommand` INT(12) DEFAULT NULL COMMENT '12';