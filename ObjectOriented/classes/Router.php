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
        'showFiles' => [Controllers\ImagesController::class, 'index'],
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

    public function resolve ()
    {
        if (isset($this->routes[$this->route]) && is_array($this->routes[$this->route])) {
            $body = $this->request->getBody();
            $this->routes[$this->route][0] = new $this->routes[$this->route][0]();
            return call_user_func($this->routes[$this->route], $body);
        }
        if (in_array($this->route, $this->routes, true)) {
           return $this->view->requireView($this->route, $body ?? null);
        }
        $this->view->requireView('default');
        return true;

    }


}