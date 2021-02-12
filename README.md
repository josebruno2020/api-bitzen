<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## API filmes

Desenvolvido em Laravel 8.27, constitui-se de uma api para atender uma plataforma de filmes, onde cada filme tem várias categorias e atores. Os usuários cadastrados no sistema poderão avaliar uma vez cada filme com uma nota de 1 a 5. 

## Funções

1. Avaliação de filme pelo usuário, sendo única e de 1 a 5;

2. Possível realizar pesquisas, informando o tipo de filtro (nome, categoria, ator) para buscar os filmes cadastrados;

3. O sistema entrega uma lista dos top 10 filmes mais bem avaliados pelos usuários.

## Configuração

1. Configurar banco de dados no arquivo .env (no desenvolvimento foi usado banco de dados mysql);

2. No terminal rodar o comando 'php artisan migrate --seed' para rodar as migrations juntamente com os envios automáticos para o banco de dados;

3. Na raiz do projeto, rodar o comando 'php artisan serve' no terminal para subir o servidor;

4. Entrar na rota /api/documentation para acessar a documentação completa das rotas;

5. Fazer o login na rota /api/login com 'bruno@teste.com' e senha '123' para resgatar o token bearer;

6. Inserir o token resgatado para poder acessar as outras rotas marcadas por um cadeado.


## Muito obrigado!