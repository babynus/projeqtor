.. include:: ImageReplacement.txt

.. title:: Common sections

.. index:: Common sections

.. _common-sections:

Common sections
***************

Some sections are displayed on almost all screens in the detail area.

Those sections allows to set information or add information to an item of the element.

.. figure:: /images/GUI/COMMON_SCR_CommonSection.png
   :alt: A view of ProjeQtOr's global interface
   
   A view of ProjeQtOr's global interface



.. topic:: Interface areas:

   |one| :ref:`description-section`
   
   |two| :ref:`search-view-item` 
   
   |three| :ref:`treatment-section` 
   
   |four| :ref:`allocation-section`
   
   |five| :ref:`assignment-section`
   
   |six| :ref:`progress-section` 
   
   |seven| :ref:`display-sub-project-activity` 
   
   |eight| :ref:`predSuces-element-section`
   
   |nine| :ref:`linkelement-section`
   
   |ten| :ref:`attachment-section`
   
   |eleven| :ref:`note-section`
   

.. _description-section:

Description section
-------------------

This section allows to identify items of the element.


.. tabularcolumns:: |l|l|

.. list-table:: Allocation dialog box - Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id` 
     - unique id of the element
   * - |RequiredField| Resource
     - Resource list.
   * - |RequiredField| Profile
     - Profile list.
   * - Rate
     - Rate (in %) of the allocation to the project.
   * - Start date
     - Start date of allocation.
   * - End date
     - End date of allocation.
   * - Description
     - Complete description of the allocation.
   * - Closed
     - Flag to indicate that allocation in not active anymore, without deleting it.
     
     
     
.. raw:: latex

    \newpage


.. _search-view-item: 

Search view item
----------------

Most of the fields available for each element offer the possibility of having a search view and an accelerator to access other elements.

These are the icons |buttonIconSearch| and |iconGoto|

The GOTO icon allows you to access the page of the selected item. 

You will then be redirected to this element with the detail of the latter displayed. 

You can right click on the search icon, you will then have more search choices.

.. figure:: /images/GUI/COMMON_BOX_SearchPlus.png
   :alt: Right click on search icon
   
   Right click on the search icon
   

L'icone |view| vous permet de visualiser les détails de l'élément sélectionné parmi ceux existants dans un popup

L'icone |buttonIconSearch| vous permet de rechercher un élément parmi la liste des éléments sélectionnés

L'icône |buttonAdd| vous permet de créer un élément directement depuis n'importe quelle page

   
     
     
     
     
     
     
     
     
     
.. raw:: latex

    \newpage


.. _treatment-section: 

Treatment section
-----------------

This section contains information about item treatment.

Depending on the element, this section  may have a different name.


.. figure:: /images/GUI/COMMON_ZONE_TreatmentSection.png
   :alt: Example of presentation for the processing section 
   
   Example of presentation for the processing section for projects
   
.. rubric:: Treatment section for project
    
.. list-table::
   :header-rows: 1

   * - Field
     - Description
   * - Status 
     - Actual :term:`status` of the project.
   * - Health status 
     - Manual tracking status 
   * - Quality level 
     - Manual tracking status 
   * - Trend 
     - Manual tracking status 
   * - Overall progress  
     - Manual tracking status 
   * - Fix planning  
     - Fix the planning prevents it from being calculated when planning your projects 
   * - Non extendable project   
     - You can't add, delete or move to/from a element to this project
   * - Under construction 
     - The project has not started. You'll don't receive the alerts and email concerning him.
   * - Exclude from global plan 
     - Do not display the "unplannable" elements of this project in the overall planning view. This means that only "standard" planning elements will be displayed, with the exception of actions, decisions, deliveries ...  
   * - :term:`Handled`
     - Box checked indicates the ticket is taken over
   * - :term:`Done`
     - Box checked indicates the ticket has been treated
   * - :term:`Closed`
     - Box checked indicates the ticket is archived


.. rubric:: Treatment section for activity

.. list-table::
   :header-rows: 1

   * - Field
     - Description
   * - Parent activity  
     - Determines if the activity is the daughter of another activity.
   * - Status 
     - Actual :term:`status` of the project.
   * - :term:`Responsible`
     - The person working on the ticket     
   * - :term:`Handled`
     - Box checked indicates the ticket is taken over
   * - :term:`Done`
     - Box checked indicates the ticket has been treated
   * - :term:`Closed`
     - Box checked indicates the ticket is archived  



.. rubric:: Treatment section for tickets


.. list-table::
   :header-rows: 1

   * - Field
     - Description
   * - Planning activity  
     - Activity on which the load of ticket treatment was planned
   * - Resolution
     - Whether the ticket has been resolved or not. Several statuses (customizable) are available 
   * - Is a regression  
     - Indicates if the incident / bug designated by the ticket must be a regression
   * - Accountable   
     - Person for whom the ticket work is carried out
   * - :term:`Responsible`
     - The person working on the ticket
   * - Criticality    
     - Criticality for processing the ticket   
   * - Priority    
     - Priority for processing the ticket
   * - Due date   
     - Due date for the resolution of the ticket
   * - Work   
     - Estimated charge for ticket processing, actual work performed on the ticket (decremented from the estimated) and remaining work on this ticket
   * - Dispatch   
     - Click on the button to distribute the load to one or more resources
   * - Start work   
     - Click the button to start the stopwatch and record the working time automatically. Please note, if you exit the ticket screen, the stopwatch stops running. If you work in hours, it takes about 4 minutes to display
   * - :term:`Handled`
     - Box checked indicates the ticket is taken over
   * - :term:`Done`
     - Box checked indicates the ticket has been treated
   * - :term:`Closed`
     - Box checked indicates the ticket is archived     
   * - Solved
     - Box checked indicates the ticket is solved      
   * - Cancelled
     - Box checked indicates the ticket is cancelled       

     
.. raw:: latex

    \newpage

.. index:: Project Allocation, Allocation section

.. _allocation-section:

Allocations section
-------------------

.. figure:: /images/GUI/COMMON_ZONE_AllocationSection.png
   :alt: Allocation section
   
   Allocation section

This section allows to manage resource allocation to projects.


.. sidebar:: Concepts 

   * :ref:`profiles-definition`
   * :ref:`allocation-to-project`
   
   
.. list-table::
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the allocation.
   * - Resource
     - Name of the allocated resource.
   * - Profile
     - Selected profile.
   * - Start date
     - Start date of allocation.
   * - End date
     - End date of allocation.
   * - Rate
     - Allocation rate for the project (%).


.. rubric:: Allocation list management

* Click on |buttonAdd| to create a new allocation. 
* Click on |buttonEdit| to update an existing allocation.
* Click on |buttonIconDelete| to delete the corresponding allocation.
* Click on |iconSwitch| to replace resource on the corresponding allocation. 

  (See: :ref:`Replace resource on an allocation<replace-resource-allocation>`)

* The icon |closeIcon| indicates that allocation to project is closed.

.. note:: **Direct access to information**

   From project screen, click on the resource name to go directly to the selected resource.
   
   From resource screen, click the project name to go directly to the selected project.

.. _allocation-box:

.. figure:: /images/GUI/COMMON_BOX_Affectation.png
   :alt: Dialog box - Allocation
   :align: center
   
   Allocation dialog box

.. tabularcolumns:: |l|l|

.. list-table:: Allocation dialog box - Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - |RequiredField| Project
     - Project list.
   * - |RequiredField| Resource
     - Resource list.
   * - |RequiredField| Profile
     - Profile list.
   * - Rate
     - Rate (in %) of the allocation to the project.
   * - Start date
     - Start date of allocation.
   * - End date
     - End date of allocation.
   * - Description
     - Complete description of the allocation.
   * - Closed
     - Flag to indicate that allocation in not active anymore, without deleting it.

.. topic:: Fields Project & Resource
 
   If the allocation is done on the screen «Projects», the field «resource» will be selectable.
   
   If the allocation is done on the screens «Resources», «Contacts» or «Users», the field «project» will be selectable.

.. topic:: Field Resource

   This field can contain a list of users, resources or contacts according to which screen comes from project allocation.

.. topic:: Field Profile

   The user profile defined will be displayed first. 

.. topic:: Field Rate

   100% means a full time allocation.

.. note::
 
   Depending on which screen is used to manage project allocations, the behavior of fields will change. 



.. _replace-resource-allocation:

.. rubric:: Replace resource on an allocation

* This feature allows to replace a resource by another.
* All tasks assigned to old resource will be transferred to the new resource with assigned and left work.

.. note:: 

   Work done on tasks still belongs the old resource.

.. figure:: /images/GUI/COMMON_BOX_ReplaceAffectation.png
   :alt: Dialog box - Replace allocation 
   :align: center
   
   Replace allocation dialog box

.. tabularcolumns:: |l|l|

.. list-table:: Replace allocation dialog box - Required field |ReqFieldLegend| 
   :header-rows: 1

   * - Field
     - Description
   * - |RequiredField| Resource
     - Resource list.
   * - Capacity (FTE)
     - The capacity of the resource selected
   * - |RequiredField| Profile
     - Profile list.
   * - |RequiredField| Rate
     - Rate (in %) of the allocation to the project
   * - Start date
     - Start date of allocation
   * - End date
     - End date of allocation


.. topic:: Field Profile

   The user profile defined will be displayed first. 

.. topic:: Field Rate

   100% means a full time allocation.



.. raw:: latex

    \newpage

.. index:: Assigment section

.. _assignment-section:

Assignment section
------------------

This section allows to manage assignment of resources to tasks.

Assigning a resource to a task makes it possible to define its function on the latter and its daily cost, if defined during the creation of the resource.

.. figure:: /images/GUI/COMMON_ZONE_PageAssignment.png
   :alt: activity page with assigment

   Activity page with assigment

.. warning::
    * Only resources allocated to a project can be assigned to its tasks.
    * If real work exists for an assignment, it can not be deleted.
    * Basic, if an actual job exists for an assignment, it cannot be deleted.
    * Only a profile with the specific right "force deletions with real work" activated can delete an element with real work.
    
.. figure:: /images/GUI/COMMON_ZONE_AssignmentSection.PNG
   :alt: assignment section
   
   Assignment section 
    
.. sidebar:: Concepts 

   * :ref:`resource-function-cost`
   * :ref:`PeriodandRate`

.. list-table:: Fields of assignment list
   :header-rows: 1

   * - Field
     - Description
   * - Resource
     - Name of the resource assigned to the task.
   * - Rate (%)
     - Rate planned for this resource to the task.
   * - Assigned
     - The work initially planned for this resource to the task.
   * - Real
     - Sum of work done by this resource to the task.
   * - Left
     - Remaining work to this resource to complete the task.


* Click on |buttonAdd| to assign a new resource.
* Click on |iconTeam| to assign an entire  team to the activity
* Click on |iconOrganization| to assign an entire organization to the activity
* Click on |buttonEdit| to modify the assignment.
* Click on |buttonIconDelete| to delete the assignment.
* Click on |iconSplit| to divide the assignment of a resource with a second resource into two equal parts 
* Click on |iconGoto| to go directly to the allocation sheet for this resource. 
* Click on the name of the resource to access the detail of the latter on the resource screen.


.. _goto-timesheet:

.. rubric:: Go to the timesheet

The button |iconGoto| allows you to go to the timesheet of the selected resource with the line of the current element highlighted.

.. figure:: /images/GUI/COMMON_SCR_Timesheet.png
   :alt: Resource's timesheet with the element highlighted
   
   Resource's timesheet with the element highlighted

You can have a goto button at the top of the assignments area if you are assigned to the item yourself. 

.. figure:: /images/GUI/COMMON_ZONE_AllocationSection-myself.png
   :alt: Assignment of the connected user
   
   The button is displayed if the logged in user is assigned.
   
   
.. rubric:: Multiple assignment to a task

* A resource can be assigned more than once to a task. See the Assignment section illustration.
* Allows to assign the resource to the same task, but with a different function (different daily cost).
* Allows to add extra work without modifying initial assignment.

.. rubric:: Incomplete planned work

* The scheduling process tries to schedule, the remaining work on the assigned task within the allocation to project period.
* The remaining work that can't be planned is displayed on the right of the resource name.

.. figure:: /images/GUI/COMMON_ZONE_AssSection-NotPlannedWork.png
   :alt: Assignment section with incomplete planned work
   :align: center

   Assignment section with incomplete planned work


.. rubric:: Add a new assignment

.. figure:: /images/GUI/COMMON_BOX_Assignment.png
   :alt: Dialog box - Assignment 
   :align: center
   
   Assignment dialog box

.. tabularcolumns:: |l|l|

.. list-table:: Fields - Assignment dialog box
   :header-rows: 1

   * - Field
     - Description
   * - Resource
     - Resource list.
   * - Function
     - Function list.
   * - Cost
     - Daily cost defined for the resource and its function.
   * - Rate
     - The max rate (%) to schedule the resource on the task by day.
   * - Assigned work
     - The work initially planned for this resource to the task.
   * - Real work
     - Sum of work done by this resource to the task.
   * - Left work
     - Remaining work to this resource to complete the task.
   * - Reassessed work
     - The new total work planned to complete the task.
   * - Comments
     - Any comment on the allocation.

.. topic:: Field Function

   The main function defined for the resource is the default function selected.

.. topic:: Field Left work

   .. code:: 
   
      [Left work] = [Assigned Work] – [Real Work]
   
   Project leaders can adjust this value to estimate the work needed to complete the task by the resource.

.. topic:: Field Reassessed work

   .. code:: 
   
      [Reassessed work] = [Real Work] + [Left Work]

.. topic:: Field Comments

   When a comment exists, |note| will appear on the assignment list, and on the description of the activity on the “real work allocation” screen.
   
   Moving the mouse over the icon will display the comment.  


.. _recurrent-mode-assign:

Recurrent mode assignment
=========================

When you use the RECURRENT planning mode, during the assignment, ProjeQtOr offers to distribute the workload of your resource on a weekly basis which will affect the entire duration of the project. The total charge will be calculated after validation.

Please note, this mode adds a significant workload depending on the duration of your project.

.. figure:: /images/GUI/GANTT_BOX_RecurrentAssignment.png
   :alt: Recurring assignment
   
   Recurring assignment

You can enter a different value for each day of the week.

The copy button is an accelerator to copy the value entered on Monday on all other days.

   

.. _plannedintervention-assign:

Planned Interventions assignment
================================

.. rubric:: Assignment

The assigned workload is no longer determined but will be entered on a calendar which can be clicked, per half-day.

See: :ref:`Manual planning assignment<assignment-manualplanning>`



.. figure:: /images/GUI/GANTT_BOX_PlanningManual-Assignment.png
   :alt: Assigment with the Manual planning mode
   
   Assigment with the Manual planning mode
   
  


.. raw:: latex

    \newpage

.. index:: Progress section

.. _progress-section:

Progress section
----------------

This section allows all at once, define planning and follow-up the progress.

All planning elements have a progress section.

.. figure:: /images/GUI/COMMON_ZONE_ProgressSection.png
   :alt: Progress Section
   :align: center
   
   Progress section
   

Description of the different sections is grouped by the planning elements that have common fields and behavior.

Progress data are displayed in the same format, **but according to the planning element, fields can have another meaning or behavior.**

Below is the definition of the different columns that make up the Progress section.



.. _progress-section-date-duration:

Dates and duration
==================

The dates and durations section allow you to record and display different time information on your element.


.. rubric:: Validated

Validated dates are used for:

* Define the input parameters according to the selected planning mode - See: :ref:`Planning mode<planning-mode-gantt>`

* Define the initial due dates as a reference in order to check any drifts in your project

* Set a deadline by which the work must be completed.



.. rubric:: Planned

Planned dates can be defined with:

 .. compound:: **Requested or validated dates**

    The planned dates can be initialized with validated dates or requested dates (whether validated dates are not specified).

 .. compound:: **Planning calculation**

    The planned dates can be determined during the planning calculation.
    
    The planning calculation is done according to tasks assigned to resources and their predecessors.

    .. note:: **Planning mode "Fixed duration"**

      The planned dates of tasks will be calculated depending on their predecessors and their specified duration.

    .. warning:: **Planned dates of parent element**
      
      At parent element level, dates are adjusted with the first planned start date and the last planned end date from all sub-elements.

      The planned start date is adjusted to the real start date when work began.




.. rubric:: Real

These are the dates of work actually carried out. The work actually charged

The real start date is set when work began (handled).

The real end date is set when no more remaining work (done).

.. note:: Real dates of parent element 

   The real start date will be propagated to parent elements up to project.
   
   The real end date for parent element will be initialized, when all sub-element have been completed.
   
   

.. rubric:: Requested

Allows you to define forecast dates. These are generally the dates agreed with your client or the beneficiary of your activity..



.. rubric:: Duration

The durations correspond to the number of days between the start and end dates.

They are calculated automatically.

But you can also enter a start date and a number of days, the end date will be automatically calculated.




.. _progress-section-resource:

Costs and works
===============

The cost of resources is calculated thanks to the workload allocated to each resource on the tasks.

You must fill in a function associated with a daily cost for your resources.

See: :ref:`Function and cost<function-cost-resource>` on the resources screen





.. rubric:: Validated

Allows to define scheduled work and budgeted cost of resources.

 .. compound:: **Work**
 
    This value is used for calculation of the expected progress and project margin (work).

 .. compound:: **Cost**

    This value is used for calculation of project margin (cost).

.. note:: **Project**

   The values of work and cost can be initialized with the sum of total work and amount of all project orders.
   
   See: :ref:`Incomes<orders>`

.. rubric:: Assigned

Sum of planned work assigned to resources and estimated cost.

.. rubric:: Real

Sum of work done by resources and cost incurred.

.. rubric:: Left

Sum of estimated remaining work to complete tasks and ensuing costs.

Left work should be re-evaluated by resource while entering the real work on real work allocation screen.

Left work can also be changed on assignment, at project management level.

.. rubric:: Reassessed

Sum of resource total work that will be needed from start to end and the ensuing costs.

   .. code::
    
      [Reassessed] = [Real] + [Left]

.. topic:: Work on tickets

   * Sum of work done on tickets and costs is included in work of activity linked through the “planning activity” of tickets.
   * Sum of work done on tickets that don't link to any activity will be integrated in the work of the project.






.. _progress-section-expense-reserve:


Expense tracking
================
This section is used by Project.

See: :ref:`Project reserve<project-reserve>`

.. rubric:: Validated (Expense)

Allows to set the budgeted cost of project expenses.

This value is used for calculation of project margin (cost).


.. rubric:: Assigned (Expense)

Project expenses planned.

Sum of "planned amount" for all expenses on project.

.. rubric:: Real (Expense)

Project expenses committed.

Sum of "real amount" for all expenses on project.

.. rubric:: Left (Expense)

Project expenses not committed yet.

Sum of "planned amount" for expenses  for which "real amount" is not defined yet.

.. rubric:: Reassessed (Expense)

Spending projections.

Sum of Real + Left

.. rubric:: Left (Reserve)

Project reserve.

.. note:: **Total columns**

   Total is the sum of resources cost, expenses and reserve of their corresponding column.




.. _technical-progress:

Technical Progress
==================

The Technical Progress section allows you to display an advancement in units of work.

.. note:: To display the technical progression section, which corresponds to an advancement in Unit of Work, you must position the option in the global parameters.
   
   See: :ref:`Global Parameters<gp_planning-section>`

The section technical progress is displayed on Project and Activity screen.

you determine the number of units of work to be performed on the tasks.

The progress and the rest will be consolidated towards the father project and / or the mother activity. 


.. rubric:: Number of units

As for the dates and durations, you can enter several values for the realization of your units of works.

 .. compound:: To delivred

  Number of units to be delivered.
   
 .. compound:: To realise

  Number of units to be produced.

   
 .. compound:: Realised
 
  Number of units actually produced.
  
 .. compound:: Progress
 
  For advancement in unit of work, you can choose the way so it will be evaluated.
  
   .. compound:: Calculated
   
     Progress is calculated by software.
     
   .. compound:: Manual
   
     You define yourself the progress of the realization of your units of works.    

 .. compound:: Weight
 
  The weight defines a certain importance on the realization of these units.

  It determines how the calculation of the progress of the work units will be calculated and consolidated.
      
   .. compound:: Manual
   
     You enter a value manually according to the unit of work to be done.
     
   .. compound:: Unity of work
   
     It is the number of units to deliver or to realize.  
     
        




.. raw:: latex

    \newpage

.. _progress-section-steering:

Steering
========

.. rubric:: Progress

Percentage of actual progress.

Calculated by the sum of the work done divided by sum of work reassessed.

   .. code:: 
      
      [Progress %] = [real work] / [reassessed work] 
      
      = [real work] / ( [real work] + [left work] )

.. rubric:: Expected

Percentage of expected progress.

Calculated by the sum of the work done divided by scheduled work.

   .. code:: 
      
      [Expected %] = [real work] / [validated work]

.. rubric:: WBS

Hierarchical position in the global planning.


.. rubric:: Color
 
You can set a color on an activity.
  
This color will be displayed on the bars of the Gantt chart.
  
  
.. rubric:: Minimum threshold
 
When this value is set, the activity will only be scheduled on the day that the daily availability will be greater than or equal to this threshold.

You also have the option to add a new property to a "not splitted work" task.

This will require defining the minimum work to be allocated each day and thus filling in the minimum threshold field

Planning will require finding consecutive days with at least the given value possible.


.. rubric:: Fix planning
 
Fix planning will avoid the recalculation of planning for an activity.
  
To fix the project see: :ref:`treatment-section`


.. _margin:

Margin
""""""

  .. compound:: Margin (work)
  
    Used by Project.
    
    Calculated by the scheduled work minus the sum of work reassessed.

    .. code:: 
   
      [Margin] = [Validated work] - [Reassessed work]
   
      [Margin(%)] = ([Validated work] - [Reassessed work]) / [Validated work] 


  .. compound:: Margin (cost)

    Calculated by the budgeted cost (resource & expense) minus the total of reassessed cost.

    .. code:: 

      [Margin] = [Validated cost] - [Reassessed cost]
 
      [Margin(%)] = ([Validated cost] - [Reassessed cost]) / [Validated cost] 

Priority
""""""""

  Allows to define priority to a project or activity.
  
  A project or an activity with a priority 

  By default, the value is set to "500" (medium priority).
  
  1 being the highest priority and 999 the lowest priority.

  See: :ref:`Scheduling priority<scheduling-priority>`.





.. _progress-section-planning-mode:

Planning mode
"""""""""""""

  Used by Activity & Test session.

  Depending on the planning mode selected, the calculation of your planning will not be executed in the same way.

  * See :ref:`Concepts<planning-mode-concept>`
  * See :ref:`Planning modes<planning-mode-gantt>`



.. _progress-section-ticket:

Ticket
""""""

Used by Activity.

Allows tracking of tickets attached to the activity throught the "planning activity" field of tickets. 

.. tabularcolumns:: |l|l|

.. list-table:: 
   :header-rows: 1

   * - Field
     - Description
   * - Number
     - Number of tickets attached to the activity.
   * - Estimated
     - Sum of estimated work for tickets attached to the activity.
   * - Real
     - Sum of work done for tickets attached to the activity.  
   * - Left
     - Sum of remaining work for tickets attached to the activity. 

.. topic:: Field Estimated

   This field will be highlighted when the sum of estimated work on the tickets is higher than the planned work on the activity.

.. topic:: Field Left

   This field will be highlighted when the sum of remaining work on the tickets is higher than the remaining planned work on the activity.


.. rubric:: Show tickets attached

* Click on |buttonIconSearch| to show ticket list attached to the activity.
* Click on a ticket name to directly move to it.

.. figure:: /images/GUI/COMMON_BOX_ListOfTicket.png
   :alt: Dialog box - List of tickets 
   :align: center




   

.. _progress-section-milestone:

Progress section Milestone
--------------------------

This section allows to define planning and follow progress on a milestone.


.. rubric:: Requested

Allows to define the initial due date for the milestone.

Have no impact on planning.

.. rubric:: Validated

Allows to define the due date at which the milestone must be completed.

.. _planning-mode-milestone:

.. rubric:: Planned

Defined according to the selected planning mode.

 .. compound:: **Fixed milestone**

    * Planned due date is the value from validated due date field.
    * The milestone will not move, and may have successors.

 .. compound:: **Floating milestone**

    * Calculation of planned due date takes into account dependencies with tasks.
    * The milestone will move depending on predecessors.

.. rubric:: Real

Determined when the status of the milestone is “done”.


.. rubric:: Planning mode

Fixed milestone

Floating milestone

.. note::
   
   A milestone has no duration, so there are no start and end dates for a milestone, just a single date.
   
   
.. rubric:: WBS

Hierarchical position of the milestone in the global planning.


.. rubric:: Color

You can set a color on a milestone.
  
This color will be displayed on the bars of the Gantt chart.
   

.. raw:: latex

    \newpage


.. _progress-section-meeting:

Progress section Meeting
------------------------

This section allows to define priority and follow progress on a meeting.

 .. compound:: Validated

   Allows to define scheduled work and budgeted cost.

   Used to consolidate validated work and cost to the project.

 .. compound:: Assigned

   Sum of planned work assigned to attendees and the planned cost.

 .. compound:: Real

   Sum of work done by attendees and the cost.

 .. compound:: Left

   Sum of planned work remaining and the remaining amount.


 .. compound:: Color

   You can set a color on a meeting. 
  
   This color will be displayed on the bars of the Gantt chart.





.. raw:: latex

    \newpage

.. _display-sub-project-activity:

Sub-Project and Sub-Activity
----------------------------

On the projects screen, this section allows you to display the sub-projects linked to the selected one.

.. figure:: /images/GUI/COMMON_ZONE_SubProject.png
   :alt: display of sub projects
   
   Display of sub projects
 
 
In the same way, you can display on the activities screen, the sub-activities linked to the selected activity.

.. figure:: /images/GUI/COMMON_ZONE_SubActivity.png
   :alt: display of sub activities
   
   Display of sub activities
   
   
   
   
   
 
.. raw:: latex

    \newpage

.. _predSuces-element-section:

Predecessor and Sucessor
------------------------

This section allows to manage dependency link between planning elements.

A dependency can be created from the predecessor and/or successor planning element.

The dependency link can be created in the Gantt chart.

Click on the name of a predecessor or successor to go directly to the element.
  
.. seealso:: 

  * :ref:`Dependencies<dependency-links>`
  
  * :ref:`Milestones on the Gantt Chart View<milestones-gantt>`

.. figure:: /images/GUI/COMMON_ZONE_Success&Predecessor.png
   :alt: Predecessor and Successor section
   :align: center
   
   Predecessor and Successor section


.. rubric:: Predecessors and successors

* Click on |buttonAdd| on the corresponding section to add a dependency link.
* Click on |buttonEdit| to edit the dependency link.
* Click on |buttonIconDelete| to delete the corresponding dependency link. 

.. figure:: /images/GUI/COMMON_BOX_Success&Predecessor.png
   :alt: Dialog box - Predecessor or Successor element
   :align: center
   :scale: 80%

   Dialog box - Predecessor or Successor element

In the NAME field, icons are displayed to indicate the type of dependencies

|iconEE| End End dependency

|iconES| End start dependency

|iconEE| End End dependency



.. note:: 

   Recursive loops are controlled on saving.
   

   **Linked element list of values**
   
   By default, the list of values shows items of the same project.

   But, it is possible to link items from different projects.
   
   Click on |buttonIconSearch| to get the list of elements of all projects.   
   

   **Multi-value selection**

   Multi-line selection is possible using :kbd:`Control` key while clicking.
   

   **Delay (late)**

   Days between predecessor end and successor start.
   

.. figure:: /images/GUI/COMMON_ZONE_Success&Predecessor_REDDate.png
   :alt: highlighting the date
   
   highlighting the date
   
Highlighting the date that will most constrain the next activity

.. raw:: latex

    \newpage

.. _linkelement-section:

Linked Elements section
-----------------------

This section allows to manage link between items of elements.

.. rubric:: Used for

Allows to associate items on different elements in the same project.

A project can be linked with other.


.. note:: Access to an item

   Click on an item name to directly move to it.
   
   Click on |buttonIconBackNavigation| to return to the last screen. 
   
   More detail, see: :ref:`Top bar <navigation-buttons>`


.. rubric:: Reciprocally interrelated

If Item A is linked to Item B, Item B is automatically linked to Item A.

.. note::

   A link between items has no impact on them treatment.
   

.. rubric:: Linked elements list

.. tabularcolumns:: |l|l|

.. list-table:: Fields of linked elements list
   :header-rows: 1

   * - Field
     - Description
   * - Element
     - Type and id of the linked element.
   * - Name
     - Name of the linked element.
   * - Date
     - Date of creation of the link.
   * - User
     - User who created the link.
   * - Status
     - Actual status of the linked element.

.. rubric:: Linked elements list buttons

* Click on |buttonAdd| to create a new link.
* Click on |buttonIconDelete| to delete the corresponding link.

.. figure:: /images/GUI/COMMON_BOX_AddLink.png
   :alt: Dialog box - Add a link with element 
   :align: center
   
   Add a link with element

.. topic:: Linked element list of values

   By default, the list of values shows items of the same project. But, it is possible to link items from different projects.
   
   Click on |buttonIconSearch| to get the list of elements of all projects.    

.. rubric:: Link with Document

When a link to a document is selected. The document version can be selected. (See options below)
Linked documents are available directly in linked elements list.

 .. compound:: **Specified version**

    A link with a document element offer the possibility to select a specific version.
    
    A direct link to version of the document is created.

 .. compound:: **Not specified version**

    If the version is not specified, the last version will be selected.
    
    The download will transfer always the last version of the document.

.. raw:: latex

    \newpage

.. index:: Attachment section

.. _attachment-section:

Attachments section
-------------------

This section allows to attach files or hyperlinks to items of elements.

.. rubric:: Document viewer available

* image
* text
* PDF
* Hyperlinks

.. figure:: /images/GUI/COMMON_ZONE_AttachmentSection.PNG
   :alt: Attachment Section
   :align: center
   
   Attachment section


.. note:: 
   
   If you do not fill in the description then the exact name of the document will be displayed
   
   see the ID#9 document in the table.
   
   If the desciption field is filled then this text will be displayed 
   
   see the ID#11 document in the table

.. tabularcolumns:: |l|l|

.. list-table:: Fields of attachments list
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the attachment.
   * - File
     - File name or hyperlink.
   * - Date
     - Date of creation of the attachment.
   * - User
     - User who created the attachment.


.. rubric:: the attachment

Select an attachment depends on whether is a file or a hyperlink.

  * Click on |buttonAdd| to add an attachment file to an item. See: :ref:`To upload a file<attachment-file>`
  * Click on |buttonIconDelete| to delete an attachment.
  * Click on |iconLink| to add hyperlink to an item.
  * Click on |iconDownload| to download attachment file.
  * Click on |iconLink| to access to hyperlink.

.. _attachment-file:

.. compound:: **To upload a file**

   Select file with "Browse" button or drop the file in "drop files here" area.
   
   Attached files are stored on server side.
   
   Attachments directory is defined in :ref:`Global parameters<file-directory-section>` screen.
   
   You can select one or more files of different types with the CTRL shortcuts when the files are not consecutive or SHIFT for those that follow.

    .. figure:: /images/GUI/COMMON_BOX_attachmentFile.png
       :alt: Dialog box - Attachment for file
       :align: center

       Attachment for file
   

.. compound:: **Hyperlink**

   Enter hyperlink in «Hyperlink» field.

    .. figure:: /images/GUI/COMMON_BOX_attachmentHyperLink.png
       :alt: Dialog box - Attachment for hyperlink
       
       Attachment for hyperlink

   
.. tabularcolumns:: |l|l|

.. list-table:: Fields - Attachment dialog box
   :header-rows: 1

   * - Field
     - Description
   * - Description
     - Description of attachment.
   * - Public
     - Attachment is visible to anyone.
   * - Team
     - Attachment is visible to every member of the creator’s team.
   * - Private
     - Attachment is visible only to the creator.


.. raw:: latex

    \newpage

.. index:: Notes (section)

.. _note-section:

Notes section
-------------

This section allows to add notes on items of elements.

Notes are comments, that can be shared to track some information or progress.

.. rubric:: Predefined note

The list of values appears whether a predefined note exists for an element or an element type.

Selecting a predefined note  will automatically fill in the note text field.

Predefined notes are defined in :ref:`predefined-notes` screen.

.. rubric:: Note visibility

* **Public:** Visible to anyone.
* **Team:** Visible to every member of the creator’s team.
* **Private:**  Visible only to the creator.

.. rubric:: Notes list

.. tabularcolumns:: |l|l|

.. list-table:: Fields of notes list
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the note.
   * - Note 
     - Text of the note.
   * - Date
     - Date of creation or modification of the note.
   * - User
     - Name of the user who created the note.

.. rubric:: Notes list buttons

* Click on |buttonAdd| to add a note to an item. 
* Click on |buttonEdit| to edit the note.
* Click on |buttonIconDelete| to delete the note.

.. figure:: /images/GUI/COMMON_BOX_Note.png
   :alt: Dialog box - Note 
   :align: center
   
   dialog box notes
