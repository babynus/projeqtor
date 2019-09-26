-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 8.2.2                                       //
-- // Date : 2019-09-26                                     //
-- ///////////////////////////////////////////////////////////
-- Patch on V8.2

ALTER TABLE `${prefix}planningelementbaseline` ADD COLUMN `indivisibility` int(1) unsigned DEFAULT 0,
ADD COLUMN `minimumThreshold` decimal(7,4) unsigned DEFAULT NULL;