<?php

namespace Simplemvc\Core;

class Request
{
    protected string $uri;

    public function __construct(
        public readonly array $getParams,
        public readonly array $postParams,
        public readonly array $fileParams,
        public readonly array $serverParams,
        public readonly array $cookieParams
    )
    {
        $this->uri = $this->serverParams['REQUEST_URI'];
    }

    public static function init(): static
    {
        return new static(
            $_GET, $_POST, $_FILES, $_SERVER, $_COOKIE
        );
    }

    /**
     * @return string
     * Strips off query string from the URI.
     */
    public function getPathInfo(): string
    {
        return strtok($this->uri);
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}