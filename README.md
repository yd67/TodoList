
# Améliorez une application existante de ToDo & Co

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/fcc195ac51c04779a28659067a9c52e9)](https://www.codacy.com/gh/yd67/todoList/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=yd67/todoList&amp;utm_campaign=Badge_Grade)
![Logo](https://user.oc-static.com/upload/2016/11/18/14794830624591_shutterstock_318837722.jpg)


# Description du projet 

Projet n°8 de la formation [Développeur d'application - PHP / Symfony](https://openclassrooms.com/fr/paths/500-developpeur-dapplication-php-symfony#path-tabs).
# Contexte

**TodoList** est une application permettant de gérer ses tâches quotidiennes. L’entreprise vient tout 
juste d’être montée, et l’application a dû être développée à toute vitesse pour permettre de 
montrer à de potentiels investisseurs que le concept est viable (on parle de Minimum Viable Product 
ou MVP).Le choix du développeur précédent a été d’utiliser le framework PHP Symfony

Les objectifs sont :
- l’implémentation de nouvelles fonctionnalités 
- la correction de quelques anomalies
- et l’implémentation de tests automatisés
# Description du besoin 


## _Corrections d'anomalies_

**Une tâche doit être attachée à un utilisateur**

Actuellement, lorsqu’une tâche est créée, elle n’est pas rattachée à un utilisateur. Il vous est demandé d’apporter les corrections nécessaires afin qu’automatiquement, à la sauvegarde de la tâche, l’utilisateur authentifié soit rattaché à la tâche nouvellement créée.

**Lors de la modification de la tâche, l’auteur ne peut pas être modifié.**

Pour les tâches déjà créées, il faut qu’elles soient rattachées à un utilisateur “anonyme”.
Choisir un rôle pour un utilisateur

**Lors de la création d’un utilisateur, il doit être possible de choisir un rôle pour celui-ci**.

 Les rôles listés sont les suivants :

    rôle utilisateur (ROLE_USER) ;
    rôle administrateur (ROLE_ADMIN).

**Lors de la modification d’un utilisateur, il est également possible de changer le rôle d’un utilisateur.**

## _Implémentation de nouvelles fonctionnalités_

- Seuls les utilisateurs ayant le rôle administrateur (ROLE_ADMIN) doivent pouvoir accéder aux pages de gestion des utilisateurs.

- Les tâches ne peuvent être supprimées que par les utilisateurs ayant créé les tâches en question.

- Les tâches rattachées à l’utilisateur “anonyme” peuvent être supprimées uniquement par les utilisateurs ayant le rôle administrateur (ROLE_ADMIN).

## _Implémentation de tests automatisés_

- Implementation de tests **unitaires** et **fonctionnels** nécessaires pour assurer que le fonctionnement de l’application est bien en adéquation avec les demandes.

- Prévoir des données de tests afin de pouvoir prouver le fonctionnement dans les cas explicités dans ce document.

- Fournir un rapport de couverture de code au terme du projet. Il faut que le taux de couverture soit supérieur à 70 %.


## _Documentation technique_

- Produire une documentation expliquant comment **l’implémentation de l'authentification** a été faite.


- Produire un document expliquant comment devront procéder tous les développeurs souhaitant **apporter des modifications au projet**.


- production d'un **audit de code** sur les deux axes suivants : **la qualité de code et la performance.**


# Installation du projet

 ### Prérequis
  - PHP 7.2.5
  - [composer](https://getcomposer.org)
  - [Symfony CLI](https://symfony.com/download)


  **Etape 1 : Cloner le Repository sur votre serveur.**
  ```
    https://github.com/yd67/todoList.git
  ```

  **Etape 2 : Installer les dépendances .**

  ```http 
  composer install
  ```
  **Etape 3 : Création de la base de données.**
  
  Dans le fichier .env (racine) changer le " DATABASE_URL " , et lancer la 
  commande suivante afin de créer votre base de données.

  ```http 
  php bin/console doctrine:database:create
  ```
  Effectué la migration de la base avec la commande :

  ```http 
  php bin/console make:migration
  ```

  suivie de la commande :

  ```http 
   php bin/console doctrine:migrations:migrate
  ```


  **Etape 4 : Remplir la bdd de données d'exemple** 
 
 lancer la commande :
  ```http 
  php bin/console doctrine:fixtures:load
  ```

  l'ensemble des Utilisateurs crée ont pour mot de passe "test"
  

 😄 c'est terminé. 

 
 