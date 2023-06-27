<?php

namespace Simplemvc\Core\Router;

use Simplemvc\Core\BaseController;

/**
 * Route model.
 */
class Route
{
    /**
     * @var string|BaseController
     * The controller file.
     */
    protected string|BaseController $controller = '';

    /**
     * @var string
     * Action refers to the method inside the controller.
     */
    protected string $action = '';

    /**
     * @var array
     * Hold the parameter required by the action or method.
     */
    protected array $params = [];

    /**
     * @var string
     * The namespace in which the controller can be found.
     */
    protected string $namespace = '';

    /**
     * @var string
     * The route address. Typically, will be converted to a regex string.
     */
    protected string $assignedRoute = '';

    /**
     * @param string $uri
     * @param array $array
     * @param string $namespace
     *
     * Sample values:
     * $uri = 'pages/about';
     * $array = ['ControllerName', 'ActionName'];
     * $namespace = 'Some\\Namespace\\';
     */
    public function __construct(string $uri = '', array $array = [], string $namespace = '')
    {
        $this->assignedRoute = $uri;
        if (!empty($array)) {
            [$this->controller, $this->action] = $array;
        }
        $this->namespace = $namespace;
    }

    /**
     * @param string $route
     * @return static
     * Returns an instantiated Route.
     */
    public static function new(string $route): static
    {
        return new static($route);
    }

    /**
     * @param string $path
     * @return bool
     * Returns whether the given path (requested page), matches the route's defined URI.
     * When a match is found, the params will be assigned to the $params property.
     */
    public function pathMatchesRoute(string $path): bool
    {
        return preg_match($this->getAssignedRoute(), $path, $this->params);
    }

    /**
     * @return BaseController|string
     */
    public function getController(): BaseController|string
    {
        return $this->controller;
    }

    /**
     * @param BaseController|string $controller
     * @return Route
     */
    public function setController(BaseController|string $controller): static
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return Route
     */
    public function setAction(string $action): static
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        // Filter out unwanted values. All params defined in the route address are assigned with string keys.
        return array_filter($this->params, function ($key) {
            return is_string($key);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @param array $params
     * @return Route
     */
    public function setParams(array $params): static
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     * @return Route
     */
    public function setNamespace(string $namespace): static
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getAssignedRoute(): string
    {
        return $this->assignedRoute;
    }

    /**
     * @param string $assignedRoute
     * @return Route
     */
    public function setAssignedRoute(string $assignedRoute): static
    {
        $this->assignedRoute = $assignedRoute;
        return $this;
    }
}