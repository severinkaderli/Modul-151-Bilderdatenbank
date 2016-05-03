<?php
require_once("./config.php");

/**
 * This file is used to set up the bootstrapping using routes.
 */
$router = new Core\Routing\Router();
$router->setBasePath(str_replace("http://" . $_SERVER['SERVER_NAME'], "", BASE_DIR));

/**
 * Defined routes
 */
// General
$router->addRoute("GET", "", function(){

    $images = Core\Model\Image::getAll();
    var_dump($images);
});

// Authentication
$router->addRoute("GET", "/logout", "AuthController@logout");
$router->addRoute("GET", "/login", "AuthController@showLogin");
$router->addRoute("POST", "/login", "AuthController@login");
$router->addRoute("GET", "/register", "AuthController@showRegister");
$router->addRoute("POST", "/register", "AuthController@register");

// User management
$router->addRoute("GET", "/users", "UserController@index");
$router->addRoute("GET", "/user/{userId}/delete", "UserController@delete");
$router->addRoute("GET", "/user/{userId}/promote", "UserController@promote");

/**
 * Dispatching and call the matched method
 */
$match = $router->dispatch();

if(DEBUG) {
    echo "<pre>";
    var_dump($match);
    echo "</pre>";
}

switch ($match["type"]) {
    case "Closure":
        $match["function"]();
        break;

    case "Controller":
        $controller = new $match["controller"]();
        if (is_null($match["parameter"])) {
            call_user_func($controller->{$match["method"]}());
        } else {
            call_user_func($controller->{$match["method"]}(), $match["parameter"]);
        }
        break;

    case "Error":
        Core\Routing\Redirect::to("/");
        break;
}

