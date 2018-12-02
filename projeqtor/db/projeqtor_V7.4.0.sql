-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.4.0                                       //
-- // Date : 2018-12-02                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}planningelement` CHANGE `wbsSortable` `wbsSortable` varchar(600) UNSIGNED;
ALTER TABLE `${prefix}planningelementbaseline` CHANGE `wbsSortable` `wbsSortable` varchar(600) UNSIGNED;
ALTER TABLE `${prefix}planningelementextension` CHANGE `wbsSortable` `wbsSortable` varchar(600) UNSIGNED;
ALTER TABLE `${prefix}project` CHANGE `sortOrder` `sortOrder` varchar(600) UNSIGNED;