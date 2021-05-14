# Symbnb

Ce projet est une installation docker compose d'un projet Symfony (Formation sur les fondamentaux) pour un site utilisant Nginx comme serveur web, MariaDB comme base de données et Adminer.

**Qu'est ce que Symbnb ?**

Symbnb est site reprenant les principales fonctionnalités de Airbnb.\
Les fonctionnalités présentes dans le projet sont donc les suivantes :
- S'inscrire, s'authentifier et gérer son compte
- Créer des annonces afin de mettre en location un appartement ou une maison
- Réserver un appartement ou une maison
- Commenter et noter l'annonce après une location

## Table des matières
- [Lancer le projet](#running) - Lancer le projet en local
- [Lonfiguration et logs](#opt-config) - Les configuration (`docker-compose.yml, Dockerfile`) et logs des containers


## <a name="running"></a>Lancer le projet

**NOTE** : Supposons que tu es à la racine du projet. (`PWD == ./symbnb`)

Il faut lancer le projet et y accéder. Pour cela tape juste la commande ci-dessous dans ton terminal.
```
$ docker-compose up -d --build
```

**INFO** : Ajoute le `--build` uniqument si c'est la première fois que tu lance le projet ou si tu as fait des changement dans le fichier `Dockerfile`.\
L'argument `--build` t'évite de taper deux commande à asuite, comme ceci : `docker-compose build` puis `docker-compose up -d`.

Après quelques instants, tu devrais voir le site en cours d'exécution à [http://localhost:8050/](http://localhost:8050/).

### <a name="connect"></a>Installer le projet
Une fois que les containers sont lancés, il faut que tu installes le projet.\
Suit les étapes suivantes pour intaller le projet.
- Accéder au container php : `$ docker-compose exec php bash`
- Installer les dépendances php : `$ composer install`
- Installer les dépendances js et css : `$ yarn install` puis `$ yarn encore dev`
- Faire les migrations dans des entités : `$ bin/console doctrine:schema:update --force`
- Jouer les fixtures pour les fausses données : `$ bin/console doctrine:fixtures:load -n`

### <a name="connect"></a>Accès Admin
Le projet contient également un espace d'administration.\
Tu peux y accéder avec cette URL : [http://localhost:8050/admin](http://localhost:8050/admin)

Un fake user est disponible pour se connecter entant que user du front et du back :\
User : `admin@symbnb.com`\
Password : `password`


## <a name="setup"></a>Le configuration

### <a name="dotenv"></a>.env

Un fichier `.env` a été inclus pour définir plus facilement les variables de docker-compose sans avoir à modifier le fichier `docker-compose.yml` lui-même.

Si jamais tu veux modifier les valeurs du fichier .env pour faire des tests, duplique le fichier et renomme-le, comme : `.env.test` ou `.env.local`

Le fichier `.env` se trouve à la racine du projet (`PWD == ./symbnb`).

```env
# PHP/nginx
SERVER_NAME=localhost
TIMEZONE=Europe/Paris
MAX_EXECUTION_TIME=60

# MySQL
MYSQL_ROOT_PASSWORD=dbrootpw
MYSQL_DATABASE=symbnb
MYSQL_USER=symbnb
MYSQL_PASSWORD=symbnbpw
MYSQL_HOST=database

## /DOCKER
```

Aussi, un deuxième fichier .env existe dans le dossier `PWD == ./symbnb/app/` de projet, celui est contient principalement les variables liées à Symfony.  

### La structure du projet

Dans le projet tu retrouveras les repertoires ci-dessous, ils constituent le projet lui-même.

- **app**: Les fichiers et répertoires liés à Symfony
- **docker**: Les répertoires des images et logs docker
    - **docker/admin**: Le fichier Dockerfile de Adminer
    - **docker/logs/nginx**: Les fichiers journaux de Nginx (error.log, access.log)
    - **docker/nginx**: Les fichiers de configuration de NGINX et Dockerfile
    - **docker/php-fpm**: Le fichier Dockerfile de PHP-FPM
## <a name="opt-config"></a>Configuration optionnelle

### Environment Variables

Les principales variables d'environnement.
- `SERVER_NAME`: Nom du serveur (`localhost`)
- `TIMEZONE`: Heure exacte de notre fuseau horaire (`Europe/Paris`)
- `MAX_EXECUTION_TIME`: Temps maximum d'exécution des scripts
- `MYSQL_ROOT_PASSWORD `: Mot de passe de la base de données. Par défaut 'root' est le user.
- `MYSQL_DATABASE `: Nom de la base de données utilisé.
- `MYSQL_USER `: Nom de l'utilisateur.
- `MYSQL_PASSWORD`: Mot de passe de la base de données.
- `MYSQL_HOST`: Le host pour se connecter à la base de données (`database`).

```yaml
#docker-compose.yml

environment:
  - MYSQL_ROOT_PASSWORD=dbrootpw
  - MYSQL_DATABASE=symbnb
  - MYSQL_USER=symbnb
  - MYSQL_PASSWORD=symbnbpw
```

### Logs des containers
Tu peux avoir besoin d'afficher les logs des différents containers. Pour cela, utilise les commandes suivantes :

**Pour afficher les logs depuis la création des tous les containers :**
```yaml
$ docker-compose logs -f
$ docker-compose logs -f nginx # Uniquement les logs du container nginx
```
**Pour afficher les logs créés à l'instant**
```yaml
$ docker-compose logs -f --tail=0
$ docker-compose logs -f --tail=0 nginx # Uniquement les logs du container nginx
```
Le `-f` permet d'afficher les logs en temps réel.

Et bien, voilà, tu peux t'amuser sur le projet avec toutes ces informations.
