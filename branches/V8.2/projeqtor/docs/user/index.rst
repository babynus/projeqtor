.. ProjeQtOr user guide documentation master file, created by
   sphinx-quickstart on Fri May 29 11:17:53 2015.
   You can adapt this file completely to your liking, but it should at least
   contain the root `toctree` directive.


Welcome
-------

ProjeQtOr is a Quality based Project Organizer, as a web application.

ProjeQtOr focuses on IT Projects, but is also compatible with all kinds of Projects.

Its purpose is to propose a unique tool to gather all the information about the projects. 

The fact is that many Project Management softwares just focus on planning. 
But it is a much too restrictive point of view. 
Of course, planning is an important activity of Project Management and is one of the keys to Project success, 
but it is not the only one.

Project Managers need to foresee all what can happen, measure risks, build an action plan and mitigation plan.

It is also important to track and keep traces of all what is happening to the Project : 
incidents, bugs , change requests, support requests, ...

In this objective, ProjeQtOr gives visibility at all levels of Project Management.

At lower level, the Project follow-up consists in gathering all information, and maintain it up to date. 
This involves all the operational teams.

At upper level, Project Steering uses the follow-up data to take the decisions and build the action plan. 
This allows to bring the adjustments needed to target on the objectives of the project. 

The goal of ProjeQtOr is to be Project Management Method independent. 
Whatever your choice of the method, you can use ProjeQtOr.


.. raw:: latex

    \newpage

What's New in this guide version?
---------------------------------

This section summarizes significant changes made in the user guide document for this version.

To see complete list of changes made to software, visit the ProjeQtOr web site.

**Current version V8.2 : Mains evolutions**

.. topic:: **Cloned environements**

   You will be able to duplicate the complete environment (data and code) to form a simulation environment. This possibility will also be accessible from simulated environments.

      * see: :ref:`cloned-environment`

.. topic:: **Minimum Threshold and the task "should not be split"**

   These planning options to set a minimum load on activity and indivisibility of this charge in the General Planning.

      * see: :ref:`minimum-threshold`

--------------------------------------------------------------------

**Reminder of the latest evolutions from V8.1**

**SSO connection through SAML 2**

 * see: :ref:`SSO_Saml2`

**Surbooking**

 * see: :ref:`surbooking`

--------------------------------------------------------------------

**Reminder of the latest evolutions from V8.0**

**Financial:**  finalization of the expenditure part to put it at the same level as the incomes

 * See: :ref:`Expenses` and :ref:`Incomes`

**Humans Resources:** Allows to manage the society’s humans resources

 * See: :ref:`humans_resources`

**Modules Management:** Allows to activate or no the modules wich include a coherent group of features.

 * See: :ref:`Module_Management`


.. raw:: latex

    \newpage

Features
--------

ProjeQtOr  is a "Quality based Project Organizer".

It is particularly well suited to IT projects, but can manage any type of project.

It offers all the features needed to different Project Management actors under a unique collaborative interface.
  
.. toctree::
   :maxdepth: 2
   
   Features

Concepts
--------

This chapter defines the concepts of ProjeQtOr.

They can be referred in the following chapters.

.. toctree::
   :maxdepth: 2

   Concept


Graphical user interface
------------------------

ProjeQtOr provides a very rich user interface.

It may be frightening at first glance because of the very numerous elements it provides, 
but once you'll get familiar to the structure of the interface you'll discover that it is quite simple 
as all screens have the same frames and sections always have simular structure and position.

.. toctree::
   :titlesonly:

   Gui
   CommonSections
   UserParameter



Planning and Follow-up
----------------------

ProjeQtOr provides all the elements needed to build a planning from workload, 
constraints between tasks and resources availability.

The main activity of Project Leader is to measure progress, analyse situation and take decisions.
In order to ease his work, ProjeQtOr provides several reporting tools, from the well know Gantt chart, to many reports.

.. toctree::
   :maxdepth: 1

   PlanningElements 
   Gantt
   Today 
   Diary
   Report


Real work allocation
--------------------

As ProjeQtOr implements Effort Driven planning (work drives planning calcuation), 
one of the key to manage project progress is to enter the real work 
and re-estimate left work for all ongoing tasks.

ProjeQtOr provides a dedicate screen for this feature, to ease this input so that entering real work is as quick as possible.
 
.. toctree::
   :titlesonly:

   RealWorkAllocation

Document management
-------------------

ProjeQtOr integrates an easy to use Document Management feature.

.. toctree::
   :maxdepth: 2

   Document

Ticket management
-----------------

.. toctree::
   :maxdepth: 1

   Ticket
   TicketDashBoard

  
Requirements & Tests
--------------------

.. toctree::
   :maxdepth: 1

   RequirementsTest
   RequirementsDashBoard

Financial
---------

.. toctree::
   :maxdepth: 2

   Expenses
   Incomes
   
Configuration Management
------------------------

.. toctree::
   :maxdepth: 1

   ConfigurationManagement

Risk & Issue Management
-----------------------

.. toctree::
   :maxdepth: 1

   RiskIssueManagement

Review logs
-----------

.. toctree::
   :maxdepth: 1

   ReviewLogs

Environmental parameters
------------------------

.. toctree::
   :maxdepth: 1

   User
   Resource
   Customer
   Provider
   Recipient

Tools
-----

.. toctree::
   :maxdepth: 2
 
   Tools

Controls & Automation
---------------------

.. toctree::
   :maxdepth: 1
 
   ControlAutomation

Access rights
-------------

.. toctree::
   :maxdepth: 1
 
   AccessRights

Lists of values
---------------

.. toctree::
   :maxdepth: 1

   ListsOfValues


.. _index-element-types-label:

Lists of types
--------------

Every element is linked to a type, defining some mandatory data or other GUI behavior.

.. toctree::
   :maxdepth: 1
   
   ListsOfTypes

Plug-ins
--------

.. toctree::
   :maxdepth: 1

   Plugin

Organizations
-------------

.. toctree::
   :maxdepth: 1

   Organization

Administration
--------------

.. toctree::
   :maxdepth: 1

   Administration
   GlobalParameters

Transverses Features
--------------------

.. toctree::
   :maxdepth: 1

   TransverseFeatures   

Humans Resources
----------------

.. toctree::
   :maxdepth: 1

   HumanResources   
   
Glossary
--------

.. toctree::
   :maxdepth: 1
  
   Glossary
