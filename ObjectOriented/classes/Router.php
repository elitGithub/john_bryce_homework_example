<?php

namespace Elit1\ObjectOriented;

class Router
{
    private array $routes = [
        'getusers',
        'adduser',
        'edituser',
        'deleteuser',
        'uploadFile',
    ];

    /**
     * @var mixed|string
     */
    private mixed $route;

    public function __construct (private View $view, private Request $request) {}


    public function setRoute (string $route): Router
    {
        $this->route = $route;
        return $this;
    }

    public function resolve (): bool | string
    {
        if (in_array($this->route, $this->routes, true)) {
            if ($this->request->isPost()) {
                $body = $this->request->getBody();
            }
           return $this->view->requireView($this->route, $body ?? null);
        }
        $this->view->requireView('default');
        return true;

    }


}