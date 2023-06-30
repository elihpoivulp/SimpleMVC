# SimpleMVC

A simple PHP MVC framework. 

## Requirements
- Docker
- PHP
- Composer

## Installation
1. Clone this repository `git clone git@github.com:elihpoivulp/SimpleMVC.git`
2. CD into the root directory `cd ./SimpleMVC`
3. First, set your environment variables in the `.env` file. 
4. Run docker command to deploy the app locally `docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml --env-file .env up -d`
5. Once it's up, go to your browser and type in `http://locahost` to load the app

## Usage
### Controllers
- To define a new controller, find the `app/Controllers/` folder, and create a new class. The class should extend the `Simplemvc\Core\Controller` class and should be in `Simplemvc\Controllers` namespace. E.g.:
```php
<?php

namespace Simplemvc\Controllers;

class HomeAlongTheRiles extends \Simplemvc\Core\Controller
{
    public function index(): void
    {
        echo 'Dolphy';
    }

    public function getMessages(): void
    {
//        $model = self::loadModel(MessagesModel::class);
        $model = new Simplemvc\Models\MessagesModel();
        foreach ($model->getMessages() as $message) echo $message['message'] . '<br>';
    }
}
```

### Models
### Defining Models
Define your models in `app/Models/`. The class should extend `Simplemvc\Core\Model` class and should be in `Simplemvc\Models` namespace. E.g.:
```php
<?php

namespace Simplemvc\Models;

use Simplemvc\Core\Model;

class MessagesModel extends Model
{
    public function getMessages(): false|array
    {
        $query = $this->db->query('SELECT * from messages');
        return $query->fetchAll();
    }
}
```
#### Using Models
To use your models, in your controller, you can instantiate the model or you can also use the static method `::loadModel($model)` defined in the parent Controller class.
```php
<?php

namespace Simplemvc\Controllers;
class HomeAlongTheRiles extends \Simplemvc\Core\Controller
{
    public function index(): void
    {
        echo 'Dolphy';
    }

    public function getMessages(): void
    {
//        $model = self::loadModel(MessagesModel::class);
        $model = new \Simplemvc\Models\MessagesModel();
        foreach ($model->getMessages() as $message) echo $message['message'] . '<br>';
    }
}
```

### Routes
#### Defining basic routes
To define routes, go to `index.php` located at the `public/` folder.
```php
// load the router
$router = new Router(new RouteCollection());

// define a route configuration
$homeAlongTheRilesRouteConfig = new \Simplemvc\Core\Router\Route();
$homeAlongTheRilesRouteConfig->setAssignedRoute('home-along-the-riles')->setController(\Simplemvc\Controllers\HomeAlongTheRiles::class)
->setAction('getMessages');

// set your routes
// an empty URI means it will be the homepage
// an empty action means it will use the index method as it's default action
// option 1 of defining route
$router->addRoute(\Simplemvc\Core\Router\Route::new('')->setController(\Simplemvc\Controllers\HomeAlongTheRiles::class));  

// option 2
$router->addRoute($homeAlongTheRilesRouteConfig);
```
#### Defining advanced routes
*TODO*

---

*TODO: refactor read me. make it complete and more comprehensive and simple*


