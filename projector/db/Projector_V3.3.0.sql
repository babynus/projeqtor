
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V3.2.0                                      //
-- // Date : 2012-12-06                                     //
-- ///////////////////////////////////////////////////////////
--
--
CREATE TABLE `${prefix}today` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(12) unsigned DEFAULT NULL,
  `scope` varchar(100) DEFAULT NULL,
  `staticSection` varchar(100) DEFAULT NULL,
  `idReport` int(12) unsigned DEFAULT NULL,
  `sortOrder` int(3) unsigned DEFAULT NULL,
  `idle` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX todayUSer ON `${prefix}today` (idUser);

CREATE TABLE `${prefix}todayParameter` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(12) unsigned DEFAULT NULL,
  `idReport` int(12) unsigned DEFAULT NULL,
  `idToday` int(12) unsigned DEFAULT NULL,
  `parameterName` varchar(100) DEFAULT NULL,
  `parameterValue` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=innoDB DEFAULT CHARSET=utf8 ;

CREATE INDEX todayParameterUser ON `${prefix}todayParameter` (idUser);
CREATE INDEX todayParameterReport ON `${prefix}todayParameter` (idReport);
CREATE INDEX todayParameterToiday ON `${prefix}todayParameter` (idToday);

INSERT INTO `${prefix}today` (`idUser`,`scope`,`staticSection`,`idReport`,`sortOrder`,`idle`)
SELECT id, 'static','Projects',null,1,0 FROM `${prefix}resource` where isUser=1 and idle=0;
INSERT INTO `${prefix}today` (`idUser`,`scope`,`staticSection`,`idReport`,`sortOrder`,`idle`)
SELECT id, 'static','AssignedTasks',null,2,0 FROM `${prefix}resource` where isUser=1 and idle=0;
INSERT INTO `${prefix}today` (`idUser`,`scope`,`staticSection`,`idReport`,`sortOrder`,`idle`)
SELECT id, 'static','ResponsibleTasks',null,3,0 FROM `${prefix}resource` where isUser=1 and idle=0;
INSERT INTO `${prefix}today` (`idUser`,`scope`,`staticSection`,`idReport`,`sortOrder`,`idle`)
SELECT id, 'static','IssuerRequestorTasks',null,4,0 FROM `${prefix}resource` where isUser=1 and idle=0;
INSERT INTO `${prefix}today` (`idUser`,`scope`,`staticSection`,`idReport`,`sortOrder`,`idle`)
SELECT id, 'static','ProjectsTasks',null,5,0 FROM `${prefix}resource` where isUser=1 and idle=0;

ALTER TABLE  `${prefix}parameter` 
CHANGE parameterValue parameterValue varchar(4000);

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null,null, 'paramMailBodyUser', 'You are welcome to ${dbName} at <a href="${url}">${url}</a>.<br>Your login is <b>${login}</b>.<br/>Your password is initialized to <b>${password}</b><br/>You will have to change it on first connection.<br/><br/>In case of an issue contact your administrator at <b>${adminMail}</b>.'),
(null,null, 'paramMailTitleUser', '[${dbName}] message from ${sender} : Your account information');

INSERT INTO `${prefix}menu` (`id`,`name`,`idMenu`,`type`,`sortOrder`,`level`,`idle`) VALUES 
(123,'menuPortfolioPlanning',7,'item',222,NULL,0);

INSERT INTO `${prefix}habilitation` (`idProfile`, `idMenu`, `allowAccess`) VALUES
(1, 123, 1),
(2, 123, 1),
(3, 123, 1),
(4, 123, 0),
(5, 123, 0),
(6, 123, 0),
(7, 123, 0);

INSERT INTO `${prefix}report` (`id`, `name`, `idReportCategory`, `file`, `sortOrder`) VALUES
(49, 'reportPortfolioGantt', 2, '../tool/jsonPlanning.php?print=true&portfolio=true', 215);

INSERT INTO `${prefix}reportparameter` (`idReport`, `name`, `paramType`, `sortOrder`, `defaultValue`) VALUES
(49, 'idProject', 'projectList', 10, 'currentProject'),
(49, 'startDate', 'date', 20, 'today'),
(49, 'endDate', 'date', 30, null),
(49, 'format', 'periodScale', 40, 'week'),
(49, 'listShowMilestone', 'milestoneTypeList', 50, '');

INSERT INTO `${prefix}habilitationreport` (`idProfile`,`idReport`,`allowAccess`) VALUES
(1,49,1),
(2,49,1),
(3,49,1);

ALTER TABLE `${prefix}statusmail` ADD COLUMN `mailToAssigned` int(1) unsigned default 0;

ALTER TABLE `${prefix}event` ADD COLUMN `sortOrder` int(3) unsigned DEFAULT NULL;

UPDATE `${prefix}event` SET `sortOrder`=10 WHERE id=3;
UPDATE `${prefix}event` SET `sortOrder`=20 WHERE id=2;
UPDATE `${prefix}event` SET `sortOrder`=60 WHERE id=1;
INSERT INTO `${prefix}event` (`id`,`name`,`idle`, `sortOrder`) VALUES 
(4,'noteChange',0,30),
(5,'descriptionChange',0,70),
(6,'resultChange',0,80),
(7,'assignmentAdd',0,40),
(8,'assignmentChange',0,50),
(9,'anyChange',0,90);

INSERT INTO `${prefix}parameter` (idUser, idProject, parameterCode, parameterValue) VALUES
(null,null, 'paramMailTitleNoteChange', '[${dbName}] A note has been modified on ${item} #${id} : "${name}"'),
(null,null, 'paramMailTitleDescription', '[${dbName}] Description has been modified on ${item} #${id} : "${name}"'),
(null,null, 'paramMailTitleResult', '[${dbName}] Result has been modified on ${item} #${id} : "${name}'), 
(null,null, 'paramMailTitleAssignment', '[${dbName}] New assignment has been added on ${item} #${id} : "${name}"'),
(null,null, 'paramMailTitleAssignmentChange', '[${dbName}] An assignment has been modified on ${item} #${id} : "${name}"'),
(null,null, 'paramMailTitleAnyChange', '[${dbName}] ${item} #${id} has been modified : "${name}"');

ALTER TABLE `${prefix}project` ADD COLUMN `fixPlanning` int(1) unsigned default 0;
