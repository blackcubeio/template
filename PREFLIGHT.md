PREFLIGHT 
=========

Initi database
--------------

### Create database

```sql 
create database blackcubetemplate CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Define database access

```sql 
grant all on blackcubetemplate.* to blackcubetemplate@localhost identified by 'pavbv3m5khngbyci4j';
```

Setup environment vars
----------------------

 * Runtime mode
   * `YII_ENV` : can be `dev` or `prod`
 * Activate debug mode
   * `YII_DEBUG` : can be`1` or `0`
 * Activate maintenance mode
    * `YII_MAINTENANCE` : can be `1` or `0`
    * `YII_MAINTENANCE_ALLOWED_IPS` : IPv4 adresses which can access the website even in maintenance mode
 * Cookies validation key
    * `YII_COOKIE_VALIDATION_KEY` : 32 chars random string
 * Define app version (mainly used with CI/CD)
    * `APP_VERSION` : semver 
 * Access to database
    * `DB_DRIVER` : driver can be `mysql` or `pgsql`
    * `DB_DATABASE` : database name
    * `DB_USER` : database user
    * `DB_PORT` : database port (`3306` for mysql)
    * `DB_HOST` : database host (`localhost`)
    * `DB_PASSWORD` : database password for defined user
    * `DB_TABLE_PREFIX` : table prefix
    * `DB_SCHEMA` : database schema (`public` for mysql)
    * `DB_SCHEMA_CACHE` : activate database schema cache
    * `DB_SCHEMA_CACHE_DURATION` : schema cache duration in seconds
 * Access to Redis
    * `REDIS_ENABLED` : activate redis can be `1` or `0`
    * `REDIS_HOST` : redis host (`localhost`)
    * `REDIS_PORT` : redis port (`6379`)
    * `REDIS_PASSWORD` : redis password (can be blank)
    * `REDIS_DATABASE` : redis database number
 * Access to filesystem
    * `FILESYSTEM_TYPE` : activate filesystem can be `local` or `s3`
    * `FILESYSTEM_CACHE` : activate cache can be `1` ou `0`
    * `FILESYSTEM_CACHE_DURATION` : cache duration in seconds
    * For `local`
       * `FILESYSTEM_LOCAL_PATH` : path alias `@data/files` 
    * For `s3`
       * `FILESYSTEM_S3_KEY` : key
       * `FILESYSTEM_S3_SECRET` : secret
       * `FILESYSTEM_S3_BUCKET` : bucket 
       * `FILESYSTEM_S3_ENDPOINT` : endpoint (https://xxx)
       * `FILESYSTEM_S3_PATH_STYLE` : path style `0` for amazon S3 or `1` for minio
       * `FILESYSTEM_S3_REGION` : `us-east-1`
       * `FILESYSTEM_S3_VERSION` : `latest`
 * Activate du syslog
    * `SYSLOG_ENABLED` : activate syslog can be `0` or `1`
    * `SYSLOG_IDENTITY` : syslog `identity`

Install dependencies
--------------------

```shell
# execute in "production" mode
composer install --no-dev
```

Init application
----------------


### Prepare data

```shell
php yii.php migrate
php yii.php bcore:init
php yii.php badmin:rbac
```

### Create admin

```shell
php yii.php badmin:admin/create
```
