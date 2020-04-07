<h1>MOVIE LIBRARY</h1>

<h2> PASSOS PARA SUBIR O PROJETO</h2>

No diretório raiz do projeto, execute os seguintes comandos:

		$ git clone https://github.com/diegotesch/cadmovies.git

		$ cd cadmovies
		
		$ cp .env.example .env

		$ docker-compose up -d

		$ docker-compose run app composer install

		$ npm install

		$ php artisan key:generate

		$ docker-compose run app php artisan migrate

		$ docker-compose run app php artisan passport:install

		$ docker-compose run app php artisan db:seed


<h2>ACESSANDO O SISTEMA</h2>

URL:

		http://localhost:8000

Dados para Login: 

		Usuário: user@test.com
		Passowrd: secret
