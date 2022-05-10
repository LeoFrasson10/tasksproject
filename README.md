## Projeto Tarefas relacionada ao colaborador

### Tecnologias utilizadas:

- Framework Laravel;
- Composer;
- PHP 7.4;
- Banco de Dados MySQL;
- HTML, JavaScript e MaterializeCss;

### Como executar:

- Clone o repositório;
- Crie um banco de dados MySQL, por exemplo: taskproject;
- Acesse o projeto e instale as dependências utilizando o composer;

  ```php
  composer install
  ```

- Acesse os arquivos do projeto, procure e renomeie o arquivo .env-example para .env;
- Nele você precisa editar alguns dados:

  ```php
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=taskproject
  DB_USERNAME=root
  DB_PASSWORD=
  ```

  \*DB_DATABASE -> é nome do banco de dados que você criou;

  \*DB_USERNAME -> é nome de usuário do banco;

  \*DB_PASSWORD -> senha de acesso do usuário do banco;

- Após realizar essas configurações, execute o comando para gerar as migrations:

  ```php
  php artisan migrate
  ```

- Se tudo der certo, é só executar o servidor:
  ```php
  php artisan serve
  ```
- Normalmente o servidor é executado em `localhost:8000 `
