<?php

namespace App\Controller;

use App\Service\Alerts;

abstract class Controller
{
    private ?\Twig\Loader\FilesystemLoader $loader;
    private ?\Twig\Environment $twig;

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('../src/View');
        $this->twig = new \Twig\Environment($this->loader);
        $this->twig->addGlobal('user', $_SESSION['user'] ?? false);
    }

    protected function getTwig():?\Twig\Environment
    {
        $this->twig->addGlobal('alerts', Alerts::getAlerts());

        return $this->twig;
    }
}
