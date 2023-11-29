<?php
namespace App\Controller;

use App\Service\ArticleList;
use App\Service\ArticleSave;
use App\Service\ArticleEdit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AppController extends AbstractController
{
    public function index(ArticleList $listAction): Response
    {
        return $this->render('list.twig', [
            'title' => 'List',
            'fileMetadata' => $listAction->getData()
        ]);
    }

    public function edit(ArticleEdit $editAction, string $id): Response
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