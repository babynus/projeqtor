.. include:: ImageReplacement.txt

.. title:: Gantt charts

.. raw:: latex

    \newpage

Gantt charts
************

.. contents:: Gantt charts
   :depth: 1
   :local: 
   :backlinks: top
   
.. index:: ! Gantt chart (Planning)

Planning
========

This screen allows to define project planning and follow progress.

.. figure:: /images/GUI/PLANNING1.png 
   :alt: Gantt (Planning)
   :align: center

   Gantt (Planning)
   
.. note:: This screen offers many features that will be described in the next sections.
   
the Gantt Chart is composed of two main areas:

* :ref:`task-list-area` |one| 
* :ref:`gantt-chart-view` |two|

---------------------------------------------------

.. rubric:: |three| Activity planning calculation

* Click on  |calculatePlanning| to start the activity planning calculation.  (See: :ref:`project-planning`)

.. raw:: latex

    \newpage

.. note::
   * Any changes to an assignment (rate, resource name, number, dates, etc.) made from an activity are not displayed on the planning screen with the new recalculated mode. 
   * Click |calculatePlanning|to start the new planning calculation
   * The automatic schedule calculation only works when you are in the Gantt schedule view and you are editing an item from this screen.


.. rubric:: |four| Buttons

* Click on |iconEnableCalendar| to validate planning.
* Click on |storePlannedDates| to save baseline of planning. (See: :ref:`project-planning`)
* Click on |buttonIconPrint| to get a printable version of the Gantt chart.
* Click on |buttonIconPdf| to export Gantt chart in PDF format. (See: :ref:`export-Gantt-PDF`) 
* Click on |msProject| to export planning to MS-Project xml format.
* Click on |createNewItem| to create a new item. (See: :ref:`project-planning`)
* Click on |buttonIconFilter| to filter the list. see the picture below. 
* Click on |buttonIconColumn| to define the columns of progress data that will be displayed. (See: :ref:`progress-data-view`)


.. figure:: /images/GUI/AdvancedFilter_Gantt.png
   :alt: Advanced filters
   :align: center

   Advanced filters of the Gantt chart

.. note:: 
  * Filter the schedule: possibility to filter the activities to display on the Gantt Planning view
  * The "parents" of the selected activities are also displayed to maintain the :ref:`wbs` structure
    

.. warning:: Check the box **"save date"** to keep registered displayed date of the overview planning, otherwise dates removing to general mode, after navigating away from this page.  

.. rubric:: |five| Show Baseline

* The baseline is a record of the planning state at a time T.
* This option displays this line at the top and / or bottom of your current Gantt chart for comparison.. 

.. note::

  * Ability to display two baselines on the Gantt chart.
  * You can recording only one baseline every day
  * Baseline can be saved with |storePlannedDates|.

.. rubric:: |six| Show Critical path

The critical path is used to determine the total duration of your project. 
The critical path of your project is the longest sequence of tasks that must be completed for the project to be completed by the due date.

* click on the **"critical path"** check box to calculate and display the red path in the Gantt schedule.

.. raw:: latex

    \newpage

.. _task-list-area:

Task list area
--------------

The task list area is composed with:

* :ref:`task-list` |one| 
* :ref:`progress-data-view` |two|

.. figure:: /images/GUI/planning2.png
   :alt: Task list & progress data view
   :align: center

   Task list & progress data view



.. _task-list:

Task List
_________

The task list displays the planning elements in hierarchical form by dividing the WBS. (See: :ref:`wbs`).

Tasks are regrouped by projects and activities.

.. rubric:: Projects displayed

* The projects displayed depend on the selection made with **the project selector** (See: :ref:`top-bar`)


.. figure:: /images/GUI/ZONE_GanttTaskList1.png
   :alt: Task list & progress data view
   :align: center

   Task list & progress data view

.. rubric:: |one| Hide all activities

show or hide project activities

* Click on |minusButton| or |plusButton| to enlarge or reduce all groups of projects at the same time

.. rubric:: |two| Icon of element

A specific icon appears to the left of each item type for faster identification.

* |iconProject16| Projet Icon
* |iconReplan16| project to recalculate (the Gant diagramm to display with the latest settings) 
* |iconActivity16| Activity
* |iconMilestone16| Milestone
* |iconMeeting16| Meeting
* |iconTestSession16| Test session

Other items can be displayed in the :ref:`gantt-planning` (action, decision, delivery...)

.. rubric:: |three| Hide activities

* Click on |minusButton| or |plusButton| on the group line to enlarge or reduce the group only.


.. rubric:: |four| Show WBS

* Click on "Show WBS" to display the WBS number before the names. (see: :ref:`wbs`)

.. figure:: /images/GUI/TaskWBS-With.png
   :alt: Task list with WBS display
   :align: left
   
   Task list with WBS Display

.. figure:: /images/GUI/TaskWBS-Without.png
   :alt: Task list without WBS display
   :align: center
   
   Task list without WBS Display

.. rubric:: |five| Item name 

* Click on a line to display the detail of the item in the detail area.

.. rubric:: |six| Checkbox "Show closed items"

* Flag on "Show closed items" allows to list closed items.


.. raw:: latex

    \newpage


.. _progress-data-view:

Progress data view
__________________

The progress data view allows to show progress on project elements.
to display the progress columns, pull the splitter to the right.

For each planning element, the progress data are displayed at them right.


.. figure:: /images/GUI/Zone_ProjectDATAView.PNG
   :alt: Progress data view
   :align: center

   Progress data view

.. rubric:: |one| Group row

* The group row has a gray background.
* Used to display consolidated progress data by tasks.

.. rubric:: |two| Task row

* The task row has a white background.
* Used to display task progress data.

.. note:: **create a new item**

   * Each new element |createNewItem| will be placed below the selected line in the "task" column after it is created.
   
   * If this item is "new project" and you have selected a line activity. The new element will automatically be a project subproject of the activity in question
   
   * If no line is selected, the new item will move to the end of the task list

.. rubric:: |three| Define the columns of progress data that will be displayed

* Click on |buttonIconColumn| to define the columns displayed.

* Use checkboxes to select or unselect columns to display.

* Use the |IconDragBLC| to reorder columns with drag & drop feature.
   
* Click on **OK** button to apply changes.
   

.. figure:: /images/GUI/TIP_GanttSelectColunmsToDisplay.png
   :alt: Popup list - Select columns
   :align: center

   Popup list - Select columns
   
 
.. rubric:: |three| Area splitter

The splitter is used to show or hide the progress data view.

.. note::

   * The progress data view is hidden by default.
   * Move the splitter on your right to display them.

.. raw:: latex

    \newpage


.. _gantt-chart-view:

Gantt chart view
----------------

The Gantt chart view is a graphical representation of the progress data of a project. 
For each planning element, a bar is associated with it

.. figure:: /images/GUI/ZONE_GanttChartView1.png 
   :alt: Gantt chart view
   :align: center

   Gantt chart view

.. rubric:: |one| Scale

* Scale available: daily, weekly, monthly and quarter
* The Gantt chart view will be adjusted according to scale selected.

.. rubric:: |two| Display from... to... 

* Change the start and / or end date to limit or extend the display of a Gantt Chart.

.. rubric:: |three| Saving dates and All the projet

* Save your dates to retrieve them on every connection.
* Check **"All the project"** for the gantt chart to show all project tasks when possible.
* If the display is truncated because the project is too long, think to change the display scale.

.. raw:: latex

    \newpage

.. rubric:: |four| Gantt bars

* The bars displayed in the gantt chart can appear with different colors. Each color has a meaning.

.. compound:: **LIGHTER BAR**

.. figure:: /images/GanttBar_PaleGreen.png 
   :alt: Without assigned work
   :align: left
   :height: 20px
   :width: 80 px

.. describe:: Condition
   Activities without assigned work
   pale red or pale green as appropriate

.. compound:: **GREEN BAR : all is well**

.. figure:: /images/GanttBar_Green.png 
   :alt: all is well
   :align: left
   :height: 20px
   :width: 80 px

.. describe:: Condition
   Assigned resources are available and meet workload, validated or scheduled dates do not conflict with other items.

.. compound:: **RED BAR : Overdue tasks**

.. figure:: /images/GanttBar_Red.png 
   :alt: Overdue tasks
   :align: left
   :height: 20px
   :width: 80 px

.. describe:: Condition
   Planned end date > Validated end date
   Real end date if completed task > Valited end date

.. compound:: **PURPLE BAR : impossible to calculate the remaining work** 

.. figure:: /images/GanttBar_Purple.png 
   :alt: Impossible to calculate
   :align: left
   :height: 20px
   :width: 80 px

.. describe:: Condition
   the remaining work on the task can't be planned.
   
.. note:: example 

   When a resource is assigned to a task over a defined period of time, and the task requests a higher workload than the resource can provide,
   or if the resource is unavailable for the assigned task then the bar becomes purple.

.. compound:: **REAL WORK IN PROGRESS**

.. figure:: /images/GanttBar_GreenWork.png 
   :alt: Work in progress
   :align: left
   :height: 20px
   :width: 80 px

.. describe:: Condition
   The line appears in the bar when real work is filled   
   it shows the percentage of actual progress
   
.. note:: its length represents the percentage of completion based on the actual progress versus the length of the Gantt bar.

.. compound:: **CONSOLIDATION BAR**

    .. image:: /images/ganttConsolidationBar.png
       :alt: consolidation bar
       :align: left
       :height: 20 px
       :width: 160 px
 
.. describe:: Condition
   Graphic display of consolidated dates for planning elements group
     
.. note:: Displayed at group row level.
   Start with the smallest start date and end with the biggest end date, either with planned or real dates.


.. note:: 
   .. figure:: /images/Gantt_DisplayDates.png 
      :alt: View the item name and scheduled dates on the selected bar
      :align: center
      
   Move the cursor over the bar to display item name and planned dates.   


.. rubric:: |five| Dependency links

* Dependencies between planning elements are displayed with an arrow.

* To modify dependency link, click on dependency to displays a pop-up

.. figure:: /images/GUI/dependencies.png
   :alt: update dependency pop-up

**3 dependency types are managed:**

* **End-Start:** The second activity can not start before the end of the first activity.
* **Start-Start:** the successor can not begin before the beginning of the predecessor. Anyway, the successor can begin after the beginning of the predecessor.
* **End-End:** The successor should not end after the end of the predecessor, which leads to planning "as late as possible". Anyway, the successor can end before the predecessor. Note that the successor "should" not end after the end of predecessor, but in some cases this will not be respected:

  * if the resource is already 100% used until the end of the successor
  * if the successor has another predecessor of type "End-Start" or "Start-Start" and the remaining time is not enough to complete the task
  * if the delay from the planning start date does not allow to complete the task
 
.. note:: Update Pop-up 

     * Right click on a dependency link (when its color is orange) will show update pop-up
     * You can modify the delay, add a comment or remove the dependency.

.. note:: Graphical add dependency

     * You can easily add a dependency with drag and drop from predecessor bar to successor bar
     * These dependencies are always End-Start, but you can change their type afterwards


.. raw:: latex

    \newpage

.. rubric:: |six| Milestone

* Milestones appear as small diamonds. Filled if completed, empty otherwise.
* Color of  diamond depends on milestone progress.

.. compound:: **Ongoing milestone and in times**

   .. image:: /images/ganttGreenMilestone.png
      :alt: ongoing milestone and in times

.. compound:: **Completed milestone and in times**

   .. image:: /images/ganttFilledGreenMilestone.png
      :alt: completed milestone and in times

.. compound:: **Ongoing milestone and delayed**
Planned end date > Validate end date

.. image:: /images/ganttRedMilestone.png
      :alt: ongoing milestone and delayed

.. compound:: **Completed milestone and delayed**
Real end date > Validated end date

.. image:: /images/ganttFilledRedMilestone.png
      :alt: completed milestone and delayed


.. rubric:: |seven| Show resources 

* Click on “Show resources” to display resources assigned to tasks.

.. figure:: /images/Gantt_Initiales.png
   :alt: Show the ressources with initials
   :align: left
   :height: 110px
   
   Display with initials 
   
.. figure:: /images/Gantt_Name.png
   :alt: Show the ressources with name
   :align: center
   :height: 110px
   
   Display with name

.. topic:: Global parameter > Work Tab >Planning Section > "Show resource on the Gantt"
   This parameter defines the option availability and whether the resource name or initial is displayed.
   
   
.. rubric:: |eight| Current date

.. figure:: /images/Gantt_YellowBar.png
   :align: left
   :height: 40px
   
* Yellow column indicates the current day, week, month or quarter, according to scale selected.
* The red line in yellow collumn display the current day and time.

.. rubric:: |nine| Detail of the work

* Right click on a bar to displays the detail of the work for this bar.

.. figure:: /images/GUI/gantressources.png 
   :alt: Popup menu - Create a new item
   :align: center 

.. Warning:: 

   You have to selected week or day scale to display detail or a message will ask you to switch to smaller scale.

.. rubric:: |ten| Miscellaneous

* On "floating" elements (floating milestone, fixed duration activity) without predecessor, set the planned start date to the validated start date

.. raw:: latex

    \newpage

.. index:: ! Project planning

.. _project-planning:

Project planning
----------------

Project planning and activity planning calculation can be done in the Gantt.



.. figure:: /images/GUI/Gantt_ProjectPlanning.png 
   :alt: Project planning
   :align: center

   Project planning 

.. rubric:: |one| Add a new planning element

* Allows to create a new planning element.
* The created element is added in the Gantt and detail window is opened.
* The detail window allows to complete entry.

.. figure:: /images/GUI/TIP_CreateNewItem.png
   :alt: Popup menu - Create a new item
   :align: center


   Popup menu - Create a new item

.. note:: Planning elements management
  
   * Planning elements can be managed with their own dedicated screen.
   * Test session and Meeting elements can be added to the planning with their own dedicated screen.  

.. rubric:: 2 - Reorder planning elements

* The selector |buttonIconDrag| allows to reorder the planning elements.
 Ability to move multiple tasks at one time from one location to another using the key control to select the lines and then dragging and dropping them.


.. rubric:: 3 - Indenting element

* Click on an element, the detail window will be displayed.
* Two new buttons are displayed in the header, they allow to increase or decrease indent of an element.

 .. compound:: **Increase indent**

    * The element will become the child of the previous element.

 .. compound:: **Decrease indent**

    * The element will be moved at the same level than the previous element.


.. rubric:: 4 - Dependency links

* To create a dependency link, clicked and hold on a graphic element, the mouse cursor changes to |dndLink|.
* Move mouse cursor on graphic element that will be linked and release the button.

 .. note:: Dependency links management
  
    * Dependency links can be managed in element screen. 
    * See: :ref:`predSuces-element-section`.


.. rubric:: 5 - Activity planning calculation

* Click on |calculatePlanning| to start the activity planning calculation.

 .. compound:: **Automatic run plan**

    * Check the box to activate automatic calculation on each change.

.. raw:: latex

    \newpage
    

.. note::
    
   * All modifications about assignement (rate, name or numbers of resources, dates...) done are not displayed on the new planning screen until having, for this purpose, activited the planning calculation, either in an automatic run plan or not.
     On the contrary, the screen planning will not change even if modifications have been loaded yet.

 .. compound:: **Automatic calculation **

  *  Differential calculation = calculation of projects that require a recalculation.
  * Complete calculation = calculation of all projects

The calculations are programmed according to a frequency of CRON type (every minute, every hour, at a given hour every day, at a given time on a given week day, ...)

.. rubric:: 6 - Store planned dates

* Allows to store planned dates into requested and validated dates.
* In other words, this feature allows to set baseline dates and preliminary dates from calculated planning.

 .. compound:: **Action available**

    * **Always:** Always overwrite existing values.
    * **If empty:** Store only if the value is empty.
    * **Never:** Values are not stored.
  

.. figure:: /images/GUI/BOX_StorePlannedDates.png
   :alt: Dialog box - Store planned dates
   :align: center

.. raw:: latex

    \newpage


.. _gantt-planning:

Planning global
===============

The global planning allows to visualize any type of object (project, activity, milestones, risk, meeting ...)

* Add and Show any new planning element on Gantt chart
* The created item is added in the Gantt and detail window is opened.
* The detail window allows to complete entry
* Project planning and activity planning calculation can be done in the Gantt.

.. figure:: /images/GUI/PlanningElement.png
   :alt: Popup menu - Create a new item
   :align: center



.. index:: ! Gantt chart (Projects portfolio)

Projects portfolio
==================

This screen displays Gantt chart from projects portfolio point of view.

It displays projects synthesis and project's dependencies, without project activities.

.. note::

   * This section describes specific behavior for this screen.
   * All others behaviors are similar to :ref:`gantt-planning` screen.


.. figure:: /images/GUI/screenshot169.png 
   :alt: Gantt (Projects portfolio)
   :align: center

   Gantt (Projects portfolio) 

.. rubric:: 1 - Show milestones

* It is possible to define whether milestones are displayed or not.
* If they are displayed, then It is possible to define the type of milestone to be displayed or displayed all. 



.. raw:: latex

    \newpage

.. index:: ! Gantt chart (Resource planning)

Resource Planning
=================

This screen displays Gantt chart from the resources point of view.

Assigned tasks are grouped under resource level.

On resource planning, group periodic meetings is under its parent

.. rubric:: Gantt bars

* For activities, the Gantt bar is split in two: 

  * Real work in grey.
  * Reassessed work in green.

 .. hint::

    * This makes appear some planning gap between started work and reassessed work.

.. rubric:: Dependencies behavior

* Links between activities are displayed only in the resource group. 
* Links existing between tasks on different resources are not displayed.

.. note::

   * This section describes specific behavior for this screen.
   * All others behaviors are similar to :ref:`gantt-planning` screen.


.. figure:: /images/GUI/screenshot171.png 
   :alt: Gantt (Resource planning) 
   :align: center

   Gantt (Resource planning)


.. rubric:: |one| - Show project level  

* Tasks can be grouped by project.
* Click on “Show project level” to display project level.

.. rubric:: |added| - show activities without work
* Ability to display assigned activities with zero work 


.. rubric:: |two| - Show left work 

* Left work can be displayed at right from Gantt bar.
* Click on “Show left work” to display left work for each item.

.. rubric:: |three| - Limit display to selected ressource or team 

* Click and select one ressource to display only his data.
* Click and select one team to display only data of resources of this team.





.. raw:: latex

    \newpage

.. _export-Gantt-PDF:

Export planning to PDF
======================

Allows to export planning to PDF format.

Export contains all details and links between tasks.

.. figure:: /images/GUI/BOX_ExportPlanningPDF.png
   :alt: Dialog box - Export planning to PDF
   :align: center


.. tabularcolumns:: |l|l|

.. list-table:: Fields - Export planning to PDF dialog box
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Orientation
     - Page orientation.
   * - Zoom
     - Allows to fit planning on page.
   * - Repeat headers
     - Planning can be  span multiple pages.

.. note:: Technical points

   * This new feature will execute export on client side, in your browser.
   * Thus the server will not be *heavy loaded* like *standard* PDF export does.
   * It is highly faster than *standard* PDF export.
   * Therefore, this feature is hightly dependant to browser compatibility.
   
.. note:: Browser compatibility

   * This new feature is technically complex and it is not compatible with all browsers.
   * Compatible with IE11, Firefox, Edge and Chrome.
   * Else, the old export feature will be used.

.. note:: Forced feature activation (deactivation)

   * To enable this feature for all browsers, add the parameter **$pdfPlanningBeta='true';** in parameters.php file.
   * To disable if for all brosers (including Chrome), add the parameter **$pdfPlanningBeta='false';**
   * Default (when **$pdfPlanningBeta** parameter is not set) is *enabled with Chrome, disabled with other browsers* 

