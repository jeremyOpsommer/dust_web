<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Prérequis

### Pour Docker (recommandé)
- Docker Desktop
- Docker Compose
- WSL2 (pour Windows)

### Pour serveur local
- PHP >= 8.3
- Extensions PHP requises : Ctype, cURL, DOM, Fileinfo, Filter, Hash, Mbstring, OpenSSL, PCRE, PDO, Session, Tokenizer, XML
- Composer
- Node.js >= 20.0
- MySQL >= 8.0

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

### Avec Docker (recommandé)

```bash
# Cloner le dépôt
git clone git@github.com:jeremyOpsommer/dust_web.git

# Se déplacer dans le dossier du projet
cd dust_web

# Créer un fichier .env
cp .env.example .env

# Lancer Docker Compose
docker compose up -d

# Installer les dépendances PHP (pour récupérer Sail)
docker compose exec laravel.test composer install

# À partir d'ici, utiliser Sail pour le reste de l'installation
./vendor/bin/sail down
./vendor/bin/sail up -d

# Générer une clé d'application
./vendor/bin/sail artisan key:generate

# Installer les dépendances Node.js
./vendor/bin/sail npm install

# Compiler les assets
./vendor/bin/sail npm run build

# Exécuter les migrations
./vendor/bin/sail artisan migrate

# Exécuter les seeders
./vendor/bin/sail artisan db:seed

# Créer un utilisateur admin (optionnel)
./vendor/bin/sail artisan make:filament-user
```

L'application sera accessible à :
- Site web : http://localhost
- Admin Filament : http://localhost/admin
- PhpMyAdmin : http://localhost:8080
- Mailpit : http://localhost:8025

#### Utilisation avec Sail (optionnel)

Une fois Sail installé via `composer install`, vous pouvez utiliser les commandes Sail au lieu de `docker compose` :

```bash
# Démarrer les conteneurs
./vendor/bin/sail up -d

# Arrêter les conteneurs
./vendor/bin/sail down

# Commandes artisan
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed

# Commandes npm
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
./vendor/bin/sail npm run build

# Accéder au shell du conteneur
./vendor/bin/sail shell

# Créer un alias pour simplifier (optionnel)
alias sail='./vendor/bin/sail'
# Puis utiliser : sail up -d, sail artisan migrate, etc.
```

## Stack technique

- **Backend** : Laravel 12
- **Frontend** : Vue.js 3 + Inertia.js
- **CSS** : Tailwind CSS v4
- **Admin** : Filament v5
- **Base de données** : MySQL 8.0

## Utilisation

### Backoffice Filament
- Accéder à l'interface d'administration : http://localhost/admin
- Le backoffice utilise Filament v5 : https://filamentphp.com/docs

### Développement
```bash
# Avec Docker - Mode watch (hot reload)
./vendor/bin/sail npm run dev

# Compiler pour la production
./vendor/bin/sail npm run build
```

