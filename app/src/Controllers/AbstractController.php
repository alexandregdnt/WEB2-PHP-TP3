<?php

namespace App\Controllers;

use App\Entities\User;

abstract class AbstractController
{
//    protected ?User $user = null;
//
//    public function __construct (string $action, array $params = [], User $user = null)
//    {
//        if (!is_callable([$this, $action])) {
//            throw new \Exception("Action $action not found");
//        }
//        $this->user = $user;
//        call_user_func_array([$this, $action], $params);
//    }

    public function getUser(): ?User
    {
        return isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    }

    public function render(string $view, array $args = [], string $title = "Document"): string
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

        ob_start();
        require_once $base;
        return ob_get_clean();
    }
}
