# Row Data Gateway

#### O que faz?

Esse pattern tem como principal objetivo transformar uma
instância do seu Gateway em um registro de sua base de
dados. Com isso vemos uma grande diferença do pattern de
**Table Data Gateway** onde um Gateway é uma tabela de sua
base de dados.

#### Porque existe?

Esse pattern existe para ser uma representação de um único
registro de uma tabela, assim mantendo os dados armazenados
dentro do próprio Gateway. Assim dessa forma caso sua aplicação
precise de uma camada Stateful, esse pattern é um boa escolha.

#### Estrutura

![Estrutura](https://i.ibb.co/WP0YrCD/estrutura-row-data-gateway.png)

#### Exemplo

![Exemplo](https://i.ibb.co/Sd53SYY/exemplo-row-data-gateway.png)
