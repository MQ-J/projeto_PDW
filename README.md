# Como rodar a aplicação

### Backend
Para rodar o backend, é necessário ter o PHP 8.1.  
Em um terminal, baixe as dependencias do PHP com:
```shell
composer install
```

Uma vez concluído o download, rode o comnado:
```shell
php artisan serve
```

Swagger disponível em: http://localhost:8000/api/documentation

### Frontend
Acesse a pasta do client:
```shell
cd client
```
Baixe as dependencias do frontend:

```shell
npm i
```
Uma vez concluído o download, rode o comnado:
```shell
npm run dev
```
O servidor do client será iniciado nesse [link: http://localhost:5000](http://localhost:5000).
