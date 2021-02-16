<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PinRepository;

class PinController extends AbstractController
{
    /**
     * @Route("/", name="app_pin")
     */
    public function index(PinRepository $pinRepo): Response
    {
        $allPins = $pinRepo->findAll();
        return $this->render(
            'pin/index.html.twig',
            compact('allPins')
        );
    }
}
