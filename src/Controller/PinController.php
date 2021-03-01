<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PinRepository;
use App\Entity\Pin;
use App\Form\PinType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;


class PinController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="app_home", methods="GET")
     */
    public function index(PinRepository $pinRepo): Response
    {
        $allPins = $pinRepo->findBy([], ['createdAt' => 'DESC']);
        return $this->render(
            'pin/index.html.twig',
            compact('allPins')
        );
    }

    /**
     * @Route("/pin/{id<\d+>}", name="app_pin_show", methods="GET")
     */
    public function show(Pin $pin): Response
    {
        return $this->render(
            'pin/show.html.twig',
            compact('pin')
        );
    }

    /**
     * @Route("/pin/create", name="app_pin_create", methods="GET|POST")
     */
    public function create(Request $req): Response
    {
        if ($this->getUser()){
            $pin = new Pin;
            /*$form = $this->createFormBuilder($pin)
                ->add('title')
                ->add('description')
                ->setMethod('PUT')
                ->setAction('whatever.com')
                ->getForm()
            ;*/
            $form = $this->createForm(PinType::class, $pin);
            $form->handleRequest($req);

            if($form->isSubmitted() && $form->isValid()){
                $pin->setUser($this->getUser());
                //$data = $form->getData();
                $this->em->persist($pin);
                $this->em->flush();
                
                $this->addFlash('success', 'The pin was successfully created');
                return $this->redirectToRoute('app_home');
            } else {
                return $this->render(
                    'pin/create.html.twig',
                    ['form' => $form->createView()]
                );
            }   
        }

        $this->addFlash('warning', 'You must sign in to create a pin');
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/pin/{id<\d+>}/edit", name="app_pin_edit", methods="GET|PUT")
     */
    public function edit(Pin $pin, Request $req): Response
    {
        if ($this->getUser()->getId() == $pin->getUser()->getId()){
            $form = $this->createForm(PinType::class, $pin, [
                'method' => 'PUT'
            ]);
            $form->handleRequest($req);

            if($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();
                $this->em->persist($pin);
                $this->em->flush();
                
                $this->addFlash('success', 'The pin was successfully updated');
                return $this->redirectToRoute('app_home');
            } else {
                return $this->render(
                    'pin/edit.html.twig',
                    ['form' => $form->createView(),
                    'pin' => $pin]
                );
            }  
        } 

        $this->addFlash('warning', 'You can\'t edit that pin.');
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/pin/{id<\d+>}", name="app_pin_delete", methods="DELETE")
     */
    public function delete(Pin $pin, Request $req): Response
    {
        if ($this->getUser()->getId() == $pin->getUser()->getId()){
            if ($this->isCsrfTokenValid('app_pin_delete' . $pin->getId(), $req->request->get('_token'))) {
                $this->em->remove($pin);
                $this->em->flush();

                $this->addFlash('success', 'The pin was successfully deleted');
                return $this->redirectToRoute('app_home');
            }
        }

        // Useless because GET route isn't allowed on the app_pin_delete route
        // $this->addFlash('warning', 'You can\'t delete that pin.');
        // return $this->redirectToRoute('app_home');
    }
    
}
