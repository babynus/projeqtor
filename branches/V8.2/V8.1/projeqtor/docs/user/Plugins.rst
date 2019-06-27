.. raw:: latex

    \newpage

.. title:: Plugins

Développement de Plugins
------------------------
.. rubric:: Déploiement et structure d'un plugin

Les plug-ins doivent être compressés sous forme de fichier zip incluant le nom du plugin et sa version.
      
Par exemple : myPlugin_V1.0.zip
      
Le fichier zip doit inclure le dossier racine avec le nom du plug-in.
      
Pour être intégré, le fichier zip doit être placé dans le dossier / plugin manuellement ou via la fonctionnalité "télécharger le plug-in". 

.. rubric:: Structure de l'archive de déploiement d'un plug-in
     
+----------------------------+------------------------------------------------------------+
| **Répertoire**             | **Utilité**                                                |
+============================+============================================================+
| plugin                     | Répertoire racine des plug-ins                             |
+----------------------------+------------------------------------------------------------+
| __loadPlugin.php           | Le script de gestion des plug-ins                          |
+----------------------------+------------------------------------------------------------+
| __nls                      | Répertoire racine pour les fichiers de traduction          |
|                            | spécifiques utilisés par le plug-in                        |
|                            | "customizedTranslations"                                   |
+----------------------------+------------------------------------------------------------+
| __myPlugin                 | Répertoire racine du plug-in "MyPlugin"                    |
+----------------------------+------------------------------------------------------------+
| ____nls                    | Répertoire racine pour les fichiers de traduction          |
|                            | spécifiques utilisés par le plug-in "myPlugin"             |
+----------------------------+------------------------------------------------------------+
| ____*.php                  | Scripts utilisable par le plug-in                          |
+----------------------------+------------------------------------------------------------+
| ____myPlugin.css           | Fichier CSS utilisé par myPlugin                           |
|                            | (sera chargé automatiquement)                              |
+----------------------------+------------------------------------------------------------+
| ____myPlugin.js            | Fonctions Javascript utilisé par myPlugin                  |
|                            | (sera chargé automatiquement)                              |
+----------------------------+------------------------------------------------------------+      
| ____pluginDescriptor.xml   | Le fichier descripteur xml du plug-in.                     |
|                            | Obligatoire. Contient des informations de déploiement.     |
+----------------------------+------------------------------------------------------------+      
  

.. rubric:: Description du contenu du descripteur "pluginDescriptor.xml"


+----------------------------------------+-------------------------------------------------+
| **Structure du descripteur XML**       | **Utilité**                                     |
+========================================+=================================================+
| plugin                                 | Répertoire racine des plug-ins.                 | 
|                                        | L'attribut "nom" doit être égal au répertoire   |
|                                        | contenant le plug-in et doit correspondre au nom| 
|                                        | du fichier zip.                                 | 
+----------------------------------------+-------------------------------------------------+
| property~name="description"            | Une courte description du plug-in               |  
+----------------------------------------+-------------------------------------------------+
| property~name="comment"                | Une description plus longue du plug-in          |
+----------------------------------------+-------------------------------------------------+          
| property~name="uniqueCode"             | Code unique du plug-in. Les codes de 100000 à   |
|                                        | 199999 sont réservés aux plug-ins ProjeQtor.    |
|                                        | Des codes de 200000 à 899999 peuvent être       |
|                                        | demandés à ProjeQtOr pour vos plug-ins          |
|                                        | déployables.                                    |
|                                        | Si vous créez vos propres plug-ins, vous        |
|                                        | pouvez utiliser en toute sécurité des valeurs   |
|                                        | >900000.                                        |
|                                        | L'id inséré (par exemple pour le menu) doit     |
|                                        | commencer par ce code +3 chiffres.              |
+----------------------------------------+-------------------------------------------------+
| property~name="version"                | Version du plug-in (doit correspondre à la      | |                                        | version sur le nom du fichier zip)              |
+----------------------------------------+-------------------------------------------------+
| property~name="compatibility"          | Première version de ProjeQtOr compatible avec   | |                                        | le plug-in                                      |
+----------------------------------------+-------------------------------------------------+


+----------------------------------------+-------------------------------------------------+
| property~name="sql"~version="x.y"~     | Le script SQL qui sera exécuté pendant le       |
|                                        | déploiement du plug-in pour modifier la base de |
|                                        | données. La version spécifie la version du      |
|                                        | plugin qui exécutera le script de sorte que     |
|                                        | l'installation de la nouvelle version           |
|                                        | n'exécutera pas un script déjà exécuté lors de  |
|                                        | l'installation de la version précédente.        | 
+----------------------------------------+-------------------------------------------------+
| property~name="reload"~                | Définie sur "1" pour forcer la recharge de l'application après l'installation du plug-in (par exemple si un nouveau menu est créé). 
+----------------------------------------+-------------------------------------------------+                                                  
| property~name="postInstall"~           | Fichier qui va être exécuté aprés l'installation du plug-in 
+----------------------------------------+-------------------------------------------------+
| **files**                              |
+----------------------------------------+-------------------------------------------------+
|file~name="x.y"~target="z"~action="act"~| Un noeud par fichier à copier ou à déplacer. 
+----------------------------------------+-------------------------------------------------+
|                                        | "x.y": nom du fichier (doit exister dans le répertoire racine du plugin. 
+----------------------------------------+-------------------------------------------------+
|                                        | "z": répertoire cible pour copier ou déplacer le fichier 
+----------------------------------------+-------------------------------------------------+
|                                        |"act": action à faire, peut-être "copy" pour copier le fichier ou "move" pour le déplacer 
+----------------------------------------+-------------------------------------------------+                                                  
| **triggers**                           |                                                 |
+----------------------------------------+-------------------------------------------------+
| trigger~event="evt"~class="cls"        | Un noeud par événement déclenché. 
| script="script"                        | "evt": événement à déclencher 
|                                        | "cls": classe d'objets pour laquelle l'événement sera déclenché 
|                                        | "script": nom du script (fichier php) à exécuter                    
+----------------------------------------+-------------------------------------------------+                                                  
| **buttons**                            |                                                 |
+----------------------------------------+-------------------------------------------------+
| button buttonName="nom" class="cls"    | Un noeud par bouton à générer.  
|scriptJS="js()" **ou** scriptPHP="x.php"| "nom": nom du bouton  
| iconClass="iconCls" scope="scope"      | "cls": classe d'objet concernée  
| sortOrder="n"                          | "js()": nom de la fonction JavaScript à exécuter 
|                                        | "x.php": nom du script PHP à appeler directement 
|                                        | "iconCls": classe css permettant d'afficher l'image du bouton 
|                                        | "scope": place du bouton, peut être "detail" ou "list"
+----------------------------------------+-------------------------------------------------+
|                                        | "n": ordre des boutons de plugins 
+----------------------------------------+-------------------------------------------------+                                                                                                                                                                                                                                                              
| Règles                                 | **buttonName** ("nom") doit correspondre à un nom traductible et sera affiché en info bulle sur le bouton. 
+----------------------------------------+-------------------------------------------------+                                                                                                                                                                                                                                                              
|                                        | **scriptJS** et **scriptPHP** sont exclusifs, un seul des deux doit être renseigné pour chaque bouton 
+----------------------------------------+-------------------------------------------------+                                                                                                                                                                                                                                                              
|                                        | **scope** ne peut contenir que "detail" (pour afficher le bouton sur les boutons de détail de l'élément) ou "list" (pour afficher le bouton sur la liste des éléments de la classe)
+----------------------------------------+-------------------------------------------------+                                                                                                                                                                                                                                                              
|                                        | **sortOrder** doit être numérique. 
+----------------------------------------+-------------------------------------------------+                                                                                                                                                                                                                                                              
|                                        | Tous les boutons de plugins seront placés après les boutons standards, dans l'ordre précisé. 


**Exemple : **

.. figure:: /images/GUI/exemplecustomization.png


.. rubric:: Exigences

* Si vous souhaitez créer des plug-ins qui peuvent être partagés avec la communauté sans interaction avec d'autres plug-ins, demandez à ProjeQtOr pour un code unique ou une zone de code unique.

* Si vous ajoutez un nouveau champ sur une table de base de données existante, commencez le nom de la colonne avec plgXXXXXX où XXXXX est le code unique du plugin.
        
* Si vous ajoutez une nouvelle table dans la base de données, commencez son nom avec plgXXXXXX où XXXXXX est le code unique du plugin.
        
* Si vous copiez ou déplacez des fichiers dans la structure de ProjeQtOr, le nom des fichiers devrait commencer par plgXXXXXX.
        
* Il est conseillé (mais pas obligatoire), d'ajouter un trait de soulignement (_) après le code unique lors du nom des fichiers, des tables et des colonnes.
        
.. rubric:: Comment ajouter un nouveau menu

* Insérer une nouvelle ligne dans le menu du tableau, avec type='item'. Vous devez également ajouter l'accès par défaut dans l'habilitation de table. L'accès sera gérable via des écrans de gestions des droits d'accès par défaut.
  Exemple: insérez les mises à jour de base de données dans myPlugin.sql et définissez ce fichier comme "sql" dans pluginDescriptor.xml, nous attendons que le nom du menu soit 'myPlugin'.   
    
* Définir trois images, une pour chaque taille (32px, 22px et 16px) et ajoutez leur description dans pluginDescription pour les déplacer vers le dossier /view/css/images.
    
* Définir le style css pour les icônes dans le css pour les plugins. Exemple : dans myPlugin.css, ajouter iconMyPlugin32, iconMyPlugin22 et iconMyPlugin16 pour pointer vers une nouvelle image d'écran.
    
* Ajouter une entrée javascript pour l'écran de plugin dans pluginMenuPage (cette variable est un tableau). Exemple : dans myPlugin.js, ajouter pluginMenuPage['menuMyPlugin']='../plugin/myPlugin/myPlugin.php'.
    
* Définissez la propriété reload à "1" dans pluginDescriptor (pour l'actualisation de l'écran après l'installation pour que le nouvel écran s'affiche).
    
.. rubric:: Conseils de codage

* Toujours inclure (require_once) le fichier /tool/projeqtor.php au début des scripts. Cela garantira que toutes les contraintes de sécurité sont prises en compte, y compris le fait que l'utilisateur doit être connecté. 
  Ceci est également obligatoire si vous souhaitez utiliser les fonctionnalités de Framework (objets, persistance).
      
* Toujours vérifier que l'utilisateur connecté a le droit d'exécuter l'action demandée.
    
* Ne jamais encoder les légendes dans votre code, même si vous ne préparez pas l'internationalisation de votre plug-in. Utilisez la fonction i18n(), qui utilisera également vos propres traductions dans la partie nls du plug-in.
    
* Ne jamais accéder directement à la base de données : utilisez toujours les fonctions proposées par le framework.
    
* Si vous avez besoin d'inclure des fonctions JavaScript ou des feuilles de style CSS, il suffit de les inclure dans le fichier correspondant avec le nom du plugin et l'extension attendue (.js ou .css).
  Exemple : myPlugin.css et myPlugin.js. Ces fichiers seront automatiquement chargés dans la page principale.
      
.. rubric:: Conseils de codage pour les événements déclenchés

* Pour les déclencheurs, les événements (evt) peuvent être :
        
  * beforeSave => avant que l'élément ne soit enregistré dans la base de données 
        
  * afterSave => après que l'élément est enregistré dans la base de données (vous pouvez alors utiliser $this->id)
        
  * beforeDelete => avant que l'élément ne soit supprimé de la base de données
        
  * afterDelete => après que l'élément est supprimé de la base de données
        
  * control => contrôles supplémentaires à ajouter après les contrôles génériques avant d'enregistrer
        
  * deleteControle => contrôles supplémentaires pour ajouter des contrôles génériques avant la suppression
        
  * connect => avant que la connexion soit contrôlée, disponible uniquement pour la classe 'User'
        
  * query => avant la requête, pour ajouter des restrictions supplémentaires
        
  * liste => avant liste de requêtes, pour ajouter des restrictions supplémentaires
  
        
* Les scripts définis seront directement inclus dans l'événement correspondant à l'objet. Donc, vous pouvez utiliser $this pour faire référence à l'objet courant et parent pour faire référence à la classe héritée.  
    
  * Pour un événement "control", pour retourner et erroner un contrôle, compléter le message dans la variable $result (considérer qu'il est initialisé et non vide, donc utiliser $result.="<br/>...")
    
  * Dans les scripts déclenchés, si vous devez comparer des valeurs dans la base de données aux valeurs qui seront ou ont été stockées, utilisez dans l'événement "beforeSave" : $old=$this->getOld(); (ceci va récupérer des valeurs dans la base de données pour l'élément courant).
    Ensuite, vous pourrez comparer les valeurs de $old et $this
    
  * Dans les après événements (afterSave ou afterDelete), la variable $result contient le résultat de l'opération correspondante (save ou delete)

.. rubric:: Conseils de codage pour les boutons de plugins

* Le nom du bouton *buttonName* doit être un code qui sera traduit. La traduction devra donc soit utiliser un code existant, soit être ajoutée dans les fichiers lang.js du plugin *(voir répertoire "nls")*
* *scope* doit contenir "detail" (pour afficher le bouton sur les boutons de détail de l'élément) ou "list" (pour afficher le bouton sur la liste des éléments de la classe
* *sortOrder* doit être numérique. Tous les boutons de plugins seront placés après les boutons standards, dans l'ordre précisé. Les boutons de plugins seront donc placé entre le dernier bouton à droite (généralement l'affichage de l'historique) et la zone de drag & drop des fichiers attachés.
* *iconClass* doit être une classe css capable d'afficher une image. On peut intégrer plusieurs classes. 
  * Il est conseillé d'ajouter *dijitButtonIcon* comme première classe de la liste pour que le bouton ait un aspect similaire aux autre boutons. La valeur sera alors "dijitButtonIcon votreClasseCss".
  * Pour que l'aspect du bouton s'adapte au thème sélectionné par l'utilisateur, il faudra le définir dans le fichier css du plugin
  * Pour que l'aspect du bouton *désactivé* soit visuellement identifiable, il faudra le définir dans le fichier css du plugin
  * Exemple:

.. code-block:: css

 /* pour les thèmes standards */
 .yourClass{ background-image: url(icon/yourImage.png); width: 24px; height: 24px; background-size: 24px 24px;}
 .dijitDisabled .yourClass{ background-image: url(icon/yourImageDisabled.png);}
 /* pour le thème "flat blue" */
 .ProjeQtOrFlatBlue .yourClass{ background-image: url(icon/blue/yourImage.png);}
 .ProjeQtOrFlatBlue .dijitDisabled .yourClass{ background-image: url(icon/blue/yourImageDisabled.png);}
* *scriptJS* et *scriptPHP* sont exclusifs, un seul des deux doit être renseigné pour chaque bouton
* *scriptPHP* est un script PHP qui sera directement appelé lors du clic sur le bouton. 
  * Pour un bouton sur la liste des éléments, toutes les données de sélection (le formulaire *listForm*) sont envoyées vers ce script. On y retrouve *objectClass* et les données de filtre saisies.
  * Pour un bouton sur le détail d'un élément, toutes les données de l'élément (le formulaire *objectForm*) sont envoyées vers ce script.
  * Pour un bouton sur le détail d'un élément, on considère qu'il s'agit d'un script qui retourne un résultat qui sera affiché dans la zone de résultat standard. Il faut donc que ce code retourne un message formaté comme attendu par le FrameWork pour les appels de scripts retournant un résultat à afficher.

  * Exemple de code générant le message de retour attendu du script:  

.. code-block:: php

 $id=RequestHandler::getValue("objectId");!
 $returnValue = '<input type="hidden" id="lastSaveId" value="'.$id.'" />';
 $returnValue .= '<input type="hidden" id="lastOperation" value="none" />';
 $returnValue .= '<input type="hidden" id="lastOperationStatus" value="OK" />';
 echo '<div class="messageOK" style="text-align:center">OK</div>';

* *scriptJS* est une fonction JavaScript qui sera appelée 

  * Cette fonction peut contenir tout le code javascript nécessaire. 

  * Elle peut ou non appeler un script PHP. Il faudra alors utiliser la fonction *xhrGet* ou *xhrPost* pour envoyer les données qu script et gérer manuellement le retour.

  * Exemple de code javascript :  

.. code-block:: javascript

 function testPluginButtonDetail() { // Exemple pour un bouton de détail
   if (waitingForReply) {
     showInfo(i18n("alertOngoingQuery"));
     return true;
   }
   for (name in CKEDITOR.instances) {
     CKEDITOR.instances[name].updateElement();
   }
   dojo.xhrPost({
     url : "../plugin/testButtons/testPluginButtonDetail.php?objectClass=" + dojo.byId("objectClass").value,
     form : 'objectForm',
     handleAs : "text",
     load : function(data) {
       showInfo(data);
     }
   });
 }

 function testPluginButtonList() { // Exemple pour un bouton de liste
   dojo.xhrGet({
     url : "../plugin/testButtons/testPluginButtonList.php?objectClass=" + dojo.byId("objectClass").value,
     handleAs : "text",
     load : function(data) {
       showInfo(data);
     }
   });
 }


* Les informations des boutons sont stockées dans la table *pluginbutton*