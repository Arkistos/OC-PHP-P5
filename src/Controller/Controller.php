<?php

namespace App\Controller;

class Controller
{
    protected ?\Twig\Loader\FilesystemLoader $loader;
    protected ?\Twig\Environment $twig;

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('../src/View');
        $this->twig = new \Twig\Environment($this->loader);
        $this->twig->addGlobal('session', isset($_SESSION['logged']) ? $_SESSION['logged'] : false);
    }

    public function getTwig()
    {
        return $this->twig;
    }
}
