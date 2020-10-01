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

INSERT INTO `${prefix}navigation` (`name`, `idParent`, `idMenu`,`idMenu`,`sortOrder`) VALUES
('navPlanning','','',''),
('navTicketing','','',''),
('navFolowUp','','',''),
('navRepports','','',''),
('navAdministration','','',''),
('navParamters',5,'',''),
('navOther',1,'',''),
('navRepports',2,'',''),
('navRepportsWork',3,'',''),
('navWork',9,'',''),
('navWorkDetailed',9,'',''),
('navWorkIndividual',9,'',''),
('menuProject',1,16,''),
('menuActivity',1,25,''),
('menuMilestone',1,26,''),
('menuPlanning',1,9,''),
('menuPortfolioPlanning',1,123,''),
('menuTicket',2,22,''),
('menuTicketSimple',2,118,''),
('menuTicketType',2,53,''),
('menuTicketDelay',2,89,''),
('menuTicketDelayPerProject',2,182,''),
('menuDashboardTicket',2,150,''),
('menuMilestone',2,26,''),
('menuImputation',3,8,''),
('menuAbsence',3,203,''),
('menuDiary',3,133,''),
('menuImputationValidation',3,204,''),
('menuConsultationPlannedWorkManual',3,9,''),
('menuImputation',3,8,''),
('menuAbsence',3,203,''),
('menuDiary',3,133,''),
('menuGlobalParameter',6,18),
('menuUserParameter',6,19);

