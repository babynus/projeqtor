
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.3.0                                      //
-- // Date : 2012-05-12                                     //
-- ///////////////////////////////////////////////////////////
--
--

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
(106,'menuResourcePlanning',7,'item',225,NULL,0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 106, 1),
(2, 106, 1),
(3, 106, 1),
(4, 106, 1),
(5, 106, 1),
(6, 106, 1),
(7, 106, 1);