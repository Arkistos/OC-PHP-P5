<?php

namespace App\Controller;

use App\Service\Alerts;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class HomeController extends Controller
{
    public function home(): void
    {
        if (isset($_POST['message']) && isset($_POST['name']) && isset($_POST['email'])) {
            $transport = Transport::fromDsn(MAILER);
            $mailer = new Mailer($transport);
            $email = (new Email())
                ->from('expediteur@gmail.com')
                ->to('pierre.lacaud@gmail.com')
                ->subject('Message du blog')
                ->text('message de '.$_POST['name'].' : '.$_POST['message']);
            $mailer->send($email);
            Alerts::addAlert('success', 'Votre message à été envoyé');
        }

        echo $this->getTwig()->render('homepage.html');
    }
}
