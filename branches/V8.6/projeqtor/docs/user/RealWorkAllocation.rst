.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage

.. title:: Real work allocation

.. index:: Real work allocation 

.. _RWA:

********************
Real work allocation
********************

Timesheet
=========

This screen is devoted to input of real work.

The resource informs his work day by day, for each assigned task.

Data entry for one resource, on a weekly base.

.. note::

   The corresponding cost to the real work is automatically updated to the assignment, activity and project.

.. figure:: /images/GUI/REALWORK_SCR_TimeSheetZone.png
   :alt: Timesheet zone screen
   :align: center

   Timesheet zone screen

.. topic:: Interface areas 

   |one| :ref:`Selection timesheet<selectionTimesheet-section>`
   
   |two| :ref:`Filters on the display<filters-resource-planning>`
   
   |three| :ref:`Show planned work<show-plannedwork>`
   
   |four| :ref:`Buttons<buttons-timesheet>`
   
   |five| :ref:`Data entry validation<data-entryvalidation-timesheet>`
   
   |six| :ref:`Entry fields<entry-fields>`


.. warning:: 

   **Global parameter - Number of hours per day**

   * In global parameters screen, you can define wether work will be entered in hours or in days.
   * If you enter work in hours, you must define  the parameter **number of hours per day** before some real work has been entered.
   * After first work is entered, this parameter will be locked.
      
   **see:** :ref:`Global Parameters<work>`
   


.. _selectionTimesheet-section:   

Selection timesheet
-------------------

.. figure:: /images/GUI/REALWORK_ZONE_TimeSheetSelector.png
   :alt: Timesheet selector zone
   
   Timesheet selector zone

Allows to select a timesheet for a resource and for a period

 .. compound:: |one| Selection of the resource 

  * By default, users can only select themselves as a resource.

  * Access to other resources timesheet depending on :ref:`specific_access`, then user can select other resources timesheets. 

  * Clicking on the checkbox below allows to select only resources allocated to the selected project on the list roll displayed. 

    .. figure:: /images/GUI/REALWORK_ZONE_Timesheet_LimitList.PNG
       :alt: Limit list of resources
       
       Limit list of resource


  * The button |iconGoto| allows you to go to the timesheet of the selected resource with the line of the current element highlighted.
  
  * For more details see :ref:`goto-timesheet`



 .. compound:: |two| Selection period

  By default, the period is determined according to the current day.
  
  Targeted periods are displayed in different places on the screen.

   * You can select the number of the week and its year directly with the corresponding filters.

   * The "first day" filter allows you to choose a specific date, day, month and year. The full week containing this date will be displayed.

   * the button today targets the current week and D-day is highlighted

  .. figure:: /images/GUI/REALWORK_ZONE_DDay.png
     :alt: the current week and D-day highlighted
     
     The current week and D-day highlighted 
  
 .. compound:: |three| Displayed timesheet

  A timesheet is displayed depends on the resource and period selection.
  
  * The name of the resource and the week are displayed.
  * The days of the week are displayed.
  * The current day is displayed.








.. _filters-resource-planning:

Filters on the display
----------------------

Filters allow to define the list of assigned tasks displayed.

 .. compound:: **Show only current week meeting**

    * Check this box to show only the tasks on meetings of the week.

 .. compound:: **Hide done items**

    * Check this box to hide completed tasks.
    
 .. compound:: **Hide not handled items**

    * Check this box to hide tasks not taken over.

 .. compound:: **Show closed items**

    * Check this box to show closed tasks.

 .. compound:: **Show ID**

    * Show ID to identify all single task.

.. note:: 

   **Global parameter - "Display only handled tasks"**

   If the value of the parameter is set to "Yes", only tasks taken over (status "handled") will be displayed.
   
   The checkbox "Hide not handled items" will be hidden.









.. _show-plannedwork:

Show planned work
-----------------

* Check this box to display the planned work.
* Planned work is indicated over each input cell, on top left corner, in light blue color.
* Allows to display the planned working time by day, for the resource assigned to the task.

.. figure:: /images/GUI/REALWORK_ZONE_WithPlannedWork2.png
   :alt: Planned work displayed zone
   :align: center

   Planned work displayed zone

.. note::

   The planned work will be deleted if the real work is entered instead of planned work (to avoid duplication of work in reports) to see it you have to refresh the screen.




.. _buttons-timesheet:

Buttons
-------

Buttons of the timesheet:

* Click on |buttonIconSave| to save timesheet data.
* Click on |buttonIconPrint| to print timesheet.
* Click on |buttonIconPdf| to export timesheet in PDF format.
* Click on |buttonIconCsv| to export timesheet in CSV format.
* Click on |buttonIconUndo| to undo modification on the timesheet.








.. _data-entryvalidation-timesheet:

Data entry validation
---------------------

.. image:: /images/GUI/Button_Timesheet_EnterRealWork.png 

* To enter automatically  the work as it is planned

.. image:: /images/GUI/Button_Timesheet_SubmitWork.png 

* Buttons allow to send and validate real work.
* Displayed if mandatory
* Users can send works to project leader.

.. image:: /images/GUI/Button_Timesheet_ValidateWork.png 

* Project leaders can validate works.






.. _entry-fields:

Entry field
-----------

.. figure:: /images/GUI/REALWORK_ZONE_InputTimesheet.png
   :alt: Input timesheet zone
   :align: center

   Input timesheet zone
   
.. topic:: Interface areas

   |one| :ref:`comments<comments-entryfields>`
   
   |two| :ref:`Real work entry<real-work-entry>`
   
   |three| :ref:`Left work<left-work>`
   
   |four| :ref:`Task list<realwork-task-list>`
   
   |five| :ref:`Assigned task function<assignedtask-function>`   
   
   |six| :ref:`Assigned task comment<assignedtask-comment>`   
   



   
.. _comments-entryfields:      

.. rubric:: |oneBLC| Comments

* A global comment can be added on the weekly follow-up.
* Possibility to extend the main comment area.
* Can enter a comment on each line of real work allocation screen.





.. _real-work-entry:

.. rubric:: |twoBLC| Real work entry

* Area to enter real work.
* Week is displayed from monday to sunday.
* It possible put real work in off days.

.. compound:: **Days off**

    * Columns of days off is displayed in grey.
    * Days off is determine in resource calendar definition, see: :ref:`calendars`.

.. compound:: Periods types

    In order to see and know the assignment times on a task, several columns indicate the periods that are assigned to a resource

      * **Planned dates**: Planned start and end dates.
      * **Assigned**: Planned work assigned to the resource.
      * **Real**: Sum of work done by the resource.
      * **Left**: The remaining planned work. 
      * **Reassessed**: The work needed to complete the task. 
      
  .. figure:: /images/GUI/REALWORK_ZONE_RowsTime.png
     :scale: 60%
              
          
.. compound:: Total of days

  On the last column is the sum for all days of the week. 

  It is a synthesis displayed for each project and globally for the whole week.
    
  .. figure:: /images/GUI/REALWORK_ZONE_TimesheetTotalDay.PNG
    :alt: Total of the day
   
    Total of the day Zone  
   
 

.. compound:: Input entry validation

 * These controls are not blocking.

 * yellow background : Enhancement of data entered


.. compound:: Resource capacity validation

* The total of the day is green whether entries respects the resource capacity of days.
* The total of the day is red whether entries is more than the resource capacity of days.

.. compound:: Resource capacity of days

   * The resource capacity is defined by the number of hours per day and the resource capacity.
   
   * The number of hours per day is defined on :ref:`Global parameters<unitForWork-section>` screen.
   
   * The capacity of the resource is defined on :ref:`resource` screen.

.. figure:: /images/GUI/REALWORK_ZONE_WithColumnsValidation.png
   :alt: Columns validation zone
   :align: center

   Columns validation zone


.. compound:: Entering real work is in excess of the number of days specified 

* This alert box appears when the real work to a resource is entering ahead of time.

.. figure:: /images/GUI/REALWORK_ALERT_RealWorkBlocked.png

* Resource can enter his real work is defined in "max days to book work" parameter in :ref:`Global parameters<unitForWork-section>` screen.
    
.. figure:: /images/GUI/GLOBALPARAM_WorkTime_Timesheet.png
   :alt: Real work over expected days alert
   :align: center



.. topic:: **Unit time of real work data entry**

    * The global parameter **Unit for real work allocation** into Work Time tab allows to set the unit time.
    
    .. figure:: /images/GUI/GLOBALPARAM_WorkTime_UnitsWorks.png
    
    * unit for Timesheet (real work) : available are in "Days" or "Hours".
    * Selected unit time is displayed on left at bottom window.      












.. _left-work:

.. rubric:: |threeBLC| Left work

* Left work is automatically decreased on input of real work.
* Resources can adjust this value to estimate the work needed to complete the task.








.. _realwork-task-list:

.. rubric:: |fourBLC| Tasks list

The list displays the assigned tasks for the resource.

   * Only assigned tasks that meet the next criteria will be displayed.
   
   * Assigned tasks planned during this period.
   
   * Assigned tasks that meet the criteria of selected filters.

   * Assigned tasks are grouped by project and displayed according the project structure.  

   * Click on the name of the activity to access the detail screen.
   
.. note::

     * Assigned tasks with real work are always displayed, even if closed.
     * The goal is to show all lines of the sum for each column, to be able to check that the week is completely entered.

  

 

.. _assignedtask-function:

.. rubric:: |fiveBLC| Assigned task function

* The assigned task function is displayed in blue after the name of the activity.  





.. _assignedtask-comment:

.. rubric:: |sixBLC| Assigned task comments
    
* The icon |iconNoteAdd| allows to add a comment.
* The icon |Note| indicates there is a comment on assigned task. 
* Just move the mouse over the icon to see the last comment.

.. note:: The comments |Note|

   fly over the icon with the mouse to see the comment
   
   .. figure:: /images/GUI/REALWORK_BOX_Timesheet_ViewComment.PNG
   
   * Click on the icon to open windows view comments
      
   .. figure:: /images/GUI/REALWORK_BOX_leftclickNote.png
      :alt: 
      :align: center
             
        














   
.. raw:: latex

    \newpage

The status of tasks
===================

The task status can be changed automatically according to data entries on real work and left work.

.. rubric:: Global parameter "Set to first 'handled' status"

* If the parameter value is set to "Yes", when real work is entered on a task, its status will be changed automatically to the first status "handled".

.. rubric:: Global parameter "Set to first 'done' status"

* If the parameter value is set to "Yes", when left work is set to zero on a task, its status will be changed automatically to the first status "done".

.. rubric:: Change status validation

* An icon will be displayed on the task if a status change is applicable.

 .. compound:: **Icons**

    * |statusStart| Due to real work is entered, the task status will be changed to the first 'handled' status.
    * |statusStartKO| The real work is entered, but the task status will not change because at issue is occurring. 
    * |statusFinish| Due to no more left work, the task status will be changed to the first ‘done’ status.
    * |statusFinishKO| No more left work, but the task status will not change because at issue is occurring. 

    .. note::

       Move the cursor over the icon to see the message.

 .. compound:: **Common issue**

    * If a :term:`responsible` or a :term:`result` are set as mandatory in element type definition for the task. It's impossible to set those values by real work allocation screen.
    * The change status must be done in treatment section on the task definition screen.

   
.. raw:: latex

    \newpage
    
Timesheet Validation
====================

The timesheet validation screen allows the project manager to receive, verify and validate the time allocated weekly by the resources to an activity for all the projects to which this resource is assigned.
.. figure:: /images/GUI/REALWORK_ZONE_TimesheetValidation.png


.. list-table:: Fields - Timesheet validation
   :header-rows: 1

   * - Field
     - Description
   * - Resource
     - resource name, owner of the posting sheet
   * - Week
     - dates of the imputed period - One shipment per week
   * - Expected
     - Expected work for the resource
   * - Operational work
     - work actually done for the resource
   * - Administrative work
     - period of leave/sickness/absence
   * - Sum
     - total days of resources over the period indicated
   * - Timesheet submitted
     - Date the timesheet was sent by the resource 
   * - Timesheet validation
     - project learder placeholder to validate or invalidate timesheet

.. note:: **Color code**

   According to the work completed by the resource, and according to the expected workload for this resource, 
   
   the PL receives the timesheet with a precise color code

      * **Green:** The completed job is the same as the expected one.

      * **Red:** The filled workload is shorter or longer. It does not match the expected work.

      * **Orange:** the job is not the same as the expected job but the load is the same.




   
.. raw:: latex

    \newpage
    
.. index:: Monthly consolidation
    
.. _monthly-consolidation:

Monthly consolidation
=====================

Monthly consolidation allows you to view, control and validate resource allocations to a particular project for an entire month.
This screen will list all the projects on which the user has visibility.

.. figure:: /images/GUI/REALWORK_SCR_MonthlyConsolidation.png
   :alt: Monthly consolidation screen
   
   Monthly consolidation screen

**Filters will limit the list:**

• Project to restrict the listed projects to this project and its sub-projects
• Project Type to restrict the listed projects to projects of this type
• Organization to restrict the listed projects to the projects of this organization
• Month and year to restrict to this date

.. note:: By default, this will be the last month for which projects are still blocked, or failing this it will be the current month.

**This screen will display for each project not validated:**

• The currently known CA
• The currently known validated load
• The total actual load currently known to the project
• The actual load consumed on the project for the selected month
• The remainder to be done currently known
• The currently known reassessed load
• The currently known margin (load) = load validated - load reassessed


For validated projects, the data displayed is that stored during validation.


.. rubric:: Block a project over a month

The |unlocked| and |locked| buttons allow you to block or unblock charges beyond the month-end date. When the project is blocked for a given month, you cannot enter a charge for the following month, even if it has started. The block will be propagated recursively to sub-projects.


.. rubric:: Validate a project over a month

The |submitted| and |unsubmitted| buttons allow you to block or unblock charges beyond the month-end date. When the project is blocked for a given month, you cannot enter a charge for the following month, even if it has started. The block will be propagated recursively to sub-projects.


.. warning:: 
   
   Access to the blocking / unlocking and the validation button will be configured by a :ref:`specific right<monthly-consolidation-rights>`.











   


   
.. raw:: latex

    \newpage
    
.. _automatic-inuptwork:

Automatic input of work
=======================

The goal is to be able to automatically inform the real from the planned, until a given date, then trigger the automatic calculation of the projects from the day after that date.

.. warning::

   However, it will be necessary to ensure that the automatic capture of the real does not come superimposed on an actual seizure of real work by a resource, which would indicate in this way having worked differently from what had been planned.

A parameter "automatic feed of the real" has been added on the setting of the complete automatic calculation.

If the parameter "Automatic feed of the real" is selected, when the calculation is triggered, the actual work is automatically entered from the planned work until the day before the start of the calculation of the schedule.

For security, and to avoid the superposition with a manual entry of real, if the resource has real for a given date, one does not copy the possible planned existing in real.
 
For each planned job found, if no job exists for the resource concerned on the date of the scheduled job, copies the planned job to real work.
  
We will mark the actual work entered automatically (technical zone type tag) to distinguish the automatic feed from a manual feed. This area will not be processed for screen renditions, but will analyze any unexpected behavior.






.. _absence:

Absences
========

The absenteeism screen allows you to enter non-productive days, i.e. days not worked

Absences must be informed as soon as possible so that the calculation of the planning of your projects takes into account the unavailability of resources.


.. figure:: /images/GUI/REALWORK_SCR_Absence.png
   :alt: absences screen
   
   absences screen
   
Absences are linked to an administrative project. Only one project is necessary for all the resources, without them being assigned to this project.


 .. compound:: |one| Resource Selector
   
   Depending on your rights and profile, you can have access to the resources that you manage or only to yourself.

   Select the resource whose non-productive days you want to add as well as the year on which these days will be retained.

 .. compound:: |two| Types of absences

   Each type of absence is an activity related to the administrative project.
   
   You can create as many activities as types of absences.

 .. compound:: |three| Accelerator

   Select the type of leave and click on the accelerators to enter the selected value directly in the date boxes in the calendar.

   1: full day
   0.5: half day on the type of leave selected
   0: delete the days already entered

 .. compound:: |four| calendar
 
   Select the type of leave from the existing list.
   
   Click on the boxes of the dates concerned by non-productive work.
   
   The boxes are filled with the color of the leave type
 
   
   

