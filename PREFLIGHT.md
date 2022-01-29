PREFLIGHT 
=========

Initialisation de la base de données
------------------------------------

### Création de la base

```sql 
create database blackcubetemplate CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Affectation des droits

```sql 
grant all on blackcubetemplate.* to blackcubetemplate@localhost identified by 'pavbv3m5khngbyci4j';
```

Paramétrage des variables d'environnement
-----------------------------------------

 * Définition du mode de fonctionnement
   * `YII_ENV` : peut être `dev` ou `prod`
 * Activation du mode de debug
   * `YII_DEBUG` : peut être `1` ou `0`
 * Activation du mode de maintenance
    * `YII_MAINTENANCE` : peut être `1` ou `0`
    * `YII_MAINTENANCE_ALLOWED_IPS` : liste des adresses IPv4 non affectées par le mode maintenance
 * Clef de validation des cookies
    * `YII_COOKIE_VALIDATION_KEY` : chaine aléatoire de 32 caractères
 * Gestion de la version de l'application
    * `APP_VERSION` : version au format semver 
 * Accès à la base de données
    * `DB_DRIVER` : driver de la base de données peut être `mysql` ou `pgsql`
    * `DB_DATABASE` : nom de la base de données
    * `DB_USER` : utilisateur ayant accès à la base
    * `DB_PORT` : port pour accéder à la base (3306 pour mysql)
    * `DB_HOST` : serveur de base de données (localhost)
    * `DB_PASSWORD` : mot de passe pour accéder à la base de données
    * `DB_TABLE_PREFIX` : préfixe à ajouter aux noms des tables dans le cas ou la base est mutualisée
    * `DB_SCHEMA` : schémas de la base à utiliser (public pour mysql)
    * `DB_SCHEMA_CACHE` : activation du cache de schémas (à n'activer qu'en production)
    * `DB_SCHEMA_CACHE_DURATION` : durée de validité du cache de schémas en secondes
 * Accès à la base Redis
    * `REDIS_ENABLED` : activation de redis peut être `1` ou `0`
    * `REDIS_HOST` : serveur redis (localhost)
    * `REDIS_PORT` : port pour accéder à la base (6379)
    * `REDIS_PASSWORD` : mot de passe pour accéder à redis
    * `REDIS_DATABASE` : numéro de la base de données rédis à utiliser (0)
 * Accès au filesystem
    * `FILESYSTEM_TYPE` : activation du filesystem peut être `local` ou `s3`
    * `FILESYSTEM_CACHE` : activation du cache peut être `1` ou `0`
    * `FILESYSTEM_CACHE_DURATION` : durée du cache en secondes (par exemple: `3600`)
    * Configuration en mode `local`
       * `FILESYSTEM_LOCAL_PATH` : par exemple `@data/files` 
    * Configuration en mode `s3`
       * `FILESYSTEM_S3_KEY` : clef S3
       * `FILESYSTEM_S3_SECRET` : secret S3
       * `FILESYSTEM_S3_BUCKET` : bucket s3 
       * `FILESYSTEM_S3_ENDPOINT` : endpoint S3
       * `FILESYSTEM_S3_PATH_STYLE` : path style `0` pour amazon S3 ou `1` pour minio
       * `FILESYSTEM_S3_REGION` : par exemple `us-east-1`
       * `FILESYSTEM_S3_VERSION` : `latest`
 * Activation du syslog
    * `SYSLOG_ENABLED` : activation du syslog peut être `0` ou `1`
    * `SYSLOG_IDENTITY` : identité du syslog `identity` (chaîne de caractères qui sera ajoutée aux logs en fonction de l'OS)

Installation des dépendances
----------------------------

```shell
# execution en mode "production"
composer install --no-dev
```

Initialisation de l'application
-------------------------------


### Préparation des données

```shell
php yii.php migrate
php yii.php bcore:init
php yii.php badmin:rbac
```

### Création de l'administrateur

```shell
php yii.php badmin:admin/create
```
