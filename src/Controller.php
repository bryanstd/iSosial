<?php

namespace App;

class Controller
{
    protected function render($view, $data = [])
    {
        extract($data);

        include "Views/$view.php";
    }

    public function redirect($path)
    {
        header("Location: $path");
    }
}