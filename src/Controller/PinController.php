<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PinRepository;
use App\Entity\Pin;

class PinController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PinRepository $pinRepo): Response
    {
        $allPins = $pinRepo->findAll();
        return $this->render(
            'pin/index.html.twig',
            compact('allPins')
        );
    }

    /**
     * @Route("/pin/{id<\d+>}", name="app_pin_show")
     */
    public function show(Pin $pin): Response
    {
        return $this->render(
            'pin/show.html.twig',
            compact('pin')
        );
    }
}
