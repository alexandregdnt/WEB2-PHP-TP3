# DEMOW2
Un blog en php réalisé dans le cadre de la formation de développeur web d'HETIC. 

## Démonstation
2 comptes utilisateur sont déjà créés :
- test_admin (mdp: Bonjour123?)
- test_user (mdp: Bonjour123?)

## Prérequis
- Docker
- npm ou yarn
- node v14 de préférence
- sass
- parcel

## Configuration
Fichiers de configuration :
- `./src/config.json` : configuration de la base de données
- `./docker-compose`, `./Dockerfile` : configuration du projet docker
-`./package.json`

## Commandes
Voici la commande à exécuter pour installer et exécuter le projet : `docker compose up -d --build`.

## Configurer l'environnement de travail

````
npm init
``
- installer sass et lancer sass
```
npm install sass --save-dev
npm run sass-dev
```
- installer une webAp avec parcel en suivant ceci => https://parceljs.org/getting-started/webapp/

- lancer le server local
```
npx parcel 
```
ou
```
yarn start
```

- pour build le projet 
```
npx parcel build 
````
ou
```
yarn build
```

Pour arrêter le projet, écrivez `docker compose down`.
