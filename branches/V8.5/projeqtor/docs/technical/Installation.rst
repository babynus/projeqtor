.. raw:: latex

    \newpage

.. title:: Installation

Installation
---------------
.. rubric:: Prérequis

ProjeQtOr est une application Web.
Ceci signifie qu'avant de pouvoir installer ProjeQtOr, il faut avoir installé un serveur Web intégrant : 

- Un serveur http (généralement Apache)

- Un serveur PHP version 5.2 ou supérieure (généralement installé comme module Apache)

- Un base de données MySQL version 5 ou supérieure  ou une base de données PostgreSql version 8.4 ou supérieure

Par exemple, vous pouvez essayer de configurer un serveur EasyPHP, qui intègre tous les composants requis.
Cette configuration n'est pas recommandée à des fins de production, mais seulement à des fins de test et d'évaluation.

Vous pouvez également configurer un serveur ZEND, qui intègre Apache et PHP. Il faudra y ajouter un serveur MySql ou PostgreSql.
Cette configuration est adaptée à des fins de production.

D'autres packages incluant PHP, Apache et MySql peuvent être utilisés pour faciliter l'installation des briques techniques. On les retrouve sous les appellations WAMP (sous Windows), MAMP (sous Mac OS), XAMP (sous Linux) et plus génériquement xAMP.

Sous Linux, il est facile d'installer ces briques en utilisant les dépôts standards. Certaines distributions intègrent nativement Apache et PHP.


.. rubric:: Procédure d'installation

- Dézipper projeqtorVx.y.z.zip dans le répertoire du serveur Web.

- Exécutez l'application dans votre navigateur préféré, en utilisant http://tonserveur/projeqtor

- Prendre plaisir !

.. rubric:: Configuration

- Au premier lancement, l'écran de configuration s'affiche.
- Il est généralement possible d'utiliser ProjeQtOr avec les paramètres par défaut. Certains paramètres ne seront pas sécurisés, mais ceci pourra être modifié par la suite.

- Pour exécuter à nouveau l'écran de configuration, il suffit de supprimer le fichier "/tool/parametersLocation.php".

- Lors de la première connexion, la base de données sera automatiquement peuplée des tables nécessaires au fonctionnement de ProjeQtOr. Cela peut prendre plusieurs minutes.

.. rubric:: Support 

- En cas de probèmes, vous pouvez demander de l'aide sur le site de Forum de ProjeQtOr http://www.projeqtor.org