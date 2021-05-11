**Introduction**

Ce projet fait suite à une formation sur les fondamentaux du framwork php Symfony

*Créer un site d'annonce avec interface d'administration pour apprendre tous les fondamentaux du Framework PHP Symfony 4.*

Ci-dessous les principales fonctionnalités :*

1. S'inscrire, s'authentifier et gestion de compte
2. Créer des annonces afin de mettre en location un bien
3. Réserver un bien
4. Commenter et noter l'annonce après que la location ait eu lieu

---

## Installation

Pour installer ce projet sur votre poste, il vous faut effectuer quelques manipulation avant ça. Notamment installer `docker` pour desktop disponilbe sur [le site officiel](https://docs.docker.com/) et `composer` que vous trouver [ici](https://getcomposer.org/). Si comme moi vous etes sur macOS vous pouvez utiliser [le macOS Setup Guide](https://sourabhbajaj.com/mac-setup/) pour installer les outils que je viens de citer.

1. Installer Docker for macOS que vous pouvez télécharger [ici](https://docs.docker.com/)
2. Installer Composer que vous pouvez télécharger [ici](https://getcomposer.org/)
3. Cloner le repository `$ git clone https://github.com/MohamedXi/symbnb.git`
4. Mettez-vous dans le dossier symbnb `$ cd symbnb`
5. Faites ensuite `$ docker-compose build` puis `$ docker-compose up -d` ou `docker-compose up -d --build`
6. Il faut a présent acceder le container php-fpm `$ docker-compose exec php-fpm bash`
7. Lancer la commande `$ composer install`
8. Ensuite, il faut lancer les migrations avec la commande suivante : `bin/console doctrine:migration:migrate -n` ou `bin/coonsole do:mi:mi -n`
9. Jouez maintenant les fictures pour avoir des fausses données dans la base de données : `bin/console do:fi:lo -n`
10. Une fois les dépendences installée faites rendez-vous sur `127.0.0.1:8000` avec un navigateur
