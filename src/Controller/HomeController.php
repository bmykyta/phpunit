<?php

namespace App\Controller;

use App\Entity\Enclosure;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $enclosures = $doctrine->getRepository(Enclosure::class)->findAll();

        return $this->render('home/index.html.twig', [
            'enclosures' => $enclosures,
        ]);
    }
}
