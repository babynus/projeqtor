.. include:: ImageReplacement.txt

.. title:: Administration

.. index:: Administration console

.. _admin-console:

Administration Console
**********************

.. figure:: /images/GUI/ADMIN_SCR_Console.PNG
   :alt: Administration screen
   :align: center
   
   Administration screen

.. note::

  The screens described below are restricted to users with administrator profile.
   
  Users with other profiles can not access it, whether display or access rights are granted or not.   

Administration console allows to execute administration tasks on application.

.. index:: Background tasks

.. _background-task:

Background tasks
----------------

Starts and stops background jobs that process and periodically checks the flags to generate the corresponding alerts, warnings, and auto-import when needed.

.. note:: 

   **It is the** :term:`CRON`

   CRON is a program that automatically runs scripts, commands, or software at a specified date and time, or a pre-defined cycle

.. figure:: /images/GUI/ADMIN_ZONE_BackgroundTask.png
   :alt: Background tasks in Admin
   
   Background tasks is running in Administration console
   
You can activate or deactivate CRON directly from the info bar

See: :ref:`The CRON button<ib-cron-button>`

.. figure:: /images/GUI/ADMIN_ZONE_ButtonCRON.PNG
   :alt: CRON Button
   
   CRON activation button


.. index:: Internal alert, Background tasks

Internal alert
--------------

Allows to send an internal alert to users. It's a :ref:`background task<background-task>`.

.. figure:: /images/GUI/ADMIN_ZONE_SendAlertIntern.png
   :alt: Internal Alert
   
   Internal Alert
   
   
Internal alerts can be sent to users. 

You can define a date and time for sending, specific adressees or all users, the type of message that users will receive: information, an alert or a warning ...

This can be a good step to warn users before a temporary shutdown of ProjeQtOr for update for example.    
   
 
.. figure:: /images/GUI/ADMIN_SCR_InternalAlertSend.png
   :alt: receipt of internal alert
   
   receipt of internal alert

An internal alert can be sent by the administrator or by monitoring indicators.

 .. compound:: By the administrator

    The administrator can send internal alert by administration console.
    
    The message will be received by user via message pop-up.
    
    

 .. compound:: Monitoring indicators   

    Monitoring indicators send only warning and alert message.
    
    The message contains information that explains the alert:

      * Item id and type.  
      * Indicator description. 
      * Target value.
      * Alert or warning value.

    The indicators are defined in :ref:`Indicators screen<indicator>` .    

   

.. index:: Connection Management

.. _manage_connection:

Manage connections
------------------

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
 
The administrator has the possibility to:

  * Close and delete sent emails and alerts. 
  * Delete history of connections. 
  * Updating references for any kind of element.

.. index:: Log file Maintenance   

Log files maintenance
---------------------

The administrator has the possibility to:
  
  * Delete old log files.
  * Show the list and specific log file.
  
  