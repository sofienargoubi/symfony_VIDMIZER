<?php

namespace App\Controller;

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
        $globalErrors = $form->getErrors();

        return $this->handleView($this->view(['status' => 'bad', 'errors' => $globalErrors], Response::HTTP_IM_USED));
    }
     /**
     * login user.
     * @Rest\Post("/login")
     *
     * @return Response
     */
    public function login(Request $request): Response
    {
       
        $contact = new User();
        $form = $this->createForm(UserType::class, $contact);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {

            $repository = $this->getDoctrine()->getRepository(User::class);
         
            $user = $repository->findOneBy(["email" => $data["email"]]);

            if($user && password_verify($data["pwd"], $user->getPwd())){
                return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_ACCEPTED));
            }else {
                return $this->handleView($this->view(['status' => 'Invalid Credentials'], Response::HTTP_UNAUTHORIZED));
            }
            
        }
        return $this->handleView($this->view($form->getErrors()));
      
    }
    
}
