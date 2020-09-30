-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.9.0                                      //
-- // Date : 2020-09-29                                     //
-- ///////////////////////////////////////////////////////////

CREATE TABLE `${prefix}navigation` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '12',
  `name` varchar(200) DEFAULT NULL,
  `idParent` int(12)  unsigned DEFAULT NULL COMMENT '12',
  `idMenu` int(12)  unsigned DEFAULT NULL COMMENT '12',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;



