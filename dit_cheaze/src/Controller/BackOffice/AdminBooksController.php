<?php

namespace App\Controller\BackOffice;


use App\Entity\Books;
use App\Entity\Images;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminBooksController extends AbstractController
{
    /**
     * @var ImagesRepository
     * @var BooksRepository
     */
    private $imagesRepository;
    private $booksRepository;
    public function __construct(BooksRepository $booksRepository, ImagesRepository $imagesRepository)
    {
        $this->booksRepository =$booksRepository;
        $this->imagesRepository = $imagesRepository;
    }

    /**
     * @Route("/admin/books", name="admin.books")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function AdminBooks()
    {
        $book = $this->booksRepository->findAll();
        $images= $this->imagesRepository->findAll();

        return $this->render('BackOffice/Books/AdminBooks.html.twig', [
            'books' => $book,
            'images'=>$images
        ]);

    }


    // create new books Images
    /**
     * @Route("/admin/books/new/", name="admin.books.new")
     */
    public function new(EntityManagerInterface $manager, Request $request)
    {
        $books = new Books();
        $images= new Images();

        $form = $this->createForm(BooksType::class, $books);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            //define Background Image
            $backImages= $form->get('BackImage')->getData();
            $backImagesName= md5(uniqid()).'.'.$backImages->guessExtension();
            $backImages->move($this->getParameter('backimage_directory'), $backImagesName);
            $books->setBackImage($backImagesName);

                //define books images
                $title = $books->getTitles();
                $imageFiles = $form->get('CountImages')->getData();
                $imgDir= $this->getParameter('photos_directory').'/'.$title.'/';

                foreach ($imageFiles as $imageFile){
                    /**
                     * @var UploadedFile $imageFile
                     */

                    $imageName = md5(uniqid()).'.'.$imageFile->guessExtension();
                    $imageFile->move($imgDir,$imageName);
                    $countImages= count($imageFiles);
                    $image = new Images();
                    $image->setAlt($title)
                            ->setBooks($books)
                            ->setUrl($imageName);
                    $manager->persist($image);
                }




            //load to db
            $books->setCountImages($countImages);
            $manager->persist($books);
            $manager->flush();
            $this->addFlash('success', 'Bien créé avec succès');
            return $this->redirectToRoute('admin.books');

        }


        return $this->render('BackOffice/Books/NewBooks.html.twig',[
            'form'=>$form->createView(),
            'books'=>$books,
            'images'=>$images

        ]);

    }

    //Edit books

    /**
     * @Route("/admin/books/edit/{slug}-{id}", name="admin.books.edit", requirements={"slug": "[a-z- -0-9]*"})
     */
    public function edit(Books $books, $slug, Request $request, EntityManagerInterface $manager)
    {
        $images= new Images();
        // redirect route when is bad writing
        if($books->getSlug() !== $slug){
            return $this->redirectToRoute('books.show', [
                'id' => $books->getId(),
                'slug' => $books->getSlug()
            ], 301);

        }


        $form = $this->createForm(BooksType::class, $books);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){


            //define Background Image
            $backImages= $form->get('BackImage')->getData();
            $backImagesName= md5(uniqid()).'.'.$backImages->guessExtension();
            $backImages->move($this->getParameter('backimage_directory'), $backImagesName);
            $books->setBackImage($backImagesName);

            //define books images
            $title = $books->getTitles();
            $imageFiles = $form->get('CountImages')->getData();
            $imgDir= $this->getParameter('photos_directory').'/'.$title.'/';

            foreach ($imageFiles as $imageFile){
                /**
                 * @var UploadedFile $imageFile
                 */

                $imageName = md5(uniqid()).'.'.$imageFile->guessExtension();
                $imageFile->move($imgDir,$imageName);
                $countImages= count($imageFiles);
                $image = new Images();
                $image->setAlt($title)
                    ->setBooks($books)
                    ->setUrl($imageName);
                $manager->persist($image);
            }




            //load to db
            $books->setCountImages($countImages);
            $manager->persist($books);
            $manager->flush();
            $this->addFlash('success', 'Bien modifier avec succès');
            return $this->redirectToRoute('admin.books');

        }

        return $this->render("BackOffice/Books/EditBooks.html.twig", [
            'images'=>$images,
            'books'=>$books,
            'form'=>$form->createView(),
        ]);
    }

    //delete books

    /**
     * @Route("admin/books/delete/{id}", name="admin.books.delete")
     * @param Books $books
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function delete(Books $books, EntityManagerInterface $manager, Request $request){
        $images= new Images();
        $fs = new Filesystem();
        $backimagedir= $books->getBackImage();
        $imagedir= $images->getUrl();
        if($this->isCsrfTokenValid('delete'.$books->getId(), $request->get('_token'))){
                $manager->remove($books);
                $manager->flush();
                $this->addFlash('success', 'Bien supprimé avec succés');
        }

        return $this->redirectToRoute("admin.books");
    }


}