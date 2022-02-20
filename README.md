# Projet 5 - Créez votre premier blog en PHP

# Informations [![Maintainability](https://api.codeclimate.com/v1/badges/c15c942a46c3ab2cf486/maintainability)](https://codeclimate.com/github/leomoille/leomoilledotcom/maintainability)

Projet réalisé dans le cadre de mon alternance à OpenClassrooms.
____

# Installation

Une fois le projet récupéré, il suffit de saisir la commande `composer install` pour récuperer les dépendances du
projet.  
Le code PHP est écrit dans le respect des règles [__PSR12__](https://www.php-fig.org/psr/psr-12/).

## Serveur Web local

Sous **Windows** : [WAMP](https://www.wampserver.com/), [Laragon](https://laragon.org/)
, [XAMPP](https://www.apachefriends.org/fr/index.html), [MAMP](https://www.mamp.info/en/downloads/)  
Sous **GNU/Linu**x : [LAMP(P) sur Ubuntu](https://doc.ubuntu-fr.org/lamp)
, [XAMPP](https://www.apachefriends.org/fr/index.html)  
Sous **macOS** : [MAMP](https://www.mamp.info/en/downloads/), [XAMPP](https://www.apachefriends.org/fr/index.html)

_Vous devrez configurer vous même l'application si vous souhaitez utiliser le serveur interne de PHP._

## Dépendances

Ce projet comporte 6 dépences.

- **twig/twig** : Utilisé pour rendre les différentes vues.
- **twig/intl-extra** : Utilisé pour formater les dates en français proprement.
- **erusev/parsedown** et **erusev/parsedown-extra** : Utilisés pour convertir des chaines de caractères utilisant la
  syntaxe Markdown en HTML et inversement.
- **ext-pdo** : Utilisé pour tout ce qui à attrait à la comunication avec la base de donnée.
- **squizlabs/php_codesniffer** : Utilisé pour s'assurer que les règles du PSR-12 sont respectés.

## Verison de PHP :

**Version minimum :** 7.0  
**Testé jusqu'à la version** : 7.4

## Configuration d'Apache

Le fichier `index.php`se trouve dans le dossier `public/` ce qui oblige la modification du fichier de configuration
Apache.

```apacheconf
define ROOT "/chemin/vers/le/dossier/public"
define SITE "mon-site.fr"

# Le reste de la configuration de base
# ...
``` 

_auto.mon-site.fr.conf_

## Configuration de la base de données

1. Importez la base de données MySQL se trouvant à la racine du projet (`leomoilledotcom.sql.zip`) via un terminal ou depuis PHPMyAdmin.
2. Connectez le projet à la base données à l'aide des 5 constantes disponibles
   dans `/Core/Database.php` ([Voir le fichier](https://github.com/leomoille/leomoilledotcom/blob/e16671644c92f8bf304a8c06e16be9f32de59132/Core/Database.php#L13))
```php
    class Database extends PDO
    {
        // Connexion informations
        private const DB_HOST = '';
        private const DB_USER = '';
        private const DB_PW = '';
        private const DB_NAME = 'leomoilledotcom';
    
        // ...
    }
```
____
**that's all folks!**
____
# Liens utiles

- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [PSR12](https://www.php-fig.org/psr/psr-12/)
- [Twig](https://twig.symfony.com/)
- [squizlabs/php_codesniffer](https://packagist.org/packages/squizlabs/php_codesniffer)
- [CodeClimate Project Overview](https://codeclimate.com/github/leomoille/leomoilledotcom)
