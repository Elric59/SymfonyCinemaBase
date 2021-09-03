# SymfonyCinemaBase

Projet développé en PHP 8 et Symfony 5 

Le but étant de pouvoir faire un site pouvant enregistrer des films et série.

Les Utilisateurs peuvent : 
    Sauvegarder des Film ou série dans leur profil
    écrire un commentaire et le modifier/supprimer par la suite
 
Les Admins peuvent :   
    Faire comme les Utilisateurs
    Créer une série, avec une saison et des épisodes
    Créer un film

===========================================================================================================

Pour installer le projet : 

Base de donnée : 
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load -n

Npm install
composer install
Yarn install

===========================================================================================================

![](D:\wamp64\www\SymfonyCinemaBase\public\images\users\popcorn.png)