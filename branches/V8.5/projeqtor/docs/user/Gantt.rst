.. include:: ImageReplacement.txt

.. title:: Planning

.. index:: Planning

.. index:: Gantt chart



Planning
********

The Gantt chart is a tool used in scheduling and project management and allowing to visualize in time the various tasks composing a project.

It is a representation of a connected graph, evaluated and oriented, which makes it possible to graphically represent the progress of the project


.. _Gantt_chart:

Gantt chart
-----------

This screen allows to define projects planning and follow progress.

**The Gantt Chart is composed of five areas:**
  

.. figure:: /images/GUI/GANTT_ZONE_Planning.png 
   :alt: Gantt (Planning)
   :align: center

   Gantt (Planning)



.. topic:: Interface areas:

   |one| :ref:`Toolbar-Gantt`
         
   |two| :ref:`task-list`
   
   |three| :ref:`progress-data-view`
   
   |four| :ref:`gantt-chart-view`
   
   |five| :ref:`gantt-details-area`








.. raw:: latex

    \newpage

.. _Toolbar-Gantt:

Toolbar
=======


.. figure:: /images/GUI/GANTT_ZONE_Toolbar.png
   :alt: Gantt chart's toolbar 
   
   Gantt chart's toolbar


.. topic:: Interface areas

   |one| :ref:`Critical path<critical-path>`
   
   |two| :ref:`Activity planning calculation<ActivityPlanningCalculation>`
   
   |three| :ref:`Display from... to... <display-from>`
   
   |four| :ref:`Planning validation<planning-validation>`
   
   |five| :ref:`Save and show baseline<save-baseline>`
   
   |six| :ref:`Print and Export<print-export-gantt>`
   
   |seven| :ref:`Create a new planning element<new-element-gantt>`
   
   |eight| :ref:`Advanced filter<advanced-filter-gantt>`
   
   |nine| :ref:`Display the columns<displayed-columns-gantt>`
   
   |ten| :ref:`The checkbox<checkbox-gantt>`   
   
   
   
   



.. _critical-path:

.. rubric:: |oneBLC| Show Critical path

**The critical path** allows you to determine the total duration of your project. This is the longest sequence of tasks that must be completed for the project to be completed on time.

**The Critical Chain**, meanwhile, is a technique for planning and monitoring deadlines but has the same principle: take into account the constraints to determine the duration of the project and the critical tasks that may impact this duration.
One of these constraints is the taking into account of resource or skill limitations in addition to the dependencies between the tasks and the implementation of buffers, i.e. time reserves, in the critical chain and the secondary chains.

ProjeQtOr offers you a critical chain rather than a critical path, but for better understanding, the term Critical path has been retained.

* click on the **critical path** check box to calculate and display the red path in the Gantt schedule.

.. figure:: /images/GUI/GANTT_ZONE_CriticalPath.png
   :alt: Critical Path
   :align: center
   
   The red net represents the critical path of the project. 

.. note::
   
   The tasks of the project which are not crossed by the critical path are elements which will not affect the duration of the project and, even modified, will not automatically involve a modification of this duration for the entire project.





.. _ActivityPlanningCalculation:

.. rubric:: |twoBLC| Activity planning calculation

Click on |calculatePlanning| to start the activity planning calculation.

A popup window appears with the list of projects. The check boxes allow you to select one or more projects to recalculate.



.. figure:: /images/GUI/GANTT_BOX_Calculation.png
   :alt: Project selection popUp for project calculation
   
   Project selection popUp for project calculation 


If you have selected one or more projects with :ref:`Project Selector<project-selector>` then the selected projects will be automatically checked.
   
Choose the date on which you want to recalculate the project. Whether in the past, today or in the future. 

By checking the "Hide unselected projects" box, you will only have the projects selected in the project selector and they will be automatically checked.



 .. compound:: Automatic run plan

  Check the box to activate automatic calculation on each change.
  
  .. Warning:: 

      Only works on the Gantt Planning view. If the modification of an element is carried out on the dedicated screen of the element, then it is necessary to click again on BUTTON to restart the computation

  
  .. note:: All modifications about assignement (rate, name or numbers of resources, dates...) done are not displayed on the new planning screen until having, for this purpose, activited the planning calculation, either in an automatic run plan or not.
  
      On the contrary, the screen planning will not change even if modifications have been loaded yet.




 .. compound:: Automatic calculation

  **Differential calculation =** calculation of projects that require a recalculation.
  
  **Complete calculation =** calculation of all projects

  
  The calculations are programmed according to a frequency of CRON type (every minute, every hour, at a given hour every day, at a given time on a given week day, ...)
  
  See: Global Parameters into the chapter :ref:`Automatic planning Calculation<automatic-planning-calcul>`







.. _display-from:

.. rubric:: |threeBLC| Display from... to... 

Change the start and / or end date to limit or extend the display of a Gantt Chart.

If the display is truncated because the project is too long, think to change the display scale.


  .. compound:: all the projet

   Check **All the project** for the Gantt chart to show all project tasks when possible.

  .. compound:: Saving dates  

   Save your dates of display to retrieve them on every connection.






.. _planning-validation:

.. rubric:: |fourBLC| Planning validation

Allows you to replace the validated dates with the planned dates.


.. figure:: /images/GUI/GANTT_BOX_StorePlannedDates.png
   :alt: Dialog box - Store planned dates
   :align: center

   Store planned dates

With this approach, you validate in a way any possible delay on the activities of your project.

Two actions are available: **Always** or if **empty**.


  .. compound:: Always

    will overwrite existing values.
    
    If values are entered in the "validated" fields then, they will all be replaced by the planned dates (calculated by the software)
    
  .. compound:: If empty
      
    will not overwrite existing values.  
    
    If the "validated" fields are not completed, then these dates will be replaced by the planned dates.
    
    If the "validated" fields are completed then they will be kept.
    
    







.. _save-baseline:

.. rubric:: |fiveBLC| Save and show baseline

The baseline is a record of the planning state at a time T.


.. figure:: /images/GUI/GANTT_ZONE_Baseline.png
   :alt: Save a baseline
   
   Save a baseline
  
You can create as many baselines as you want per day, but you can only save one baseline per day. Each new baseline must replace the previous one.
  
  
  .. compound:: Save baseline
  
   Saved a baseline with the button |storePlannedDates|. 
   
   Enter the project on which to create the baseline. The list of existing baselines, already registered, is available via this window. You can modify your baseline or delete it to save another one.
  
   .. figure:: /images/GUI/GANTT_BOX_Baseline.png
      :alt: Record baseline
   
      Record baseline





  .. compound:: Show baseline
  
   You can display two baselines at the same time. The one above the current activity bars of your project. The other below.
   
   Each of them has a different color, pale blue for the top line and pale purple for the bottom line
   
   .. figure:: /images/GUI/GANTT_ZONE_Baseline.png
      :alt: Display two baselines
      
      Display two baselines
      

   This option will be very useful for you to compare possible drifts and explain them. 





.. _print-export-gantt:

.. rubric:: |sixBLC| Print and Export the Gantt chart

You can print directly on your printer or export in PDF format or in MS Project format





  .. compound:: Print planning

   Click on the button |buttonIconPrint| to print the Gantt chart in A4 and / or A3 format.

   The print quality, despite printing or exporting on a reduced scale, remains very qualitative and offers very little loss of detail in the diagram.






  .. compound:: Export planning to PDF

   Allows to export planning to PDF format.
   Export can be done horizontally (landscape) or vertically (portrait) in A4 and / or A3 format
   with great detail even with a zoom

   Export contains all details and links between tasks and also include a pagination.
   
   And the option **Repeat Headers** allow you to print or export your planning in multiple pages
   
   .. figure:: /images/GUI/GANTT_BOX_ExportPlanningPDF.png
      :alt: Dialog box - Export planning to PDF
      :align: center

      Export planning to PDF


   This feature will execute export on client side, in your browser. Thus the server will not be heavy loaded like standard PDF export does.
   
   It is highly faster than standard PDF export.

   .. warning:: 
   
      This technically complex feature is highly dependent on the browser and is not compatible with all of them.
      It is compatible with the latest versions of IE (v11), Firefox, Edge and Chrome. Otherwise, the old export function will be used.
   
   .. tip:: 

      **Forced feature activation/deactivation**
      
      * To enable this feature for all browsers, add the parameter **$pdfPlanningBeta='true';** in parameters.php file.
      * To disable if for all browsers, add the parameter **$pdfPlanningBeta='false';** 
        Default (when **$pdfPlanningBeta** parameter is not set) is *enabled with Chrome, disabled with other browsers* 


  .. index:: Export to MS Project

  .. compound:: Export planning to MS Project

   You have the option of exporting XML in MS Project. 

   Click on the button |msProject| to start the export. 


   A **user parameter** allows you to enter if you want to add the assignments when exporting the project to MS-Project format.

   If not, the name of the resources will not be available in the MS-Project application   
   
   See: User Parameters into the chapter :ref:`UP-print-export` 
     







.. _new-element-gantt:

.. rubric:: |sevenBLC| Add a new planning element

* Allows you to create a new planning element.
* The element is then added under the previously selected element and with the same level of incrementation
* The element is added to the Gantt chart and the detail area adapts to the content created.
* The details area allows you to complete the entry.

.. figure:: /images/GUI/GANTT_TIP_CreateNewItem.png
   :alt: Popup menu - Create a new item
   :align: center

   Popup menu - Create a new item

You can create several elements on the planning view and more on to the :ref:`Global planning<gantt-planning>`.









.. _advanced-filter-gantt:

.. rubric:: |eightBLC| Advanced Filter

The advanced filter allows to define clause to filter and sort.

For more explanation and understanding of the mechanism of advanced filters, 
see the chapter on :ref:`filters<advanced-filter>` in the graphical user interface.







.. _displayed-columns-gantt:

.. rubric:: |nineBLC| Displayed columns

This functionality allows to define columns displayed in the list  for this element.

For more explanation and understanding of the mechanism of advanced filters, 

see the chapter on :ref:`Display the columns<displayed-columns>` in the graphical user interface.




.. _checkbox-gantt:

.. rubric:: |tenBLC| Checkbox for display

At the end of the first zone, you have the choice to display or not, certain information on the Gantt chart.

  .. compound:: Show WBS
  
   Click on "Show WBS" to display the :term:`WBS` number before the names.

   .. figure:: /images/GUI/GANTT_ZONE_TaskWBS.PNG
      :alt: Task list with WBS display
      
      Task list without and with WBS Display


  .. compound:: Closed 
  
   Flag on "Show closed items" allows to list closed items.
   
   
  .. compound:: Resource
  
   The Resource checkbox allows you to directly display the resources assigned to each activity on the Gantt chart.

   .. figure:: /images/GUI/GANTT_ZONE_ShowResourceInitials.png
      :alt: Display of initials
      
      Display of initials

   .. figure:: /images/GUI/GANTT_ZONE_ShowResourceName.png
      :alt: Display of initials
      
      Display of name
      
      
   A user parameter allows you to choose between displaying names or initials.

   Choose if you want names, initials or nothing to appear on the Gantt chart.
   
   See: :ref:`display-parameters`
   
   
   .. figure:: /images/GUI/GANTT_ZONE_ParamInitiales.png
      :alt: setting the display of resources
      
      Setting the display of resources
      
      









.. _task-list:

Task List
=========

The task list displays the planning elements in hierarchical form by dividing the :term:`WBS`.

Tasks are regrouped by projects and activities.

The projects displayed depend on the selection made with **the project selector** 

See: :ref:`Project selector<project-selector>`


.. figure:: /images/GUI/GANTT_ZONE_TaskList.png
   :alt: Task list & progress data view
   :align: center

   Task list & progress data view


.. topic:: Interface areas:

   |one| |two|:ref:`Hide activities<hide-activity>`
         
   |three| :ref:`Icon of element<icon-element>`
      
   |four| :ref:`Reorder Planning elements<reorderPlanning>`
   
   |five| :ref:`Names of the items<item-name>`
   
   |six| :ref:`Increase and decrease indent level<increase-decrease-indent>`






.. _hide-activity:

.. rubric:: |oneBLC| and |twoBLC| Hide activities

Show or hide project activities. Click on |minusButton| or |plusButton|  

      * Click on the icons at the top of the list |one| to enlarge or reduce all groups of projects at the same time
      
      * Click on the group line |two| to enlarge or reduce the group only 




.. _icon-element:
            
.. rubric:: |threeBLC| Icon of element

A specific icon appears to the left of each item type for faster identification.

* |iconProject16| Project
* |iconReplan16| Project to recalculate (the Gant diagramm to display with the latest settings) 
* |construction| Project under construction
* |fixPlann| Projet fixed in the planning
* |iconActivity16| Activity
* |iconMilestone16| Milestone
* |iconMeeting16| Meeting
* |iconTestSession16| Test session


Other items can be displayed in the :ref:`gantt-planning` (action, decision, delivery...)




.. _reorderPlanning:

.. rubric:: |fourBLC| Reorder planning elements

The selector |buttonIconDrag| allows to reorder the planning elements.

.. note:: 

   Ability to move multiple tasks at one time from one location to another using the key control to select the lines and then dragging and dropping them.









.. _item-name:

.. rubric:: |fiveBLC| Item name 

Click on a line to display the detail of the item in the detail area.

.. _show-closed-item:





.. _increase-decrease-indent:

.. rubric:: |sixBLC| Increase and decrease indent level

Increase and decrease indent level

.. figure:: /images/GUI/GANTT_Button_Indent.png
   :alt: Indentation
   
   Indentation buttons


.. compound:: **Increase indent**
   
   The element will become the child of the previous element.
   
.. compound:: **Decrease indent**
   
   The element will be moved at the same level than the previous element.
   
     






.. raw:: latex

    \newpage


.. _progress-data-view:

Progress data view
==================

The progress data view allows to show progress on project elements.
to display the progress columns, pull the splitter to the right.

For each planning element, the progress data are displayed at them right.


.. figure:: /images/GUI/GANTT_ZONE_ProjectDATAView.png
   :alt: Progress data view
   :align: center

   Progress data view
   
.. topic:: Interface areas   

   |one| :ref:`Project group line<project-group-line>`
   
   |two| :ref:`Task row<task-row>` 
   
   |three| :ref:`The columns of datas<columns-datas>`


.. _project-group-line:

.. rubric:: |oneBLC| Project group line

* The project and sub-project lines have a gray background.
* Used to display consolidated progress data by the tasks.


.. _task-row:

.. rubric:: |twoBLC| Task row

* The task row has a white background.
* Used to display task progress data.


.. _columns-datas:

.. rubric:: |threeBLC| The columns of datas

* Click on |buttonIconColumn| to define the columns displayed.

* Use checkboxes to select or unselect columns to display.

* Use the |IconDragBLC| to reorder columns with drag & drop feature.
   
* Click on **OK** button to apply changes.
   


For more explanations and understanding of the mechanism on the display of columns, 

see the chapter on :ref:`Display the columns<displayed-columns>` in the graphical user interface.







.. _gantt-chart-view:

Gantt chart view
================

The Gantt chart view is a graphical representation of the progress data of a project. 

For each planning element, a bar is associated with it

.. figure:: /images/GUI/GANTT_ZONE_ChartView.png
   :alt: Gantt chart view
   :align: center

   Gantt chart view
   
   
   
.. topic:: Interface areas

   |one| :ref:`Scale<scale-gantt>`
   
   |two| :ref:`The Gantt chart's Bars<gantt-bars>`
   
   |three| :ref:`Dependencies<dependency-links>`
   
   |four| :ref:`Milestone<milestones-gantt>`
   
   |five| :ref:`Detail of the work<detail-work>`   






.. _scale-gantt:

.. rubric:: |oneBLC| Scale

Scale available: daily, weekly, monthly and quarter

The Gantt chart view will be adjusted according to scale selected.






.. _gantt-bars:

.. rubric:: |twoBLC| Gantt chart's bars

The bars displayed in the gantt chart can appear with different colors. Each color has a meaning.

  .. compound:: Current date Bar

   .. figure:: /images/GUI/GANTT_BAR_YellowBar.png 
      :alt: Current date bar
      :figwidth: 100% 
      :align: left
      
      Current date bar
      
  
   Yellow column indicates the current day, week, month or quarter, according to scale selected.

   The red line in yellow collumn display the current day and time.


  .. compound:: PALE GREEN OR RED BAR

   .. figure:: /images/GUI/GANTT_BAR_PaleGreen.png 
      :alt: Without assigned work
      :figwidth: 100% 
      :align: left
      
      no charge
      
   
   Condition : Activities without assigned work - pale red or pale green as appropriate




  .. compound:: GREEN BAR

   .. figure:: /images/GUI/GANTT_BAR_Green.png 
      :alt: all is well
      :figwidth: 100% 
      :align: left
      
      all is well
      
   Condition : Assigned resources are available and meet workload, validated or scheduled dates do not conflict with other items   



  .. compound:: RED BAR

   .. figure:: /images/GUI/GANTT_BAR_Red.png 
      :alt: Overdue tasks
      :figwidth: 100% 
      :align: left

      Overdue tasks


   Condition: Planned end date > Validated end date - Real end date if completed task > Valited end date



  .. compound:: PURPLE BAR

   .. figure:: /images/GUI/GANTT_BAR_Purple.png 
      :alt: Impossible to calculate
      :figwidth: 100% 
      :align: left
      
      Impossible to calculate the remaining work

   Condition: If a resource is not or is no longer available on an activity.

   The calculator is trying to plan the workload. The resource assigned to the activity is unable to be planned for this task (absence, calendar, assignment or assignment periods, etc.); then the bar turns purple.
   


  .. compound:: SURBOOKING BAR
  
   .. figure:: /images/GUI/GANTT_BAR_Yellow.png
      :alt: Surbooking
      :figwidth: 100% 
      :align: left      

      Resource capacity overbooking

   Condition: Add extra work time on the standard capabilities of your resources to plan more projects that you will not process.
   
   For more information see: :ref:`surbooking`



  .. compound:: SURCAPACITY BAR

   .. figure:: /images/GUI/GANTT_BAR_Surcapacity.PNG 
      :alt: Surcapacity
      :figwidth: 100% 
      :align: left
      
      Overcapacity of resources

   Condition: The capacity of the resource has been changed. It can be under capacity or over capacity. That is to say, it does less or more than its FTE.
   
   For more information see: :ref:`variation-capacity`




  .. compound:: REAL WORK IN PROGRESS

   .. figure:: /images/GUI/GANTT_BAR_GreenWork.png 
      :alt: Work in progress
      :figwidth: 100% 
      :align: left
      
      Work in progress

   Condition: the length represents the percentage of completion based on the actual progress versus the length of the Gantt bar.
   



  .. compound:: CONSOLIDATION BAR

   .. figure:: /images/GUI/GANTT_BAR_Consolidation.png
      :alt: consolidation bar
      :figwidth: 100% 
      :align: left
      
      Consolidation Bar
 
   Condition: graphical display of the dates consolidated by the group of planning elements for a project
     


   .. figure:: /images/GUI/GANTT_ZONE_DisplayDates.png 
      :alt: View the item name and scheduled dates on the selected bar
      :figwidth: 100% 
      :align: left
      
      item name and scheduled dates on the selected bar
      
   Move the cursor over the bar to display item name and planned dates.   










.. index:: Dependency Links

.. _dependency-links:

.. rubric:: |threeBLC| Dependency links

Dependencies allow to define the execution order of tasks (sequential or concurrent).

All planning elements can be linked to others.

Dependencies can be managed in the Gantt chart and in screen of planning element.

Dependencies between planning elements are displayed with an arrow.


 .. compound:: Create a dependency

   To create a dependency, left click on a bar of the gantt (the predecessor) and slide towards the successor.
   
   You can also create dependencies with the predecessor and successor tables at the bottom of the details area. 
   
   Remember than the first task always drives the second.


   .. figure:: /images/GUI/COMMON_ZONE_Success&Predecessor.png
      :alt: Predecessor and Successor section
   
      Predecessor and Successor section - In the NAME field, icons are displayed to indicate the type of dependencies


   * Click on |buttonAdd| on the corresponding section to add a dependency link.
   * Click on |buttonEdit| to edit the dependency link.
   * Click on |buttonIconDelete| to delete the corresponding dependency link. 

   .. figure:: /images/GUI/COMMON_BOX_Success&Predecessor.png
      :alt: Dialog box - Predecessor or Successor element
      :scale: 80%

      Dialog box - Predecessor or Successor element

   
   
     
   


 .. compound:: Modify a dependency
    
   Click on the arrow which turns orange, a pop up is displayed allowing you to modify the type and one to add a possible delay.
   
   The delay can be positive or negative. Negative delay allows overlapping of certain tasks

   See the strict mode of dependencies


   .. figure:: /images/GUI/GANTT_BOX_dependencies.png
      :alt: update dependency pop-up
      
      Dependencies dialog box
      
      

 .. compound:: Dependency types

  .. compound:: |iconES| End-Start 
  
    The second activity can not start before the end of the first activity.

  .. compound:: |iconSS| Start-Start
  
    The successor can not begin before the beginning of the predecessor. Anyway, the successor can begin after the beginning of the predecessor.

  .. compound:: |iconEE| End-End
  
    The successor should not end after the end of the predecessor, which leads to planning "as late as possible". 
    
    Anyway, the successor can end before the predecessor. Note that the successor "should" not end after the end of predecessor, but in some cases this will not be respected:
    
    * if the resource is already 100% used until the end of the successor
    * if the successor has another predecessor of type "End-Start" or "Start-Start" and the remaining time is not enough to complete the task
    * if the delay from the planning start date does not allow to complete the task
 


 .. compound:: Strict mode for dependencies

   ..figure:: /images/GUI/PARAMGLOB_ZONE_ModStrict.png
      :alt: Strict mode for dependencies 
      
      Strict mode for dependencies  
   
   The strict dependency mode is a global parameter in the work tab, planning section.

By default, the strict dependency mode is set to YES.

The strict dependency mode forces the successor planning element not to start on the same day as the same predecessor but the next day. Even if the task is finished before the end of the day.

To have the successor start on the same day or before the end of the predecessor task, select NO for strict mode or you can also put a negative delay.


     


.. index:: Milestone (Gantt chart)

.. _milestones-gantt:

.. rubric:: |fourBLC| Milestone

Milestones appear as small diamonds. Filled if completed, empty otherwise.

Color of  diamond depends on milestone progress.

.. compound:: **Ongoing milestone and in times**

   .. image:: /images/GUI/GANTT_ZONE_GreenMilestone.png
      :alt: ongoing milestone and in times

.. compound:: **Completed milestone and in times**

   .. image:: /images/GUI/GANTT_ZONE_FilledGreenMilestone.png
      :alt: completed milestone and in times

.. compound:: **Ongoing milestone and delayed**

Planned end date > Validate end date

.. image:: /images/GUI/GANTT_ZONE_RedMilestone.png
      :alt: ongoing milestone and delayed

.. compound:: **Completed milestone and delayed**

Real end date > Validated end date

.. image:: /images/GUI/GANTT_ZONE_FilledRedMilestone.png
      :alt: completed milestone and delayed







.. _real-work:

.. rubric:: |fiveBLC| Real work
   
   
   
   
.. _detail-work:
   
.. rubric:: |sixBLC| Detail of the work 

Right click on a bar to displays the detail of the work for this bar.

.. figure:: /images/GUI/GANTT_ZONE_Resources.png 
   :alt: Display details of the work
   :align: center
   
   Display details of the work


.. Warning:: 

   You have to selected week or day scale to display detail or a message will ask you to switch to smaller scale.





.. _gantt-details-area:

Details area
============

The details area is the same as on all the ProjeQtOr element screens and adapts according to the selected element.

For more details on this area, see the chapter :ref:`Details window<detail-window>` in the :ref:`graphic-user-interface`







.. _gantt-planning:

Planning global
---------------

.. figure:: /images/GUI/GANTT_ZONE_PlanningGlobal.png
   :alt: Global planning
   
   Global planning

The global planning allows to create and visualize any type of element (project, activity, milestones, risk, meeting, action ...)

* Add and Show any new planning element on Gantt chart
* The created item is added in the Gantt and detail window is opened.
* The detail window allows to complete entry
* Project planning and activity planning calculation can be done in the Gantt.

.. figure:: /images/GUI/GANTT_TIP_PlanningElement.png
   :alt: Create a new item
   :align: center

   Create a new item

.. index:: Gantt chart (Projects portfolio)

Projects portfolio
------------------

This screen displays only the projects on the diagram. The activities and other elements that make up the schedule are hidden.

It displays summary and project dependencies only.

.. note::

   This section describes specific behavior for this screen.
   All others behaviors are similar to :ref:`gantt-planning` screen.


.. figure:: /images/GUI/GANTT_ZONE_PortfolioPlanning.png 
   :alt: Gantt (Projects portfolio)
   :align: center

   Gantt (Projects portfolio) 

.. rubric:: Show milestones

Ability to display milestones or not. 

If they are displayed, it is possible to define the type of milestone to display or to display them all. 

All milestones are available: deliverable, incoming, key date...



.. raw:: latex

    \newpage

.. index:: Gantt chart (Resource planning)

.. index:: Resource planning

.. _resource-planning:

Resource planning
-----------------

.. sidebar:: Others section 

   * :ref:`resource`
   
   
This screen displays the Gantt chart from a resource perspective.

The assigned tasks are grouped under the resource level.

Regarding resource planning, periodic group meetings are under his responsibility

Ability to view assigned activities without charge


.. figure:: /images/GUI/GANTT_SCR_ResourcePlanning.png 
   :alt: Gantt (Resource planning) 
   :align: center

   Gantt (Resource planning)  
   
   
.. topic:: Interface areas

   |one| :ref:`Show project level<project-level>`
   
   |two| :ref:`Gantt charts for resources<gantt-bars-resource>`
  
   |three| :ref:`Limit display<visibility-resource>`
   
   |four| :ref:`Activity without work<activity-without-work>`
   
   |five| :ref:`Show left work<show-left-work>`
   
   |six| :ref:`Add a new activity<add-new-activity>`
   
   |seven| :ref:`Advanced Filters<filter-resource-planning>`




.. _project-level:

.. rubric:: |oneBLC| Show project level  

Tasks are grouped by project.

Click "View Project Level" to view the projects on which resource activities depend.

Below the two views with and without "View Project Level" 

.. figure:: /images/GUI/GANTT_ZONE_ResourcesPlanning_with&without_PjtLVL.png 
   :alt: view with project levels (Resource planning) 

   view with project levels and without project levels
   
   
   
   
   
   
.. _gantt-bars-resource:

.. rubric:: |twoBLC| Gantt charts for resources
   
The remaining work can be displayed to the right of the Gantt bar..

Click “Show left work” to display or not the duration of the rest to be done.





.. _visibility-resource:

.. rubric:: |threeBLC| Limit display to selected ressource or team 

Click and select one ressource to display only his data.

Click and select one team to display only data of resources of this team.

Click and select one organization to display only data of resources of this organization.





.. _activity-without-work:

.. rubric:: |fourBLC| show activities without work

View activities without assigned workload.

These activities then appear in the list box and on the Gantt chart in light color, as for standard planning.

The software takes into account the validated dates for display on the diagram.







.. _show-left-work:  

.. rubric:: |fiveBLC| Show left work
  
The bars used in the Gantt chart for resources differ slightly from the standard planning bars.

.. figure:: /images/GUI/GANTT_ZONE_PlanningResource.png
   :alt: Work Bar
   :align: center
   
   Work bars
   
Most of the bars used in the Gantt chart are the same as for standard planning.

You will find their meaning in chapter 2 of the Gantt chart view: :ref:`Gantt chart’s bars<gantt-bars>`.


  .. compound:: GREY BAR

   .. figure:: /images/GUI/GANTT_BAR_Green.png 
      :alt: all is well
      :figwidth: 100% 
      :align: left
      
      all is well
      
   Condition : Assigned resources are available and meet workload, validated or scheduled dates do not conflict with other items   





Real work in grey.

Left work in green or in red. 

See: :ref:`Gantt Bars<gantt-bars>`

The gray bar in the middle graphically represents the actual percentage progress relative to the total duration of the activity 

.. note:: 

   This makes appear some planning gap between started work and reassessed work.

.. rubric:: Dependencies behavior

Links between activities are displayed only in the resource group. 

Links existing between tasks on different resources are not displayed.

.. note::

   This section describes specific behavior for this screen.
   
   All others behaviors are similar to :ref:`gantt-planning` screen.


  .. compound:: GREEN BAR

   .. figure:: /images/GUI/GANTT_BAR_Green.png 
      :alt: all is well
      :figwidth: 100% 
      :align: left
      
      all is well
      
   Condition : Assigned resources are available and meet workload, validated or scheduled dates do not conflict with other items.


.. _add-new-activity:

.. rubric:: |sixBLC| Add a new activity

Depending on your profile and your rights, you can add an activity directly in the schedule by resource.

You must select an existing activity to insert the new activity into the WBS structure. If no activity is selected, the "add new item" icon will be grayed out.

The new activity is automatically inserted after the selected activity. It is then created under the same project as the activity selected during creation.




.. _filter-resource-planning:

.. rubric:: |sevenBLC| Advanced filters

Click on the icon to define an advanced filter.

The advanced filter allows to define clause to filter and sort.

Fore more details, see :ref:`Advanced filters<advanced-filter>` in the :ref:`Graphical user interface section<graphic-user-interface>`
