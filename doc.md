### START:
- composer install;
- npm install;
- cria o .env e atualiza com o email;
- Se for banco zerado deve rodar as migrations;
- composer run dev - start do projeto; 

### CRONS:
- /mensalidades - Verifica as mensalidades, avisa vencidos e muda status ativo para inativo;
- /avisar - Avisa sobre o treino do dia para o aluno;
- /aniversario - Mensagem de aniversário para o aluno;
- /turmas-dia - Avisa sobre as turmas do dia;
- /aulas-exp-dia - Avisa sobre as aulas exp do dia;
- /analytics - Joga os dados coletados para o whatsapp;

### IMPORTANTE:
- Usando o email da freeladev no .env para disparar notificações;
- Usando o sqlite para tudo, então o .env deve ficar padrão;
- Usando o Uazapi para notificações no whatsapp;
- Quando o aluno está em atraso ele consegue logar mas fica mostrando aviso de atraso apenas;
- Quando colocar 5x na semana o valor é referente ao que aparece no site como aula avulsa;
- Precisa aprovar as avaliações;
- Precisa reativar o aluno depois que vence o plano pelo admin;

### NOTIFICAÇÕES PELO WHATSAPP:
- Quando fazer novo cadastro;
- Quando aprova cadastro vai a senha para o aluno;
- Dia de treino do aluno;
- Cron que verifica vencimento, envia também notificação;
- Mensalidade regularizada, quando aprovo no admin envia a notificação avisando para o aluno;
- Quando o aluno atualiza o horário dele envia para mim avisando no whatsapp;

### PÁGINAS:
- home - / = landing page;
- cadastro - /cadastro = formulário de cadastro dos novos alunos;
- login - /login = fazer login no sistema;

