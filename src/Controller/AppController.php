<?php
namespace App\Controller;

use App\Service\ArticleSave;
use App\Service\FileEdit;
use App\Service\FileInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AppController extends AbstractController
{
    public function index(FileInfo $files): Response
    {
        return $this->render('list.twig', [
            'title' => 'List',
            'fileMetadata' => $files->getList()
        ]);
    }

    public function edit(FileEdit $editAction, string $id): Response
    {
        return $this->render('edit.twig', [
            'title' => 'Edit',
            'data' =>  $editAction->getData($id)
        ]);
    }

    public function save(ArticleSave $saveAction, Request $request)
    {
        if ($saveAction->saveHandler($request->request)){
            return $this->redirectToRoute('index');
        }
        else{
            return $this->render('error.twig', [
                'title' => 'ERROR!'
            ]);
        }
    }

}