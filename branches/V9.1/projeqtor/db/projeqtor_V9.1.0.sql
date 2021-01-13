-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 9.1.0                                       //
-- // Date : 2020-01-11                                     //
-- ///////////////////////////////////////////////////////////

CREATE TABLE `${prefix}subtask` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `refType` varchar(100) DEFAULT NULL,
  `refId` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idMenu` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `sortOrder` int(5) unsigned DEFAULT NULL COMMENT '5',
  `idReport` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `name` varchar(200) DEFAULT NULL,
  `idPriority` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idResource` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `handled` int(1) unsigned DEFAULT 0  COMMENT '1',
  `done` int(1) unsigned DEFAULT 0  COMMENT '1',
  `idle` int(1) unsigned DEFAULT 0  COMMENT '1',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;
