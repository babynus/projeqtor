
.. title:: Administration

.. index:: ! Administration console

.. _admin-console:

ADMINISTRATION CONSOLE
**********************

.. note::

  * The screens described below are restricted to users with administrator profile.
   
  * Users with other profiles can not access it, whether display or access rights are granted or not.   

Administration console allows to execute administration tasks on application.

.. index:: ! Internal alert (Background tasks)
.. index:: ! Email (Background tasks)
.. index:: ! Import data (Background tasks)


Background tasks
----------------

* Starts and stops background jobs that process and periodically checks the flags to generate the corresponding alerts, warnings, and auto-import when needed.

.. index:: ! Internal alert (Send)

Send an internal alert
----------------------

* Allows to send an internal alert to users.

.. index:: ! Connection (Management)

Manage connections
------------------

* Allows to force disconnection of active users and close the application for new connections.

.. compound:: **Button: Disconnect all users**

    * Allows to disconnect all connected users except your own connection.
    * The application status is displayed below.

    .. note::

       * Disconnection will be effective for each user when his browser will ckeck for alerts to be displayed.
       * The delay for the effective disconnection of users will depend on the parameter “delay (in second) to check alerts” in :ref:`Global parameters<automated-service>` screen.

.. compound:: **Button: Open/Close application**

    * Allows to open and close application.
    * When the application is closed the message below will appear on login screen.

Consistency check
-----------------

* Consistency check on the WBS sequence (search for duplicates, sequence holes, incorrect order)
* This feature available on the administration screen also automatically corrects detected issues

.. index:: ! Email (Maintenance of Data)
.. index:: ! Internal alert (Maintenance of Data)
.. index:: ! Connection (Maintenance of Data)

Maintenance of Data
-------------------
 
* The administrator has the possibility to:

  * Close and delete sent emails and alerts. 
  * Delete history of connections. 
  * Updating references for any kind of element.

.. index:: ! Log file (Maintenance)   

Log files maintenance
---------------------

.. note:: The administrator has the possibility to:
  
  * Delete old log files.
  * Show the list and specific log file.

.. index:: ! Audit connections
.. index:: ! Connection (Audit)

.. _audit-connections:

AUDIT CONNECTIONS
*****************

Audit connection proposes a view of “who is online”.

.. note::

   * The administrator has the possibility to force the disconnection of any user (except his own current connection, see: :ref:`admin-console`.

.. raw:: latex

    \newpage

.. index:: ! Global parameters

.. _global-parameters:

GLOBAL PARAMETERS
*****************

Global parameters screen allows configuration of application settings.

.. note:: Tooltip

* Moving the mouse over the caption of a parameter will display a tooltip with more description about the parameter.

Tab Work time
-------------

.. _daily-work-hours-section:

Daily work hours
================

* Definition of regular “work hours”.

* Used to calculate delays based on “open hours”.

Open days
=========

* Possibility to define the working days in the company. For each day of the week, you can choose between open days or off days.

.. note::
  
  * This parameter are taken into account in : working days on calendars, the working days on the calculation and the display ,the working days on the display of real work allocation.

.. index:: ! Real work allocation (Unit for work)
.. index:: ! Workload (Unit form work)

.. _unitForWork-section:

Units for work
==============

.. compound:: **unit for Timesheet (real work)**

.. compound:: **Unit for Workload**

  * Parameters to real work allocation and workload.
  * Fields: Unit for real work allocation and for all work data
  * Definition of the unit can be in days or hours.

.. note::
     
  * If both values are different, rounding errors may occur.
  * Remember that data is always stored in days.   
  * Duration will always be displayed in days, whatever the workload unit. 

.. compound:: **Number of hours per day**

  * Allows to set number of hours per day.

.. index:: ! Real work allocation (Behavior)

.. _realWorkAllocation-section:

Timesheet
=========

Defines behavior of tasks in the real work allocation screen.

.. compound:: **Display only handled tasks**

  * Display only tasks with "handled" status.

.. compound:: **Set to first 'handled' status**

  * Change status of the task to the first "handled" status when  real work is entered.

.. compound:: **Set to first 'done' status**

  * Change status of the task to the first "done" status when no left work remains.

.. compound:: **Max days to book work (warning) :**

  * Number of days that user can enter real work in the future before getting a warning.
    
.. note::

  * this parameter does not apply to administrative projects
    
.. compound:: **Max days to book work (blocking)**

  * Number of days that user can enter real work in the future. This limit is blocking.
  
.. note::

  * this parameter does not apply to administrative projects.
  
.. compound:: **Alert resource on input done by someone else**

  * Select your type of alert : Internal, Email, both or none.

.. compound:: **Display pools on timesheet**

  * Possibly to display the pool whose the resource belongs to.

.. compound:: **After submit, alert to project leader**
  
  * After submission what type of alert would you want to send to the project leader 

.. compound:: **After submit, alert to team manager**
  
  * After submission what type of alert would you want to send to the team manager
  
.. compound:: **After submit, alert to organism manager**
  
  * After submission what type of alert would you want to send to the organism manager  
  
Tab Activity
------------

Planning
========
Specific parameters about Gantt planning presentation.

.. compound:: **Show resource in Gantt**

  * Select if the resource can be displayed in a Gantt chart, and format for display (name or initials or none).

.. compound:: **Max projects to display**

  * Defines maximum number of projects to display.
  * To avoid performance issues.

.. compound:: **Apply strict mode for dependencies**

Defines if a task can begin the same day as the preceding one.

  * If yes, the successor should begin the next day 
  * If no, the successor can start the same day.
    
Tickets
=======
Specific behavior for ticket management 

.. compound:: **Only responsible works on ticket**

  * Only responsible can enter some real work on the ticket.

.. compound:: **Ticket responsible from product Responsible**

  * Select if the product Responsible is displayed ( always, if empty, never) as Ticket Responsible on that screen

.. compound:: **Limit planning activity to those whit flag**

  * Display planning activity selected for the ticket

.. compound:: **Enable to filter ticket reports by priority**
 
  * Can display tickets on Report screen by level of priority

.. compound:: **Display ticket at customer level**

  * Display of tickets on the Customer screen and on the Contacts screen

.. compound:: **Display ticket at version level**

  * Display of tickets on the version screen 

.. compound:: **Manage accontable on ticket**

  * Display the coordinator as Accountable, so the Responsible is the current actor
    
Organization
============

Specific parameter for Organization management 

.. compound:: **Use budget feature for organizations**

  * If yes, can display and work on budget for an organization.


Automation
==========

Parameters to manage automations

.. compound:: **Consolidate validated work & cost**

  * Select if validated work & cost are consolidated on top activities and therefore for projects :
  
      * **Never**: Not consolidated
      * **Always**: Values are replaced on activities and project.(erase parents)
      * **Only is set**: Replaces values ( excepted if set by null or stay not indicated,do not erase parents)


.. compound:: **Auto set Responsible if single resource:**

  * Behavior about management of responsible, including automatic initialization of responsible.

  * Automatically set Responsible if not set and by the only one resource allocated to the project 

.. compound:: **Auto allocated the Manager to the project:**
    
  * Automatically create an allocation for the project Manager to the project. He should be a resource.

.. compound:: **Auto set a Responsible if needed:**
 
  * Automatically set Responsible to current resource (as using the element) if not set and if a Responsible is required (respecting access rights)

.. compound:: **Auto assign Responsible to activity:**
 
  * Assign automatically the Responsible to activities

.. compound:: **Update milestone from deliverable:** (Have to link elements)
 
  * Update milestone Responsible automatically when the Responsible of deliverable has changed.

.. compound:: **Update milestone from incoming:** (Have to link elements)
 
  * Update milestone Responsible automatically when the Responsible of deliverable has changed.

.. compound:: **Update deliverable from milestone (have to link elements):**
 
  * Update deliverable Responsible automatically when the Responsible of mielstone has changed.

.. compound:: **Update incoming from milestone (have to link elements):**
 
  * Update incoming Responsible automatically when the Responsible of milestone has changed.

.. compound:: **Auto set parent activity status:**
 
  * Auto set status of parent activity from the status of children activity. 

Milestones
==========
Specific parameters for Miltones management 

.. compound:: **Manage target milestone**
 
* It updates the target (planned) date of the element (on Requirements, Tickets, Product Versions, Incomings, Deliverables and Deliveries) from the planned date of the milestone.

.. compound:: **Auto link the milestone**
 
* It optionally allows you to display the element linked to the milestone (The option above should be on "yes" to have access to the selection of milestone targetted)

.. compound:: **Set milestone from product version**
 
* It optionally allows you to automatically retrieve the milestone from the milestone of the Project Version.
    
Controls and restrictions
=========================

.. compound:: **allow the type restriction on project**

  * allow to define additional restriction's type on each project additionally to restrictions defined at project type level. 
  * if so, a Restrict Types button appears in the detail area and allows you to define the type restriction .

.. figure:: /images/GUI/BOX_RestrictType.png

.. compound:: **restriction on types by profil hides items**

  * allows the administrator to restrict the display of certain item types on profiles in the topic Acces Right / profiles

.. figure:: /images/GUI/BOX_RestrictTypeForProject.png

 
Tab Display
-----------

Graphic interface behavior and generic display parameters.

Display
=======

.. compound:: **Name of the instance**

* Change the window's name. The name appears at the top center of the window

.. compound:: **display in fading mode**

* transition between screen changes in flash or fade mode.

.. compound:: **Max items to display in Today lists**

* limit the display of the "today list". items are generally ordered by issue date increasing

.. compound:: **Quick filtering by status**

* Display one button. Allow to filter on lists the element by status checking boxes. Refresh to make appear on boxe a new state just created on list .

Localization
============

.. compound:: **Currency**

* Choose your symbol displayed on each monetary boxe

.. compound:: **Currency position for cost display**

* Symbol sets  before or after each monetary boxe

Default values for user parameters
==================================

.. compound:: **Default language**

 * choose among 19 languages / easy come back with translation in target language

.. compound:: **Default theme**

 * More than 30 themes choices

.. compound:: **First page**

 * Choice of the first visible screen after the connection.

.. compound:: **Icone size in menu**

 * Icon size are default : user can overwrite these values

.. compound:: **Display of the upper menu**

 * Icones are hidden or no.

.. compound:: **Display of the left menu**

 * Appears by icones or in wide mode

.. compound:: **Display history**

 * no
 * yes, yes with work indicated ( on the bottom of the page )
 * on request ( through a specific button )  
 
.. compound:: **Editor for rich text**

 * Choose your favorite text editor

.. compound:: **Activate the spell checker in CK editor**

 * yes or no 

.. compound:: **Not applicable value**

 * choice of the symbol defining the non-applicable values.
 * On the global view the value of the field that has no applicable value for the given column will display this symbol

.. compound:: **Restric project list**
 
 * When creating an element, name of the project stays like than the one selected at the selector or on contrary offers choice on global list of projects

.. compound:: **Export in XLS or ODS**

 * choice between proprietary or free application 
 
.. compound:: **displaying notes in discussion mode**

 * Display of notes in discussion mode with indentation for answers 
 

Tab References
--------------

Format for reference numbering
==============================

.. compound:: **prefix format for reference**

* Allows to define reference formats for items of element, documents and bills.
* can contain prefix : 
 
     * {PROJ} for project code, 
     * {TYPE} for type code, 
     * {YEAR} for current year 
     * {MONTH} for current month.
     
.. compound:: **change reference on type or project change**

* Change the reference on type change of element will generate missing numbers in reference

Document reference format
=========================

.. compound:: **document reference format**

* Format can contain : 

      * {PROJ} for project code, 
      * {TYPE} for type code, 
      * {NUM} for number as computed for reference, 
      * {NAME} for document name.

.. compound:: **version reference suffix**

* Suffix can contain : 

      * {VERS} for version name.
      
.. compound:: **Separator for draft in version name**

* choose the sign for the separator of the draft

.. compound:: **preserve uploaded file name**

* If yes, the file is downloaded with the name of original file 
* If no, the document take the reference formatted name

.. compound:: **forbid download of locked document**

* forbid document download if yes is checked
      
    
Bill reference format
=====================

.. compound:: **bill reference format**

* reference format : can contain {NUM} for version name.

.. compound:: **number of digit for bill number**

* choice of the number of digits to display in an invoice.

Tab Configuration
-----------------

Product and Component
=====================

.. compound:: **display Business features**

* Filter on date

.. compound:: **display the start and delivery milestones**

* Display start and delivery milestones for product/component version and delivery dates in flat structure

.. compound:: **display language in Product/Component (Version)**

* Enable language

.. compound:: **display contexts in Product/Component (Version)**

* Enable contexts

.. compound:: **display Tenders on Products, Components, Versions**

* Display a section to list linked Tenders on products, component, product version and component versions

.. compound:: **list of activity on component version**

* display the list of activity

.. compound:: **direct access to product / component full list**

* when selecting a component, we go directly to the full list (with filter capacity), without going through the pop-up window

.. compound:: **automatic format of version name**

* ability to choose a preformatted format for version names

.. compound:: **separator between name and number**

* Choose the character of the separator for version names 

.. compound:: **auto subscription to versions**

* Suscription automatic to versions or components when you suscribe to product or component

.. compound:: **types of copy of Component Version**

You can choose between :

* free choice
* copy structure from origin version
* replace the origin version with new copied one

.. compound:: **enable Product Versions compatibility management**

* Display compatibility section in product version details

.. compound:: **display product version on delivery**

* allows to link a delivery to product version

.. compound:: **sort versions combobox in descending order**

* Change sort order for versions in combobox to have more recent first (descending on name)

.. compound:: **sort version composition and structure on type**

* Sort version composition and structure by type ascending and name descending

.. compound:: **manage component on requirements**

* Manage component and target component version on requirements

.. compound:: **Do not add closed and delivered versions to a project**

* When adding a product to a project, do not add its closed and delivered versions

.. compound:: **allow activities on delivered version**

* Include delivered products versions in target product version list for activities

.. compound:: **automatically set component version if unique**

* Automatically set component version if there is only one component version of the selected component that is linked to the selected product version

Tab Financial
-------------

Input of amounts for expenses
=============================

.. compound:: **Input mode for amounts**

* Defined for expenses items if the amounts must be entered without taxes and calculated in with taxes or vice versa

.. compound:: **input mode for bill lines**

* Defined for expenses items if the total bill lines feed the total with or without taxes. The parameter is priority if there a bill lines

Input of amounts for incomes
============================

.. compound:: **input mode for amounts**

* Defined for incomes items if the amounts must be entered without taxes and calculated in with taxes or vice versa

.. compound:: **input mode for bill lines**

* Defined for icomes items if the total bill lines feed the total with or without taxes. The parameter is priority if there a bill lines

Tab Mailing
-----------

Emailing
========

Parameters to allow the application to send emails.

Mail titles
===========

* Parameters to define title of email depending on event.(see: :ref:`administration-emailing-group-label`)

* it is possible to use special fields to call a function or data of the project. (see: :ref:`administration-special-fields`)

.. raw:: latex

.. index:: special fields

    \newpage

.. _administration-emailing-group-label:

Automatic emails grouping
=========================

.. compound:: **activate email grouping**

* When emailing grouping is activated, automatic emails sent during the defined period are grouped into a **single mail**

.. compound:: **grouping period (in seconds)**

* Defines the period (in seconds) during which if an email is send after another on same item, then emails **are grouped into single one**

.. compound:: **how to treat different formats**

* If grouped emails refer to different templates, you can : 
   * send all messages, one for each template
   * Only send the last message
   * Merge all messages and send a single email


Test email configuration
========================

.. compound:: **Send email to**

* Sent a email to check sptm configuration.

.. warning:: This operation saves global parameters


Tab Authentication
------------------

Ldap management parameters
==========================

* Information about LDAP connection and behavior on creation of new user from LDAP connection.

User and password
=================

* Security constraints about users and passwords.

Tab Automation
--------------

.. _automated-service:

Management of automated service (CRON)
======================================

Parameters for the Cron process.

.. topic:: **Defined frequency for these automatic functions**

  * It will manage :

     * Alert generation : Frequency for recalculation of indicators values.

     * Check alert : Frequency for client side browser to check if alert has to be displayed.

     * Import : Automatic import parameters as below.
     
.. warning:: **Cron working directory** Should be set out of the path web..

.. _automatic-import:
     
Automatic import of files
=========================

Automatic import settings for cron processes.

.. warning:: **Directory of automated integration files** Should be set out of the path web.


Automatic import of replies to emails
=====================================

Defined parameters for the “Reply to” process
It will manage connection to IMAP INBOX to retrieve email answers.

.. compound:: **email input check cron delay (in seconds)**

* Delay of -1 deactivates this functionality. 

.. note:: **IMAP host**

   * Must be an IMAP connection string.
   * Ex: to connect to GMAIL input box, host must be: {imap.gmail.com:993/imap/ssl}INBOX
   
.. _administration_defined-parameters:

Automatic planning calculation
==============================

  Activated or desactived this feature by simple click
  
.. compound:: **Differential calculation**

* Project planning is recalculated only for those who need to be. A data or more has been changed into the project so a new calculation is expected. 

.. compound:: **Complete calculation**

* All projects planning are recalculated. 


.. note:: Select the frequency of the calendar by clicking on the button **defined parameters** and choose the schedule, day, month.
   
   .. figure:: /images/definedparameters.png

.. note:: **Start date for...**
   Select when you want to recalculate project(s)according the date of today's date 


Generation of alerts if real work is not entered
================================================

Specific settings for alerts based on a profile. 
An email is sent on the agreed date. Click on the button **Defined Parameters** (see: :ref:`administration_defined-parameters`) to set the send frequency.

.. compound:: **generation parameters for the Resource/Project leader and Team Manager**

* select the frequency of the calendar with which the emails will be generated and sent to the profile 


.. note:: **Control input up to** Select when you want to be controlled. Current day, previous day or next days.

.. note:: **Number of days to control** Choose how many days will be controled
      
.. note:: **Select how to send alert to each profil** chose how alerts will be sent, Internal alert, email, both or none


.. warning::
   * All days of the week, open or off days are taken into account.
   * Off days in real work allocation will not send you an alert.
 
Tab System
----------

Files and directories
=====================

Definition of directories and other parameters used for Files and documents management.

.. warning:: **Attachments Directory** and **Root directory for documents** Should be set out of web reach.

.. warning:: **Temporary directory for reports** Must be kept in web reach.

.. _document-section:

Localization data
=================

.. compound:: **Charset to save files on server**

* Keep empty for Linux servers, files names will be stored in UTF8. 

* For windows OS server, define charset as "windows-1252" (for western europe) or similar corresponding to your localization.
    
.. compound:: **Separator for CSV files**

* Choose the field separator for csv exports

.. compound:: **export CSV to UTF-8 format**

* Preserve UTF-8 for exported csv files. If set no, will encode in CP1252 (recommended for windows in English and western Europe Languages)

Miscellaneous
=============

.. compound:: **check for new version**

* Auto check (or not) for existing new version of the tool (only administrator is informed);

PDF export
==========

.. compound:: **Memory limit for PDF generation.**

* Size In MB. Too small can lead to PDF error but too big can crash the server

.. compound:: **Font for PDF Export.**

* Freesans give great portability for non ANSI characters - Helvetica give smaller PDF files.


SSL connection to database
==========================

Allows to set up a secure SSL connection

.. compound:: **SSL Key

.. compound:: **SSL Certification

.. compound:: **SSL Certificate Authority

* Enter patch to corresponding files to enable SSL connection to the database.

.. warning:: Take care that these files must exist and be valid SSL files.
 
     If values are incorrect, the application will not work any more, and you'll have to manually fix parameters in the database.  
    

.. _administration-special-fields:

Special Fields
--------------

Special fields can be used in the title and body mail to be replaced by item values :

* **${dbName}** the display name of the instance
* **${id}** id of the item
* **${item}** the class of the item (for instance "Ticket") 
* **${name}** name of the item
* **${status}** the current status of the item
* **${project}** the name of the project of the item
* **${type}** the type of the item
* **${reference}** the reference of the item
* **${externalReference}** the :term:`external reference` of the item
* **${issuer}** the name of the issuer of the item
* **${responsible}** the name of the responsible for the item
* **${sender}** the name of the sender of email
* **${sponsor}** the name of the project sponsor
* **${projectCode}** the project code
* **${contractCode}** the contact code of project
* **${customer}** Customer of project 
* **${url}** the URL for direct access to the item
* **${login}** the user name
* **${password}** the user password
* **${adminMail}** the email of administrator





