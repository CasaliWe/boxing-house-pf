### START:
- composer install;
- npm install;
- cria o .env e atualiza com o email;
- Se for banco zerado deve rodar as migrations;
- composer run dev - start do projeto; 

### CRONS:
- /avisar - Avisa sobre o treino do dia para o aluno;
- /aniversario - Mensagem de aniversário para o aluno;
- /turmas-dia - Avisa sobre as turmas do dia;
- /aulas-exp-dia - Avisa sobre as aulas exp do dia;
- /analytics - Joga os dados coletados para o whatsapp;


### IMPORTANTE:
- Todos os arquivos ficam em /public/uploads;
- Usando o email da freeladev no .env para disparar notificações;
- Usando o mysql para tudo, então o .env deve ficar padrão;
- Usando o Uazapi para notificações no whatsapp;
- Quando o aluno está em atraso ele consegue logar mas fica mostrando aviso de atraso apenas;
- Precisa aprovar as avaliações;
- Precisa reativar o aluno depois que vence o plano pelo admin colocando crédito;

### NOTIFICAÇÕES PELO WHATSAPP:
- Quando fazer novo cadastro;
- Quando aprova cadastro vai a senha para o aluno;
- Dia de treino do aluno;
- Créditos de aula regularizada, quando aprovo no admin envia a notificação avisando para o aluno;
- Quando o aluno atualiza o horário dele envia para mim avisando no whatsapp;
- Quando aluno faz reserva de aula exp;

### ROTAS ESPECIAIS:
- /cadastro = fazer o cadastro do aluno;
- /precos = valores para treinar na academia;
- /agendar-exp = agendar uma aula experimental;
- /avaliar-boxing-house = avaliar publicamente a academia, vai para aprovação;