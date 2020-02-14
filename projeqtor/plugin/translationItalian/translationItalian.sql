-- ///////////////////////////////////////////////////////////////////////////////
-- // PROJECTOR TRANSLATION PLUGIN                                              //
-- // Translation of some parameters related to the language used by the users. //
-- // To execute ONCE after a fresh install of database.                        //
-- // Example of French translation of values for parameters tables.            //
-- // Usefull for French users.                                                 //
-- // Good start for translation in other languages.                            //
-- ///////////////////////////////////////////////////////////////////////////////

-- Access Profile 
UPDATE `${prefix}accessprofile` SET description = 'Leggi solo sugli elementi dei suoi progetti' WHERE name = 'accessProfileRestrictedReader';
UPDATE `${prefix}accessprofile` SET description = 'Leggi solo sugli elementi in tutti i progetti' WHERE name = 'accessProfileGlobalReader';
UPDATE `${prefix}accessprofile` SET description = 'Leggi e aggiorna sugli elementi dei suoi progetti' WHERE name = 'accessProfileRestrictedUpdater';
UPDATE `${prefix}accessprofile` SET description = 'Leggi e aggiorna gli elementi da tutti i progetti' WHERE name = 'accessProfileGlobalUpdater';
UPDATE `${prefix}accessprofile` SET description = 'Leggi solo gli elementi nei suoi progetti
Creazione possibile
Aggiorna ed elimina i propri elementi 'WHERE name =' accessProfileRestrictedCreator ';
UPDATE `${prefix}accessprofile` SET description = 'Leggi gli elementi in tutti i progetti
Creazione possibile
Aggiorna ed elimina i propri elementi 'WHERE name =' accessProfileGlobalCreator ';
UPDATE `${prefix}accessprofile` SET description = 'Leggi solo gli elementi nei suoi progetti
Creazione possibile
Aggiorna ed elimina gli elementi dei suoi progetti 'WHERE name =' accessProfileRestrictedManager ';
UPDATE `${prefix}accessprofile` SET description = 'Leggi gli elementi in tutti i progetti
Creazione possibile
Aggiorna ed elimina sugli elementi dei suoi progetti 'WHERE name =' accessProfileGlobalManager ';
UPDATE `${prefix}accessprofile` SET description = 'Nessun accesso consentito' WHERE name = 'accessProfileNoAccess';
UPDATE `${prefix}accessprofile` SET description = 'Legge solo sugli oggetti per i quali è dichiarato come creatore
Impossibile creare 'WHERE name =' accessReadOwnOnly ';

-- ContextType
UPDATE `${prefix}contexttype` SET name = 'Ambiente' WHERE name = 'environment';
UPDATE `${prefix}contexttype` SET name = 'Operating System' WHERE name = 'OS';
UPDATE `${prefix}contexttype` SET name = 'Browser' WHERE name = 'browser';

-- Criticality
UPDATE `${prefix}criticality` SET name='Basso' WHERE name='Low';
UPDATE `${prefix}criticality` SET name='Medio' WHERE name='Medium';
UPDATE `${prefix}criticality` SET name='Alto' WHERE name='High';
UPDATE `${prefix}criticality` SET name='Critico' WHERE name='Critical';


-- DeliveryMode

UPDATE `${prefix}deliverymode` SET name = 'email' WHERE name = 'email';
UPDATE `${prefix}deliverymode` SET name = 'posta postale' WHERE name = 'postal mail';
UPDATE `${prefix}deliverymode` SET name = 'consegnato a mano' WHERE name = 'hand delivered';
UPDATE `${prefix}deliverymode` SET name = 'repository' WHERE name = 'digital deposit';


-- Efficiency
UPDATE `${prefix}efficiency` SET name='totalmente efficace' WHERE name='fully efficient';
UPDATE `${prefix}efficiency` SET name='parzialmente efficace' WHERE name='partially efficient';
UPDATE `${prefix}efficiency` SET name='innefficace' WHERE name='not efficient';

-- ExpenseDatailType
UPDATE `${prefix}expensedetailtype` SET name='Viaggiare in auto' WHERE name='travel by car';
UPDATE `${prefix}expensedetailtype` SET name='Viaggiare spesso in auto', unit01='giorni', unit02='km/giorno' WHERE name='regular mission car travel';
UPDATE `${prefix}expensedetailtype` SET name='Spese per i pasti', unit01='persone', unit02='€ per persona' WHERE name='lunch for guests';
UPDATE `${prefix}expensedetailtype` SET name='Spese senza giustificati' WHERE name='justified expense';
UPDATE `${prefix}expensedetailtype` SET name='Altro', unit01='unità', unit02='€ per unità' WHERE name='detail';

-- Feasibility
UPDATE `${prefix}feasibility` SET name='fattibile' WHERE name='Yes';
UPDATE `${prefix}feasibility` SET name='Analizzare' WHERE name='Investigate';
UPDATE `${prefix}feasibility` SET name='Non fattibile' WHERE name='No';

-- Health
UPDATE `${prefix}health` SET name='sicuro' WHERE name='secured';
UPDATE `${prefix}health` SET name='protetto' WHERE name='surveyed';
UPDATE `${prefix}health` SET name='in pericolo' WHERE name='in danger';
UPDATE `${prefix}health` SET name='sotto controllo' WHERE name='crashed';
UPDATE `${prefix}health` SET name='in pausa' WHERE name='paused';

-- Likelihood
UPDATE `${prefix}likelihood` SET name='Basso (10%)' WHERE name='Low (10%)';
UPDATE `${prefix}likelihood` SET name='Medio (50%)' WHERE name='Medium (50%)';
UPDATE `${prefix}likelihood` SET name='Alto (90%)' WHERE name='High (90%)';

-- MeasureUnit
UPDATE `${prefix}measureunit` SET name='pezzi', pluralName='pièces' WHERE name='piece';
UPDATE `${prefix}measureunit` SET name='molti', pluralName='lots' WHERE name='lot';
UPDATE `${prefix}measureunit` SET name='giorni', pluralName='jours' WHERE name='day';
UPDATE `${prefix}measureunit` SET name='mesi', pluralName='mois' WHERE name='month';

-- Message 
UPDATE `${prefix}message` SET description='Bienvenue dans l''application ProjeQtOr' WHERE description='Welcome to ProjectOr web application';

-- PaymentDelay 
UPDATE `${prefix}paymentdelay` SET name='15 giorni' WHERE name='15 days';
UPDATE `${prefix}paymentdelay` SET name='15 giorni fine del mese' WHERE name='15 days end of month';
UPDATE `${prefix}paymentdelay` SET name='30 giorni' WHERE name='30 days';
UPDATE `${prefix}paymentdelay` SET name='30 giorni fine del mese' WHERE name='30 days end of month';
UPDATE `${prefix}paymentdelay` SET name='45 giorni' WHERE name='45 days';
UPDATE `${prefix}paymentdelay` SET name='45 giorni fine del mese' WHERE name='45 days end of month';
UPDATE `${prefix}paymentdelay` SET name='60 giorni' WHERE name='60 days';
UPDATE `${prefix}paymentdelay` SET name='su ordine' WHERE name='on order';

-- PaymentMode
UPDATE `${prefix}paymentmode` SET name='trasferimento bancario' WHERE name='bank transfer';
UPDATE `${prefix}paymentmode` SET name='cheque' WHERE name='cheque';
UPDATE `${prefix}paymentmode` SET name='carta di credito' WHERE name='credit card';
UPDATE `${prefix}paymentmode` SET name='terminale di pagamento virtuale (POS)' WHERE name='virtual payment terminal';

-- Priority
UPDATE `${prefix}priority` SET name='Bassa' WHERE name='Low priority';
UPDATE `${prefix}priority` SET name='Media' WHERE name='Medium priority';
UPDATE `${prefix}priority` SET name='Alta' WHERE name='High priority';
UPDATE `${prefix}priority` SET name='Critica' WHERE name='Critical priority';

-- Profile
UPDATE `${prefix}profile` SET description='Può vedere e modificare tutti i progetti' WHERE name='profileAdministrator' AND description='Has a visibility over all the projects';
UPDATE `${prefix}profile` SET description='Può vedere tutti i progetti ma non aggiornarli' WHERE name='profileSupervisor' AND description='Has a visibility over all the projects';
UPDATE `${prefix}profile` SET description='Gestisce i propri progetti' WHERE name='profileProjectLeader' AND description='Leads his owns project';
UPDATE `${prefix}profile` SET description='Lavora sui progetti a cui è assegnato' WHERE name='profileTeamMember' AND description='Works for a project';
UPDATE `${prefix}profile` SET description='Ha una visibilità limitata sui progetti ai quali è assegnato' WHERE name='profileGuest' AND description ='Has limited visibility to a project';
UPDATE `${prefix}profile` SET description='Ha una visibilità limitata sui progetti ai quali è assegnato. Può validare alcuni passaggi.' WHERE name='profileExternalProjectLeader' AND description is null;
UPDATE `${prefix}profile` SET description='Ha una visibilità limitata sui progetti ai quali è assegnato. Può creare tickets.' WHERE name='profileExternalTeamMember' AND description is null;

-- Quality
UPDATE `${prefix}quality` SET name='conforme' WHERE name='conform';
UPDATE `${prefix}quality` SET name='con commenti' WHERE name='some remarks';
UPDATE `${prefix}quality` SET name='non conforme' WHERE name='not conform';

-- Resolution
UPDATE `${prefix}resolution` SET name='non risolto' WHERE name='not resolved';
UPDATE `${prefix}resolution` SET name='risoluto' WHERE name='fixed';
UPDATE `${prefix}resolution` SET name='già risolto' WHERE name='already fixed';
UPDATE `${prefix}resolution` SET name='in duplicato' WHERE name='duplicate';
UPDATE `${prefix}resolution` SET name='respinto' WHERE name='rejected';
UPDATE `${prefix}resolution` SET name='supporto fornito' WHERE name='support provided';
UPDATE `${prefix}resolution` SET name='bypass fornito' WHERE name='workaround provided';
UPDATE `${prefix}resolution` SET name='evoluzione realizzata' WHERE name='evolution done';

-- Risklevel
UPDATE `${prefix}risklevel` SET name='Molto basso' WHERE name='Very Low';
UPDATE `${prefix}risklevel` SET name='Basso' WHERE name='Low';
UPDATE `${prefix}risklevel` SET name='Medio' WHERE name='Average';
UPDATE `${prefix}risklevel` SET name='Alto' WHERE name='High';
UPDATE `${prefix}risklevel` SET name='Molto alto' WHERE name='Very High';

-- Role
UPDATE `${prefix}role` SET name='Project Manager', description='Capo progetto (PMO)', sortOrder='80' WHERE name='Manager';
UPDATE `${prefix}role` SET name='Analista', description='', sortOrder='20' WHERE name='Analyst';
UPDATE `${prefix}role` SET name='Sviluppatore', description='', sortOrder='110' WHERE name='Developer';
UPDATE `${prefix}role` SET name='Esperto', description='', sortOrder='130' WHERE name='Expert';
UPDATE `${prefix}role` SET name='Attrezzatura', description='Ex risorsa hardware: server', sortOrder='140' WHERE name='Machine';

-- Severity
UPDATE `${prefix}severity` SET name='Bassa' WHERE name='Low';
UPDATE `${prefix}severity` SET name='Mediaa' WHERE name='Medium';
UPDATE `${prefix}severity` SET name='Alta' WHERE name='High';

-- Status
UPDATE `${prefix}status` SET name='registrato' WHERE name='recorded';
UPDATE `${prefix}status` SET name='qualificato' WHERE name='qualified';
UPDATE `${prefix}status` SET name='accettato' WHERE name='accepted';
UPDATE `${prefix}status` SET name='riaperto' WHERE name='re-opened';
UPDATE `${prefix}status` SET name='assegnato' WHERE name='assigned';
UPDATE `${prefix}status` SET name='preparato' WHERE name='prepared';
UPDATE `${prefix}status` SET name='in corso' WHERE name='in progress';
UPDATE `${prefix}status` SET name='fatto' WHERE name='done';
UPDATE `${prefix}status` SET name='verificato' WHERE name='verified';
UPDATE `${prefix}status` SET name='consegnato' WHERE name='delivered';
UPDATE `${prefix}status` SET name='convalidato' WHERE name='validated';
UPDATE `${prefix}status` SET name='chiuso' WHERE name='closed';
UPDATE `${prefix}status` SET name='annullato' WHERE name='cancelled';

-- Trend
UPDATE `${prefix}trend` SET name='in aumento' WHERE name='increasing';
UPDATE `${prefix}trend` SET name='stabile' WHERE name='even';
UPDATE `${prefix}trend` SET name='in calo diminution' WHERE name='decreasing';

-- Type
UPDATE `${prefix}type` SET name='Prezzo fisso' WHERE scope='Project' AND name='Fixed Price';
UPDATE `${prefix}type` SET name='Tempo e materiali' WHERE scope='Project' AND name='Time & Materials';
UPDATE `${prefix}type` SET name='Tempo limitato e materiali' WHERE scope='Project' AND name='Capped Time & Materials';
UPDATE `${prefix}type` SET name='Interno' WHERE scope='Project' AND name='Internal';
UPDATE `${prefix}type` SET name='Amministrativo' WHERE scope='Project' AND name='Administrative';
UPDATE `${prefix}type` SET name='Modello' WHERE scope='Project' AND name='Template';
UPDATE `${prefix}type` SET name='Incidente' WHERE name='Incident';
UPDATE `${prefix}type` SET name='Assistenza' WHERE name='Support / Assistance';
UPDATE `${prefix}type` SET name='Anomalia' WHERE name='Anomaly / Bug';
UPDATE `${prefix}type` SET name='Sviluppo' WHERE scope='Activity' AND name='Development';
UPDATE `${prefix}type` SET name='Evoluzione' WHERE scope='Activity' AND name='Evolution';
UPDATE `${prefix}type` SET name='Gestione' WHERE scope='Activity' AND name='Management';
UPDATE `${prefix}type` SET name='Fase' WHERE scope='Activity' AND name='Phase';
UPDATE `${prefix}type` SET name='Compito' WHERE scope='Activity' AND name='Task';
UPDATE `${prefix}type` SET name='consegnabile' WHERE scope='Milestone' AND name='Deliverable';
UPDATE `${prefix}type` SET name='in arrivo' WHERE scope='Milestone' AND name='Incoming';
UPDATE `${prefix}type` SET name='Data chiave' WHERE scope='Milestone' AND name='Key date';
UPDATE `${prefix}type` SET name='Prezzo fisso' WHERE scope='Quotation' AND name='Fixe Price';
UPDATE `${prefix}type` SET name='Al giorno' WHERE scope='Quotation' AND name='Per day';
UPDATE `${prefix}type` SET name='Al mese' WHERE scope='Quotation' AND name='Per month';
UPDATE `${prefix}type` SET name='All''anno' WHERE scope='Quotation' AND name='Per year';
UPDATE `${prefix}type` SET name='Prezzo fisso' WHERE scope='Command' AND name='Fixe Price';
UPDATE `${prefix}type` SET name='Al giorno' WHERE scope='Command' AND name='Per day';
UPDATE `${prefix}type` SET name='Al mese' WHERE scope='Command' AND name='Per month';
UPDATE `${prefix}type` SET name='All''anno' WHERE scope='Command' AND name='Per year';
UPDATE `${prefix}type` SET name='Rapporto spese' WHERE scope='IndividualExpense' AND name='Expense report';
UPDATE `${prefix}type` SET name='Spesa della macchina' WHERE scope='ProjectExpense' AND name='Machine expense';
UPDATE `${prefix}type` SET name='Spese d''ufficio' WHERE scope='ProjectExpense' AND name='Office expense';
UPDATE `${prefix}type` SET name='Fatura Parziale' WHERE scope='Bill' AND name='Partial bill';
UPDATE `${prefix}type` SET name='Fattura Finale' WHERE scope='Bill' AND name='Final bill';
UPDATE `${prefix}type` SET name='Fattura completa' WHERE scope='Bill' AND name='Complete bill';
UPDATE `${prefix}type` SET name='Contrattuale' WHERE scope='Risk' AND name='Contractual';
UPDATE `${prefix}type` SET name='operativo' WHERE scope='Risk' AND name='Operational';
UPDATE `${prefix}type` SET name='Technique' WHERE scope='Risk' AND name='Technical';
UPDATE `${prefix}type` SET name='Contractuelle' WHERE scope='Opportunity' AND name='Contractual';
UPDATE `${prefix}type` SET name='Opérationnelle' WHERE scope='Opportunity' AND name='Operational';
UPDATE `${prefix}type` SET name='Tecnico' WHERE scope='Opportunity' AND name='Technical';
UPDATE `${prefix}type` SET name='Progetto' WHERE scope='Action' AND name='Project';
UPDATE `${prefix}type` SET name='Interno' WHERE scope='Action' AND name='Internal';
UPDATE `${prefix}type` SET name='Cliente' WHERE scope='Action' AND name='Customer';
UPDATE `${prefix}type` SET name='Problema tecnico' WHERE scope='Issue' AND name='Technical issue';
UPDATE `${prefix}type` SET name='Non conformità del processo' WHERE scope='Issue' AND name='Process non conformity';
UPDATE `${prefix}type` SET name='Non conformità di qualità' WHERE scope='Issue' AND name='Quality non conformity';
UPDATE `${prefix}type` SET name='Processo non applicabile' WHERE scope='Issue' AND name='Process non appliability';
UPDATE `${prefix}type` SET name='Reclamo del cliente' WHERE scope='Issue' AND name='Customer complaint';
UPDATE `${prefix}type` SET name='Ritardo non rispettato' WHERE scope='Issue' AND name='Delay non respect';
UPDATE `${prefix}type` SET name='Problema di gestione delle risorse' WHERE scope='Issue' AND name='Resource management issue';
UPDATE `${prefix}type` SET name='Perdita finanziaria' WHERE scope='Issue' AND name='Financial loss';
UPDATE `${prefix}type` SET name='Comitato direttivo' WHERE scope='Meeting' AND name='Steering Committee';
UPDATE `${prefix}type` SET name='Riunione di avanzamento' WHERE scope='Meeting' AND name='Progress Metting';
UPDATE `${prefix}type` SET name='Incontro di gruppo' WHERE scope='Meeting' AND name='Team Meeting';
UPDATE `${prefix}type` SET name='Funzionale' WHERE scope='Decision' AND name='Functional';
UPDATE `${prefix}type` SET name='operativo' WHERE scope='Decision' AND name='Operational';
UPDATE `${prefix}type` SET name='Contrattuale' WHERE scope='Decision' AND name='Contractual';
UPDATE `${prefix}type` SET name='Strategico' WHERE scope='Decision' AND name='Strategic';
UPDATE `${prefix}type` SET name='Funzionale' WHERE scope='Question' AND name='Functional';
UPDATE `${prefix}type` SET name='Tecnico' WHERE scope='Question' AND name='Technical';
UPDATE `${prefix}type` SET name='ALLARME' WHERE scope='Message' AND name='ALERT';
UPDATE `${prefix}type` SET name='AVVERTIMENTO' WHERE scope='Message' AND name='WARNING';
UPDATE `${prefix}type` SET name='INFORMAZIONI' WHERE scope='Message' AND name='INFO';
UPDATE `${prefix}type` SET name='Specifiche' WHERE scope='Document' AND name='Need expression';
UPDATE `${prefix}type` SET name='Specifiche generali' WHERE scope='Document' AND name='General Specification';
UPDATE `${prefix}type` SET name='Specifiche dettagliate' WHERE scope='Document' AND name='Detailed Specification';
UPDATE `${prefix}type` SET name='Concezione generale' WHERE scope='Document' AND name='General Conception';
UPDATE `${prefix}type` SET name='Concezione del dettaglio' WHERE scope='Document' AND name='Detail Conception';
UPDATE `${prefix}type` SET name='Piano di prova' WHERE scope='Document' AND name='Test Plan';
UPDATE `${prefix}type` SET name='Manuale di installazione' WHERE scope='Document' AND name='Installaton manual';
UPDATE `${prefix}type` SET name='Manuale operativo' WHERE scope='Document' AND name='Exploitation manual';
UPDATE `${prefix}type` SET name='Manuale dell''utente' WHERE scope='Document' AND name='User manual';
UPDATE `${prefix}type` SET name='Contratto' WHERE scope='Document' AND name='Contract';
UPDATE `${prefix}type` SET name='Gestione' WHERE scope='Document' AND name='Management';
UPDATE `${prefix}type` SET name='Riunione' WHERE scope='Document' AND name='Meeting Review';
UPDATE `${prefix}type` SET name='Azione supplementare' WHERE scope='Document' AND name='Follow-up';
UPDATE `${prefix}type` SET name='Finanziario' WHERE scope='Document' AND name='Financial';
UPDATE `${prefix}type` SET name='Funzionale' WHERE scope='Requirement' AND name='Functional';
UPDATE `${prefix}type` SET name='Tecnico' WHERE scope='Requirement' AND name='Technical';
UPDATE `${prefix}type` SET name='Sicurezza' WHERE scope='Requirement' AND name='Security';
UPDATE `${prefix}type` SET name='Regolazione' WHERE scope='Requirement' AND name='Regulatory';
UPDATE `${prefix}type` SET name='Test di implementazione dei requisiti' WHERE scope='TestCase' AND name='Requirement test';
UPDATE `${prefix}type` SET name='Test unitario' WHERE scope='TestCase' AND name='Unit test';
UPDATE `${prefix}type` SET name='Test di non regressione' WHERE scope='TestCase' AND name='Non regression';
UPDATE `${prefix}type` SET name='test di evoluzione' WHERE scope='TestSession' AND name='Evolution test session';
UPDATE `${prefix}type` SET name='test di sviluppo' WHERE scope='TestSession' AND name='Development test session';
UPDATE `${prefix}type` SET name='test di non regressione' WHERE scope='TestSession' AND name='Non regression test session';
UPDATE `${prefix}type` SET name='test unitario' WHERE scope='TestSession' AND name='Unitary case test session';
UPDATE `${prefix}type` SET name='Prospettiva', sortOrder='50', description='Potenziale cliente' WHERE scope='Client' AND name='business prospect';
UPDATE `${prefix}type` SET name='Cliente', sortOrder='30', description='Cliente attuale' WHERE scope='Client' AND name='customer';
UPDATE `${prefix}type` SET name='Pagamento finale' WHERE scope='Payment' AND name='final payment';
UPDATE `${prefix}type` SET name='Pagamento Parziale' WHERE scope='Payment' AND name='partial payment';
UPDATE `${prefix}type` SET name='Software' WHERE scope='Product' AND name='software';
UPDATE `${prefix}type` SET name='Servizio' WHERE scope='Product' AND name='service';
UPDATE `${prefix}type` SET name='Specifico' WHERE scope='Component' AND name='specific';
UPDATE `${prefix}type` SET name='Sullo scaffale' WHERE scope='Component' AND name='on the shelf';
UPDATE `${prefix}type` SET name='Grossista' WHERE scope='Provider' AND name='wholesaler';
UPDATE `${prefix}type` SET name='Rivenditore' WHERE scope='Provider' AND name='retailer';
UPDATE `${prefix}type` SET name='Destinatario' WHERE scope='Provider' AND name='service provider';
UPDATE `${prefix}type` SET name='Subappaltatore' WHERE scope='Provider' AND name='subcontractor';
UPDATE `${prefix}type` SET name='Centrale d''Acquisti' WHERE scope='Provider' AND name='central purchasing';
UPDATE `${prefix}type` SET name='Accordo reciproco' WHERE scope='CallForTender' AND name='by mutual agreement';
UPDATE `${prefix}type` SET name='Procedura adattata' WHERE scope='CallForTender' AND name='adapted procedure';
UPDATE `${prefix}type` SET name='Bando di gara aperto' WHERE scope='CallForTender' AND name='open call for tender';
UPDATE `${prefix}type` SET name='Bando di gara ristretto' WHERE scope='CallForTender' AND name='restricted call for tender';
UPDATE `${prefix}type` SET name='Bando di gara di accordo reciproco' WHERE scope='Tender' AND name='by mutual agreement';
UPDATE `${prefix}type` SET name='Procedura adattata' WHERE scope='Tender' AND name='adapted procedure';
UPDATE `${prefix}type` SET name='Bando di gara aperto' WHERE scope='Tender' AND name='open call for tender';
UPDATE `${prefix}type` SET name='Bando di gara ristretto' WHERE scope='Tender' AND name='restricted call for tender';

-- Urgency
UPDATE `${prefix}urgency` SET name='Blocco' WHERE name='Blocking';
UPDATE `${prefix}urgency` SET name='Urgente' WHERE name='Urgent';
UPDATE `${prefix}urgency` SET name='Non urgente' WHERE name='Not urgent';

-- Workflow
UPDATE `${prefix}workflow` SET name='Défaut', description='Flusso di lavoro predefinito con solo vincoli logici.
Chiunque può cambiare lo stato.' WHERE name='Default';
UPDATE `${prefix}workflow` SET name='Simple', description='Flusso di lavoro semplice con stato limitato.
Chiunque può cambiare lo stato.' WHERE name='Simple';
UPDATE `${prefix}workflow` SET name='Validation externe', description='Flusso di lavoro sviluppato con elaborazione interna del team e convalida esterna.'
  WHERE name='External validation';
UPDATE `${prefix}workflow` SET name='Acceptation & validation externe', description='Flusso di lavoro sviluppato con accettazione esterna, elaborazione interna del team e convalida esterna.'
  WHERE name='External acceptation & validation';
UPDATE `${prefix}workflow` SET name='Simple avec validation', description='Flusso di lavoro semplice con stato limitato, inclusa la convalida.'
  WHERE name='Simple with validation';
UPDATE `${prefix}workflow` SET name='Validation', description='Breve flusso di lavoro con solo una convalida o una possibilità di cancellazione.
Privilegi di convalida ristretti.' WHERE name='Validation';
UPDATE `${prefix}workflow` SET name='Simple avec préparation', description='Flusso di lavoro semplice con stato limitato, inclusa la preparazione.
Chiunque può cambiare lo stato.' WHERE name='Simple with preparation';
UPDATE `${prefix}workflow` SET name='Semplice con la convalida del project manager ', description =' Flusso di lavoro semplice con stato limitato, inclusa la convalida del project manager.
Chiunque può modificare lo stato, ad esempio per il viding riservato al project manager.' WHERE name='Simple with Project Leader validation';

-- Configuration / Parameters
UPDATE `${prefix}parameter` SET parameterValue='L''applicazione è chiusa.
Solo l''amministratore può connettersi.
Grazie. Torna più tardi.' WHERE parameterCode='msgClosedApplication';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Sei l''approvatore di <a href="${url}"> Documento # $ {id} </a>: "$ {name}". <br/> Accedi a <a href = "$ { url} "> questo documento </a> e segui la procedura di approvazione".' WHERE parameterCode = 'paramMailBodyApprover';
UPDATE `${prefix}parameter` SET parameterValue='Benvenuto nell''istanza di $ {dbName} ProjeQtOr, accessibile all''indirizzo <a href="${url}"> $ {url} </a>. <br/> Il tuo nome utente è <b> $ {login} </ b>. <br/> La tua password è inizializzata su <b> $ {password} </ b> <br/> dovrai modificarla al primo accesso. </ b> > <br/> Se c''è un problema, contatta il tuo amministratore su <b> $ {adminMail} </ b>. ' WHERE parameterCode = 'paramMailBodyUser';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Articolo $ {articolo} # $ {id} modificato: "$ {nome}" 'WHERE parameterCode =' paramMailTitleAnyChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Messaggio inviato da $ {mittente}: è necessario approvare un documento' WHERE parameterCode='paramMailTitleApprover';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] È stato aggiunto un nuovo compito per l''articolo $ {elemento} # $ {id}: "$ {nome}"' WHERE parameterCode='paramMailTitleAssignment';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Un compito è stato modificato per l''articolo $ {articolo} # $ {id}: "$ {nome}"' WHERE parameterCode='paramMailTitleAssignmentChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Un nuovo file è stato allegato all''articolo $ {item} # $ {id}: "$ {name}"' WHERE parameterCode='paramMailTitleAttachment';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] La descrizione dell''oggetto $ {item} # $ {id} è stata modificata in: "$ {name}"' WHERE parameterCode='paramMailTitleDescription';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Messaggio inviato da ${sender} : ${item} #${id}' WHERE parameterCode='paramMailTitleDirect';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] L''articolo $ {item} # $ {id} è stato creato : "${name}"' WHERE parameterCode='paramMailTitleNew';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Una nuova nota è stata aggiunta all''elemento ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleNote';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Una nota è stata cambiata sull''articolo ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleNoteChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] ${responsible} è ora responsabile per l''elemento ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleResponsible';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Il risultato è stato modificato per l''articolo ${item} #${id} : "${name}' WHERE parameterCode='paramMailTitleResult';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] ${item} #${id} è appena passato nello stato ${status} : ${name}' WHERE parameterCode='paramMailTitleStatus';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Messaggio inviato da $ {sender}: le informazioni dell''account ProjeQtOr per l''istanza ${dbName}' WHERE parameterCode='paramMailTitleUser';

-- Product and Component type
UPDATE `${prefix}type` SET name='software' WHERE scope='Product' AND name='software';
UPDATE `${prefix}type` SET name='servizio' WHERE scope='Product' AND name='service';
UPDATE `${prefix}type` SET name='specifico' WHERE scope='Component' AND name='specific';
UPDATE `${prefix}type` SET name='dallo scaffale' WHERE scope='Component' AND name='on the shelf';

-- TenderStatus
UPDATE `${prefix}tenderstatus` SET name='richiesta da inviare' WHERE name='request to send';
UPDATE `${prefix}tenderstatus` SET name='in attesa di risposta' WHERE name='waiting for reply';
UPDATE `${prefix}tenderstatus` SET name='risposta obsoleta' WHERE name='out of date answer';
UPDATE `${prefix}tenderstatus` SET name='file incompleto' WHERE name='incomplete file';
UPDATE `${prefix}tenderstatus` SET name='ammissibile' WHERE name='admissible';
UPDATE `${prefix}tenderstatus` SET name='lista breve"' WHERE name='short list';
UPDATE `${prefix}tenderstatus` SET name='non selezionato' WHERE name='not selected';
UPDATE `${prefix}tenderstatus` SET name='selezionato' WHERE name='selected';