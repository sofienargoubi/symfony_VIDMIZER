<?php
namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
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
  public function getMovieAction()
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
  public function postMovieAction(Request $request)
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
    * @Route("/contact", methods="GET")
    */
    public function index(ContactRepository $contactRepository)
    {
        $contact = $contactRepository->findAll();

       // return new JsonResponse($contact);
    }

    // this method allows us to accept JSON payloads in POST requests 
// since Symfony 4 doesn't handle that automatically:

protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
{
    $data = json_decode($request->getContent(), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return null;
    }

    if ($data === null) {
        return $request;
    }

    $request->request->replace($data);

   // return $request;
}


    /**
    * @Route("/new_contact", methods="POST")
    */
    public function create(Request $request, ContactRepository $contactRepository, EntityManagerInterface $em)
   {
        $request = $this->transformJsonBody($request);

        if (! $request) {
            //return $this->respondValidationError('Please provide a valid request!');
        }

       //  validate the title
        if (! $request->get('title')) {
         //   return $this->respondValidationError('Please provide a title!');
        }

     //    persist the new contact
    $contact = new Contact;
$contact->setNom($request->get('title'));
        $contact->setPrenom(0);
    $em->persist($contact);
        $em->flush();

      // return $this->respondCreated($contactRepository->transform($contact));
  }


}