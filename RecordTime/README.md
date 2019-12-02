# RecordTime

## LAMP Technology Stack
- PHP 7
- CodeIgniter 3.1.10
- MySQL Community Edition 8.0.15
- Apache HTTP server

If on a Mac, [this guide is OK.]]( https://coolestguidesontheplanet.com/install-apache-mysql-php-on-macos-mojave-10-14/)


### Apache Web Server
- `/etc/apache2/httpd.conf` is config file for httpd daemon. It is made up of configuration directives. http://httpd.apache.org/docs/2.4/mod/directives.html
- make sure the PHP module is enabled
- Important Directives: `DocumentName`

#### Handy commands:
* apachectl start
* apachectl stop
* apachectl restart
* apachectl configtest
* httpd -v

### MySQL Community Server 8.0.15

- When installing, use legacy password system (not SHA2)
- To log in: `mysql -u USER -p`
- `CREATE DATABASE recordtime;`
- `mysql -u USER -p recordtime < dump.sql`
- PHPMyAdmin recommended
