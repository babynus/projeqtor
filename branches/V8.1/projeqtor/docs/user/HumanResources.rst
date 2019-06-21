.. raw:: latex

    \newpage

.. title:: Humans Resources

.. index:: ! Humans resources

.. _humans_resources:

Humans Resources
****************

**[06/2019 - UNDER CONSTRUCTION]**

.. note:: **Documentation**

   `Documentation <https://www.projeqtor.org/files/ProjeQtOr%20-%20Documentation%20-%20Absences%20r%C3%A9glement%C3%A9es.pdf/>`_ on the implementation of regulated absences by Salto consulting 
   is online on the `download page <https://www.projeqtor.org/fr/product-fr/downloads-fr/>`_

This section allows to manage the society's Humans Resources 

This system comes in addition to the standards of the management of absences

* You must define the employees [#f1]_, contract types and leaves types contract 

* You can choose the leave entitlement standard for each type of contract

* The employee may reserve periods of leave of absence according to his rights.

* The system also includes a validation process of the requests during the leave period.

.. warning:: **Absence Administrator**

   In order to be able to manage and parameterize the human resources module after its installation, 
   you must go to global parameters in the Work tab.
   A new parameter is displayed: Leaves System
   

   .. figure:: /images/GUI/RH_ZONE_ParamGlob_LeavesAdmin.png
      :alt: Global Parameters - Leaves System
      :align: center
   
   You can choose here who will be the administrator of this module




.. index:: Humans Resources (Sections)
.. rubric:: **Humans Resources Sections**

   * Leaves Calendar
   * Leaves Period
   * Leaves rights earned
   * Employees
   * Employment Contract
   * Employee Managers
   * Leaves Dashboard
   * Regulated leaves parameters


.. index:: Human Resources (variable capacity)
.. rubric:: **Variable capacity**
   
   The resources may have a capacity that varies over time. 
   This allows you to reserve and enter additional time (for periods of overtime) 
   or less than the standard capacity (for some periods of 'rest
   
.. important:: The HR module was created in order to be easily adapted to French law 
   but it can be fully parameterized according to the rights of any country
   
.. index:: ! Regulated absence

.. _regulated_absences:

-----------------------------

.. rubric:: **Footnote**

.. [#f1] an employee is a resource whose property 'is an employee' is checked.
      
      This property is visible only when the REGULATED ABSENCE module is enabled.
 
   
.. _regulated_absences:
   
Regulated absence
-----------------

The 'Regulated Absence' module is used to manage absences that must be validated, controlled and have values to be regulated according to French law.

Thanks to this module, it is thus possible to manage the paid holidays, the RTT, the Stopped diseases by treating

   * quantities acquired over a period of time
   * the period of validity of a quantity of absence 
   * the possibility or not to take early holidays over the period being acquired
   * the number of days before and after which the absence request can be made
   * 'specific' acquisition rules
   * validation or rejection of an application
   
.. note:: A project dedicated to these regulated absences is created and makes it possible to store the requested days of absence as planned time 
   and the days of absence validated as working time thus making it possible to integrate these absences in the planning.   

   
Leaves Calendar
===============

Regulated absences are done either by the employees or by their manager

Absences can be recorded from the leaves calendar 

.. figure:: /images/GUI/RH_SCR_LeavesCalendar.png
   :alt: Leaves calendar
   :align: center

To record or change your absences, double clicking on an existing date or absence

a pop up opens to display the properties of an absence (date and type of absence ...)

.. figure:: /images/GUI/RH_POPUP_LeavesAttributs.png
   :alt: Leaves attributs
   :align: center
   
.. rubric:: Leaves States   

Regulated absences have 3 states:

* **recorded:** 
Creation status. In this state all the data of the absence can be modified

* **validated:** 
State that only the manager and the administrator of the module can be enabled.
In this state, only the state of absence can be changed by the manager or administrator

* **canceled:** 
State that only the manager and the administrator of the module can be enabled.
In this state, only the state of absence can be modified by the manager or administrator
and the number of days the absence represents are not taken

.. note:: 

   The calculation of the number of days represented by absence is done on the basis of working days
   Global setting of projeqtor and schedule associated with employee: holidays, non-working days

Leaves Periods
==============

Regulated absences are done either by the employees or by their manager

Absences can be recorded from the leaves Periods screen 

.. figure:: /images/GUI/RH_SCR_LeavesPeriods.png
   :alt: Leaves periods
   :align: center

On this screen, you can save, edit, delete a holiday request as on the absence schedule.

The employee manager and the administrator can change the status of a holiday (see reports)



Leave Rights earned
===================

On this screen, you can see your leaves rights earned since your contratc's beginning.

.. figure:: /images/GUI/RH_SCR_LeavesRightsearned.png
   :alt: Leaves rights earned
   :align: center

* the start and end dates correspond to the period on which the days of leave are calculated

* The numbers of the days acquired and remaining 

* If your holidays over the reference period and according to the type of leave, 
  then the checkbox "closed" is validated.
  You no longer have this type of holiday available and can not ask any more

Employees
=========

Employment contract
===================

Employee Managers
=================

Leaves Dashboard
================

Regulated leaves parameters
===========================

.. _rh_LeavesTypes:

Leaves types
^^^^^^^^^^^^

this part allows you to create the types of absences regulated according to the laws of your country.

A corresponding activity (= name of absence type) is created on the project dedicated to absences management.

All employees (resource registered as employee) are assigned to this activity

.. figure:: /images/GUI/RH_SCR_TypesConges.png
   :alt: creating types of absences
   :align: center
   
   Leaves types

In the details area, you assign a name and color to your type of absence.

You can choose which workflow it is attached to

You can define who will receive, an alert, a notification, and / or an email when creating, updating, processing or deleting types of absences .

The manager records the request
Employee makes the request 

.. warning:: Check box "On default" and "on everything"

   * If you check on 'default' the entered values will be reflected on the default contract type only. 

   * If you check on 'all' the entered values will be on all contract types. 

   * These values can not be changed after they are saved.

   For any change, the creation of a new type of absence is necessary.  

.. note:: In France, an employee is entitled to 2 and a half days of leave per month of actual work at the same employer, 
   wether 5 weeks per full year of work (from June 1st to May 31st)


.. _rh_ContractuelValues:

.. rubric:: **Contractual values**
      
   .. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 70
   :header-rows: 1

   * - Field
     - Description
   * - start month period
     - month starting the reference period of paid holidays in your country.
   * - start day period
     - day starting the reference period of paid holidays in your country.
   * - period duration
     - The length of the period gives the number of months over which your reference period will extend.
   * - quantity
     - the number of days of leave that will be paid during the period reference.
   * - period of leave rights earned 
     - the number of months before you can use your acquired days.
   * - integer :term:`quotity` 
     - Possibility of rounding up earned leave.
   * - validity duration  
     - period during which the days of leave acquired will be retained. Beyond this period the acquired holidays are lost.
   * - is justiable
     - defines if the absence must be the subject of a request for proof
   * - can be anticipated
     - If leave can be taken before the vesting period
   * - max delay for retroactive absence (days)
     - allows, or not, to record absences on paid leave after being actually absent.
   * - max delay for anticipated absence (days)
     - Number of days before which an application can be made     

Employment contract type
^^^^^^^^^^^^^^^^^^^^^^^^

This section allows you to create the different contracts that are in effect in your company

The types of contracts allow to have rules of acquisition of different regulated absences according to the contract of employment of an employee

You can only have one type of default contract

.. note:: **example in France**

   * Executive contract = No acquisition rule
   
   * Full-time frame contract = RTT
   
   * Part time frame contract = No RTT 
   
   * etc.
   
.. figure:: /images/GUI/RH_SCR_TypesContrats.png
   :alt: Employment contract type
   :align: center
   
   Screen of Employment contract type   
   
In the details area, you assign a name to your contract's type.

You choose which workflow it is attached to


.. rubric:: **Parameters for earned leave rights**
   
* In this section you can define which types of regulated absences will be attached to this type of contract.

* If you have created several types of regulated absences and attached them to all your contracts
 (check box **on default** or **on everything**), 
 these types will be visible in this section.


If you are missing types of absences, you can create them from this screen:

* Click on the |ButtonADD| button
* A pop up opens and proposes to fill in the same fields as on the screen of the types of regulated absences

.. figure:: /images/GUI/RH_POPUP_AddTypesConges.png
   :alt: Special leaves rights
   :align: center

.. rubric:: **Configuration of special leave rights**

Special acquisition rules are rules that can not be expressed with the values of the standard acquisition rules

.. figure:: /images/GUI/RH_POPUP_AddSpecialLeaves.png
   :alt: Special leaves rights
   :align: center

.. rubric:: **custom earned rules:** 

Define the special acquisition rule based on the attribute values of a ProjeQtOr entity.

This rule follows the vocabulary of the SQL language

.. rubric:: **where clause**

Condition of application of the special right

this clause follows the vocabulary of the SQL language

.. important:: for help with the SQL functions you can use, 
   click on the section bar ** help on clause input **
   
   A new part appears and proposes drop-down menus with prerecorded SQL queries 

.. figure:: /images/GUI/RH_POPUP_AddSpecialLeavesPLUS.png
   :alt: Special Leaves
   :align: center
   
.. rubric:: **Quantity**

Number of additional acquired days calculated following the application of the special acquisition rule

This rule follows the vocabulary of the SQL language

.. rubric:: **Leave type**

The type of regulated absence to which will be attached, the rule of special absence.   

Employment contract end reason
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Allows you to record the different types of end of contract.

.. note:: **Why end a contract?**
   
   * resignation
   * change of status (ETAM -> FRAMEWORK) 
   * change in the percentage of working time (100% -> 80%)

.. figure:: /images/GUI/RH_SCR_ContractEND.png

Leaves System habilitation
^^^^^^^^^^^^^^^^^^^^^^^^^^

Allows you to restrict or restrict the view of Human Resources module screens to employee profile types.

* They can view - read - create - update and/or delete access


.. figure:: /images/GUI/RH_SCR_LeavesSystemHabilitation.png
   :alt: Leaves System habilitation
   :align: center
