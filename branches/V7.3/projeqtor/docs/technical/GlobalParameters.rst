.. raw:: latex

    \newpage

.. title:: GlobalParameters

Gestion des paramètres
-------------------------

===============================================    ===================================================================    =================================================    
**Caption**                                        | **Description**                                                      **Variable name**     
               
Databasetype                                       | Le type de base de données.Les valeurs
                                                   | possibles sont 'mysql' et 'pgsql'                                     $paramDbType
                       
DatabaseHost                                       | Nom du serveur MySql ou PostgreSql ('localhost' par défaut).
                                                   | Si votre base de données n'écoute pas le port par défaut,
                                                   | il suffit de l'indiquer ici 'myServer:myPort'.                       $paramDbHost

Database user to connect                           | Utilisateur valide de base de données (par défaut 'root')            $paramDbUser       
          
                    
Database password for user                         | Mot de passe de base de données pour utilisateur                     $paramDbPassword

Database schema name                               | Nom de schéma de base de données                                     $paramDbName                                                                            

Name to be displayed                               | Nom qui sera affiché en bas de l'écran principal.                    $paramDbDisplayName
                                                   | Toute valeur est possible pour identifier la base de données.   

Database prefix for table names                    | Préfixe sur les noms de tables. Il est utilisé pour stocker 
                                                   | plusieurs instances sous le même schéma. Il peut être laissé vide    $paramDbName                                                                                                                                              
===============================================    ===================================================================    ================================================= 

Paramètres Globaux
------------------
.. warning:: L'accès à l'écran des paramètres globaux doit être restreint aux administrateurs.
             Les paramètres globaux doivent être enregistrés avant de quitter l'écran

.. seealso:: Déplacer la souris sur la légende d'un paramètre affichera une info-bulle avec plus de description sur le paramètre

.. figure:: /images/GUI/globalparameters.png

.. figure:: /images/GUI/ldap.png
   
   Pour accéder à un serveur AD (Microsoft Active Directory), le paramétrage est un peu spécifique et surtout différent du paramétrage standard LDAP.
   user ldap : ne pas ajouter la chaîne de connexion LDAP, seul le nom d'utilisateur, avec éventuellement le nom de domaine Domaine\User
   search string : sAMAccountName=%username%  
   
   ** TODO : Exemples
   $paramLdap_user_filter = 'uid=%USERNAME%'; // Standard, marche par défaut pour Open Ldap 
   $paramLdap_user_filter = 'sAMAccountName=%USERNAME%'; // Pour AD
   $paramLdap_user_filter = 'cn=%USERNAME%'; // Peut aussi marcher pour AD
   $paramLdap_user_filter = '(&(objectCategory=person)(objectClass=user)(givenName=*)(sn=*))'; // Autre exemple

.. figure:: /images/GUI/filedirectory.png

.. figure:: /images/GUI/document.png

.. figure:: /images/GUI/cron.png

.. figure:: /images/GUI/email.png


Jusqu'à V3.4.4, il existe deux façons d'envoyer des mails :
    
    - Utilisation de la fonction php mail : cette fonction permet uniquement la connexion anonyme
    
    - En utilisant une connexion socket spécifique : cette méthode permet des connexions authentifiées.
      Depuis V4.0.0 une nouvelle méthode a été introduite :
      
      - À l'aide de la bibliothèque PHPMailer : cette méthode avancée permet des connexions anonymes et authentifiées
      
Vous pouvez sélectionner la méthode en ajoutant simplement $paramMailerType dans votre fichier parameters.php :

    - $paramMailerType = 'mail' utilisant la fonction php mail
    
    - $paramMailerType = 'socket' en utilisant une connexion de socket spécifique
    
    - $paramMailerType = 'phpmailer' en utilisant la bibliothèque PHPMailer