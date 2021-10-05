<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\UserType;
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
class UserController  extends AbstractFOSRestController
{
    /**
     * Lists all Contacts.
     * @Rest\Get("/contacts")
     *
     * @return Response
     */
    public function getContact()
    {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contacts = $repository->findAll();
        return $this->handleView($this->view($contacts));
    }

    /**
     * Create user.
     * @Rest\Post("/new_user")
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $options = [
            'cost' => 12,
        ];
        $contact = new User();
        $form = $this->createForm(UserType::class, $contact);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $contact->setPwd(password_hash($contact->getPwd(), PASSWORD_BCRYPT, $options));

            $em->persist($contact);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
     /**
     * login user.
     * @Rest\Post("/login")
     *
     * @return Response
     */
   // public function login(Request $request): Response
  //  {
       /* $options = [
            'cost' => 12,
        ];
        $contact = new User();
        $form = $this->createForm(UserType::class, $contact);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {

            $repository = $this->getDoctrine()->getRepository(Contact::class);
            $user = $repository->findOneBy(["email" => $data->get('email')]);
            
            $em = $this->getDoctrine()->getManager();


            $contact->setPwd(password_hash($contact->getPwd(), PASSWORD_BCRYPT, $options));

            $em->persist($contact);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));*/
        //$user = $this->getUser();
       

      /*  return $this->json([
            'user' => $this->getUser() ? $this->getUser()->getId() : null]
        );
    }*/
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
           if($contact){
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($contact);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view(['status' => 'error'], Response::HTTP_NOT_FOUND));
    }
}
