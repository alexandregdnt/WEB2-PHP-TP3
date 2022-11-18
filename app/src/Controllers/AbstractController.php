<?php

namespace App\Controllers;

abstract class AbstractController
{
    public function __construct (string $action, array $params = [])
    {
        if (!is_callable([$this, $action])) {
            throw new \Exception("Action $action not found");
        }
        call_user_func([$this, $action], $params);
    }

    public function render(string $view, array $args = [], string $title = "Document"): void
    {
        $view = dirname(__DIR__, 2) . '/views/' . $view;
        $base = dirname(__DIR__, 2) . '/views/base.php';

        ob_start();
        foreach ($args as $key => $value) {
            $$key = $value;
        }

        require_once $view;
        $_pageContent = ob_get_clean();
        $_pageTitle = $title;


        require_once $base;
    }
}
