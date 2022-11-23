# DEMOW2
Un blog en php réalisé dans le cadre de la formation de développeur web d'HETIC. 

## Démonstation
2 comptes utilisateur sont déjà créés :
- test_admin (mdp: Bonjour123?)
- test_user (mdp: Bonjour123?)

## Prérequis
- Docker
- Yarn Parcel

## Configuration
Fichiers de configuration :
- `./src/config.json` : configuration de la base de données
- `./docker-compose`, `./Dockerfile` : configuration du projet docker

## Commandes
Voici la commande à exécuter pour installer et exécuter le projet : `docker compose up -d --build`.
Pour le SASS on utilise Parcel : `yarn build` to build your project for production and `yarn start` to start the development server.

Pour arrêter le projet, écrivez `docker compose down`.
