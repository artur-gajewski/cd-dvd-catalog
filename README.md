# CD/DVD Catalog

Application created with Zend Framework and utilizing Doctrine 2 ORM

See [https://github.com/artur-gajewski/cd-dvd-catalog](https://github.com/artur-gajewski/cd-dvd-catalog)

This package provided to you by Artur Gajewski

Thanks to Rob Allen for great ZF2 tutorial which this application is based on and Jason Grimes for his instructions on applying Doctrine 2 to Rob's tutorial.

## Dependancy installation

Installation of the dependancies uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).


#### Installation steps

  1. `cd my/project/directory`
  2. run `php composer.phar install`

This will install Zend Framework 2 in whole as well as all Doctrine 2 modules needed for the ORM operations.


#### Setting up your database connection

Setup your connection by adding the module configuration to any valid ZF2 config file. This can be any file in autoload/
or a module configuration (such as the Application/config/module.config.php file).

```php
<?php
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'username',
                    'password' => 'password',
                    'dbname'   => 'database',
                )
            )
        )
    ),
);
```

You can add more connections by adding additional keys to the `connection` and specifying your parameters.


#### Database creation

CREATE TABLE album (
  id int(11) NOT NULL auto_increment,
  number int(11),
  artist varchar(100) NOT NULL,
  title varchar(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE dvd (
  id int(11) NOT NULL auto_increment,
  number int(11),
  title varchar(100) NOT NULL,
  PRIMARY KEY (id)
);


## Doctrine 2 Usage in Zend Framework 2 application

#### Registered Services

 * doctrine.connection.orm_default
 * doctrine.configuration.orm_default
 * doctrine.driver.orm_default
 * doctrine.entitymanager.orm_default
 * doctrine.eventmanager.orm_default

#### Command Line
Access the Doctrine command line as following

```sh
./vendor/bin/doctrine-module
```

#### Service Locator
Access the entity manager using the following alias:

```php
<?php
$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
```

#### Injection
You can also inject the `EntityManager` directly in your controllers/services by using a controller factory. Please
refer to the official ServiceManager documentation for more information.

Example implementation using `Boostrap` event that you can add into you module class:
```php
<?php

namespace MyModule;

class Module
{
    //..

    public function onBootstrap(\Zend\EventManager\EventInterface $e)
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();

        $controllerLoader = $serviceManager->get('ControllerLoader');

        // Add initializer to Controller Service Manager that check if controllers needs entity manager injection
        $controllerLoader->addInitializer(function ($instance) use ($serviceManager) {
            if (method_exists($instance, 'setEntityManager')) {
                $instance->setEntityManager($serviceManager->get('doctrine.entitymanager.orm_default'));
            }
        });
    }
}
```



