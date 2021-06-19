.. raw:: latex

    \newpage

Installer une nouvelle version
----------------------------------
.. rubric:: Installer une nouvelle version

ProjeQtOr évoluera constamment pour répondre aux besoins des utilisateurs.
Pour déployer une nouvelle version, décompressez le nouveau projectorVx.y.z.zip dans le répertoire du serveur Web et connectez-vous à l'application.
Les mises à jour de la base de données seront automatiquement déclenchées.
Une fois terminé, un message affiche la synthèse des mises à jour (nombre d'erreurs éventuelles).
Vous trouverez les détails des mises à jour dans le fichier journal.

Certaines nouvelles versions peuvent également ajouter de nouveaux paramètres.
Ceux-ci seront naturellement intégrés dans l'écran de configuration.
Si vous déployez une de ces versions à partir d'une version précédemment installée, de nouveaux paramètres seront automatiquement insérés à la fin de votre fichier "parameter.php" avec une valeur par défaut.
Vous pourrez alors mettre à jour cette valeur dans votre contexte, en modifiant le fichier.
Dans ce cas, un message vous informe que de nouveaux paramètres ont été ajoutés, à l'écran de connexion, juste avant le message "Mise à jour de la base de données".

.. warning:: 
   Si vous mettez à niveau une version inférieure à 1.1.0, vous devez supprimer la dernière fermeture de script (?>) Dans le fichier "parameters.php" avant la mise à niveau.

Mais aussi : 

.. warning:: Il est fortement recommandé de sauvegarder votre base de données avant de passer à la nouvelle version, pour pouvoir revenir à la version précédente.

.. seealso:: Vous pouvez mettre à jour deux fois (si nécessaire) : mettre à jour la table "parameter", réinitialiser la valeur de la ligne où parameterCode = 'dbVersion' au numéro de version précédente et se connecter à nouveau. 
             Si vous constatez alors que certains éléments de menu ont disparu, vérifiez les entrées doubles dans la table d'habilitation (dernières lignes) et supprimez-les (cela ne devrait pas se produire depuis V1.5.0).
.. title:: Deployment

Procédure de Migration
---------------------------
.. rubric:: Déploiement initial

.. rubric:: Migration vers nouvelle version

J-3 :
  - Annonce par un message en page de login : "Le xx/xx/xxxx l'application sera fermée à xx heure pour une opération de maintenance"
      
H-1 :
  - Fermeture de l'application
  - Envoie d'un message de rappel " fermeture dans une heure"
      
H :
  - Déconnexion des derniers utilisateurs connectés
  - Installation de la nouvelle version (recopie du code pour écraser l'existant)
  - Déconnexion/reconnexion admin
  - Vérifications (VABF)
  - Réouverture de l'application

Cas particulier de changement de serveur
----------------------------------------

Il faut :
  - Copier la base de données
  - Copier tout le code (c’est le plus simple pour ne rien oublier)
  - Modifier le fichier parameters.php qui contient les informations de connexion à la base (à modifier) et certains répertoires (à modifier ou pas selon la configuration)
  - Se connecter à l’application : tout devrait fonctionner correctement
  - Allez de suite dans paramètres globaux, onglet « système » et vérifiez les répertoires des fichiers attachés et des documents et sous l’onglet « automatismes » le répertoire des imports
Si ces répertoires ont un chemin relatif (« ../files/xxxx »), il n’y a rien à faire de plus, mais la configuration n’est pas sécurisée
Si ces chemins ont un chemin absolu (« /var/xxxx ») ; il faut recopier ces répertoires de la source et éventuellement adapter les répertoires en fonction de l’environnement

Si on ne veut pas recopier tout le code pour repartir avec une nouvelle version du code, il faut penser à récupérer : 
  - les customisations : tous les fichiers dans projeqtor/model/custom
  - les plugins : tous les répertoires dans projeqtor/plugin
  - les rapport spécifiques : tous les fichiers dans projeqtor/report/object et dans projeqtor/report/template
  - la configuration .htaccess dans le répertoire projeqtor/api


