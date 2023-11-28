<?php
namespace App\Controller;

use App\Service\FileInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AppController extends AbstractController
{
    public function index(FileInfo $files): Response
    {
        return $this->render('list.twig', [
            'title' => 'List',
            'fileMetadata' => $files->getList()
        ]);
    }
}