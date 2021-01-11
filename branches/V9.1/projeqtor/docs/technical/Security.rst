.. raw:: latex

    \newpage

.. title:: Security

Sécurisation
------------
.. rubric:: Securité

L'installaton par défaut permet de faire fonctionner ProjeQtOr, mais la configuration proposée, simple, n'est pas sécurisée.
Afin de sécuriser votre installation, quelques bonnes pratiques doivent être appliquées.


Les répertoires contenant les données sensibles doivents être déplacées hors de portée du chemin web :
    - Le fichier des paramètres    
    - le répertoire des logs
    - Le répertoire des fichiers attachés    
    - Le répertoire des documents    
    - Le répertoire des imports.

L'idéal est de réaliser cette adaptation lors de la configuration initiale.
Sinon, il faut :
 - déplacer les répertoires
 - corriger leur emplacement :
     - dans tools/parametersLocation.php pour l'emplacement du fichier parameters.php
     - dans parameters.php pour l'emplacement du répertoire des logs
     - directement dans l'application, via l'écran des paramètres globaux pour les autres emplacements
    
