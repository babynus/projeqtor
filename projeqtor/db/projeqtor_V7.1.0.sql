-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 7.1.0                                       //
-- // Date : 2017-12-12                                     //
-- ///////////////////////////////////////////////////////////

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`) VALUES 
(83, 'clientsForVersion', 3, 'clientsForVersion.php', 399);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `idle`, `defaultValue`, `multiple`) VALUES
(83,'idProduct','productList',10,0,null,0),
(83,'idProductVersion','productVersionList',20,0,null,0),
(83,'listTickets','boolean',30,0,null,0),
(83,'idStatus','statusList',40,0,null,1);

INSERT INTO `${prefix}habilitationreport` (`idProfile`, `idReport`, `allowAccess`) VALUES 
(1, 83, 1);