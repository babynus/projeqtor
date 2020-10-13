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
  `sortOrder` int(3) unsigned DEFAULT NULL COMMENT '3',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `${prefix}navigation` (`id`, `name`, `idParent`, `idMenu`,`sortOrder`) VALUES
(1,'navPlanning',null,null,1),
(2,'navTicketing',null,null,2),
(3,'navFollowup',null,null,3),
(4,'navFinancial',null,null,4),
(5,'navSteering',null,null,5),
(6,'navRepports',null,null,6),
(7,'navTools',null,null,7),
(8,'navParamters',null,null,8),
(9,'navOther',1,null,6),
(10,'navIndicators',2,null,5),
(11,'navAbsence',3,null,3),
(20,'menuProject',1,16,1),
(21,'menuActivity',1,25,2),
(22,'menuMilestone',1,26,3),
(23,'menuMeeting',1,62,4),
(24,'menuPlanning',1,9,5),
(25,'menuPlannedWorkManual',9,252,1),
(26,'menuPortfolioPlanning',9,123,2),
(27,'menuGlobalPlanning',9,196,3),
(28,'menuResourcePlanning',9,106,4),
(29,'menuConsultationPlannedWorkManual',9,253,5),
(30,'menuGlobalView',9,192,6),
(31,'menuDashboardTicket',2,150,1),
(32,'menuTicket',2,22,2),
(33,'menuTicketSimple',2,118,3),
(34,'menuKanban',2,100006001,4),
(35,'menuTicketDelay',10,89,1),
(36,'menuTicketDelayPerProject',10,182,2),
(37,'menuIndicatorDefinition',10,90,3),
(38,'menuIndicatorDefinitionPerProject',10,181,4),
(39,'menuImputation',3,8,1),
(40,'menuAbsence',3,203,2),
(41,'menuImputationValidation',3,204,4),
(42,'menuConsultationPlannedWorkManual',3,9,5),
(44,'menuDiary',3,133,6),
(45,'menuLeaveCalendar',11,209,1),
(46,'menuEmployeeLeaveEarned',11,211,2),
(47, 'menuDashboardEmployeeManager',11,215,3),
(100,'menuGlobalParameter',6,18,null),
(101,'menuUserParameter',6,19,null);

ALTER TABLE `${prefix}menucustom` ADD `idRow` INT(12) DEFAULT '1' COMMENT '12' AFTER `idUser`;

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES 
('menuLeftDisplayMode','ICONTXT');
