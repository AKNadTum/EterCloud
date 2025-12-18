# EterCloud - Plateforme de gestion Cloud

## À propos

EterCloud (Eternom) est une plateforme de gestion de services cloud avec intégration Stripe pour les paiements et Pterodactyl pour la gestion des ressources.

## Déploiement sur Laravel Cloud

### 1. Prérequis

- Un compte Laravel Cloud (https://cloud.laravel.com)
- Votre dépôt GitHub/GitLab/Bitbucket connecté
- Clés API Stripe configurées
- URL et clé API Pterodactyl (si applicable)

### 2. Configuration initiale

1. **Connectez votre dépôt** à Laravel Cloud
2. **Sélectionnez ce projet** (EterCloud)
3. **Configurez la base de données** : MySQL ou PostgreSQL (recommandé pour production)

### 3. Variables d'environnement obligatoires

Configurez ces variables dans le dashboard Laravel Cloud :

```env
APP_NAME=Eternom
APP_ENV=production
APP_KEY=base64:...  # Sera généré automatiquement
APP_DEBUG=false
APP_URL=https://votre-domaine.com

# Base de données (fournie par Laravel Cloud)
DB_CONNECTION=mysql
DB_HOST=...
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

# Stripe (Obligatoire pour les paiements)
STRIPE_KEY=pk_live_...
STRIPE_SECRET=sk_live_...
STRIPE_WEBHOOK_SECRET=whsec_...

# Pterodactyl (Si applicable)
PTERODACTYL_URL=https://votre-panel.com
PTERODACTYL_API_KEY=...

# Session et Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Email (Configurez selon votre service)
MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS=noreply@eternom.fr
```

### 4. Configuration du Webhook Stripe

Après le déploiement, configurez le webhook Stripe :
- URL : `https://votre-domaine.com/webhook/stripe`
- Événements à écouter : `checkout.session.completed`, `customer.subscription.updated`, etc.

### 5. Commandes de déploiement

Laravel Cloud exécutera automatiquement :
```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm install && npm run build
```

### 6. Vérifications post-déploiement

- [ ] Tester la connexion à la base de données
- [ ] Vérifier que les migrations sont exécutées
- [ ] Tester l'intégration Stripe
- [ ] Vérifier les logs d'erreur
- [ ] Tester la création d'un compte utilisateur

## Développement local

```bash
# Cloner le projet
git clone <url-du-repo>
cd EterCloud

# Installer les dépendances
composer install
npm install

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Base de données locale (SQLite)
touch database/database.sqlite
php artisan migrate

# Lancer le serveur de développement
composer dev
```

## Stack technique

- Laravel 12
- Stripe PHP SDK
- Blade Heroicons
- Vite pour les assets
- Pest pour les tests

---

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

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
