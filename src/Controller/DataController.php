<?php

namespace App\Controller;

use App\Repository\DataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DataController extends AbstractController
{
    public function __construct(
        private DataRepository $dataRepository
    ){
    }

    #[Route(path: '/dashboard', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        $data = $this->dataRepository->findAll();

        return $this->render('dashboard.html.twig', [
            'data' => $data,
        ]);
    }
}
