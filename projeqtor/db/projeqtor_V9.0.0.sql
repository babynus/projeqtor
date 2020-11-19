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
(1,'navPlanning',0,0,20),
(2,'navTicketing',0,0,30),
(3,'navFollowup',0,0,40),
(4,'navFinancial',0,0,50),
(5,'navSteering',0,0,60),
(6,'navReports',0,0,80),
(7,'navTool',0,0,90),
(8,'navAdministration',0,0,100),
(9,'menuToday',0,1,10),
(10,'navOther',1,0,60),
(11,'navIndicators',2,0,50),
(12,'navLeaveSystem',3,0,30),
(13,'navExpenses',4,0,40),
(14,'navIncomes',4,0,50),
(15,'navSituation',4,0,60),
(16,'navRiskManagement',5,0,90),
(17,'navRequirementsManagement',5,0,100),
(18,'navConfigurationManagement',5,0,110),
(19,'navAssetManagement',5,0,120),
(20,'menuProject',1,16,10),
(21,'menuActivity',1,25,20),
(22,'menuMilestone',1,26,30),
(23,'menuMeeting',1,62,40),
(24,'menuPlanning',1,9,50),
(25,'menuPlannedWorkManual',10,252,10),
(26,'menuPortfolioPlanning',10,123,40),
(27,'menuGlobalPlanning',10,196,30),
(28,'menuResourcePlanning',10,106,20),
(29,'menuConsultationPlannedWorkManual',10,253,50),
(30,'menuGlobalView',3,192,70),
(31,'menuDashboardTicket',2,150,10),
(32,'menuTicket',2,22,20),
(33,'menuTicketSimple',2,118,30),
(34,'menuKanban',2,100006001,40),
(35,'menuTicketDelay',11,89,10),
(36,'menuTicketDelayPerProject',11,182,20),
(37,'menuIndicatorDefinition',11,90,30),
(38,'menuIndicatorDefinitionPerProject',11,181,40),
(39,'menuImputation',3,8,10),
(40,'menuAbsence',3,203,20),
(41,'menuImputationValidation',3,204,40),
(42,'menuConsultationPlannedWorkManual',3,253,50),
(44,'menuDiary',3,133,60),
(45,'menuLeaveCalendar',12,209,10),
(46,'menuEmployeeLeaveEarned',12,211,20),
(47,'menuDashboardEmployeeManager',12,215,30),
(48,'menuBudget',13,197,10),
(49,'menuSupplierContract',13,228,20),
(50,'menuCallForTender',13,153,30),
(51,'menuTender',13,154,40),
(52,'menuProviderOrder',13,191,50),
(53,'menuProviderTerm',13,195,60),
(54,'menuProviderBill',13,194,70),
(55,'menuProviderPayment',13,201,80),
(56,'menuIndividualExpense',13,75,90),
(57,'menuProjectExpense',13,76,100),
(58,'menuClientContract',14,234,10),
(59,'menuQuotation',14,131,20),
(60,'menuCommand',14,125,30),
(61,'menuTerm',14,96,40),
(62,'menuBill',14,97,50),
(63,'menuPayment',14,78,60),
(64,'menuActivityPrice',14,94,70),
(65,'menuGallery',14,146,80),
(66,'menuCatalog',14,174,90),
(67,'menuCatalogUO',14,255,100),
(68,'menuHierarchicalBudget',4,233,10),
(69,'menuGanttSupplierContract',4,232,20),
(70,'menuGanttClientContract',4,235,30),
(71,'menuProjectSituation',15,245,10),
(72,'menuProjectSituationExpense',15,246,20),
(73,'menuProjectSituationIncome',15,247,30),
(74,'menuMeeting',5,62,10),
(75,'menuDecision',5,63,20),
(76,'menuQuestion',5,64,30),
(77,'menuPeriodicMeeting',5,124,40),
(78,'menuDeliverable',5,167,50),
(80,'menuIncoming',5,168,60),
(81,'menuDelivery',5,176,70),
(82,'menuChangeRequest',5,225,80),
(83,'menuRisk',16,3,10),
(84,'menuIssue',16,5,20),
(85,'menuOpportunity',16,119,30),
(86,'menuRequirement',17,11,10),
(87,'menuTestCase',17,112,20),
(88,'menuTestSession',17,113,30),
(89,'menuDashboardRequirement',17,189,40),
(90,'menuProduct',18,86,10),
(91,'menuProductVersion',18,87,20),
(92,'menuComponent',18,141,30),
(93,'menuComponentVersion',18,142,40),
(94,'menuVersionsPlanning',18,179,50),
(95,'menuVersionsComponentPlanning',18,227,60),
(96,'menuAsset',19,237,10),
(97,'menuLocation',19,238,20),
(98,'menuBrand',19,239,30),
(99,'menuModel',19,240,40),
(100,'menuAssetCategory',19,241,50),
(101,'menuAssetType',19,248,60),
(102,'menuMessage',7,51,10),
(103,'menuImportData',7,58,30),
(104,'menuMail',7,69,30),
(105,'menuAlert',7,91,40),
(106,'menuAudit',18,122,50),
(107,'menuNotification',7,185,60),
(108,'menuMailToSend',7,187,70),
(109,'menuAutoSendReport',7,205,80),
(110,'menuDataCloning',7,222,90),
(111,'menuMessageLegal',7,223,100),
(112,'navHumanResource',0,0,70),
(113,'menuLeaveCalendar',112,209,10),
(114,'menuLeave',112,210,20),
(115,'menuEmployeeLeaveEarned',112,211,30),
(116,'menuEmploymentContract',112,213,40),
(117,'menuEmployeeManager',112,214,50),
(118,'menuDashboardEmployeeManager',112,215,60),
(119,'navParameter',112,0,70),
(120,'menuLeaveType',119,217,10),
(121,'menuEmploymentContractType',119,218,20),
(122,'menuEmploymentContractEndReason',119,219,30),
(123,'menuLeavesSystemHabilitation',119,220,40),
(124,'menuGlobalParameter',8,18,15),
(125,'menuUserParameter',8,20,20),
(126,'menuAdmin',8,92,5),
(127,'navParameter',8,0,40),
(128,'navEnvironmentalParameter',8,0,50),
(129,'navAutomation',8,0,60),
(130,'navHabilitation',8,0,70),
(131,'navListOfValues',127,0,10),
(132,'navType',127,0,20),
(133,'navHumanResourceParameters',127,0,30),
(134,'menuDataCloningParameter',127,224,40),
(135,'menuClient',128,15,10),
(136,'menuUser',128,17,20),
(137,'menuResource',128,44,30),
(139,'menuAffectation',128,50,40),
(140,'menuTeam',128,57,50),
(141,'menuContact',128,72,60),
(142,'menuCalendar',128,85,70),
(143,'menuRecipient',128,95,80),
(144,'menuDocumentDirectory',128,103,90),
(145,'menuContext',128,104,100),
(146,'menuProvider',128,148,110),
(147,'menuResourceTeam',128,188,120),
(148,'menuEmployee',128,212,130),
(149,'menuWorkflow',129,59,10),
(150,'menuStatusMail',129,68,20),
(151,'menuTicketDelay',129,89,30),
(152,'menuIndicatorDefinition',129,90,40),
(153,'menuPredefinedNote',129,116,50),
(154,'menuChecklistDefinition',129,130,60),
(155,'menuJoblistDefinition',129,162,70),
(156,'menuKpiDefinition',129,169,80),
(157,'menuStatusMailPerProject',129,180,90),
(158,'menuIndicatorDefinitionPerProject',129,181,100),
(159,'menuTicketDelayPerProject',129,182,110),
(160,'menuEmailTemplate',129,184,120),
(161,'menuNotificationDefinition',129,186,120),
(162,'menuInputMailbox',129,250,130),
(163,'menuHabilitation',130,21,10),
(164,'menuAccessProfile',130,47,20),
(165,'menuAccessRight',130,48,30),
(166,'menuProfile',130,49,40),
(167,'menuHabilitationReport',130,70,50),
(168,'menuHabilitationOther',130,71,60),
(169,'menuAccessRightNoProject',130,135,70),
(170,'menuModule',130,221,80),
(171,'menuAccessProfileNoProject',130,256,90),
(172,'menuRole',131,73,10),
(173,'menuStatus',131,34,20),
(174,'menuResolution',131,149,30),
(175,'menuQuality',131,128,40),
(176,'menuHealth',131,121,50),
(177,'menuOverallProgress',131,127,60),
(178,'menuTrend',131,129,70),
(179,'menuLikelihood',131,39,80),
(180,'menuCriticality',131,40,90),
(181,'menuSeverity',131,38,100),
(182,'menuUrgency',131,42,110),
(183,'menuPriority',131,41,120),
(184,'menuRiskLevel',131,114,130),
(185,'menuFeasibility',131,115,140),
(186,'menuEfficiency',131,117,150),
(187,'menuPaymentDelay',131,137,160),
(188,'menuPaymentMode',131,138,170),
(189,'menuDeliveryMode',131,139,180),
(190,'menuMeasureUnit',131,140,190),
(191,'menuBudgetOrientation',131,199,200),
(192,'menuBudgetCategory',131,200,210),
(193,'menuTenderStatus',131,157,220),
(194,'menuCategory',131,170,230),
(195,'menuIncomingWeight',131,171,240),
(196,'menuDeliverableWeight',131,163,250),
(197,'menuIncomingStatus',131,172,260),
(198,'menuDeliverableStatus',131,164,270),
(199,'menuLanguage',131,178,280),
(200,'menuOrganizationType',132,159,10),
(201,'menuProjectType',132,93,20),
(202,'menuTicketType',132,53,30),
(203,'menuActivityType',132,55,40),
(204,'menuMilestoneType',132,56,50),
(205,'menuBudgetType',132,198,60),
(206,'menuCallForTenderType',132,155,70),
(207,'menuTenderType',132,156,80),
(208,'menuProviderOrderType',132,190,90),
(209,'menuProviderBillType',132,193,100),
(210,'menuProviderPaymentType',132,202,110),
(211,'menuIndividualExpenseType',132,80,120),
(212,'menuProjectExpenseType',132,81,130),
(213,'menuExpenseDetailType',132,84,140),
(214,'menuQuotationType',132,132,150),
(215,'menuCommandType',132,126,160),
(216,'menuBillType',132,100,170),
(217,'menuPaymentType',132,83,180),
(218,'menuCatalogType',132,175,190),
(219,'menuInvoiceType',132,82,200),
(220,'menuRiskType',132,45,210),
(221,'menuOpportunityType',132,120,220),
(222,'menuActionType',132,60,230),
(223,'menuIssueType',132,46,240),
(224,'menuMeetingType',132,65,250),
(225,'menuChangeRequestType',132,226,260),
(226,'menuDecisionType',132,66,270),
(227,'menuQuestionType',132,67,280),
(228,'menuMessageType',132,52,290),
(229,'menuDocumentType',132,101,300),
(230,'menuContextType',132,105,310),
(231,'menuRequirementType',132,107,320),
(232,'menuTestCaseType',132,108,330),
(233,'menuTestSessionType',132,109,340),
(234,'menuClientType',132,134,350),
(235,'menuProviderType',132,147,360),
(236,'menuProductType',132,144,370),
(237,'menuComponentType',132,145,380),
(238,'menuProductVersionType',132,160,390),
(239,'menuComponentVersionType',132,161,400),
(240,'menuIncomingType',132,166,410),
(241,'menuDeliverableType',132,165,420),
(242,'menuDeliveryType',132,183,430),
(243,'menuSupplierContractType',132,229,440),
(244,'menuClientContractType',132,236,450),
(245,'menuRenewal',131,231,290),
(246,'menuPredefinedSituation',131,249,300),
(247,'menuInterventionMode',131,251,310),
(248,'menuDocument',7,102,15),
(249,'menuAction',5,4,15),
(250,'menuActivityStream',0,177,15),
(251,'menuRequirement',5,111,17),
(252,'menuOrganization',128,158,5),
(253,'menuConsultationValidation',3,254,45),
(254,'menuLeaveType',133,217,10),
(255,'menuEmploymentContractType',133,218,20),
(256,'menuEmploymentContractEndReason',133,219,30),
(257,'menuLeavesSystemHabilitation',133,220,40),
(258,'menuConsultationPlannedWorkManual',3,253,45),
(258,'menuProjectParameter',8,19,10),
(300,'navPlugin',0,0,110),
(301,'menuPluginManagement',300,136,10);

ALTER TABLE `${prefix}menucustom` ADD `idRow` INT(12) DEFAULT '1' COMMENT '12',  ADD `sortOrder` int(3) unsigned DEFAULT 1 COMMENT '3';

INSERT INTO `${prefix}parameter` (`parameterCode`, `parameterValue`) VALUES 
('menuLeftDisplayMode','ICONTXT');

INSERT INTO ${prefix}parameter (idUser, parameterCode, parameterValue) SELECT r.id , 'newGui', 0 FROM ${prefix}resource r where r.isUser=1;