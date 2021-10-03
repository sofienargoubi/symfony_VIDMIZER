<?php
namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;


class ContactController 
{
    /**
    * @Route("/contact", methods="GET")
    */
    public function index(ContactRepository $contactRepository)
    {
        $contact = $contactRepository->findAll();

        return new JsonResponse($contact);
    }
/*
    /**
    * @Route("/new_contact", methods="POST")
    */
  //  public function create(Request $request, ContactRepository $contactRepository, EntityManagerInterface $em)
 //   {
      //  $request = $this->transformJsonBody($request);

      //  if (! $request) {
      //      return $this->respondValidationError('Please provide a valid request!');
      //  }

        // validate the title
    //    if (! $request->get('title')) {
    //        return $this->respondValidationError('Please provide a title!');
    //    }

        // persist the new contact
    //    $contact = new Contact;
//$contact->setNom($request->get('title'));
     //   $contact->setPrenom(0);
    //    $em->persist($contact);
   //     $em->flush();

  //      return $this->respondCreated($contactRepository->transform($contact));
  //  }


}