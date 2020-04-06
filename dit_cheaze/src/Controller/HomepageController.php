<?php

namespace App\Controller;

use App\Entity\Books;
use App\Repository\BooksRepository;
use App\Repository\ImagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController{



    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response
     */
    public function index(BooksRepository $booksRepository): Response{

            $books = $booksRepository->findAll();
        return $this->render('FrontOffice/index.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route("/books/{slug}-{id}", name="books.show", requirements={"slug": "[a-z- -0-9]*"})
     * @return Response
     */
    public function show($slug, Books $books, ImagesRepository $imagesRepository): Response{
        if($books->getSlug() !== $slug){
            return $this->redirectToRoute('books.show', [
                'id' => $books->getId(),
                'slug' => $books->getSlug()
            ], 301);

        }
        $images = $imagesRepository->findAll();
        return $this->render('FrontOffice/books.html.twig',[
            'books' => $books,
            'images'=>$images
        ]);
    }
}