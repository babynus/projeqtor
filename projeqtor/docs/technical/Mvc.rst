.. raw:: latex

    \newpage

.. title:: Mvc

Modèle Vue Contrôleur
-----------------------

Modèle-Vue-Contrôleur (MVC) est une type d'architecture destiné aux interfaces graphiques et très populaire pour les applications web.

Les types de modules ont trois responsabilités différentes : 

    - Un modèle qui contient les données à afficher.
    - Une vue qui contient la présentation de l'interface graphique.
    - Des contrôleurs qui contiennent "la logique" concernant les actions effectuées par l'utilisateur.

Dans ProjeQtOr les modèles sont placés dans le dossier **model**.
Il y a un ensemble de contrôleurs dans le dossier **tool** dont le principal est **projeqtor.php** qui est appelé dans chaque script. 
Les vues sont dans le dossier view.

ProjeQtOr n'applique pas strictement le modèle MVC afin de conserver de la "souplesse" au niveau de son framework. Par exemple, pour chaque objet du modèle, on n'a pas de description de type vue. C'est la description des champs du modèle, et leur type en base de données qui permet de construire la vue sur l'objet grace au script **objectDetail.php**

