.. raw:: latex

    \newpage

.. title:: Opérations Système

Base de données MySql
---------------------
.. rubric:: Deadlock

Parfois, on trouve dans les logs des messages du type


.. code-block:: sql

  Exception-[HY000] SQLSTATE[HY000]: General error: 1205 Lock wait timeout exceeded; try restarting transaction

Cela montre un verrou pour lequel on a attendu trop longtemps la libération.
Ceci peut être le symptôme d'un verrou bloquant (deadlock) :

  * User1 verrouille A
  * User2 verrouille B
  * User1 veut verrouiller B : verrou en attente de la libération de B
  * User2 veut verrouiller A : verrou bloquant (deadlock)

Pour supprimer les verrous, parfois un simple arrêt de la base de données ne suffit pas car l'état des verrous peut persister.
Il faut alors identifier les process qui tournent

Sous l'interface mySql :

.. code-block:: sql

  SHOW PROCESSLIST;

Ceci list tous les process, même ceux qui sont en sommeil (sleep)
Pour voir ceux qui tournent uniquement :

.. code-block:: sql

  SELECT * FROM `information_schema`.`innodb_trx` ORDER BY `trx_started`

On va répérer les process qui tournent et les tuer

.. code-block:: sql

  KILL 115; // Tue le process d'id 115

Attention, le process qui bloque peut être un process endormi (sleep)


Check InnoDB status for locks

SHOW ENGINE InnoDB STATUS;
Check MySQL open tables

SHOW OPEN TABLES WHERE In_use > 0;
Check pending InnoDB transactions

SELECT * FROM `information_schema`.`innodb_trx` ORDER BY `trx_started`; 
Check lock dependency - what blocks what

SELECT * FROM `information_schema`.`innodb_locks`;
After investigating the results above, you should be able to see what is locking what.

The root cause of the issue might be in your code too - please check the related functions especially for annotations if you use JPA like Hibernate.

For example, as described here, the misuse of the following annotation might cause locks in the database:

@Transactional(propagation = Propagation.REQUIRES_NEW) 


   


