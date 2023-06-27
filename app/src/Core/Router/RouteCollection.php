<?php

namespace Simplemvc\Core\Router;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * Routes container.
 */
class RouteCollection implements IteratorAggregate
{
    protected array $items;

    public function add(Route $route): void
    {
        $this->items[$route->getAssignedRoute()] = $route;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}