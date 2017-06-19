# #Projet BI
##  #Installation du Projet BI
####
#### Installation des dépendances (Symfony 2.8)
>php composer.phar install
#### Création de BDD
>php app/console doctrine:database:create
#### Création du schéma de la BDD
>php app/console doctrine:schema:update --force --dump-sql
#### Création d'un utilisateur SUPERADMIN
>php app/console fos:user:create --super-admin
>chmod -R 777 app/cache app/logs
#### Démarrage de l'application
>php app/console server:run
#### URL: http://127.0.0.1:8001/