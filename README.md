# Joy_Penard_filrougeLivres

Création de site web, fil rouge 4.0.1
Bibliothèque – personnelle, site web

Introduction:

Ce projet contien un site web avec plusieurs pages qui montrent une bibliothèque personnelle avec des livres, des auteurs, une page pour montrer les livres préférés et une page pour documenter les emprunts des livres par des amis.

-Pour télécharger le projet:

Pour télécharger le projet entier, visite: https://git.uha4point0.fr/UHA40/fils-rouges-2022/joy_penard_filrougelivres

Sur cette page, tu peux choisir:
- clone le projet sur ton ordinateur = clique sur le bouton bleu à droite de la page, on voit l'opton Clone avec SSH ou Clone avec HTTP. Clique sur l'image du presse-papier pour copier le lien.
- télécharger le projet sous forme de dossier zip - le bouton avec la fléche à coté du bouton bleu.

Choix: Clone le projet (télécharger zip instructions après)
- Pour suivre la méthode 'clone', on a besoin de Git - pour installer Git, visite: https://git-scm.com/
- Sur ton ordinateur, navigue vers le dossier où on veut installer le projet.
Par exemple, dans Documents, crée un nouveau dossier "Bibliothèque" - et ouvre le dossier.
Dans ce nouveau dossier vide, un clique droit donne l'option: ouvre dans la terminale.
Cette action ouvre la terminale lié avec le dossier crée. 
Entre: git clone ssh://git@git.uha4point0.fr:22222/UHA40/fils-rouges-2022/joy_penard_filrougelivres.git
Cette action copie le contenus du projet dans le dossier "Bibliothèque".
Après - suivre Installation (après Télécharger zip).


Choix: Télécharger zip
- Clique le bouton avec la flèche - on voit les options de téléchargement: zip, tar.gz, tar.bz2 & tar
Clique sur zip - cette action télécharge le contenu du projet et on voit le progrès du téléchargement en bas de la page. Quand c'est terminé, clique sur ce dossier zip: joy_penard_filrougelivres-main.zip et on a tous le contenus du projet.

Base de données:
Ce projet de bibliothèque utilise une base de données pour stocker les livres, les auteurs et les emprunts des livres. Pour créer une base de données, on recommande le package Xampp, une suite d'applications:  MariaDB, PHP, et Perl. Ces applications offrent la possibilité de stocker les données et d'y accèder depuis le client, en passant par le serveur.
Pour télécharger Xampp, visite: https://www.apachefriends.org/


- Installation:
- Ouvre index.php.
C'est la page d'accueil. En bas de cette page, clique sur la petite image de la bibliothèque: cette image lance la création de la base de données pour la bibliothèque.

Contenus:
-index.php : La page d'acceuil du site, avec les liens de navigation vers les autres pages etn le bouton de la base de données pour la créer. La base de données contient les tables avec les livres, les auteurs, les genres, et les emprunts.

- livres.php : La page montre tous les livres dans la bibliothèque, dans l'ordre alphabétique.

- auteurs.php : La page montre tous les auteurs de la bibliothèque, ainsi que les livres de chaque auteur.

- ratingsPage.php : La page permet un visiteur à cliquer "like" pour indiquer ses livres préférés.

- emprunteLivre.php : La page montre les livres empruntés par des amis et permet d'ajouter, modifier et supprimer les emprunts.

- emprunteLivre.php : this page shows friends who have borrowed books – & the titles. It also allows the addition, modification or deletion of the borrowed books.

- admin.php : La page permet ajouter, modifier ou supprimer des livres dans la bibliothèque.


Pages pour les genres :
Sur la page livres.php, le menu déroulant permet de voir des livres par leur genre:
- drame.php
- fiction.php
- poesie.php
- policier.php
- theatre.php

Pages style & js :
style.css & livres.css : ces fichiers donnent le style avec les couleurs et cadres pour le contenu et les liens du site web.

bibscript.js, livres.js, ratingsPage.js : ces fichiers donnent les instructions pour le menu déroulant pour les genres, les livres pour chaque auteur, et pour compter les "likes" pour chaque livre.

Dossier databases :
Ce dossier contient les fichiers qui permettent la création et le branchement de la base de données dans MySQL:
createDatabase.php : crée la base de données; les tables et le lien aux APIs livres & auteurs.

connectDatabase & database.php : utilisent PDO pour établir le branchement à la base de données et créer la base de données, avec les données des deux APIs.

Database.php : Ce fichier permet le branchement à la base de données.

livres.sql : si besoin, ce fichier permet de créer la base de données avec les données dans les deux APIs; il contient tous les données pour le site web ainsi que les instructions pour construire les tables.

Dossier includes :
head.php & nav.php : ensemble, ces fichiers créent la navigation et les instructions pour le site web, référencent style.css.

Dossier images :
Ce dossier contient l'image de la bibliothèque pour la page d'accueil ainsi que l'image de l'autre bibliothèque qui apparait sur les autres pages. Il contient aussi les photos des auteurs, dans le cas où ces images ne sont plus disponibles.

Dossier API :
Ce dossier contient tous les fichiers necessaires pour la page d'administration et la page emprunt - pour ajouter, modifier et supprimer les livres et les emprunts.





Web page creation, fil rouge 4.0.1
Library – personal, website

This project contains a website of several pages that showcases a personal library with books, authors, a page for rating favorite books and a page to keep track of friends borrowing books.

Contents:
main folder:
- index.php : this is the homepage of the site, with navigation links to the other pages, and the database button to create a database that contains the books, authors, genres and borrowed books tables.

- livres.php : this is the page that displays all the books in the library, alphabetical order.

- auteurs.php : this is the page that displays all the authors in the library, as well as the author’s books.

- ratingsPage.php : this page allows a visitor to click “like” on the page that indicates which books are favorites by the number of likes.

- emprunteLivre.php : this page shows friends who have borrowed books – & the titles. It also allows the addition, modification or deletion of the borrowed books.

- admin.php : this page allows changes to the database – addition, deletion, changes to livres.

Genres pages:
On the livres.php the Genre dropdown menu allows grouping books by the following genre pages:
- drame.php
- fiction.php
- poesie.php
- policier.php
- theatre.php


Style & JS pages :
style.css & livres.css : provide the style formatting, font style, color, background & frames, as well as for links throughout the website pages.

bibscript.js, livres.js, ratingsPage.js : provide instructions for the drop down menu for the genres, the books by author, and counting the likes for each book.


Databases folder:
This folder contains files that allow the creation and connection of the database in MySQL:
createDatabase.php : creates the database; tables and accesses the original livres & auteurs APIs.
connectDatabase & database.php :uses PDO to establish connection to the database & create database, populated with information from two APIs.
Database.php : file providing connection to database for API
livres.sql : in the even that the two JSON APIs livres & auteurs are not available, this file contains all the data to build a database with the necessary data.

Includes folder :
head.php & nav.php : together, these pages create the navigation banner & the formatting for the website – including referencing the style.css information

Images folder :
This folder contains the library image for the home page and the image for the secondary pages. It also contains the author photos, in case the source changes the access to those photos.


API folder :
This folder contains the files necessary for the administration and emprunt pages - to add, modify and delete books and borrowed books.


