<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/***
 * Contact controller.
 * 
 * @Route("/api",name="api_")
 * 
 * 
 */
class ContactController  extends AbstractFOSRestController
{
    /**
     * Lists all Contacts.
     * @Rest\Get("/contacts")
     *
     * @return Response
     */
    public function getContact(ContactRepository $productRepository)
    {
        $contacts = $productRepository->findAllOrdred();
        return $this->handleView($this->view($contacts));
    }

    /**
     * Create Contact.
     * @Rest\Post("/new_contact")
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

            return $this->handleView($this->view(['status' => 'Contact added successfully'], Response::HTTP_CREATED));
        }

        $globalErrors = $form->getErrors();

        return $this->handleView($this->view(['status' => 'bad', 'errors' => $globalErrors], Response::HTTP_IM_USED));
    }
    /**
     * Delete Contact.
     * @Rest\Delete("/delete_contact/{id}")
     *
     * @return Response
     */
    public function deleteContact(Request $request)
    {
        $contact = new Contact();

        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contact = $repository->find($request->get('id'));
        if ($contact) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($contact);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view(['status' => 'error'], Response::HTTP_NOT_FOUND));
    }
}
