<?php

namespace Simplemvc\Core\Router;

use ArgumentCountError;
use Exception;
use Simplemvc\Config\Config;
use Simplemvc\Core\Controller;
use Simplemvc\Core\Helper;
use Simplemvc\Core\Request;
use Simplemvc\Exceptions\BadControllerException;
use TypeError;

class Router
{
    /**
     * @var Route
     * The matching route based on the requested URI page.
     */
    protected Route $matchedRoute;

    /**
     * @var string
     * The current path or URI.
     */
    protected string $currentPath;

    /**
     * @var string
     * The default controller.
     */
    protected string $defaultController;

    /**
     * @var string
     * The default action or method.
     */
    protected string $defaultAction;

    /**
     * @var string
     * The default controller namespace.
     */
    protected string $defaultNamespace;

    public function __construct(
        protected RouteCollection $routes
    )
    {
        $this->defaultController = Config::$defaultController;
        $this->defaultAction = Config::$defaultActionMethod;
        $this->defaultNamespace = Config::$defaultControllerNamespace;
    }

    /**
     * @param Request $request
     * @return void
     * Finds the route and sends the output to the browser.
     */
    public function dispatch(Request $request): void
    {
        $this->currentPath = $this->removeSlashes($request->getPathInfo());

        // show 404 if route is not found on the collection.
        if (!$this->routeExists($this->currentPath)) exit('404: Page does not exist');

        try {
            $controller = $this->getMatchedRouteController($request);
            $action = $this->getMatchedRouteAction();
            call_user_func_array([$controller, $action], $this->matchedRoute->getParams());
        } catch (BadControllerException|ArgumentCountError|TypeError|Exception $e) {
            exit('<strong>404</strong>: ' . $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return Controller
     * @throws BadControllerException
     * @throws Exception
     *
     * Gets the defined controller for the route.
     * If no controller property was set, it will look for the params
     * defined in its assigned route URI.
     * Controller and method defined the route URI will take precedence over
     * the property values.
     */
    protected function getMatchedRouteController(Request $request): Controller
    {
        $params = $this->matchedRoute->getParams();
        if (key_exists(Config::$termForControllers, $params)) {
            $controller = $params[Config::$termForControllers];

            // if the controller found on the URI is written like "some-page",
            // it will be converted to proper class name (camel case);  SomePage
            $controller = $this->toCamelCase($controller);
            // unset the param from the array, so it does not get passed to the method
            unset($params[Config::$termForControllers]);
            $this->matchedRoute->setParams($params);
        } else {
            $controller = $this->matchedRoute->getController() ?: Config::$defaultController;
        }
        $namespace = $this->matchedRoute->getNamespace() ?: Config::$defaultControllerNamespace;

        Helper::loadHelper('string');

        // check if controller contains namespace
        if (!hasNamespacePresence($controller)) {
            $controller = $namespace . '\\' . $controller;
        }
        $controller = ucfirst($controller);
        if (!class_exists($controller)) {
            throw new BadControllerException("Controller \"$controller\" does not exist.");
        }

        // instantiate the controller
        return new $controller($request);
    }

    /**
     * @return string
     * Finds the action assigned based on the requested page.
     */
    private function getMatchedRouteAction(): string
    {
        $params = $this->matchedRoute->getParams();
        if (key_exists(Config::$termForActions, $params)) {
            $action = $params[Config::$termForActions];
            // if the action found on the URI is written like "some-action",
            // it will be converted to proper method name (studly case);  someAction
            if (strpos($action, '-')) {
                $action = $this->toStudlyCaps($action);
            }
            unset($params[Config::$termForActions]);
            $this->matchedRoute->setParams($params);
        } else {
            $action = $this->matchedRoute->getAction() ?: Config::$defaultActionMethod;
        }
        return $action;
    }

    /**
     * @param Route $route
     * @return $this
     * Method for adding route to the collection.
     * Calls registerRoute.
     */
    public function addRoute(Route $route): static
    {
        $this->registerRoute($route);
        return $this;
    }

    public function addRouteGroup(array $routes, string $groupName = '', string|Controller $commonController = '', string $namespace = ''): static
    {
        foreach ($routes as $route) {
            $this->registerRoute($route, $groupName, $commonController, $namespace);
        }
        return $this;
    }

    /**
     * @param Route $route
     * @param string $group
     * @param string|Controller $controller
     * @param string $namespace
     * @return void
     *
     * Converts the URI to regex and then appends route to the collection.
     */
    protected function registerRoute(Route $route, string $group = '', string|Controller $controller = '', string $namespace = ''): void
    {
        if (!empty($controller)) $route->setController($controller);

        if (!empty($namespace)) $route->setController($namespace);

        $uri = $this->removeSlashes($route->getAssignedRoute());
        if (!empty($group)) {
            $group = $this->removeSlashes($group);
            $uri = $group . (!empty($uri) ? '/' . $uri : '');
        }

        $route->setAssignedRoute($this->uriToRegex($uri));
        $this->routes->add($route);
    }

    /**
     * @param string $path
     * @return bool
     *
     * finds if the route exists in the collection
     */
    protected function routeExists(string $path): bool
    {
        $this->setDynamicRouting();

        foreach ($this->routes as $route) {
            if ($route->pathMatchesRoute($path)) {
                $this->matchedRoute = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $path
     * @return string
     * Removes slashes from both ends of the string.
     */
    protected function removeSlashes(string $path): string
    {
        return trim($path, '/');
    }

    /**
     * @param string $uri
     * @return string
     * Converts the URI to regex.
     */
    protected function uriToRegex(string $uri): string
    {
        // convert / to \/
        $uri = str_replace('/', '\\/', $uri);
        // get named routes
        $uri = preg_replace('/{([\w\-_]+)}/', '(?P<$1>[\w\-_]+)', $uri);
        // get named routes with custom regex
        $uri = preg_replace('/{([\w\-_]+):([^}]+)}/', '(?P<$1>$2)', $uri);
        return '/^' . $uri . '$/';
    }

    protected function toStudlyCaps(string $str): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $str)));
    }

    protected function toCamelCase(string $str): string
    {
        return lcfirst($this->toStudlyCaps($str));
    }

    private function setDynamicRouting(): void
    {
        if (Config::$allowDynamicRouting) {
            $this->addRoute(Route::new('{controller}'));
            $this->addRoute(Route::new('{controller}/{action}'));
        }
    }
}