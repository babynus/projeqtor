.. raw:: latex

    \newpage

.. title:: Installation

Installation
---------------
.. rubric:: Prérequis

ProjeQtOr est une application Web.
Ceci signifie qu'avant de pouvoir installer ProjeQtOr, il faut avoir installé un serveur Web intégrant : 

- Un serveur http, généralement Apache, mais peut aussi être NGINX)

- Un serveur PHP version 5.4 ou supérieure, généralement installé comme module Apache. Attention, la configuration de PHP sous NGINX est plus subtile et sera réservé aux utilisateurs avertis.

- Une base de données MySQL version 5 ou supérieure  ou une base de données PostgreSql version 8.4 ou supérieure. A noter que pour ProjeQtOr, MariaDB est assimilé à MySQL, il n'y a aucune distinction.

Par exemple, vous pouvez essayer de configurer un serveur EasyPHP, qui intègre tous les composants requis.
Cette configuration n'est pas recommandée à des fins de production, mais seulement à des fins de test et d'évaluation.
Un serveur WAMP Server sera plus approprié pour un environnement de Production sous Windows.

Vous pouvez également configurer un serveur ZEND, qui intègre Apache et PHP. Il faudra y ajouter un serveur MySql ou PostgreSql.
Cette configuration est adaptée à des fins de production.

D'autres packages incluant PHP, Apache et MySql peuvent être utilisés pour faciliter l'installation des briques techniques. On les retrouve sous les appellations WAMPP (sous Windows), MAMP (sous Mac OS), XAMP (sous Linux) et plus génériquement xAMP.

Sous Linux, il est facile d'installer ces briques en utilisant les dépôts standards. Certaines distributions intègrent nativement Apache et PHP ou NGINX.

Pensez à vérifier sur le site de ProjeQtOr les pré-requis en termes de module PHP nécessaires et de configuration conseillée.


.. rubric:: Procédure d'installation

Une fois que les pré-requis sont installés (PHP et MySql opérationnels), l'installation de ProjeQtOr est simple :

- Dézipper projeqtorVx.y.z.zip dans le répertoire du serveur Web.

- Exécutez l'application dans votre navigateur préféré, en utilisant http://nomDuServeur/projeqtor

- L'application affiche l'écran de configuration

.. rubric:: Configuration

- Au premier lancement, l'écran de configuration s'affiche.

- Il est généralement possible d'utiliser ProjeQtOr avec les paramètres par défaut. Certains paramètres ne seront pas sécurisés, mais ceci pourra être modifié par la suite.
Si l'authentification à MySql échoue, pensez à tester sans mot de passe : MySql est souvent installé sous Windows sans mot de passe pour le user "root". Ceci devrait bien sûr être corrigé pour sécuriser la base de données.

- Suite à cette configuration, la paramétrage sera sauvegardé dans le fichier parameter.php (à l'emplacement précisé sur l'écran de configuration) et les pré-requis seront testés. Certains message seront affichés
 * En vert : les prérequis correctement satisfaits
 * En rose : les prérequis non satisfaits mais non indispensables au bon fonctionnement de ProjeQtOr. Vous pouvez continuer l'installation, mais certaines fonctionnalités pourraient ne pas être disponibles. Le message affiché devrait être explicite sur ce point.
 * En rouge : les prérequis bloquants. L'installation ne peut continuer tant que l'anomalie n'est pas corrigée.

- Si les prérequis sont corrects, vous obtenez un bouton "continuer", qui vous mènera à l'écran de connexion de l'application. Pour la première connexion, utilisez le compte "admin", mot de passe "admin".

- Lors de la première connexion, la base de données sera automatiquement peuplée des tables nécessaires au fonctionnement de ProjeQtOr. Cela peut prendre plusieurs minutes.

** Note
Pour exécuter à nouveau l'écran de configuration, il suffit de supprimer le fichier "/tool/parametersLocation.php".

.. rubric:: Support 

- En cas de probèmes, vous pouvez demander de l'aide sur le site de Forum de ProjeQtOr http://www.projeqtor.org