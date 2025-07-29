# Noveden E-commerce 

Bienvenue dans le projet de plateforme e-commerce Noveden, une boutique en ligne dédiée aux produits cosmétiques. Ce fichier README présente les principales fonctionnalités, la structure du projet et les instructions de base pour démarrer.
**Stack utilisée : Laravel 12**

## Présentation du projet

La plateforme Noveden permet la vente en ligne de cosmétiques, la gestion de contenus éditoriaux (blog), le suivi des commandes et la communication automatisée avec les clients.
Elle est pensée pour être simple à utiliser, responsive, et administrable sans compétences techniques avancées.

## Fonctionnalités principales

### Pages publiques (clients)

- **Page d’accueil**
  Présentation rapide de la marque, mise en avant de produits populaires, accès à la boutique et inscription à la newsletter.
- **À propos**
  Histoire de la marque, engagements (bio, naturel, éthique, etc.).
- **Boutique**
  Catalogue de produits avec images, prix, filtres par catégorie/type de peau.
  Fiche produit détaillée (description, composition, conseils d’utilisation).
- **Blog**
  Articles beauté, routines, nouveautés. Lecture complète sur pages dédiées.
- **FAQ**
  Réponses aux questions fréquentes (commande, livraison, remboursement, etc.).
- **Contact**
  Formulaire simple (nom, email, sujet, message), coordonnées et réseaux sociaux.
- **Suivi de commande**
  Consultation du statut de commande via numéro (commande reçue, en préparation, expédiée, livrée).
- **Panier \& commande**
  Ajout au panier, passage de commande sans création de compte, paiement sécurisé (Stripe), email de confirmation automatique.


### Backoffice (administration privée)

Accès protégé par mot de passe.

- **Tableau de bord**
  Vue synthétique des ventes récentes et commandes en attente.
- **Gestion des produits**
  Ajout, modification, suppression de produits, gestion des photos, prix, promotions.
- **Gestion du blog**
  Création, publication, modification des articles.
- **Gestion des commandes**
  Suivi et mise à jour du statut des commandes (4 étapes), envoi automatique d’emails aux clients à chaque changement.
- **Newsletter**
  Liste des abonnés, envoi de messages à tous les inscrits en un clic.


## Stack technique

- **Framework** : Laravel 12 (PHP)
- **Base de données** : MySQL/MariaDB (recommandé)
- **Paiement** : Stripe (intégration carte bancaire)
- **Front-end** : Blade (Laravel), responsive design (Bootstrap/Tailwind recommandé)
- **Email** : Notifications automatiques via le système de mail Laravel


## Installation \& démarrage

1. **Cloner le projet**

```bash
git clone <repository-url>
cd noveden-ecommerce
```

2. **Installer les dépendances**

```bash
composer install
npm install && npm run dev
```

3. **Configurer l’environnement**
    - Copier `.env.example` en `.env`
    - Renseigner les accès base de données, Stripe, mail, etc.
4. **Générer la clé d’application**

```bash
php artisan key:generate
```

5. **Lancer les migrations**

```bash
php artisan migrate
```

6. **Démarrer le serveur**

```bash
php artisan serve
```


## Informations complémentaires

- **Responsive** : le site s’adapte à tous les écrans (mobile, tablette, desktop).
- **Interface intuitive** : navigation et gestion simplifiées, accessibles à tous.
- **Automatisation** : suivi des commandes et notifications clients par email automatisés.


## Objectif

Permettre à la cliente de :

- Gérer facilement les produits, articles et abonnés.
- Vendre en ligne sans gestion technique complexe.
- Maintenir une relation client efficace grâce aux emails automatiques et à la newsletter.

Pour toute question technique ou besoin d’assistance, contactez l’équipe produit ou le support technique du projet.

