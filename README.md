
#OnUni

## Sobre

Esse repositório é todo back-end desenvolvido para o TCC do curso de tecnologia do Instituto PROA. O projeto consiste em um local onde ONGs poderiam criar perfis para expor suas necessidades e doadores que pudessem poderiam entrar em contato com a ONG para ajudar de alguma forma.

O projeto foi criado utilizando o framework laravel

[documentação do laravel para melhor entedimento do repositório](https://laravel.com/docs/8.x)

## Requisitos

* PHP 7 
* composer
* mysql

## Iniciar o projeto

Primeiro instale todos os pacotes necessários para o funcionameto do framework utilizando o composer.

```
    composer install
```

Após isso crie um arquivo ```.env``` com base no ```.env.example``` disponível no repositório, após isso altere as seguinte linhas do arquivo .env

```
    DB_DATABASE= (insira aqui o nome do seu banco de dados)
    DB_USERNAME= (username do mysql)
    DB_PASSWORD= (e aqui a senha vinculado ao seu
    username, caso não possua deixe em branco)
```

Rode os seguinte comando para a criação e inserção das tabelas

```
    php artisan migrate
    php artisan db:seed
```

