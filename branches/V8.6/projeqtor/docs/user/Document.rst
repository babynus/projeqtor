.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage

.. title:: Documents

.. index:: Documents 

.. _document:

Documents
---------

.. sidebar:: Concepts 

   * :ref:`product-concept`

A document is a reference element that gives a description of a project or product.

The document element describes the general information.

The file will be stored in the tool as versions.

.. figure:: /images/GUI/DOCUMENT_SCR_Documents.png
   :alt: Documents screen
   
   Documents screen





.. rubric:: Description section

.. sidebar:: Other sections

   * :ref:`Linked element<linkElement-section>`
   * :ref:`Notes<note-section>`

     
.. list-table:: Required fields |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the context.
   * - |RequiredField| Type
     - Type of the document
   * - |RequiredField| Project
     - Name of the project to which the document is attached    
   * - Product
     - Name of the product to wich the document is attached
   * - |RequiredField| Directory
     - Choose the :ref:`directory<document-directory>` in which the document should be saved
   * - Document reference 
     - Automatic reference created from the parameters saved in the :ref:`global parameters<gp-reference>` 
   * - External reference   
     - Manual reference corresponding to your activity 
   * - Author
     - The author, the creator of the document.
   * - :term:`Closed`
     - Box checked indicates the document is archived.
   * - Cancelled
     - Box checked indicates the document is cancelled. 


.. rubric:: Project and Product

Must be concerned either with a project, a product or both.

If the project is specified, the list of values for field "Product" contains only products linked the selected project.

.. rubric:: Field Author

Positioned by default as the connected user.

Can be changed (for instance if the author is not the current user).



.. index:: lock document

.. rubric:: Section Lock

This section allows to manage document locking.

When a document is locked the following fields are displayed.


.. figure:: /images/GUI/DOCUMENT_ZONE_LockDocument.png
   :alt: Lock the document section
   
   Lock document section
   
  



.. tabularcolumns:: |l|l|

.. list-table:: Fields when the document is locked
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Locked
     - Box checked indicates the document is locked.
   * - Locked by
     - User who locked the document.
   * - Locked since
     - Date and time when document was locked.

.. compound:: lock/unlock this document
 
   * Button to lock or unlock the document to preserve it from being editing, or new version added.
         
   * When document is locked it cannot be modified
         
   * When the document is locked, it can not be downloaded except for the user who locked it or a user with privilege
         
   * Only the user who locked the document, or a user with privilege can unlock it
         
   * You can forbid :ref:`Global Parameters<format_reference_doc>`
   
   



.. raw:: latex

    \newpage

.. index:: Document

.. index:: Versioning

.. _versioning:

Document versioning
___________________

This section allows to manage version list of document.

Document versioning allows to keep different version at each evolution of the document.

Document can evolve and a new file is generated at each evolution.

Type of versioning must be defined for a document. 

.. figure:: /images/GUI/DOCUMENT_ZONE_Versioning.png
   :alt: Versionning section
   
   Versioning section
   
   
.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :widths: 40, 80
   :header-rows: 1

   * - Field
     - Description
   * - |RequiredField| Versioning type
     - Type of versioning for the document.
   * - Last version
     - Caption of the last version of the document.
   * - :term:`Status`
     - Status of the last version of the document.



* Click on |buttonAdd| to add a new version. 
* Click on |iconDownload| to download file at this version.
* Click on |buttonEdit| to modifiy a version.
* Click on |buttonIconDelete| to delete a version.
* Click on |ListApprovers| to display the history for approvals for version

   
  


.. rubric:: Type of versioning

A document can evolve following four ways defined as versioning type :

   .. compound:: **Evolutive**
   
    * Version is a standard Vx.y format. 
    * It is the most commonly used versioning type.
    * Major updates increase x and reset y to zero. 
    * Minor updates increase y.
   
   .. compound:: **Chronological**
   
    * Version is a date. 
    * This versioning type is commonly used for periodical documents.
    * For instance : weekly boards.
   
   .. compound:: **Sequential**
   
    * Version is a sequential number. 
    * This versioning type is commonly used for recurring documents.
    * For instance : Meeting reviews.
   
   .. compound:: **Custom**
   
    * Version is manually set. 
    * This versioning type is commonly used for external documents, when version is not managed by the tool, or when the format cannot fit any other versioning type.



.. rubric:: Document viewer

* Document viewer available for image, text and PDF files.
* Click on |buttonAdd| to display the pop up.


.. figure:: /images/GUI/BOX_DocumentVersion.png
   :alt: Dialog box - Document version 
   :align: center
   
   Document version dialog box


.. note:: 

   **Name of download file**
   
   The name of download file will be the document reference name displayed in **description** section.
   
   If you want to preserve the uploaded file name, set the parameter in  the :ref:`Global parameters <format_reference_doc>`



.. tabularcolumns:: |l|l|

.. list-table::  Fields - Document version dialog box
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - File
     - This button allows to upload locale file.
   * - Last version
     - Caption of the last existing version.
   * - Update
     - Importance of the update concerned by the new version.
   * - New version
     - New caption for the created version.
   * - Date
     - Date of the version.
   * - Status
     - Current status of the version.
   * - Is a reference
     - Check box to set this version is the new reference of the document.
   * - Description
     - Description of the version.

.. rubric:: Field "Update"

A version can have a draft status, that may be removed afterwards.

.. rubric:: Field "Is a reference"

Should be checked when version is validated.

Only one version can be the reference for a document.

Reference version is displayed in bold format in the versions list.

.. rubric:: Field "Description"
   
May be used to describe updates brought by the version.

This icon |Note| appears when the description field is filled.

Moving the mouse over the icon will display description text.







Approval process
________________


.. figure:: /images/GUI/DOCUMENT_ZONE_Approvers.png
   :alt: Approvers section
   
   Approvers section
   
      
You can define approvers for a document.
  
* Click on |buttonAdd| to add an approver
* Click on |buttonIconDelete| to delete an approver

.. warning :: Only users assigned to the project linked to the document can be added
    
When an approver is created in the list, the approver is also automatically added to the latest version of the document.
   
When adding a version to the document, approvers are automatically added to the version.


.. rubric:: The approvers


Each approver can see the list of documents to approve on their Today screen.



.. figure:: /images/GUI/DOCUMENT_ZONE_ApproverValidation.png
   :alt: Details zone for the approvers
   
   Document details area for the approvers
   
   
   
On the Documents screen, the approver can approve or reject the document.

Once the document is approved, the line is then checked and the date and time of the approval recorded.   

.. figure:: /images/GUI/DOCUMENT_ZONE_DocumentApprove.png
   :alt: Document is approved
   
   Document is approved

When all approvers have approved the document version, it is considered approved and then appears with a check mark in the list of versions.
  
   

  .. compound:: Send a reminder email to approvers

   Send an email to approvers who have not yet validated the document. 

   Those who have already validated it will not receive this email.

   The sending will be effective if an email address has been registered for the user.







.. raw:: latex

    \newpage

.. title:: Document directories management

.. index:: Document (Directories management) 

.. _document-directory:

Document directories
--------------------

Document directories management allows to define a structure for document storage.

* The files of document will be stored in the folder defined by the parameters  **Document root** and **Location**.
* **Document root** is defined in :ref:`Global parameters<file-directory-section>` screen. 

.. rubric:: Section Description

.. tabularcolumns:: |l|l|

.. list-table:: Required field |ReqFieldLegend|
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the directory.
   * - |RequiredField| Name
     - Name of the directory.
   * - Parent directory
     - Name of the parent directory to define hierarchic structure.
   * - Location
     - Folder where files will be stored.
   * - Project
     - Directory is dedicated to this project.
   * - Product
     - Directory is dedicated to this product.
   * - Default type
     - Type of document the directory is dedicated to.
   * - :term:`Closed`
     - Flag to indicate that directory is archived.
 
.. topic:: Field **Parent directory**

   The current directory is then a sub-directory of parent.

.. topic:: Field **Location**

   Location is automatically defined as «Parent directory» / «Name».

.. topic:: Field **Project**

   This project will be the default to new stored documents in this directory.

.. topic:: Field **Product**

   This product will be the default to new stored documents in this directory.
   
   If the project is specified, the list of values contains the products linked the selected project.
   
   If the project is not specified, the list of values contains all products defined.

.. topic:: Field **Default type**

   This document type will be the default to new stored documents in this directory.



      

Nomenclature
------------

.. rubric:: product designation in the document nomenclature

Possibility to take into account the designation of the product in the nomenclature of documents with the new codes

* {PROD} product designation
* {PROJ / PROD} the project code if specified, otherwise the product designation
* {PROD / PROJ} designation of the product if specified, otherwise the project code
