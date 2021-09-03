# SymfonyCinemaBase

Projet développé en PHP 8 et Symfony 5 

Le but étant de pouvoir faire un site pouvant enregistrer des films et série.

Les Utilisateurs peuvent : <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Sauvegarder des Film ou série dans leur profil <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- écrire un commentaire et le modifier/supprimer par la suite
 
Les Admins peuvent :  <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Faire comme les Utilisateurs <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Créer une série, avec une saison et des épisodes <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Créer un film

---

Pour installer le projet : 

Base de donnée :<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- php bin/console doctrine:schema:update --force <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- php bin/console doctrine:fixtures:load -n <br>

Npm install <br>
Composer install <br>
Yarn install <br>

---

![](public\images\users\popcorn.png)