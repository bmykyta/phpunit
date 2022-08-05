<?php

namespace App\Controller;

use App\Factory\DinosaurFactory;
use App\Repository\EnclosureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private EnclosureRepository $enclosureRepository;

    public function __construct(EnclosureRepository $enclosureRepository)
    {
        $this->enclosureRepository = $enclosureRepository;
    }

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $enclosures = $this->enclosureRepository->findAll();

        return $this->render('home/index.html.twig', [
            'enclosures' => $enclosures,
        ]);
    }

    #[Route('/grow', name: 'grow_dinosaur', methods: ['POST'])]
    public function growAction(Request $request, DinosaurFactory $dinosaurFactory): RedirectResponse
    {
        $enclosure = $this->enclosureRepository->find($request->request->get('enclosure'));

        $specification = $request->request->get('specification');
        $dinosaur      = $dinosaurFactory->growFromSpecification($specification);

        $dinosaur->setEnclosure($enclosure);
        $enclosure->addDinosaur($dinosaur);

        $this->enclosureRepository->add($enclosure, true);

        $this->addFlash(
            'success',
            sprintf(
                'Grew a %s in enclosure #%d',
                mb_strtolower($specification),
                $enclosure->getId()
            )
        );

        return $this->redirectToRoute('homepage');
    }

}
