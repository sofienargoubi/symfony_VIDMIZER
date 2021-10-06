<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


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

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $options = ['cost' => 12];
            $user->setPwd(password_hash($user->getPwd(), PASSWORD_BCRYPT, $options));
            $em->persist($user);
            $em->flush();

            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }

        return $this->handleView($this->view(['status' => 'bad', 'errors' => $form->getErrors()], Response::HTTP_IM_USED));
    }
    /**
     * login user.
     * @Rest\Post("/login")
     *
     * @return Response
     */
    public function login(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(["email" => $data["email"]]);

        if ($user && password_verify($data["pwd"], $user->getPwd())) {
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_ACCEPTED));
        }

        return $this->handleView($this->view(['status' => 'Invalid Credentials'], Response::HTTP_NON_AUTHORITATIVE_INFORMATION));
    }
}
