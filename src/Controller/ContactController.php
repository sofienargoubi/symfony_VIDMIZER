<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\Controller\Annotations as Rest;

/***
 * Contact controller.
 * 
 * @Route("/api",name="api_")
 * 
 * */
class ContactController  extends AbstractFOSRestController
{
    /**
     * Lists all Movies.
     * @Rest\Get("/movies")
     *
     * @return Response
     */
    public function getContact()
    {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $movies = $repository->findall();
        return $this->handleView($this->view($movies));
    }

    /**
     * Create Movie.
     * @Rest\Post("/movie")
     *
     * @return Response
     */
    public function postContact(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
    /**
     * Create Movie.
     * @Rest\Post("/movie")
     *
     * @return Response
     */
    public function deleteContact(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
}
