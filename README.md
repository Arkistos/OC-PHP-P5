# Bienvenue sur mon blog en PHP

Ce projet est un blog développé en PHP dans le cadre du cours "Développez votre premier site web avec PHP" d'OpenClassrooms.

## Installation

1. Clonez ce repository en utilisant la commande suivante :

   ```
   git clone https://github.com/Arkistos/OC-PHP-P5.git
   ```

2. Accédez au répertoire du projet :

   ```
   cd OC-PHP-P5
   ```

3. Importez la base de données fournie dans le fichier `database.sql` dans votre système de gestion de base de données (par exemple, MySQL).

4. Configurez les informations de connexion à la base de données dans le fichier `config.php` :

   ```php
   <?php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'nom_de_la_base_de_donnees');
   define('DB_USER', 'utilisateur');
   define('DB_PASSWORD', 'mot_de_passe');
   ```

5. Lancez un serveur local (par exemple, en utilisant [XAMPP](https://www.apachefriends.org/index.html) ou [WampServer](https://www.wampserver.com/)) et placez les fichiers du projet dans le répertoire approprié.

## Utilisation

1. Accédez à votre site en ouvrant votre navigateur et en accédant à l'URL `http://localhost/OC-PHP-P5`.

2. Vous pouvez naviguer sur le site, lire les articles, poster des commentaires et gérer les articles en tant qu'administrateur.

## Fonctionnalités

- Affichage des articles
- Affichage des commentaires associés à chaque article
- Ajout de nouveaux articles
- Modification et suppression des articles existants (accès réservé aux administrateurs)
- Ajout de commentaires sur les articles
- Gestion des utilisateurs (administrateur ou utilisateur normal)

## Contributions

Les contributions sont les bienvenues ! Si vous souhaitez améliorer ce projet, n'hésitez pas à soumettre une demande de pull.

## Auteurs

Ce projet a été développé par Pierre Lacaud.

## Licence

Ce projet est distribué sous la licence [MIT](LICENSE).

N'hésitez pas à personnaliser ce README en fonction des spécificités de votre projet et à ajouter toute autre information pertinente. Bonne continuation avec votre blog en PHP !
