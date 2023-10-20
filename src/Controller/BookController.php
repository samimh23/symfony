<?php

namespace App\Controller;


use App\Form\BoookType;
use Doctrine\Persistence\ManagerRegistry;



use App\Repository\BookRepository;
use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\RequestHandlerInterface;

class BookController extends AbstractController
{

    #[Route( '/addbok',name:'add_book' )]
    public function addboo(Request $request, ManagerRegistry $managerRegistry ){
    $book=new Book();
    $book->setPublished(true);
    $form=$this->createForm(BoookType::class,$book);
    $form->handleRequest($request);
       if ($form->isSubmitted()){
           $em=$managerRegistry->getManager();
           $em->persist($book);
           $em->flush();
           return new Response("zona");
       }
       return $this->renderForm("book/Addbook.html.twig",
            array('form'=>$form,));


    }
    #[Route( '/addboko  ',name:'add_show' )]
    public function afficher(BookRepository $bookRepository)
    {
        return $this->render("book/listsbooks.html.twig",[
            'books'=>$bookRepository->findAll(),
        ]);
    }


}
