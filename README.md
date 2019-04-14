# Database Patterns

Esse é um repositório para consulta dos principais patterns
de banco de dados e exemplos de implementações em PHP.

#### Como rodar os exemplos?

Para rodar os exemplos é necessário ter as seguintes tecnologias
instaladas e rodando em seu computador:

- [Docker](https://docs.docker.com/)

- [Docker Compose](https://docs.docker.com/compose/)

- [Docker Hosts Updater](https://github.com/grachevko/docker-hosts-updater)

Todos os exemplos contém um arquivo para a inicialização
do banco de dados, que é usado nos exemplos.

Esse repo serve mais como consulta de implementação, mas
caso queira rodar algum dos exemplos de teste, basta
executar o comando para subir o container de MySQL dos
exemplos:

```shell
docker-composer up -d
```

Caso não tenha a rede informada no arquivo compose, ao subir
ele irá gerar um erro informando o comando para a criação da rede.
Caso queira usar uma rede já existente, apenas altere o no arquivo
docker-compose.yml.

Depois de ter o banco de dados rodando, basta executar o
servidor do próprio php: 

```shell
php -S localhost:8080
```
