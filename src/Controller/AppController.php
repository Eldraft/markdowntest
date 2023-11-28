<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AppController extends AbstractController
{
    public function index(): Response
    {
        $number = 'XXX';

        return $this->render('base.html.twig', [
            'number' => $number,
        ]);
    }

}