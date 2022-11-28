<?php

namespace App\Routes;

use App\Types\HttpMethods;
use Exception;

#[\Attribute]
class Route
{
    private ?string $name = null;
    private ?string $path = null;
    private ?string $controller = null;
    private ?string $action = null;
    private array $params = [];
    private array $methods = ["GET"];

    public function __construct(string $path, ?string $name = null, ?array $methods = null)
    {
        $this->setPath($path);
        $this->setName($name);
        if ($methods) {
            $this->setMethods($methods);
        }
    }

    /*======= SETTERS =======*/
    public function setPath(string $path): self
    {
        preg_match_all("/{(\w*)}/", $path, $match);
        $this->params = $match[1];
        $this->path = preg_replace("/{(\w*)}/", '([^/]+)', str_replace("/", "\/", $path));
        return $this;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    public function setController(string $controller): self
    {
        $this->controller = $controller;
        return $this;
    }
    public function setAction(string $action): self
    {
        $this->action = $action;
        return $this;
    }
    public function setParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param HttpMethods[] $methods
     * @throws Exception
     */
    public function setMethods(array $methods = [HttpMethods::GET]): self
    {
        foreach ($methods as $method) {
            if (is_string($method) && HttpMethods::tryFrom($method) === null) {
                throw new Exception("Invalid method: " . $method);
            }
        }
        $this->methods = $methods;
        return $this;
    }

    /*======= GETTERS =======*/
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getPath(): ?string
    {
        return $this->path;
    }
    public function getController(): ?string
    {
        return $this->controller;
    }
    public function getAction(): ?string
    {
        return $this->action;
    }
    public function getParams(): array
    {
        return $this->params;
    }
    public function getMethods(): array
    {
        return $this->methods;
    }

    /*======= OTHER METHODS =======*/
    public function mergeParams(string $url): array
    {
        preg_match("#{$this->path}#", $url, $match);
        array_shift($match);
        return array_combine($this->getParams(), $match);
    }

    public function macth (string $url): bool
    {
        return (bool)preg_match("#^{$this->path}$#", $url);
    }
}