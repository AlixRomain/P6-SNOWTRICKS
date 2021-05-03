#Snowtricks | Description du besoin


Project 6 of [PHP/Symfony](https://github.com/AlixRomain) course for [OpenClassrooms](https://openclassrooms.com/)

## Build with

- Symfony 5
- Bootstrap 4

## Installation

__1 - Git clone the project__

```
git clone https://github.com/AlixRomain/P6-SNOWTRICKS
``` 

__2 - Composer install__

Run this command, for download many library :

```
composer install
```

__3 - Create snowtricks DB and modify the .env file__

Go to [http://localhost:8080/](http://localhost:8080/)

```
User : root
Password: 
```
Create DB named snow-P6 and modify the .env file.

__4 - Initialiser la base de donnée__

2 méthodes :

Soit utiliser le fichier .sql dans le dossier public et l'importer dans votre SGBD
Soit utiliser les migrations de doctrine et les fixtures


```
php bin/console doctrine:migrations:migrate 
```

__5 - Fixtures Load__

Run this command, for insert many fixtures in your DB :

```
symfony console doctrine:fixtures:load
```
__6 - Setting your dataMail__

Modify with your datas the dataMailLocal.php


__7 - Server - start__

Run this command, for start your server :

```
symfony server:start
```

__8 - Go to [http://127.0.0.1:8000/snowtricks](http://localhost/), all is ready !__

## Usage



Admin account :

```
Pseudo : toto@toto.com
Password : OpenClass21!
```

##Context

###1- Vous êtes chargé de développer le site répondant aux besoins de Jimmy. Vous devez ainsi implémenter les fonctionnalités suivantes : 

un annuaire des figures de snowboard. Vous pouvez vous inspirer de la liste des figures sur Wikipédia. Contentez-vous d'intégrer 10 figures, le reste sera saisi par les internautes ;
la gestion des figures (création, modification, consultation) ;
un espace de discussion commun à toutes les figures.
Pour implémenter ces fonctionnalités, vous devez créer les pages suivantes :

la page d’accueil où figurera la liste des figures ; 
la page de création d'une nouvelle figure ;
la page de modification d'une figure ;
la page de présentation d’une figure (contenant l’espace de discussion commun autour d’une figure).
L’ensemble des spécifications détaillées pour les pages à développer est accessible ici : Spécifications détaillées.

Si vous souhaitez héberger le projet en ligne, notre partenaire 1&1 IONOS offre 2 mois d'hébergement gratuit aux étudiants pour toute souscription à un pack d'hébergement (plus d'infos).

##Nota bene
Il faut que les URL de page permettent une compréhension rapide de ce que la page représente et que le référencement naturel soit facilité.

L’utilisation de bundles tiers est interdite sauf pour les données initiales. Vous utiliserez les compétences acquises jusqu’ici ainsi que la documentation officielle afin de remplir les objectifs donnés.

Le design du site web est laissé complètement libre, attention cependant à respecter les wireframes fournis pour le gabarit de vos pages. Néanmoins, il faudra que le site soit consultable aussi bien sur un ordinateur que sur mobile (téléphone mobile, tablette, phablette…).

En premier lieu, il vous faudra écrire l’ensemble des issues/tickets afin de découper votre travail méthodiquement et de vous assurer que l’ensemble du besoin client soit bien compris avec votre mentor. Les tickets/issues seront écrits dans un repository GitHub que vous aurez créé au préalable.

L’ensemble des figures de snowboard doivent être présentes à l’initialisation de l’application web. Vous utiliserez un bundle externe pour charger ces données. 

 
##De l’aide pour aborder le projet étape par étape
Afin de fluidifier votre avancement voici une proposition de manière de travailler :

Étape 1 - Prenez connaissance entièrement de l’énoncé et des spécifications détaillées.

Étape 2 - Produisez les diagrammes UML (modèle de données, classes, séquences, uses cases).

Étape 3 - Créez le repository GitHub pour le projet.

Étape 4 - Créez l’ensemble des issues sur le repository GitHub (https://github.com/username/nom_du_repo/issues/new).

Étape 5 - Faites les estimations de l’ensemble de vos issues.

Étape 6 - Entamez le développement de l’application et proposez des pull requests pour chacune des fonctionnalités/issues.

Étape 7 - Faites relire votre code à votre mentor (code proposé dans la ou les pull requests), et une fois validée(s), mergez la ou les pull requests dans la branche principale. (Cette relecture servira à valider votre implémentation des bonnes pratiques et la cohérence de votre code. La validation se fera en continu durant les sessions.)

Étape 8 - Effectuez une démonstration de l’ensemble de l’application.

Étape 9 - Préparez l’ensemble de vos livrables et soumettez-les sur la plateforme.

Prenez le temps de valider chaque étape avec votre mentor afin de vous assurer que vous avancez dans la bonne direction. ^^

#Livrables
Un lien vers l’ensemble du projet (fichiers PHP/HTML/JS/CSS…) sur un repository GitHub

L’ensemble des diagrammes demandés (modèles de données, classes, use cases, séquentiels)

Les issues sur le repository GitHub

Les instructions pour installer le projet (dans un fichier README à la racine du projet)

Jeu de données initiales avec l’ensemble des figures de snowboard

Lien vers les analyses SensioLabsInsight, Codacy ou Codeclimate (via une médaille dans le README, par exemple).