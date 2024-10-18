<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/article', name: 'admin.article')]
class ArticleController extends AbstractController
{
    // nouvelle syntaxe refactorisée depuis php 8
    public function __construct(
        private EntityManagerInterface $em,
        private ArticleRepository $articleRepository,
    ){
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Admin/Article/index.html.twig', [
            'articles' => $this->articleRepository->findAll()
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        // Instanciation nouvel article (entity)
        $article = new Article();

        // Création formulaire
        $form = $this->createForm(ArticleType::class, $article);

        // Traiter le formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($article);
            $this->em->flush();

            $this->addFlash('success', 'L\'article a bien été créé');

            return $this->redirectToRoute('admin.article.index');
        }

        // On récupère le formulaire a la vue
        return $this->render('Admin/Article/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function update(Article $article, Request $request): Response
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($article);
            $this->em->flush();

            $this->addFlash('success', 'L\'article a bien été modifié');

            return $this->redirectToRoute('admin.article.index');
        }

        return $this->render('Admin/Article/update.html.twig', [
            'form' => $form,
        ]);
    }
}