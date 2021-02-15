-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 9.0.5                                       //
-- // Date : 2021-02-10                                     //
-- ///////////////////////////////////////////////////////////
-- Patch on V8.6

ALTER TABLE `${prefix}livemeeting` CHANGE `result` `result` mediumtext;

INSERT INTO `${prefix}referencable` (`id`,`name`, `idle`) VALUES 
(26,'ProviderOrder', '0'),
(27,'ProviderBill', '0'),
(28,'ProviderPayment', '0');

UPDATE `${prefix}referencable` set idle=1 WHERE name in ('Payment','ProviderPayment');