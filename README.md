**Introduction**

Ce projet fait suite à une formation sur les fondamentaux du framwork php Symfony

*Créer un site d'annonce avec interface d'administration pour apprendre tous les fondamentaux du Framework PHP Symfony 4. On n'apprend jamais mieux que par la pratique. Cette formation destinée à tous le monde et qui est disponible sur Udemy  traite le Framework Symfony 4 sur les fontionnalités suivante :*

1. S'inscrire, s'authentifier et gérer leur compte
2. Créer des annonces afin de mettre en location leur bien
3. Réserver une location
4. Commenter et noter l'annonce après que la location ait eu lieu

---

## Installation

Pour installer ce projet sur votre poste, il vous faut effectuer quelques manipulation avant ça. Notamment installer `docker` for desktop disponilbe sur [le site officiel](https://docs.docker.com/) et `commposer` que vous trouver [ici](https://getcomposer.org/). Si comme moi vous etes sur macOS vous pouvez utiliser [le macOS Setup Guide](https://sourabhbajaj.com/mac-setup/)

1. Installer Docker for macOS que vous pouvez télécharger [ici](https://docs.docker.com/)
2. Installer Composer que vous pouvez télécharger [ici](https://getcomposer.org/)
3. Cloner le repository `$ git clone https://github.com/MohamedXi/symbnb.git`
4. Mettez-vous dans le dossier symbnb `$ cd symbnb`
5. Faites ensuite `$ docker-compose build` puis `$ docker-compose up -d`
6. Il faut a présent acceder le container php-fpm `$ docker-compose exec php-fpm bash`
7. Lancer la commande `$ composer install`
8. Une fois les dépendences installée faites rendez-vous sur `127.0.0.1:8000` avec un navigateur

---

## Docker est trop lent ?

Il peut arriver que votre environennemt de développement soit trop lent. Si jamais c'est le cas voici comment résoudre le problème.

1. Installer VirtualBox que vous pouvez télécharger [ici](https://www.virtualbox.org/wiki/Downloads)
1. Créer ensuite une nouvelle machine docker `$ docker-machine create -d virtualbox name_of_machine`
1. Vérifier les variables d'envirronement `$ docker-machine env name_of_machine`
1. Ajouter les variables d'envirronement dans docker `$ eval $(docker-machine env name_of_machine)`
1. Il faut ensuite installer docker-machine-nfs afin de configurer nos sous-répertoire du projet avec le filesystem NFS. Mes projets sont dans /Users/[username]/another_folder, donc je monte tout le répertoire /Users en NFS `$ brew install docker-machine-nfs)` puis `$ docker-machine-nfs name_of_machine --shared-folder=/Users)`
1. Afficher la nouvelle adresse `ip` de la nouvelle machine docker `$ docker-compose up -d` puis `$ docker-machine ip name_of_machine`

Voila vous devriez avoir un environnement plus rapide ?
