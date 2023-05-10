<?php

namespace App\Controller;

use App\Service\Database;

abstract class Controller
{
    private ?\Twig\Loader\FilesystemLoader $loader;
    private ?\Twig\Environment $twig;
    protected ?\PDO $database;

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('../src/View');
        $this->twig = new \Twig\Environment($this->loader);
        $this->twig->addGlobal('session', isset($_SESSION['logged']) ? $_SESSION['logged'] : false);
    }

    protected function getTwig()
    {
        return $this->twig;
    }
}
