jCatalogue
==========

A Symfony project created on May 10, 2017, 4:02 pm.


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

The commands are valid for a Linux System: for other OS check and run the right commands.


### Prerequisites

* It's required MySql Server: install it if you don't have it.

* Install the Symfony framework by following these instructions:

```
 sudo mkdir -p /usr/local/bin
 sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
 sudo chmod a+x /usr/local/bin/symfony
```

* You need to create your Symfony folder.

*Before to do it, open a terminal/shell and enter in your favourite system folder (in our case we decide to stay in the home folder):*

```
mkdir Symfony
```

* Install and enable Assetic (*you need composer installed*):
```
composer require symfony/assetic-bundle
```

* Install PHP XML Extension (*in case you don't have it already installed*)
```
sudo apt-get install php-xml
```

* Install the php7.0-mysql package (*in case you don't have it already installed*)
```
sudo apt-get install php7.0-mysql
```

### Installing
Instructions in order to install the application in local in a right way.

* Install the existing Symfony project (inside your Symfony folder):
```
git clone https://github.com/mark0s81/jCatalogue.git
```

* Configure MySql setting 
    * duplicate the file /jCatalogue/app/config/parameters.yml.dist and rename it in parameters.yml
    * set database_host: 127.0.0.1
    * set database_port: null
    * set database_name: jCatalogue
    * set database_user: root (or something else if you want another user)
    * set database_password (you need to insert your own password) - between ''

* Enter in the project folder "/jCatalogue"

* Run this command in order to install the dependencies:
```
composer install
```

* Create the database and its scheme by running these commands:
```
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
```


## Running the Application

* Always inside "/jCatalogue" run this command in order to start the web server:
```
php bin/console server:run
```

* Digit in your browser this url "http://localhost:8000/" and start to use jCatalogue.


## Built With

* [Symfony 3.2](https://symfony.com/): the web framework used
* [Doctrine 2](http://www.doctrine-project.org/): several PHP libraries primarily focused on database storage and object mapping
* [Twig](https://twig.sensiolabs.org/): the template engine
* [Bootstrap 3.3.7](http://getbootstrap.com/): he most popular HTML, CSS, and JS framework for developing responsive, mobile first projects on the web.
* [dataTables](https://datatables.net/): it's a plug-in for the jQuery Javascript library. It is a highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table.
* [jQuery](https://jquery.com/)



## Authors

* Marco Carpene - *jTeam*