<?php

namespace App;

class Controller
{
    protected function render($view, $data = [])
    {
        extract($data);
        $view = ltrim(str_replace('..', '', (string) $view), '/');
        include __DIR__ . "/Views/{$view}.php";
    }

    public function redirect($path)
    {
        header("Location: $path");
    }
}