# Table Data Gateway

#### O que faz?

O objetivo desse padrão é oferecer uma interface de comunicação
com o banco de dados e que permita operações de CRUD.

#### Porque existe?

Para que possamos criar um classe que terá a responsabilidade
de manipular cada tabela do banco de dados e apenas uma
instância dessa classe irá manipular todos os registros da tabela.

Sendo assim uma classe Table Data Gateway deve ser stateless,
assim sendo uma ponte entre o objeto de negócio e o banco de
dados.

#### Estrutura

![Estrutura](https://i.ibb.co/yPnRLVY/estrutura-table-data-gateway.png)

#### Exemplo

![Exemplo](https://i.ibb.co/mz5Rb0j/exemplo-data-table-gateway.png)
