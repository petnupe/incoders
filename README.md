Requisitos do sistema
	Git
	PHP7
	Imap habilitado (php_imap)

Requisitos do email
	Conta gmail (para esta implementação foram utulizados apenas contas Gmail, para demais provedores verificar configurações de segurança, imap e etc)
	Opção de e-mail como conversa desabilitadas

Configurações de conta gmail:
	Acesso a APPs menos seguros habilitada# incoders

Arquivo de configuração
	O arquivo config/config.ini contem as infromações utilizadas pelo sistema, são elas:
	SERVER = endereço imap do servidor de email
	PORT = porta imap do servidor de email
	USER = endereço de email que será verificado
	PASS = senha do email a ser verificado
	PORT_IMAP = porta do servidor interno
	TIME_READ = intervalo de tempo que os emails são lidos.
	TYPE_MESSAGES =  Quais mensagens serão lidas ALL = todas UNSEEN = não lidas e etc.


Instruções para utilização
1 Clonar o repositorio (git clone https://github.com/petnupe/incoders.git)
2 Acessar o diretorio incoders
3 Criar o servidor apontando para ./src (sugestao php -S localhost:8080 -t ./src)
4 Alterar as informações do arquivo config/config.inc (se necessário)
	TIME_READ
	USER e PASS
	PORT_IMAP - deve ser a mesma utilizada na criação do servidor (sugestão 8080)

5 Executar o arquivo src/reader.php (php src/reader.php)	
6 Enviar e-mail conforme layout definido e com anexo simulando a NF para o email configurado.
	Layout do email:
	===============================================
		Nome:  NOME DA INSTITUICAO
		Endereço: ENDERECO DA INSTITUICAO
		Valor: VALOR DO PAGAMENTO
		Vencimento:MES E ANO DE VENCIMENTO (MM/AA)
		Att.
	===============================================

7 Aguardar a leitura.
8 Conferir a ultima linha do arquivo database/bd.csv (simulador do BD) e o download do anexo na pasta ./files
