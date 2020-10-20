Requisitos do sistema
	Git
	PHP7
	Imap habilitado (php_imap)

Requisitos do email
	Conta gmail (apenas para teste, em produção melhorar as opçoes)
	Opção de e-mail como conversa desabilitadas

Configurações de conta gmail:
	Acesso a APPs menos seguros habilitada# incoders

Layout do email:
===============================================
	Nome:  NOME DA INSTITUICAO
	Endereço: ENDERECO DA INSTITUICAO
	Valor: VALOR DO PAGAMENTO
	Vencimento:MES E ANO DE VENCIMENTO (MM/AA)
	Att.
===============================================

Instruções para utilizacao
Clonar o repositorio (git clone https://github.com/petnupe/incoders.git)
Acessar o diretorio incoders
Criar o servidor apontando para ./src (sugestao php -S localhost:8080 -t ./src)
Alterar as informações do arquivo config/config.inc
	TIME_READ
	USER e PASS
	PORT_IMAP - deve ser a mesma utilizada na criação do servidor (sugestão 8080)

Executar o arquivo src/reader.php (php src/reader.php)	
Enviar e-mail conforme layout definido e com anexo simulando a NF para o email configurado.
Aguardar a leitura.
Conferir a ultima linha do arquivo bd.csv e o download do anexo na pasta ./files


Arquivo de configuração
	O arquivo config/config.ini contem as infromações utilizadas pelo sistema, são elas:

	SERVER = endereço imap do servidor de email
	PORT = porta imap do servidor de email
	USER = endereço de email que será verificado
	PASS = senha do email a ser verificado
	PORT_IMAP = porta do servidor interno
	TIME_READ = intervalo de tempo que os emails são lidos.
	TYPE_MESSAGES =  Quais mensagens serão lidas ALL = todas UNSEEN = não lidas e etc.