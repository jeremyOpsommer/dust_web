<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Prérequis

Prérequis pour un serveur local:

- PHP >= 8.2
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- Filter PHP Extension
- Hash PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Session PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Composer
- Node.js version 20.0 ou supérieur

Sinon un fichier docker-compose.yml est disponible pour lancer un serveur local avec Docker.

## Installation

### Sans Docker

```bash
# Cloner le dépôt
git clone git@github.com:jeremyOpsommer/dust_web.git

# Se déplacer dans le dossier du projet
cd path/to/dust_web

# Installer les dépendances
composer install

# Créer un fichier .env
cp .env.example .env

# Générer une clé d'application
php artisan key:generate

# Créer une base de données mysql
# Modifier le fichier .env pour ajouter les informations de connexion à la base de données

# Exécuter les migrations
php artisan migrate

# Exécuter les seeders
php artisan db:seed

# Lancer le serveur
php artisan serve

```

### Avec Docker

```bash
# Cloner le dépôt
git clone git clone git@github.com:jeremyOpsommer/dust_web.git

# Se déplacer dans le dossier du projet
cd path/to/dust_web

# Installer les dépendances pour récupérer sail
composer install

# Créer un fichier .env
cp .env.example .env

# Générer une clé d'application
php artisan key:generate

# lancer sail
./vendor/bin/sail up

# Exécuter les migrations
./vendor/bin/sail artisan migrate

# Exécuter les seeders
./vendor/bin/sail artisan db:seed


```

## Utilisation

### Backoffice
- Accéder à l'interface d'administration à l'adresse http://localhost/admin.
- Les identifiants par défaut sont à modifier dans le fichier .env.
- Le backoffice utilise laravel filament. https://filamentphp.com/docs

