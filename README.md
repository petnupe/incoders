Requisitos do sistema
	PHP7
	imap habilitado

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
1 Criar um servidor atraves do comando php -S localhost:8080 -t src apartir da pasta raiz
2 Emails deverão ser enviados para petersontesteicrs@gmail.com (coforme arquivo de configuação em config/config.ini)
3 Executar o arquivo reader.php para a leitura dos emails, somente email com anexo serão considerados conforme especificações.
4 As informações serão armazenadas no arquivo bd/bd.csv simulando uma base de dados

Arquivo de configuração
	O arquivo config/config.ini contem as infromações utilizadas pelo sistema, são elas:

	SERVER = endereço imap do servidor de email
	PORT = porta imap do servidor de email
	USER = endereço de email que será verificado
	PASS = senha do email a ser verificado
	PORT_IMAP = porta do servidor interno
	TIME_READ = intervalo de tempo que os emails são lidos.