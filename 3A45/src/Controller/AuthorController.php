<?php

namespace App\Controller;



use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;

use phpDocumentor\Reflection\Types\This;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\Form\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/list/{var}', name: 'list_author')]
    public function listAuthor($var)
    {
        $authors = array(
            array('id' => 1, 'username' => ' Victor Hugo','email'=> 'victor.hugo@gmail.com', 'nb_books'=> 100),
            array ('id' => 2, 'username' => 'William Shakespeare','email'=>
                'william.shakespeare@gmail.com','nb_books' => 200),
            array('id' => 3, 'username' => ' Taha Hussein','email'=> 'taha.hussein@gmail.com','nb_books' => 300),
        );

        return $this->render("author/list.html.twig",
            array('variable'=>$var,
                'tabAuthors'=>$authors
                ));
    }

    #[Route('/listAuthor', name: 'authors')]
    public function list(AuthorRepository $repository)
    {
        $authors = $repository->listAuthorByEmail();
        return $this->render("author/listAuthors.html.twig",
            array(
                'tabAuthors'=>$authors
            ));
}

    #[Route('/add', name: 'add_authors')]
    public function addAuthor(ManagerRegistry $managerRegistry)
    {
        $author= new Author();
        $author->setEmail("author6@gmail.com");
        $author->setUsername("author6");
       // $em= $this->getDoctrine()->getManager();
        $em= $managerRegistry->getManager();
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute("authors");

   }


    #[Route('/update/{id}', name: 'update_authors')]
    public function updateAuthor($id,AuthorRepository $repository,ManagerRegistry $managerRegistry)
    {
        $author= $repository->find($id);
        $author->setEmail("author7@gmail.com");
        $author->setUsername("author7");
        // $em= $this->getDoctrine()->getManager();
        $em= $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("authors");
    }

    #[Route('/remove/{id}', name: 'remove_authors')]
    public function deleteAuthor(AuthorRepository $repository,$id,
                                 ManagerRegistry $managerRegistry)
    {
        $author= $repository->find($id);
        $em = $managerRegistry->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute("authors");
    }

    #[Route('/addop', name: 'raddop')]
    public function addother(ManagerRegistry $managerRegistry ,Request $request,AuthorRepository $repository){

        $author=new Author();
        $form = $this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $emailexist = $repository->findOneBy(['email' => $author->getEmail()]);
           if($emailexist){
               return  new Response("email exist");
           }
            else
            {$em=$managerRegistry->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute("authors");}


        }
        return $this->renderForm("author/add.html.twig",
            array('authorForm'=>$form,));


    }
    #[Route('/updateauth/{id}', name: 'Update_author')]
    public function upd($id,ManagerRegistry $managerRegistry ,AuthorRepository $authorRepository,Request $request)   {
        $author=$authorRepository->find($id);
        $form=$this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em=$managerRegistry->getManager();
            $em->flush();
           return $this->redirectToRoute("authors");


        }

        return $this->renderForm('author/update.html.twig',array('form'=>$form));
    }




}

