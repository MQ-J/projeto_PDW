# Backend de API's com Laravel

Esta aplicação reune APIS que funcionam como backend para outros projetos
<hr>

## **ReactMobile**

Aplicação em React, com suporte para ser desenvolvida em dispositivos mobile por meio do app "Spck NodeJS".

- **[Usuários (GET)](https://polar-shelf-77439.herokuapp.com/api/ReactMobile/getUsers)**
- **[Login (POST)](https://polar-shelf-77439.herokuapp.com/api/ReactMobile/login)**
<hr>

## **Slurp**

Teste de integração entre a biblioteca Slurp, em python, com uma aplicação PHP.

- **[Ver sua própria requisição (POST)](https://polar-shelf-77439.herokuapp.com/api/sllurp/getconnection)**
<hr>

## **Banco de dados**

### como configurar
- no arquivo **php.ini**, tire os comentários das linhas:
  - extension=pdo_pgsql
  - extension=pgsql
- em **config/database.php**, defina qual banco de dados vc usará:
  - 'default' => env('DB_CONNECTION', 'postgres'),
- no arquivo **.env**, defina as variáveis de acesso ao banco:
  - DB_CONNECTION=pgsql (padrão)
  - DB_HOST= >>nome do servidor<<
  - DB_PORT=5432 (padrão)
  - DB_DATABASE= >>nome da base de dados<<
  - DB_USERNAME= >>nome do usuário<<
  - DB_PASSWORD= >>senha do usuário<<

Operações CRUD com banco de dados usando API.

- **[Select * Pessoas (GET)](https://polar-shelf-77439.herokuapp.com/api/pessoas/index)**
- **[Insert into Pessoas (POST)](https://polar-shelf-77439.herokuapp.com/api/pessoas/create)**
- **[Update Pessoas (POST)](https://polar-shelf-77439.herokuapp.com/api/pessoas/update/{id})**
- **[Delete from Pessoas (POST)](https://polar-shelf-77439.herokuapp.com/api/pessoas/destroy/{id})**
<hr>

## **Security Vulnerabilities**

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.
<hr>

## **License**

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
<hr>

## **Como começar:**

1. primeiro tenha o composer instalado em sua maquina;
Recomendo o POSTMAN ou INSOMNIA para os testes;

```console
- git clone https://github.com/igor-mondoni/laravel-cad-cliente.git
```

2. Acesse a pasta que foi gerada;

```console
- composer install
- php artisan serve
```

3. Configure o .env para acessar um banco de dados valido

```console
- php artisan migrate
```

4. Rotas:

Caso não configure um virtual host ou mude a porta, logo por default a rota principal será http://127.0.0.1:8000/api


- Listar todas as pessoas:
GET - http://127.0.0.1:8000/api/index

- Criar uma pessoa:
POST - http://127.0.0.1:8000/api/create
campos: 
nome (string).
sobrenome (string).


- Listar uma pessoa em especifico:
GET - http://127.0.0.1:8000/api/show/{id}
id = id do registro da pessoa

- Atualizar o registro de uma pessoa:
POST - http://127.0.0.1:8000/api/update/{id}
id = id do registro da pessoa
campos: 
nome (string).
sobrenome (string).

- Deletar o registro de uma pessoa:
DELETE - http://127.0.0.1:8000/api/destroy/{id}
id = id do registro da pessoa