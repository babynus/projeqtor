.. include:: ImageReplacement.txt

.. index:: Translation

.. _Translation:

Translation
***********

Translations are a separate module. By activating it you have access to a series of screens allowing you to manage your translation requests.

This module is linked to configuration management. If the configuration module is not active then you will not be able to record any request.

.. figure:: /images/GUI/ACCESSRIGHT_SCR_ManagementModuleTranslation.png
   :alt: Module management screen - Translation
   
   Module management screen - Translation
   
   
   
See: :ref:`Module management<module-management>`

See: :ref:`Configuration management<ConfigurationManagement>`




   
Language skill level
--------------------

You set the skill levels on this screen.

The levels are customizable and you can create as many as you want.

By default, ProjeQtOr offers you the 3 most basic levels: beginner, intermediate and advanced.

These skill levels are required of you when creating your :ref:`translators`.





Translation requests types
--------------------------

You define the types of translation that you will use in your business.

.. figure:: /images/GUI/TRANSLATION_SCR_RequestTypes.png
   :alt: Request types
   
   Request types
   

.. rubric:: Behaviour

For each type you can apply automatisms.

* Make the Description mandatory.
* Make the manager mandatory as soon as the status changes to "in progress".
* You can lock the "completed" status, it can then only be modified by the status if the box is checked.
* You can lock the "closed" status, it can then only be modified by the status if the box is checked.
* You can lock the "canceled" status, it can then only be modified by status if the box is checked.

   
   

Translation items types
-----------------------

Under construction


.. _translators:

Translators
-----------

You register your translators from your resources.

.. figure:: /images/GUI/TRANSLATION_SCR_Translators.png
   :alt: Translators screen
   
   Translators screen
   
* Each translator can have one or more associated languages.

* Each language has a skill level.


Translation request
-------------------

You create a translation request in one or more languages.
This request must be linked to a product or a product version.

The product or product version must have at least one language specified, in order to be able to link it to the translation request.

The original language of the text to be translated must be entered.

When the request is saved, one line on the translations screen is generated per language registered on the product or product version without taking into account the original language.

The text to be translated in the original language being existing, the line is not generated

.. figure:: /images/GUI/TRANSLATION_SCR_TranslationRequest.png
   :alt: Translation request screen
   
   Translation request screen


Translation
-----------

Under construction