<?php

namespace Elit1\ObjectOriented;

use Elit1\ObjectOriented\Helpers\StringEndsWith;
use Exception;

class View
{
    private string $folder = 'views';
    private string $root;
    private string $includePath;
    private const DS = DIRECTORY_SEPARATOR;

    public function __construct ()
    {
        $this->root = dirname(__FILE__, 2);
        $this->includePath = $this->root . static::DS . $this->folder . static::DS;
        $this->checkForViewsDir();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function checkForViewsDir ()
    {
        if (!is_dir($this->includePath)) {
            throw new Exception('Error - views folder does not exist.');
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function header (): void
    {
       echo $this->requireView('header');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function footer (): void
    {
        echo $this->requireView('footer');
    }

    /**
     * @param              $view
     * @param  array|null  $params
     *
     * @return mixed|string
     * @throws Exception
     */
    private function require ($view, ?array $params = []): mixed
    {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $$key = $value;
            }
        }
        if (is_file($this->includePath . $view)) {
            if (StringEndsWith::check($view, '.html', false)) {
                echo file_get_contents($this->includePath . $view);
                return '';
            }

            if (StringEndsWith::check($view, '.php', false)) {
                return require_once $this->includePath . $view;
            }

        }

        if (is_file($this->includePath . $view . '.html')) {
            echo file_get_contents($this->includePath .  $view . '.html');
            return '';
        }

        if (is_file($this->includePath . $view . '.php')) {

            return require_once $this->includePath .  $view . '.php';
        }

        throw new Exception("File $this->includePath$view is not found, or is not a valid HTML or PHP file.");
    }

    public function show ($view, ?array $params = [])
    {
        echo $this->includeView($view, $params);
    }

    /**
     * @param              $view
     * @param  array|null  $params
     *
     * @return void
     * @throws Exception
     */
    private function include ($view, ?array $params = [])
    {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                echo $key . '<br />';
                $$key = $value;
            }
        }
        if (is_file($this->includePath . $view)) {
            if (StringEndsWith::check($view, '.html', false)) {
                echo file_get_contents($this->includePath . $view);
                return;
            }

            if (StringEndsWith::check($view, '.php', false)) {
                include_once $this->includePath . $view;
                return;
            }

        }



        if (is_file($this->includePath . $view . '.html')) {
            echo file_get_contents($this->includePath .  $view . '.html');
            return;
        }

        if (is_file($this->includePath . $view . '.php')) {
            include_once $this->includePath . $view . '.php';
            return;
        }

        throw new Exception("File $this->includePath$view is not found, or is not a valid HTML or PHP file.");
    }

    /**
     * @param  string  $view
     * @param  array   $params
     *
     * @return bool
     * @throws Exception
     */
    public function includeView(string $view, array $params = []): bool
    {
        $this->include($view, $params);
        return true;

    }

    /**
     * @param  string      $view
     * @param  array|null  $params
     *
     * @return mixed|string
     * @throws Exception
     */
    public function requireView(string $view, ?array $params = []): mixed
    {
        return $this->require($view, $params);

    }

}