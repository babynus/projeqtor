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

INSERT INTO `${prefix}navigation` (`name`, `idParent`, `idMenu`,`sortOrder`) VALUES
('navPlanning',null,null,null),
('navTicketing',null,null,null),
('navFolowUp',null,null,null),
('navRepports',null,null,null),
('navAdministration',null,null,null),
('navParamters',5,null,null),
('navOther',1,null,null),
('navRepports',2,null,null),
('navRepportsWork',3,null,null),
('navWork',9,null,null),
('navWorkDetailed',9,null,null),
('navWorkIndividual',9,null,null),
('menuProject',1,16,null),
('menuActivity',1,25,null),
('menuMilestone',1,26,null),
('menuPlanning',1,9,null),
('menuPortfolioPlanning',1,123,null),
('menuTicket',2,22,null),
('menuTicketSimple',2,118,null),
('menuTicketType',2,53,null),
('menuTicketDelay',2,89,null),
('menuTicketDelayPerProject',2,182,null),
('menuDashboardTicket',2,150,null),
('menuMilestone',2,26,null),
('menuImputation',3,8,null),
('menuAbsence',3,203,null),
('menuDiary',3,133,null),
('menuImputationValidation',3,204,null),
('menuConsultationPlannedWorkManual',3,9,null),
('menuImputation',3,8,null),
('menuAbsence',3,203,null),
('menuDiary',3,133,null),
('menuGlobalParameter',6,18,null),
('menuUserParameter',6,19,null);

ALTER TABLE `${prefix}menucustom` ADD `idRow` INT(12) DEFAULT '1' COMMENT '12' AFTER `idUser`;

