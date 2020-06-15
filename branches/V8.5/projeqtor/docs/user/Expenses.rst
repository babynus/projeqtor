.. include:: ImageReplacement.txt

.. title:: Expenses

.. index:: Expenses

.. _Expenses:

Expenses
********

The expenses incurred for the project are monitored.

.. index:: Budget

.. _budget:

Budget
------

A budget is a list of all products and different expenses to plan. It is a plan that allows to define in advance the expenses, the incomes and the possible savings to be realized during a definite period.

It allows to anticipate the resources that the company will have at a specific moment.

.. figure:: /images/GUI/EXPENSES_SCREEN_Budget.png
   :alt: Budget screen
   :align: center

   Budget Screen
   
   
* You can create as much budget and sub budget as you want.

* An expense is related to a base budget, ie a budget item

* A budget item is linked to a parent budget 

* Only the current budget items will be displayed in the lists.

* Current, under construction and closed budgets will not appear in the lists. To view the closed items, check the "closed" box.



 .. compound:: Budget parent filter
  
   With the filter, you can display in the list area, only a budget and its family (sub-budget). 
    
   An indentation of these to the right shows that they are sub-budgets.

   To see the closed items in this list, check the "closed" box.
   
   If you change the name of a budget, remember to refresh the page so that the lists take into account the changes.
   
   
   .. figure:: /images/GUI/EXPENSES_ZONE_FilterBudgetParent.png
      :alt: Filter parent budget
   
      Display of a budget and its family
 

   * The parent budget exists only to consolidate the data of the underlying budget items.

   * You cannot modify the expenses in the Progress field of a parent budget.

   * Only the target amount can be changed if the budget treatment is still under construction.




 .. compound:: The budget item
  
   * The budget item is the finer element of the budget analysis. 
   * These posts or budget destinations will allow you to detail your budget, categorizing it at your convenience.
   
   .. figure:: /images/GUI/EXPENSES_ZONE_ItemBudget.PNG
      :alt: Display of budget items on a project expense 
   
      Display of budget items on a project expense   
   
   
   When you create a project expenditure or an individual expenditure, you can link them to a specific budget item.

   In the dropdown list of budget items, only the budget items will be available. 
   
   Parent budgets will be grayed out and you will not be able to select them.
   

.. rubric:: Description

This section allows to identify items of the element.

.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|  
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the budget
   * - |RequiredField| Name
     - Short description of the budget
   * - |RequiredField| Budget type
     - Type of budget: initial or additional
   * - Budget orientation
     - The orientation of the budget: operation or transformation 
   * - Budget category
     - subdivision of budget orientation into category
   * - Article number
     - The number of the article 
   * - Organisation    
     - Name of the organisation
   * - Customer Code
     - the code you attribute to your client 
   * - is sub-budget of
     - if your budget is part of another budget
   * - Sponsor     
     - from the budget.
       If your budget comes from grant for example


.. rubric:: Treatment

.. figure:: /images/GUI/EXPENSES_ZONE_TreatmentBudget.png
   :alt:
   
   Treatment area for the budget
   
   
This area allow you to change the macro state of the budget.

* A budget may be under construction

* A budget under construction does not allow to see the fields "target amount" and prevents the modification of the estimated amount

* The "approved" macro-state changes and automatically cancels the "under construction" macro state. The date is then displayed in the fields of the macro-state concerned.

* Each sub-budget is then impacted and the "approved" state will then be propagated on all of his family.

* Each macro state "under construction", "approved", "closed" and "canceled" modified from the parent budget screen propagates in cascade over the entire budget hierarchy. 

.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - |RequiredField| :term:`Status`
     - Change of states according to the :ref:`workflow` selected for the type of your budget 
   * - Is a budget item
     - Self-checked box when the budget becomes a sub-budget
   * - Under construction
     - When the budget is validated. The box is unchecked
   * - Approved
     - When the box is checked, the target amount is blocked
   * - :term:`Closed`
     - Flag to indicate that profile is archived.
   * - Cancelled
     - Flag to indicate that profile is cancelled.



   
   
   
.. rubric:: Progress

.. figure:: /images/GUI/EXPENSES_ZONE_Progress.png
   :alt: Progress Section
   
   Progress Section

This section allows to follow the consolidation of all the expenses.

The target amount is the only amount that you can change on a parent budget if it is still under construction.

The other amounts are recovered from the sub-budgets and consolidated on the parent budget.

Transferred Amount allows to release a sum of an amount planned for a budget item in order to redistribute it to another item.

This amount is visible on all budget items.

  .. compound:: Transfered Amount
   
   * Enter a negative amount on a budget line to transfer an amount
   * Enter a positive amount on a budget line to recover this amount
   * Only the parent budget and its sub budget will see this amount. 
   * Another parent budget can not recover this amount.



.. rubric:: Budget expense detail

This section displays :ref:`project-expense` lines in detail 

.. figure:: /images/GUI/EXPENSES_ZONE_DetailLine.png
   :alt: Details lines

   Details lines
   
   
   
Hierarchical budget
===================

The hierarchical view of budgets allows you to display an overview of budgets in a very graphic way with an interpretation system for better reading.

You can filter the list of budgets using the parent budget filter.

You can display a particular budget family.

You can move budgets by "drag and drop".


.. figure:: /images/GUI/EXPENSES_SCR_HierarchicalBudget.png
   :alt: Hierarchical budget screen
   
   Hierarchical budget screen
   
   
   


.. raw:: latex

    \newpage
    
.. index:: Financial situation  

.. _financial-situation:  
 
Financial situation
===================

the financial situation screens allow you to precisely follow up all the financial elements of a project. Expenses as incomes.

A tracking view also exists to view only expenses and one for incomes.

The following operations will then be displayed for the expenses.

- Call for tender.
- provider tenders
- Orders to provider
- Provider bills


And the following operations will then displayed for the incomes.

- Client quatations
- Client orders
- Clients bills
- Client paiements

Find the financial situation in its entirety on the respective screens of the elements.

Financial status screens will only display the most recent transaction.


   
   
      

.. raw:: latex

    \newpage
    
.. index:: Supplier contract  

.. _supplier-contrat:  
    
Supplier Contract
-----------------

ProjeQtOr gives you the possibility to manage and precisely follow your supplier contracts

The supplier contract is necessarily linked to a project and a supplier.


.. figure:: /images/GUI/EXPENSES_SCR_SupplierContract.png
   :alt: contract gantt chart screen
   
   Supplier contract screen
 


.. rubric:: Section Description

Complete the description of the contract.

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - |RequiredField| Name
     - Name of the contract  
   * - Number
     - Reference number of the contract
   * - |RequiredField| Client contract type
     - List of types of the contracts
   * - Project
     - Project to which this contract will be attached
   * - |RequiredField| Supplier
     - Supplier concerned by the contract
   * - Contact  
     - List of provider contact only. Contacts must be registered in advance on the supplier's screen. Change supplier, the contacts list is suitable. 
   * - Supplier reference    
     - Reference of the provider
   * - Phone number
     - The field is of alphanumeric type. You can enter a telephone number with precision. Example with a number phone and his ext. 
   * - Origin    
     - Used to enter the origin of the agreement
       Example the name of the seller or the advertisement which brought the customer
   * - Description
     - Descriptive text of the contract





.. rubric:: Section Treatment

Follow the state, the progress of your contract in this section.

 .. compound:: Responsible
   
   * Choose a responsible
   
   * Its initials are displayed on the Gantt chart of contracts
   

 .. compound:: Workflow
   
   * The workflow is based on the default workflow. 
   
   * You can change or modify the current workflow.
   
   * See: :ref:`workflow`
 

.. _renewal:

 .. compound:: Renewal
   
   Defines the behavior of the renewal of a contract at the end of the initially planned duration
   
      * **Never:** the contract will never be renewed
      
      * **Tacit:** the contract will be renewed if there is no termination
      
      * **Express:** the contract is renewed and is the subject of a written or verbal act 
 


 .. compound:: States
   
      * **Handled:** Date on which the contract is taken over. Effective. This date can be entered manually or by going to the Assigned state of the workflow
      
      * **Done:** Date the contract ends.
      
      * **Closed:** Date on which the contract was closed.
      
      * **Cancelled:** Cancellation Date 




.. rubric:: Section contact

This section allows you to fill in the information relating to your contact with the provider

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - |RequiredField| Contact
     - Name of the provider contact
   * - Phone Number
     - Phone number of the provider contact.The field is not numeric and lets you add textual information such as the extension number.
   * - |RequiredField| Levels of service agreements
     - Determines if you have levels of service agreements (:term:`SLA`) with the s for this contract. This check box is an indication.
   * - Intervention time
     - Periods during which services, contacts and interventions with the provider will be possible. You can choose a time slot for weeks, Saturdays, as well as Sundays and holidays.



.. rubric:: Section Progress

In the Progress section, determine the different dates and deadlines for the contract, notice, deadlines, payments ...


.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - Contract dates
     - Start and end date of the contract
   * - Initial contract term
     - Contract duration displayed according to the chosen unit: day, month, year
   * - Notice period 
     - Duration displayed according to the chosen unit: day, month, year
   * - Notice date
     - Free reminder of a scheduled deadline
   * - Due date
     - End of contract validity
   * - Periodicity of the contract (Month)
     - Duration of the renewal of the contract is possible. Example 24-month subscription renewable after 12 months
   * - Billing frequency (Month)
     - Billing frequency during the term of the contract


Supplier contract Gantt chart
=============================

In addition to the contract management screen (list and details area), you can view your contracts in a time view on a Gantt chart. This is the "contract schedule"

Each bar representing the different contracts, going from the start date to the end date of the contract.

Notice dates and due dates are displayed as milestones.

Gantt bars for customer contracts turn red when the due date is higher than the end of contract date. 

No calculation is made. This is an indication to show an inconsistency. 



.. figure:: /images/GUI/EXPENSES_SCR_GanttSupplierContract.png
   :alt: Supplier contract gantt chart screen
   
   Supplier contract Gantt chart screen
















.. raw:: latex

    \newpage

.. index:: Expenses (Call for tender)

.. index:: Call for tender (Expenses)

.. _call-for-tenders:

Call for tenders
----------------


.. figure:: /images/GUI/EXPENSES_SCR_CallforTender.png
   :alt: Call for tender screen
   
   Call for tender screen
   
   
This screen allows you to record information on your needs for any request for tenders from your providers.

This can be used to detail all requests and find the best proposal.

To help you do this, you have the option of creating different evaluation criteria. You can then assign a value to them in the offer.

The call for tenders, once saved, automatically creates a provider offer for each of the selected providers.


.. rubric:: Section Description

.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the call for tender
   * - |RequiredField| Name
     - Short name of the call for tender
   * - |RequiredField| Type
     - Type of tender. See: :ref:`List of type<call_for_tender-type>`
   * - Project
     - Project link to call for tender
   * - Maximum amount
     - Maximum amount of the call for tender
   * - Expected delivery date
     - Date expected
   * - Description
     - Description of the tender 
   * - Business requirements
     - Description of the requirements
   * - Technical requirements      
     - Description of the technical requirements
   * - Other requirements 
     - Description of the others requirements (organization, financial...)
   
   
   
     
.. rubric:: Section Treatment

.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1
   
   * - Field
     - Description
   * - |RequiredField| Status
     - Actual :term:`status` of the item according to the workflow you have selected.
   * - Responsible
     - Person responsible for the processing of this call for tender.
   * - Sent date
     - Sent date of the call for tender. 
   * - Expected answer date
     - Expected answer date, meaning expected tender date.
   * - :term:`Handled`
     - Box checked indicates that the tender is handled with date when checked.
   * - :term:`Done`
     - Box checked indicates that the tender is done with date when checked. 
   * - :term:`Closed`
     - Box checked indicates that the tender is archived with date when checked.
   * - Cancelled
     - Box checked indicates that the tender is cancelled.
   * - Result
     - Description or analysis of the desired result.  




.. rubric:: Section Submissions of tenders

This section contains the list of providers to whom the invitation to tender is sent.


* Click on |buttonAdd| to add a provider to the list.

* Click on |buttonEdit| to edit informations.

* Click on |buttonIconDelete| to delete a provider to the list.


A pop up is displayed. Fill in the different fields necessary for your needs.

.. figure:: /images/GUI/EXPENSES_BOX_SubmissionCallTender.png
   :alt: Submission to call for tender
   
   Submission to call for tender pop-up
   
* You can choose a specific provider contact. List of provider contact only. Contacts must be registered in advance on the provider's screen. Change provider, the contacts list is suitable

* The dates of the request and the expected response.

* The status of the submission to tender. Several statuses are available. 

* They are fully configurable and customizable.

* Each status has a color code.

* See: :ref:`List of values<LoV-tender-statut>`

.. figure:: /images/GUI/EXPENSES_ZONE_SubmissionsTender.png
   :alt: Submission of tender
   :align: center

   Submission of tender   

   
.. tabularcolumns:: |l|l|

.. list-table::
   :header-rows: 1

   * - Field
     - Description
   * - Provider
     - Name of the provider to which the offer was sent as well as the color code corresponding to the provider's status in relation to the offer. 
   * - Requested
     - Request date when tender sent with the hour.
   * - Expected
     - Answer date expected with the hour.
   * - Received
     - Date of receipt of the provider's offer   
   * - Evaluation amount
     - Evaluation note given to the provider upon receipt of the offer according to the selected criteria and the total amount of the offer made by the provider. See: :ref:`Provider Tenders<tenders>`.     
     
You can access to each offer by clicking on the name of the provider or by visiting the provider offers screen.
     
     
.. _evaluation-criteria:
     
.. rubric:: Evaluation Criteria

This section allows you to add evaluation criteria to rate your providers based on your requests.

* Click on |buttonAdd| to add a criteria
* Click on |buttonEdit| to modify a criteria
* Click on |buttonIconDelete| to delete a criteria     
     
.. figure:: /images/GUI/EXPENSES_ZONE_CriterionEvaluation.png
   :alt: Evaluation criteria pop-up
   
   Add an evaluation criteria
   
* Name your evaluation criteria.

* Assign a maximum rating value.

* Assign a coefficient according to the importance of the criteria.

* The score is calculated based on the values assigned and reported in the "submission of tenders" table.      
     
.. tip:: 

   Click on |buttonIconCopy| to logically switch from one financial item to another:

   Call for tenders -> Provider tenders -> Order to provider -> Terms/Bills -> Payments to providers

   Each time you copy a financial item, the most logical financial item for the rest of the order process will be displayed automatically.

   The amount of expense of these elements will be recovered, passed on and linked to each of the others and will allow you more precise monitoring.
   
   You can prevent the carry forward of amounts or the generation of expenses in the :ref:`global parameters<financial>`
   

.. raw:: latex

    \newpage

.. index:: Expenses (Provider Tenders)

.. index:: Provider Tenders (Expenses)

.. _tenders:

Provider Tenders
----------------

Provider tenders store information about responses to tenders you have submitted.

This can be used to detail all the offers, compare them, evaluate them to choose the most suitable for your needs.

.. figure:: /images/GUI/EXPENSES_SCR_ProviderTender.png
   :alt: Provider tender screen
   
   Provider tender screen


An offer can be created manually or generated automatically following a call for tenders.

Each provider added to the invitation to tender will generate an offer.


.. rubric:: Section Description

.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the tender.
   * - |RequiredField| Name
     - Short name of the tender.
   * - |RequiredField| Type
     - Type of tender. See: :ref:`List of type<provider_tender_type>`
   * - Project
     - Project link to tender.
   * - Call for tender
     - Link to call for tender.
   * - Tender statuts
     - Statut of the tender.
   * - |RequiredField| Provider
     - Provider of the tender.
   * - External reference
     - External reference of the tender.






.. rubric:: Section Treatment

.. tabularcolumns:: |l|l|

.. list-table::  Required field |ReqFieldLegend|
   :header-rows: 1
   
   * - Field
     - Description
   * - |RequiredField| :term:`Status`
     - Actual status of the tender.
   * - Responsible
     - Person responsible for the processing of this tender.
   * - Contact
     - Contact of the tender.
   * - Request date
     - Resquest date for tender.
   * - Expected answer date
     - Expected answer date of the tender.
   * - Date of receipt
     - Date of receipt of the tender with the hour.
   * - Offer validity
     - Offer validity date.
   * - Initial
     - Initial amount not taxed - Amount of tax applicable by the provider and the type of product - Total amount 
   * - Discount
     - Negotiated price - Enter a numerical value and the percentage is calculated automatically. And conversely, enter a percentage, the numerical value is generated automatically.
   * - Total
     - Total amount with discount taken into account.
   * - Project expense 
     - Connect your provider's offer to an existing project expense. 
   * - Generate expense 
     - Automatically create expenses from the current item. The name of the project expenditure generated will be the same as that of the offer.  
   * - Payment conditions
     - Type of payment conditions. 
   * - Delivery delay
     - Delivery delay of the tender.
   * - Expected delivery date
     - Expected delivery date of the tender.   
   * - :term:`Handled`
     - Box checked indicates that the tender is handled with date when checked.
   * - :term:`Done`
     - Box checked indicates that the tender is done with date when checked. 
   * - :term:`Closed`
     - Box checked indicates that the tender is archived with date when checked.
   * - Cancelled
     - Box checked indicates that the tender is cancelled.
   * - Result
     - Description or analysis of the expected result from this provider.  

.

  .. compound:: project expenses and generate expense
 
       You can attach a specific expense to your order.
   
       Select a manually created expense from the project expense list.
   
       If you have not created an expense upstream, check the generate expense box, a line will then be created in the project expenses.



.. rubric:: Evaluation Section

The Evaluation section is only available when the offer is linked to a call for tenders.

If the offer is created manually, the evaluation section does not offer criteria.


.. figure:: /images/GUI/EXPENSES_ZONE_EvaluationSection.png
   :alt: Evaluation section
   
   Evaluation section
   
   
When the link is made then: 


* You can assign evaluation criteria

* You can assign a rating with a coefficient system.

* The evaluation will display a summary of your criteria with their scores.

* The overall score will then be displayed on the invitation to tender for all the offers concerned.

* See: :ref:`the criteria evaluations<evaluation-criteria>` in the Call for tenders chapter


.. raw:: latex

    \newpage

.. index:: Expenses (Order to provider)

.. index:: Order to provider (Expenses)

.. _order_providers:

Orders to provider
------------------

This screen allow to manage the orders to provider.

.. figure:: /images/GUI/EXPENSES_SCR_OrderProvider.png
   :alt: Order to provider screen
   
   Order to provider screen
   
.. rubric:: Section Description

.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the expense 
   * - |RequiredField| Name
     - Short description of the expense
   * - |RequiredField| Order to provider type.
     - Type of order product and/or Service.  See: :ref:`order_provider_type`
   * - |RequiredField| Project 
     - The project concerned by the order
   * - Sent date 
     - Date of sending to the provider
   * - :term:`Origin`
     - Element which is the origin of the quotation 
   * - Provider
     - Name of the provider
   * - External Reference
     - Provider reference

 
.. rubric:: Section Treatment

.. figure:: /images/GUI/EXPENSES_ZONE_TreatmentOrderProvider.png
   :alt: Order to provider - Treatment section
   :align: center
   
   Order to provider - Treatment section
   
.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - |RequiredField| Status
     - Defines the progress of the processing of the element according to the :term:`workflow` used
   * - Responsible
     - Name of the person in charge of the order
   * - Contact
     - Name of the contact related to the order at the provider 
   * - payment conditions 
     - Description of payment terms
   * - Delivery delay 
     - From the validation of the order, processing time and preparation of the order
   * - Delivery date: **Planned date**
     - Delivery date planned by the provider
   * - Delivery date: **Real date**
     - Date of receipt of delivery
   * - Delivery date: **Validated date**
     - Date of validation of delivery to the service provider     
   * - :term:`Handled status`
     - Defines whether ‘handled’ flag is automatically set for this status
   * - :term:`Done status`
     - Defines whether ‘done’ flag is automatically set for this status
   * - :term:`Closed status`
     - Defines whether ‘closed’ flag is automatically set for this status
   * - :term:`Cancelled status`
     - Defines whether ‘cancelled’ flag is automatically set for this status
   * - Untaxed amount
     - Amount of the order without taxes
   * - Tax rate
     - Applicable tax rates in your country/region
   * - Tax Amount
     - Total amount of taxes calculated based on Taxe rate
   * - Full amount
     - Total amount of the order including taxes
   * - Project expense
     - Connect your provider's offer to an existing project expense
   * - Generate expense 
     - Automatically create expenses from the current item. The name of the project expenditure generated will be the same as that of the order.                  
   * - Comment
     - Leave your comments here


.. rubric:: List of terms section

This section allows you to create one or more terms for your bills.

* Click on |buttonAdd| to add a term. A pop-up opens.

* Click on |iconList| to add an existing term.

.. figure:: /images/GUI/EXPENSES_ZONE_ListOfTermSection.png
   :alt: List of term section
   
   List of term section
      
* The name and the date are mandatory.

* Enter the number of installments you want to pay your bill.

* If 1 then it is a cash payment.


.. figure:: /images/GUI/EXPENSES_ZONE_ListOfTerm.png
   :alt: Terms creation pop-up
   
   Terms creation pop-up

* When you enter several terms, the calculation on the total amount is done automatically.

* When you copy your order as a bill, the terms are automatically added to it.

* You can add due dates from the provider bill screen if you have not done so on this screen. 


.. figure:: /images/GUI/EXPENSES_ZONE_ListOfTermDetails.png
   :alt: calculation after number of deadlines entered
   
   Calculation after number of deadlines entered
   

When you transform your order into an bill, the terms recorded in the offer are automatically transferred to the bills.

In the offers, in the terms section, these will be filled in as billed with a link to the latter.


.. figure:: /images/GUI/EXPENSES_ZONE_ListOfTermSectionBilled.png
   :alt: List of terms billed
   
   List of terms billed
   
   

.. note:: 

   You can attach many documents related to your order: The general conditions of sale, the quotation, the order form ...            
   
.. raw:: latex

    \newpage

.. index:: Expenses (Terms of payment to provider)

.. index:: Terms of payment to provider (Expenses)

.. _TermPaymentProvider:

Terms of payments to providers
------------------------------

In France, inter-company payment periods are regulated and set at maximum 60 calendar days or 45 days end of month 
from the date of issue of the invoice. 

Failing to mention the payment period in the contract or the invoice,
it is legally fixed to 30 days after receipt of the goods or performance of the service. 

* Depending on the sector, deadlines are modifiable

* you can save, organize, track and edit your payment dates to your provider

* You can record one or more payment delays on each bill to the service provider.

* A bill can therefore be paid either in cash or in several installments.

* Each recorded due date, whether on the supplier orders screen or on the supplier invoices screen, generates a line on the terms screen.


.. rubric:: Section Description 

.. tabularcolumns:: |l|l|

.. list-table::  Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the term of payment
   * - |RequiredField| Name
     - Short description of the term
   * - |RequiredField| Project
     - project attached to the term of payment 
   * - Order to provider
     - Name of the order atatched to the term of payment  
   * - Provider Bill
     - the provider's invoice 
   * - Responsible
     - Name of the person in charge of the payment  

.. rubric:: Section Fixed price for term

.. tabularcolumns:: |l|l|

.. list-table::  Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - Initial ex VAT
     - Amount before taxes
   * - Tax
     - Applicable tax
   * - Full
     - Amount with taxes 
   * - |RequiredField| Date
     - date of expiry  
   * - Billed status
     - If payment has been billed  
   * - Paid status
     - If payment has been paid   
   * - :term:`Closed status`
     - Defines whether ‘closed’ flag is automatically set for this status.

.. note:: 

      * **Ex VAT:** The column value is automatically updated with the sum of bill line amounts.

      * **Tax:** If the tax is not defined, nothing is applied in this field and the amount will remain without tax
 
      * **Full:** If the total amount exclusive of tax and the tax rate have been entered, the total amount will be calculated automatically 
      
      * On the project, the sum of the expenses must be carried out in including taxes if the entry of expenses is in including taxes
 



.. raw:: latex

    \newpage

.. index:: Expenses (Provider Bills)

.. index:: Provider Bills (Expenses)

.. Provider_Bills:

Provider bills
--------------

This screen is used to manage bills generated manually or linked to provider offers.


.. figure:: /images/GUI/EXPENSES_SCR_ProviderBill.png
   :alt: Provider bill screen
   
   Provider bill screen
   
   
.. rubric:: Section Description 

.. tabularcolumns:: |l|l|

.. list-table::  Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the term of payment
   * - |RequiredField| Name
     - Short description of the term
   * - |RequiredField| Provider :ref:`client_bill_type`
     - The way to define common behavior on group of bills     
   * - |RequiredField| Project
     - project attached to the bill 
   * - Date
     - Date of the bill
   * - :term:`Origin`
     - Element which is the origin of the quotation 
   * - Provider
     - Provider name.
   * - |RequiredField| External reference
     - :term:`External reference` of the provider's bill
   * - :term:`Description`
     - Complete description of the expense.






.. rubric:: Section Treatment

.. tabularcolumns:: |l|l|

.. list-table::  Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - |RequiredField| :term:`status`
     - Actual status of the expense.
   * - Responsible
     - person placing the order 
   * - Contact
     - name of the person at the provider related to this bill     
   * - Payment conditions
     - the payment terms of the provider 
   * - Payment due date
     - expected payment date
   * - :term:`Handled`
     - Box checked indicates that the tender is handled with date when checked.
   * - :term:`Done`
     - Box checked indicates that the tender is done with date when checked. 
   * - :term:`Closed`
     - Box checked indicates that the tender is archived with date when checked.
   * - Cancelled
     - Box checked indicates that the tender is cancelled.




.. rubric:: List of terms section

This section allows you to create one or more terms for your bills.

If your bill was created from an order, then the terms recorded on the offer will be automatically recovered on the bill.


.. figure:: /images/GUI/EXPENSES_ZONE_ListOfTermSection.png
   :alt: List of term section
   
   List of term section

* Click on |buttonAdd| to add a term. A pop-up opens.

* Click on |iconList| to add an existing term.
      
* The name and the date are mandatory.

* Enter the number of installments you want to pay your bill.

* If 1 then it is a cash payment.


.. figure:: /images/GUI/EXPENSES_ZONE_ListOfTerm.png
   :alt: Terms creation pop-up
   
   Terms creation pop-up

* When you enter several terms, the calculation on the total amount is done automatically.

* When you copy your order as a bill, the terms are automatically added to it.

* You can add due dates from the provider bill screen if you have not done so on this screen. 


.. figure:: /images/GUI/EXPENSES_ZONE_ListOfTermDetails.png
   :alt: calculation after number of deadlines entered
   
   Calculation after number of deadlines entered
   

In the offers, in the terms section, these will be filled in as billed with a link to the latter.

.. figure:: /images/GUI/EXPENSES_ZONE_ListOfTermSectionBilled.png
   :alt: List of terms billed
   
   List of terms billed
   
     
   
   
.. raw:: latex

    \newpage

.. index:: Expenses (Payment to provider)

.. index:: Payment to provider (Expenses)

.. _payment-provider:

Payments to provider
--------------------

Follow the payment of your provider bills to better organize your general cash flow or your working capital


.. rubric:: Section Description 

.. tabularcolumns:: |l|l|

.. list-table::  Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the term of payment
   * - |RequiredField| Name
     - Short description of the payment
   * - |RequiredField| Payment to :ref:`provider-type`
     - The way to define common behavior on payments to provider     

.. rubric:: Section Treament 

.. figure:: /images/GUI/EXPENSES_ZONE_TreatmentPayments.PNG
   :alt: Payment modes
   
   Payment modes

.. tabularcolumns:: |l|l|

.. list-table::  Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - Payment mode
     - Groups different payment methods.
   * - Payment date
     - The date on which the payment method chosen above will be made.
   * - payment amount 
     - Amount of the bill.
   * - Payment fee
     - Fee generated by payment or otherwise.
   * - payment credit 
     - Amount of credit if there is.   
   * - Provider payment term
     - Selection of the payment term to the provider. if the exchanges were created on the offers or on the bill, they will be available in the list.
   * - Provider bill
     - Selection of the provider bill. The bill is automatically choose if the provider payment term is existing.
   * - Provider bill reference
     - The reference is automatically fill in when selecting the provider bill.
   * - Provider
     - The name of the provider is automatically fill when selecting the provider bill.
   * - Provider bill amount
     - The amount of the bill is automatically fill when selecting the provider bill.                             
   * - :term:`Closed`
     - Box checked indicates that the tender is archived with date when checked.


When the payment to the supplier has been completed and recorded, on the screen of provider bill in the treatment section, you will find a record of these payments.

In the list of terms section, you can see in the table, the terms for which the settlement has been made.

When all the deadlines have been honored, on the screen of invoices to the service provider the completed payment box is automatically checked and the date of the last due date is recorded but is always editable. 

.. figure:: /images/GUI/EXPENSES_ZONE_Payment.png
   :alt: List of paid installments
   
   List of paid installments
   
   

.. raw:: latex

    \newpage

.. index:: Expenses (Individual)

.. index:: Individual Expenses

.. _individual-expense:

Individual expenses
-------------------

An individual expense stores information about individual costs, such as travel costs or else.

Individual expense has detail listing for all items of expense.

This can for instance be used to detail all the expense on one month so that each user opens only one individual expense per month (per project), or detail all the elements of a travel expense.


.. rubric:: Section Description

.. sidebar:: Other sections

   * :ref:`expense-detail-lines`
   * :ref:`Linked element<linkElement-section>`
   * :ref:`Attachments<attachment-section>`
   * :ref:`Notes<note-section>`

.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the expense.
   * - |RequiredField| Name
     - Short description of the expense.
   * - |RequiredField| Type
     - Type of expense.
   * - |RequiredField| Project
     - The project concerned by the expense.
   * - |RequiredField| Resource
     - Resource concerned by the expense.
   * - :term:`Description`
     - Complete description of the expense.

.. rubric:: Section Treatment

.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - |RequiredField| Status
     - Actual :term:`status` of the expense.
   * - Responsible
     - Person responsible for the processing of this expense
   * - Planned amount
     - Planned amount of the expense (Date is mandatory)
   * - Real amount
     - Real amount of the expense (Date is mandatory) 
   * - Budget item
     - Budget item related to expense  
   * - Payment done
     - Box checked indicates the payment is done. 
   * - :term:`Closed`
     - The box is checked automatically when the invoice linked to this expense is paid
   * - Cancelled
     - Box checked indicates that the expense is cancelled




.. raw:: latex

    \newpage


.. index:: Expenses (Project)

.. index:: Project (Expenses)

.. _project-expense:

Project expense
---------------

.. sidebar:: Other sections

   * :ref:`expense-detail-lines`
   * :ref:`Linked element<linkElement-section>`
   * :ref:`Attachments<attachment-section>`
   * :ref:`Notes<note-section>`
   
A project expense stores information about project costs that are not resource costs.

This can be used for all kinds of project cost : 

* Machines (rent or buy).
* Softwares.
* Office.
* Any logistic item.

.. rubric:: Section Description

.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the expense.
   * - |RequiredField| Name
     - Short description of the expense
   * - |RequiredField| Type
     - Type of expense: machine or office expense
   * - |RequiredField| Project
     - The project concerned by the expense
   * - Provider
     - Provider name
   * - :term:`External reference`
     - External reference of the expense
   * - :term:`Origin`
     - Element which is the origin of the quotation  
   * - Business responsible
     - The person who makes the purchase requisition
   * - Financial responsible
     - The person who pays the purchase
   * - Payment conditions
     - Conditions of payment
   * - :term:`Description`
     - Complete description of the expense


.. rubric:: Section Treatment

.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - |RequiredField| Status
     - Actual :term:`status` of the expense.
   * - Order date
     - Date of the order.
   * - Delivery mode
     - Delivery mode for the order.
   * - Delivery delay
     - Delivery delay for the order.
   * - Expected delivery date
     - Expected delivery date for the order.
   * - Date of receipt
     - Date of receipt of the order.
   * - :term:`Closed`
     - Box checked indicates that the expense is archived.
   * - Cancelled
     - Box checked indicates that the expense is cancelled.
   * - Planned
     - Planned amount of the expense (Date is mandatory).
   * - Real
     - Real amount of the expense (Date is mandatory).
   * - Payment done
     - Box checked indicates the payment is done.
   * - Result
     - Complete description of the treatment of the expense.  
  
.. topic:: Fields Planned & Real

   * **Ex VAT**: Amount without taxes.
     
     * Real amount is automatically updated with the sum of the amounts of detail lines.

   * **Tax**: Applicable tax. 

   * **Full**: Amount with taxes.

   * **Payment date**: 

     * For field "Planned" is the planned date.
     * For field "Real" can be the payment date or else.


.. raw:: latex

    \newpage

.. index::  Expenses (Detail line)

.. _expense-detail-lines:

Expenses detail lines
=====================

.. rubric:: Section Expenses detail lines

This section is common to individual and project expenses.

It allows to enter detail on expense line.

.. topic:: Fields: Real amount and date

   * When a line is entered, expense real amount is automatically updated to sum of lines amount.
   * Real date is set with the date in the firts detail line.


.. tabularcolumns:: |l|l|

.. list-table::
   :header-rows: 1

   * - Field
     - Description
   * - Date
     - Date of the detail line.
   * - Name
     - Name of the detail line.
   * - Type
     - Type of expense.
   * - Detail
     - Detail depends on the type of expense.
   * - Amount
     - Amount of the detail line.


.. rubric:: Detail lines management
 
* Click on |buttonAdd| to add a detail line.
* Click on |buttonEdit| to modify an existing detail line.
* Click on |buttonIconDelete| to delete the detail line.


.. figure:: /images/GUI/BOX_ExpenseDetail.png
   :alt: Dialog box - Expense detail
   :align: center

   Expense detail dialog box
   
.. tabularcolumns:: |l|l|

.. list-table:: Fields - Expense detail dialog box - Required field |ReqFieldLegend| 
   :header-rows: 1

   * - Field
     - Description
   * - Date
     - Date of the detail.
   * - Reference
     - External reference.
   * - |RequiredField| Name
     - Name of the detail.
   * - Type
     - Type of expense.
   * - |RequiredField| Amount
     - Amount of the detail.

.. topic:: Field Date

   This allows to input several items, during several days, for the same expense, to have for instance one expense per travel or per month.

.. topic:: Field Type

   Depending on type, new fields will appear to help calculate of amount.
   
   Available types depending on whether individual or project expense.
   
   See: :ref:`expense-detail-type`. 

.. topic:: Field Amount 

   Automatically calculated from fields depending on type.
   
   May also be input for type “justified expense”.
   
   
.. rubric:: Financial expenses synthesis

When your financial elements have been linked and attached to a project expense (detailed or not), you will find the summary of these elements.

.. figure:: /images/GUI/EXPENSES_ZONE_ExpensesDetailsSynthesis.png   
   :alt: Details Line and financial expenses synthesis

   
   