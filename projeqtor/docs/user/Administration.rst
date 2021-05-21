.. include:: ImageReplacement.txt

.. title:: Administration

.. index:: Administration console

.. _admin-console:

Administration Console
**********************

.. figure:: /images/GUI/ADMIN_SCR_Console.png
   :alt: Administration screen
   :align: center
   
   Administration screen

Administration console allows to execute administration tasks on application.

.. note::

  The screens described below are restricted to users with administrator profile.
   
  Users with other profiles can not access it, whether display or access rights are granted or not.   


.. index:: Background tasks

.. _background-task:

Background tasks
----------------

The :term:`CRON` program starts and stops background jobs that process and periodically check indicators to generate the corresponding alerts, warnings or even automatic imports if necessary.

This program automatically runs scripts, commands, or software at a specified date and time, or a pre-defined cycle.

.. figure:: /images/GUI/ADMIN_ZONE_BackgroundTask.png
   :alt: Background tasks in Admin
   
   Background tasks is running in Administration console
   
You can activate or deactivate CRON directly from the info bar. See: :ref:`The CRON button<cron-button>`

.. figure:: /images/GUI/ADMIN_ZONE_ButtonCRON.png
   :alt: CRON Button
   
   CRON activation button


.. index:: Internal alert, Background tasks

Send a internal alert
---------------------

Allows to send an internal alert to users. It's a :ref:`background task<background-task>`.

.. figure:: /images/GUI/ADMIN_ZONE_SendAlertIntern.png
   :alt: Internal Alert
   
   Internal Alert
   
   
An internal alert can be sent to users. 

You can define a date and time for sending, specific adressees or all users, the type of message that users will receive: information, an alert or a warning ...

This can be a good step to warn users before a temporary shutdown of ProjeQtOr for update for example.    

An internal alert can be sent by the administrator or by monitoring indicators.

 .. compound:: By the administrator

    The administrator can send internal alert by administration console.
    
    The message will be received by user via message pop-up.
    
   

.. index:: Connection Management

.. _manage_connection:

Manage connections
------------------


.. figure:: /images/GUI/ADMIN_ZONE_ManageConnection.png
   :alt: Manage connections
   
   Manage connections

Allows to force disconnection of active users and close the application for new connections.

.. compound:: Disconnect all users

    * The button :kbd:`Disconnect all users` allows to disconnect all connected users except your own connection.
    * The application status is displayed below.
    * Disconnection will be effective for each user when his browser will ckeck for alerts to be displayed.
    * The delay for the effective disconnection of users will depend on the parameter “delay (in second) to check alerts” in :ref:`Global parameters<automated-service>` screen.

.. compound:: Open/Close application

    * The button :kbd:`Open/Close application`
    * Allows to open and close application.
    * When the application is closed the message below will appear on login screen.

.. index:: Consistency check

Consistency check
-----------------
.. figure:: /images/GUI/ADMIN_ConstencyCheck.png
   :alt: constancy check
   :align: center
   
   consistency check
   
**Consistency check**

* on the WBS sequence search for duplicates, sequence holes, incorrect order
* on the presence of one and only one line of "PlanningElement" for the planifiable elements
* on the consolidation of ticket work
* on consolidation of work on activities
* on assignments



* This feature available automatically corrects detected issues

.. index:: Maintenance of Data (Email)
.. index:: Maintenance of Data (Internal alert)
.. index:: Maintenance of Data (Connection)

Maintenance of Data
-------------------
 
This section allows you to clean data relating to emails, alerts, notifications, logs ...

You have the option of closing or deleting and or activating the function so that the data is processed automatically on a daily basis.

* Close emails sent over X days
* Delete emails sent over X days
* Close alerts sent over X days
* Delete alerts sent older than X days
* Delete notifications sent more than X days
* Delete connection logs closed for X days



And you can update references for all or each of the elements.
.. index:: Log file Maintenance   

Log files maintenance
---------------------

.. figure:: /images/GUI/ADMIN_Zone_LogFiles.png
   :alt: Log files maintenance
   :align: center
   
   Log files maintenance

The administrator has the possibility to choose the level of the log files among debug, trace, script and errors.

  
  * delete files on a given number of days.
  * Show the list of logs
  * Show the last logs list.
  
  
.. figure:: /images/GUI/ADMIN_BOX_LogfilesList.png 
   :alt: Log files maintenance
   :align: center
   
   Log files list
  
  