-- //////////////////////////////////////////////////////////////////////////////////
-- // PROJECTOR TRANSLATION PLUGIN                                                 //
-- // Translation of some parameters related to the language used by the users.    //
-- // To execute ONCE after a fresh install of database.                           //
-- // Example of Brazilian Portuguese translation of values for parameters tables. //
-- // Usefull for Brazilian Portuguese users.                                      //
-- // Good start for translation in other languages.                               //
-- //////////////////////////////////////////////////////////////////////////////////

-- Access Profile 
UPDATE `${prefix}accessprofile` SET description='Ler itens dos seus projetos.' WHERE name='accessProfileRestrictedReader';
UPDATE `${prefix}accessprofile` SET description='Ler todos os itens em todos os projetos.' WHERE name='accessProfileGlobalReader';
UPDATE `${prefix}accessprofile` SET description='Ler e atualizar somente os seus projetos.' WHERE name='accessProfileRestrictedUpdater';
UPDATE `${prefix}accessprofile` SET description='Ler e atualizar todos os itens em todos os projetos.' WHERE name='accessProfileGlobalUpdater';
UPDATE `${prefix}accessprofile` SET description='Ler somente os seus projetos. Pode criar, atualizar e excluir somente seus próprios elementos.' WHERE name='accessProfileRestrictedCreator';
UPDATE `${prefix}accessprofile` SET description='Ler todos os projetos. Pode criar, atualizar e excluir somente seus próprios elementos.' WHERE name='accessProfileGlobalCreator';
UPDATE `${prefix}accessprofile` SET description='Ler somente os seus projetos. Pode criar, atualizar e excluir somente seus próprios elementos.' WHERE name='accessProfileRestrictedManager';
UPDATE `${prefix}accessprofile` SET description='Ler todos os projetos. Pode criar, atualizar e excluir seus projetos.' WHERE name='accessProfileGlobalManager';
UPDATE `${prefix}accessprofile` SET description='Sem acesso' WHERE name='accessProfileNoAccess';
UPDATE `${prefix}accessprofile` SET description='Somente leitura dos itens próprios' WHERE name='accessReadOwnOnly';

-- ContextType
UPDATE `${prefix}contexttype` SET name='Ambiente' WHERE name='environment';
UPDATE `${prefix}contexttype` SET name='Sistema operacional' WHERE name='OS';
UPDATE `${prefix}contexttype` SET name='Navegador' WHERE name='browser';

-- Criticality
UPDATE `${prefix}criticality` SET name='Baixo' WHERE name='Low';
UPDATE `${prefix}criticality` SET name='Médio' WHERE name='Medium';
UPDATE `${prefix}criticality` SET name='Alto' WHERE name='High';
UPDATE `${prefix}criticality` SET name='Crítico' WHERE name='Critical';

-- DeliveryMode
UPDATE `${prefix}deliverymode` SET name='email' WHERE name='email';
UPDATE `${prefix}deliverymode` SET name='correio' WHERE name='postal mail';
UPDATE `${prefix}deliverymode` SET name='entrega em mãos' WHERE name='hand delivered';
UPDATE `${prefix}deliverymode` SET name='armazenamento digital' WHERE name='digital deposit';

-- Efficiency
UPDATE `${prefix}efficiency` SET name='totalmente eficiente' WHERE name='fully efficient';
UPDATE `${prefix}efficiency` SET name='parcialmente eficiente' WHERE name='partially efficient';
UPDATE `${prefix}efficiency` SET name='ineficaz' WHERE name='not efficient';

-- ExpenseDatailType
UPDATE `${prefix}expensedetailtype` SET name='Por carro' WHERE name='travel by car';
UPDATE `${prefix}expensedetailtype` SET name='Por carro (frequente)', unit01='dias', unit02='km/dia' WHERE name='regular mission car travel';
UPDATE `${prefix}expensedetailtype` SET name='Almoço com clientes', unit01='convidados', unit02='$ por convidado' WHERE name='lunch for guests';
UPDATE `${prefix}expensedetailtype` SET name='Despesa justificada' WHERE name='justified expense';
UPDATE `${prefix}expensedetailtype` SET name='Detalhes', unit01='unidades', unit02='$ por unidade' WHERE name='detail';

-- Feasibility
UPDATE `${prefix}feasibility` SET name='Sim' WHERE name='Yes';
UPDATE `${prefix}feasibility` SET name='Em análise' WHERE name='Investigate';
UPDATE `${prefix}feasibility` SET name='Não' WHERE name='No';

-- Health
UPDATE `${prefix}health` SET name='seguro' WHERE name='secured';
UPDATE `${prefix}health` SET name='questionado' WHERE name='surveyed';
UPDATE `${prefix}health` SET name='em perigo' WHERE name='in danger';
UPDATE `${prefix}health` SET name='quebrado' WHERE name='crashed';
UPDATE `${prefix}health` SET name='parado' WHERE name='paused';

-- Likelihood
UPDATE `${prefix}likelihood` SET name='Baixo (10%)' WHERE name='Low (10%)';
UPDATE `${prefix}likelihood` SET name='Médio (50%)' WHERE name='Medium (50%)';
UPDATE `${prefix}likelihood` SET name='Alto (90%)' WHERE name='High (90%)';

-- MeasureUnit
UPDATE `${prefix}measureunit` SET name='peça', pluralName='peças' WHERE name='piece';
UPDATE `${prefix}measureunit` SET name='lote', pluralName='lotes' WHERE name='lot';
UPDATE `${prefix}measureunit` SET name='dia', pluralName='dias' WHERE name='day';
UPDATE `${prefix}measureunit` SET name='mês', pluralName='meses' WHERE name='month';

-- Message 
UPDATE `${prefix}message` SET description='Bem-vindo ao sistema ProjeQtor' WHERE description='Welcome to ProjectOr web application';

-- PaymentDelay 
UPDATE `${prefix}paymentdelay` SET name='15 dias' WHERE name='15 days';
UPDATE `${prefix}paymentdelay` SET name='15 dias do fim do mês' WHERE name='15 days end of month';
UPDATE `${prefix}paymentdelay` SET name='30 dias' WHERE name='30 days';
UPDATE `${prefix}paymentdelay` SET name='30 dias do fim do mês' WHERE name='30 days end of month';
UPDATE `${prefix}paymentdelay` SET name='45 dias' WHERE name='45 days';
UPDATE `${prefix}paymentdelay` SET name='45 dias do fim do mês' WHERE name='45 days end of month';
UPDATE `${prefix}paymentdelay` SET name='60 dias' WHERE name='60 days';
UPDATE `${prefix}paymentdelay` SET name='por pedido' WHERE name='on order';

-- PaymentMode
UPDATE `${prefix}paymentmode` SET name='transferência bancária' WHERE name='bank transfer';
UPDATE `${prefix}paymentmode` SET name='cheque' WHERE name='cheque';
UPDATE `${prefix}paymentmode` SET name='cartão de crédito' WHERE name='credit card';
UPDATE `${prefix}paymentmode` SET name='terminal de pagamento virtual' WHERE name='virtual payment terminal';

-- Priority
UPDATE `${prefix}priority` SET name='Baixa' WHERE name='Low priority';
UPDATE `${prefix}priority` SET name='Média' WHERE name='Medium priority';
UPDATE `${prefix}priority` SET name='Alta' WHERE name='High priority';
UPDATE `${prefix}priority` SET name='Crítica' WHERE name='Critical priority';

-- Profile
UPDATE `${prefix}profile` SET description='Pode ver todos os projetos' WHERE name='profileAdministrator' AND description='Has a visibility over all the projects';
UPDATE `${prefix}profile` SET description='Pode ver todos os projetos e realiza atualizações' WHERE name='profileSupervisor' AND description='Has a visibility over all the projects';
UPDATE `${prefix}profile` SET description='Gerencia seus próprios projetos' WHERE name='profileProjectLeader' AND description='Leads his owns project';
UPDATE `${prefix}profile` SET description='Trabalha nos projetos em que é atribuído' WHERE name='profileTeamMember' AND description='Works for a project';
UPDATE `${prefix}profile` SET description='Visibilidade limitada sobre os projetos em que é atribuído' WHERE name='profileGuest' AND description ='Has limited visibility to a project';
UPDATE `${prefix}profile` SET description='Visibilidade limitada sobre os projetos em que é atribuído. Pode validar algumas etapas.' WHERE name='profileExternalProjectLeader' AND description is null;
UPDATE `${prefix}profile` SET description='Visibilidade limitada sobre os projetos em que é atribuído. Pode criar tickets.' WHERE name='profileExternalTeamMember' AND description is null;

-- Quality
UPDATE `${prefix}quality` SET name='conforme' WHERE name='conform';
UPDATE `${prefix}quality` SET name='algumas observações' WHERE name='some remarks';
UPDATE `${prefix}quality` SET name='não conforme' WHERE name='not conform';

-- Resolution
UPDATE `${prefix}resolution` SET name='não resolvido' WHERE name='not resolved';
UPDATE `${prefix}resolution` SET name='resolvido' WHERE name='fixed';
UPDATE `${prefix}resolution` SET name='já resolvido' WHERE name='already fixed';
UPDATE `${prefix}resolution` SET name='duplicado' WHERE name='duplicate';
UPDATE `${prefix}resolution` SET name='rejeitado' WHERE name='rejected';
UPDATE `${prefix}resolution` SET name='suporte realizado' WHERE name='support provided';
UPDATE `${prefix}resolution` SET name='alternativa realizada' WHERE name='workaround provided';
UPDATE `${prefix}resolution` SET name='evolução' WHERE name='evolution done';

-- Risklevel
UPDATE `${prefix}risklevel` SET name='Muito baixo' WHERE name='Very Low';
UPDATE `${prefix}risklevel` SET name='Baixo' WHERE name='Low';
UPDATE `${prefix}risklevel` SET name='Médio' WHERE name='Average';
UPDATE `${prefix}risklevel` SET name='Alto' WHERE name='High';
UPDATE `${prefix}risklevel` SET name='Muito alto' WHERE name='Very High';

-- Role
UPDATE `${prefix}role` SET name='Ferente', description='Responsável pelo projeto (PMO)', sortOrder='80' WHERE name='Manager';
UPDATE `${prefix}role` SET name='Analista', description='', sortOrder='20' WHERE name='Analyst';
UPDATE `${prefix}role` SET name='Desenvolvedor', description='', sortOrder='110' WHERE name='Developer';
UPDATE `${prefix}role` SET name='Especialista', description='', sortOrder='130' WHERE name='Expert';
UPDATE `${prefix}role` SET name='Material', description='Recurso material. Ex.: Servidor', sortOrder='140' WHERE name='Machine';

-- Severity
UPDATE `${prefix}severity` SET name='Baixo' WHERE name='Low';
UPDATE `${prefix}severity` SET name='Médio' WHERE name='Medium';
UPDATE `${prefix}severity` SET name='Alto' WHERE name='High';

-- Status
UPDATE `${prefix}status` SET name='registrado' WHERE name='recorded';
UPDATE `${prefix}status` SET name='qualificado' WHERE name='qualified';
UPDATE `${prefix}status` SET name='aceito' WHERE name='accepted';
UPDATE `${prefix}status` SET name='reaberto' WHERE name='re-opened';
UPDATE `${prefix}status` SET name='atribuído' WHERE name='assigned';
UPDATE `${prefix}status` SET name='preparado' WHERE name='prepared';
UPDATE `${prefix}status` SET name='em andamento' WHERE name='in progress';
UPDATE `${prefix}status` SET name='concluído' WHERE name='done';
UPDATE `${prefix}status` SET name='verificado' WHERE name='verified';
UPDATE `${prefix}status` SET name='entregue' WHERE name='delivered';
UPDATE `${prefix}status` SET name='validado' WHERE name='validated';
UPDATE `${prefix}status` SET name='fechado' WHERE name='closed';
UPDATE `${prefix}status` SET name='cancelado' WHERE name='cancelled';

-- Trend
UPDATE `${prefix}trend` SET name='crescente' WHERE name='increasing';
UPDATE `${prefix}trend` SET name='estável' WHERE name='even';
UPDATE `${prefix}trend` SET name='decrescente' WHERE name='decreasing';

-- Type
UPDATE `${prefix}type` SET name='Preço fixo' WHERE scope='Project' AND name='Fixed Price';
UPDATE `${prefix}type` SET name='Tempo e Material' WHERE scope='Project' AND name='Time & Materials';
UPDATE `${prefix}type` SET name='Tempo e material fornecidos' WHERE scope='Project' AND name='Capped Time & Materials';
UPDATE `${prefix}type` SET name='Interno' WHERE scope='Project' AND name='Internal';
UPDATE `${prefix}type` SET name='Administrativo' WHERE scope='Project' AND name='Administrative';
UPDATE `${prefix}type` SET name='Modelo' WHERE scope='Project' AND name='Template';
UPDATE `${prefix}type` SET name='Incidente' WHERE name='Incident';
UPDATE `${prefix}type` SET name='Suporte' WHERE name='Support / Assistance';
UPDATE `${prefix}type` SET name='Erro' WHERE name='Anomaly / Bug';
UPDATE `${prefix}type` SET name='Desenvolvimento' WHERE scope='Activity' AND name='Development';
UPDATE `${prefix}type` SET name='Evolução' WHERE scope='Activity' AND name='Evolution';
UPDATE `${prefix}type` SET name='Gerenciamento' WHERE scope='Activity' AND name='Management';
UPDATE `${prefix}type` SET name='Fase' WHERE scope='Activity' AND name='Phase';
UPDATE `${prefix}type` SET name='Tarefa' WHERE scope='Activity' AND name='Task';
UPDATE `${prefix}type` SET name='Entregável' WHERE scope='Milestone' AND name='Deliverable';
UPDATE `${prefix}type` SET name='Recebimento' WHERE scope='Milestone' AND name='Incoming';
UPDATE `${prefix}type` SET name='Data chave' WHERE scope='Milestone' AND name='Key date';
UPDATE `${prefix}type` SET name='Preço fixo' WHERE scope='Quotation' AND name='Fixe Price';
UPDATE `${prefix}type` SET name='Diário' WHERE scope='Quotation' AND name='Per day';
UPDATE `${prefix}type` SET name='Mensal' WHERE scope='Quotation' AND name='Per month';
UPDATE `${prefix}type` SET name='Anual' WHERE scope='Quotation' AND name='Per year';
UPDATE `${prefix}type` SET name='Preço fixo' WHERE scope='Command' AND name='Fixe Price';
UPDATE `${prefix}type` SET name='Diário' WHERE scope='Command' AND name='Per day';
UPDATE `${prefix}type` SET name='Mensal' WHERE scope='Command' AND name='Per month';
UPDATE `${prefix}type` SET name='Anual' WHERE scope='Command' AND name='Per year';
UPDATE `${prefix}type` SET name='Relatório de despesas' WHERE scope='IndividualExpense' AND name='Expense report';
UPDATE `${prefix}type` SET name='Despesa de equipamento' WHERE scope='ProjectExpense' AND name='Machine expense';
UPDATE `${prefix}type` SET name='Despesa de escritório' WHERE scope='ProjectExpense' AND name='Office expense';
UPDATE `${prefix}type` SET name='Fatura parcial' WHERE scope='Bill' AND name='Partial bill';
UPDATE `${prefix}type` SET name='Fatura final' WHERE scope='Bill' AND name='Final bill';
UPDATE `${prefix}type` SET name='Fatural completa' WHERE scope='Bill' AND name='Complete bill';
UPDATE `${prefix}type` SET name='Contratual' WHERE scope='Risk' AND name='Contractual';
UPDATE `${prefix}type` SET name='Operacional' WHERE scope='Risk' AND name='Operational';
UPDATE `${prefix}type` SET name='Técnico' WHERE scope='Risk' AND name='Technical';
UPDATE `${prefix}type` SET name='Contratual' WHERE scope='Opportunity' AND name='Contractual';
UPDATE `${prefix}type` SET name='Operacional' WHERE scope='Opportunity' AND name='Operational';
UPDATE `${prefix}type` SET name='Técnico' WHERE scope='Opportunity' AND name='Technical';
UPDATE `${prefix}type` SET name='Projeto' WHERE scope='Action' AND name='Project';
UPDATE `${prefix}type` SET name='Interno' WHERE scope='Action' AND name='Internal';
UPDATE `${prefix}type` SET name='Cliente' WHERE scope='Action' AND name='Customer';
UPDATE `${prefix}type` SET name='Problema técnico' WHERE scope='Issue' AND name='Technical issue';
UPDATE `${prefix}type` SET name='Não conformidade com o processo' WHERE scope='Issue' AND name='Process non conformity';
UPDATE `${prefix}type` SET name='Não conformidade com a qualidade' WHERE scope='Issue' AND name='Quality non conformity';
UPDATE `${prefix}type` SET name='Processo não aplicável' WHERE scope='Issue' AND name='Process non appliability';
UPDATE `${prefix}type` SET name='Reclamação do cliente' WHERE scope='Issue' AND name='Customer complaint';
UPDATE `${prefix}type` SET name='Detalhe não respeitado' WHERE scope='Issue' AND name='Delay non respect';
UPDATE `${prefix}type` SET name='Problema de gerenciamento de recurso' WHERE scope='Issue' AND name='Resource management issue';
UPDATE `${prefix}type` SET name='Perda financeira' WHERE scope='Issue' AND name='Financial loss';
UPDATE `${prefix}type` SET name='Comitê Diretor' WHERE scope='Meeting' AND name='Steering Committee';
UPDATE `${prefix}type` SET name='Reunião de progresso' WHERE scope='Meeting' AND name='Progress Metting';
UPDATE `${prefix}type` SET name='Reunião da Equipe' WHERE scope='Meeting' AND name='Team Meeting';
UPDATE `${prefix}type` SET name='Funcional' WHERE scope='Decision' AND name='Functional';
UPDATE `${prefix}type` SET name='Operacional' WHERE scope='Decision' AND name='Operational';
UPDATE `${prefix}type` SET name='Contratual' WHERE scope='Decision' AND name='Contractual';
UPDATE `${prefix}type` SET name='Estratégico' WHERE scope='Decision' AND name='Strategic';
UPDATE `${prefix}type` SET name='Funcional' WHERE scope='Question' AND name='Functional';
UPDATE `${prefix}type` SET name='Técnico' WHERE scope='Question' AND name='Technical';
UPDATE `${prefix}type` SET name='ALERTA' WHERE scope='Message' AND name='ALERT';
UPDATE `${prefix}type` SET name='ATENÇÃO' WHERE scope='Message' AND name='WARNING';
UPDATE `${prefix}type` SET name='INFORMAÇÃO' WHERE scope='Message' AND name='INFO';
UPDATE `${prefix}type` SET name='Especificação necessária' WHERE scope='Document' AND name='Need expression';
UPDATE `${prefix}type` SET name='Espeficicação geral' WHERE scope='Document' AND name='General Specification';
UPDATE `${prefix}type` SET name='Especificação detalhada' WHERE scope='Document' AND name='Detailed Specification';
UPDATE `${prefix}type` SET name='Concepção geral' WHERE scope='Document' AND name='General Conception';
UPDATE `${prefix}type` SET name='Concepção detalhada' WHERE scope='Document' AND name='Detail Conception';
UPDATE `${prefix}type` SET name='Plano de teste' WHERE scope='Document' AND name='Test Plan';
UPDATE `${prefix}type` SET name='Manual de instalação' WHERE scope='Document' AND name='Installaton manual';
UPDATE `${prefix}type` SET name='Manual de exploração' WHERE scope='Document' AND name='Exploitation manual';
UPDATE `${prefix}type` SET name='Manual do usuário' WHERE scope='Document' AND name='User manual';
UPDATE `${prefix}type` SET name='Contrato' WHERE scope='Document' AND name='Contract';
UPDATE `${prefix}type` SET name='Gerenciamento' WHERE scope='Document' AND name='Management';
UPDATE `${prefix}type` SET name='Reunião de Revisão' WHERE scope='Document' AND name='Meeting Review';
UPDATE `${prefix}type` SET name='Retorno' WHERE scope='Document' AND name='Follow-up';
UPDATE `${prefix}type` SET name='Financeiro' WHERE scope='Document' AND name='Financial';
UPDATE `${prefix}type` SET name='Funcional' WHERE scope='Requirement' AND name='Functional';
UPDATE `${prefix}type` SET name='Técnico' WHERE scope='Requirement' AND name='Technical';
UPDATE `${prefix}type` SET name='Segurança' WHERE scope='Requirement' AND name='Security';
UPDATE `${prefix}type` SET name='Regulatório' WHERE scope='Requirement' AND name='Regulatory';
UPDATE `${prefix}type` SET name='Teste de Requisitos' WHERE scope='TestCase' AND name='Requirement test';
UPDATE `${prefix}type` SET name='Teste Unitário' WHERE scope='TestCase' AND name='Unit test';
UPDATE `${prefix}type` SET name='Teste de Não-regressão' WHERE scope='TestCase' AND name='Non regression';
UPDATE `${prefix}type` SET name='Sessão de teste de evolução' WHERE scope='TestSession' AND name='Evolution test session';
UPDATE `${prefix}type` SET name='Sessão de teste de desenvolvimento' WHERE scope='TestSession' AND name='Development test session';
UPDATE `${prefix}type` SET name='Sessão de teste de não-regressão' WHERE scope='TestSession' AND name='Non regression test session';
UPDATE `${prefix}type` SET name='Sessão de teste unitário' WHERE scope='TestSession' AND name='Unitary case test session';
UPDATE `${prefix}type` SET name='Prospecção', sortOrder='50', description='Cliente potencial' WHERE scope='Client' AND name='business prospect';
UPDATE `${prefix}type` SET name='Cliente', sortOrder='30', description='Cliente atual' WHERE scope='Client' AND name='customer';
UPDATE `${prefix}type` SET name='Completo' WHERE scope='Payment' AND name='final payment';
UPDATE `${prefix}type` SET name='Parcial' WHERE scope='Payment' AND name='partial payment';
UPDATE `${prefix}type` SET name='Software' WHERE scope='Product' AND name='software';
UPDATE `${prefix}type` SET name='Serviço' WHERE scope='Product' AND name='service';
UPDATE `${prefix}type` SET name='Específico' WHERE scope='Component' AND name='specific';
UPDATE `${prefix}type` SET name='Prateleira' WHERE scope='Component' AND name='on the shelf';
UPDATE `${prefix}type` SET name='Atacadista' WHERE scope='Provider' AND name='wholesaler';
UPDATE `${prefix}type` SET name='Varejista' WHERE scope='Provider' AND name='retailer';
UPDATE `${prefix}type` SET name='Prestador de Serviços' WHERE scope='Provider' AND name='service provider';
UPDATE `${prefix}type` SET name='Subcontratado' WHERE scope='Provider' AND name='subcontractor';
UPDATE `${prefix}type` SET name='Central de Compras' WHERE scope='Provider' AND name='central purchasing';
UPDATE `${prefix}type` SET name='Comum acordo' WHERE scope='CallForTender' AND name='by mutual agreement';
UPDATE `${prefix}type` SET name='Procedimento adaptado' WHERE scope='CallForTender' AND name='adapted procedure';
UPDATE `${prefix}type` SET name='Chamada de propostas' WHERE scope='CallForTender' AND name='open call for tender';
UPDATE `${prefix}type` SET name='Chamada de propostas restrito' WHERE scope='CallForTender' AND name='restricted call for tender';
UPDATE `${prefix}type` SET name='Comum acordo' WHERE scope='Tender' AND name='by mutual agreement';
UPDATE `${prefix}type` SET name='Procedimento adaptado' WHERE scope='Tender' AND name='adapted procedure';
UPDATE `${prefix}type` SET name='Chamada de propostas' WHERE scope='Tender' AND name='open call for tender';
UPDATE `${prefix}type` SET name='Chamada de propostas restrito' WHERE scope='Tender' AND name='restricted call for tender';

-- Urgency
UPDATE `${prefix}urgency` SET name='Impedimento' WHERE name='Blocking';
UPDATE `${prefix}urgency` SET name='Urgente' WHERE name='Urgent';
UPDATE `${prefix}urgency` SET name='Não urgente' WHERE name='Not urgent';

-- Workflow
UPDATE `${prefix}workflow` SET name='Padrão', description='Fluxo de trabalho padrão com restrições. Todos podem mudar o status' WHERE name='Default';
UPDATE `${prefix}workflow` SET name='Simples', description='Fluxo de trabalho simples com os status limitados. Todos podem mudar o status' WHERE name='Simple';
UPDATE `${prefix}workflow` SET name='Validação externa', description='Fluxos de trabalho desenvolvido com a equipe interna e validação externa.'
  WHERE name='External validation';
UPDATE `${prefix}workflow` SET name='Aceite e validação externa', description='Fluxos de trabalho desenvolvido com aceite externo, equipe interna e validação externa.'
  WHERE name='External acceptation & validation';
UPDATE `${prefix}workflow` SET name='Simples com validação', description='Fluxo de trabalho simples com os status limitados, incluindo a validação.'
  WHERE name='Simple with validation';
UPDATE `${prefix}workflow` SET name='Validação', description='Fluxo de trabalho curto com apenas uma validação ou possibilidade de cancelamento. Privilégios de validação restritos.' WHERE name='Validation';
UPDATE `${prefix}workflow` SET name='Simples com preparação', description='Fluxo de trabalho simples com status limitados, incluindo a preparação. Todos podem modificar o status.' WHERE name='Simple with preparation';
UPDATE `${prefix}workflow` SET name='Simples com validaçao do líder do projeto', description='Fluxo de trabalho simples com os status limitados, incluindo a validação do gerente do projeto. Todos podem mudar o status, exceto para validação que é reservado para gerente do projeto.' WHERE name='Simple with Project Leader validation';

-- Configuration / Parameters
UPDATE `${prefix}parameter` SET parameterValue='O sistema está fechado. Apenas o adminsitrador pode se conectar. Por favor, retorne mais tarde.' WHERE parameterCode='msgClosedApplication';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Você é o aprovador do <a href="${url}" >Documento #${id}</a> : "${name}".<br/>Por favor acesse <a href="${url}" >este documento</a> e siga o processo de aprovação.' WHERE parameterCode='paramMailBodyApprover';
UPDATE `${prefix}parameter` SET parameterValue='Bem-vindo ao sistema ProjeQtOr ${dbName}, acessível em <a href="${url}">${url}</a>.<br/>Seu nome de usuário é <b>${login}</b>.<br/>Sua senha inicial é <b>${password}</b><br/>Você vai precisar alterar na primeira conexão.<br/><br/>Se ocorrerem problemas, contate o administrador através do endereço <b>${adminMail}</b>.' WHERE parameterCode='paramMailBodyUser';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] O item ${item} #${id} foi alterado : "${name}"' WHERE parameterCode='paramMailTitleAnyChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Mensagem para ${sender} : Você deve aprovar um documento' WHERE parameterCode='paramMailTitleApprover';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Um novo comentário foi adicionado ao item ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleAssignment';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Uma atribuição foi modificada para o item ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleAssignmentChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Um novo arquivo foi anexado ao item ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleAttachment';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] A descrição do item ${item} #${id} foi alterado : "${name}"' WHERE parameterCode='paramMailTitleDescription';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Mensagem enviada para ${sender} : ${item} #${id}' WHERE parameterCode='paramMailTitleDirect';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] O item ${item} #${id} foi criado : "${name}"' WHERE parameterCode='paramMailTitleNew';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Uma nova nota foi adicionada ao item ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleNote';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Uma nota foi alterada no item ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleNoteChange';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] ${responsible} agora é o responsável pelo o item ${item} #${id} : "${name}"' WHERE parameterCode='paramMailTitleResponsible';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] O resultado foi alterado para o item ${item} #${id} : "${name}' WHERE parameterCode='paramMailTitleResult';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] ${item} #${id} passou do status ${status} : ${name}' WHERE parameterCode='paramMailTitleStatus';
UPDATE `${prefix}parameter` SET parameterValue='[${dbName}] Mensagem enviada para ${sender} : Informações sobre a sua conta no sistema ${dbName}' WHERE parameterCode='paramMailTitleUser';

-- Product and Component type
UPDATE `${prefix}type` SET name='software' WHERE scope='Product' AND name='software';
UPDATE `${prefix}type` SET name='serviço' WHERE scope='Product' AND name='service';
UPDATE `${prefix}type` SET name='específico' WHERE scope='Component' AND name='specific';
UPDATE `${prefix}type` SET name='prateleira' WHERE scope='Component' AND name='on the shelf';

-- TenderStatus
UPDATE `${prefix}tenderstatus` SET name='solicitação para envio' WHERE name='request to send';
UPDATE `${prefix}tenderstatus` SET name='aguardando por resposta' WHERE name='waiting for reply';
UPDATE `${prefix}tenderstatus` SET name='resposta fora do prazo' WHERE name='out of date answer';
UPDATE `${prefix}tenderstatus` SET name='arquivo incompleto' WHERE name='incomplete file';
UPDATE `${prefix}tenderstatus` SET name='admissível' WHERE name='admissible';
UPDATE `${prefix}tenderstatus` SET name='lista curta"' WHERE name='short list';
UPDATE `${prefix}tenderstatus` SET name='não selecionado' WHERE name='not selected';
UPDATE `${prefix}tenderstatus` SET name='selecionado' WHERE name='selected';