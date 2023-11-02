# R3.01_Projet - Réseau Social de Cybersécurité

## Équipe de développement
- Caron Pierrick
- Carvajal Tom
- Ferrier Killian
- Nardi Fabio
- Guil Vanessa

## Description du Projet
Le projet R3.01_Projet est un réseau social axé sur la cybersécurité, développé en PHP 8.1 avec une architecture MVC. 
Ce réseau social se concentre sur la sécurité en ligne en intégrant des fonctionnalités telles que :
- un onglet de veille informatique pour suivre les dernières actualités en termes de cybersécurité, d'hacking et d'informatique en général
- un onglet blog, pour publier vos meilleurs tutoriels afin de partager vos connaissances avec le reste de la communauté
- un onglet forum, pour poser vos questions et obtenir de l'aide dans les domaines du development, du hacking et de la défense

## Liens Importants
- [Notion - Organisation, Recherche, Conception](https://www.notion.so/R301-DEV-WEB-CR-ATION-D-UN-BLOG-3e0c15adb99845c3888fdd2f2bcb4bd5)
- [Site Web du Projet](http://cyphub.tech)
- [Repository](https://github.com/FERRIER-Killian-2225036a/R3.01_Projet)

## Caractéristiques
- Langage : PHP 8.1.2 / 8.2.0
- Architecture : Framework MVC
- Modules Externes : Aucun
- Utilisation des API :
    - [Have I Been Pwned](https://haveibeenpwned.com) pour la vérification des fuites de données des mots de passes.
    - [Google Cloud Vision](https://cloud.google.com/vision) pour l'analyse d'images posté par les utilisateurs.

## Hébergement
L'application est hébergée chez FastComet.

## Instructions pour Exécution en Local avec XAMPP

Si vous souhaitez exécuter le projet sur un serveur XAMPP, suivez ces étapes :

1. **Téléchargement et Installation de XAMPP :**
    - Téléchargez et installez XAMPP depuis [le site officiel de Apache Friends](https://www.apachefriends.org).

2. **Clonage du Dépôt du Projet :**
    - Clonez le dépôt du projet depuis le gestionnaire de contrôle de version ou téléchargez-le au format ZIP.

3. **Configuration de XAMPP :**
    - Démarrez XAMPP et assurez-vous que les services Apache et MySQL sont actifs.

4. **Base de Données :**
    - Importez le schéma de la base de données fourni dans la documentation Notion dans votre serveur MySQL.

5. **Configuration du Projet :**
    - Placez les fichiers du projet dans le répertoire `htdocs` de XAMPP (situé dans le dossier d'installation de XAMPP).

6. **Lancement du Serveur :**
    - Ouvrez votre navigateur web et accédez à l'URL : `http://localhost/nom-du-projet`.

7. **Accès à l'Application :**
    - Vous devriez maintenant pouvoir accéder à l'application à partir de votre navigateur en utilisant l'URL locale.

Assurez-vous d'adapter le chemin et le nom du répertoire du projet (`nom-du-projet`) en fonction de votre structure de dossiers dans XAMPP.

Cette méthode vous permettra de lancer le projet sur votre serveur XAMPP localement, prêt à être testé et exploré via votre navigateur web.
