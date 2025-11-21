<?php

namespace App\Controller;

use App\Entity\Data;
use App\Form\DataType;
use App\Repository\DataRepository;
use App\Service\DataExportService;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
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

    #[Route('/data/table', name: 'data_table')]
    public function dataTable(Request $request): Response
    {
        $data = $this->dataRepository->findAll();

        return $this->render('data/_table.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/data/save', name: 'data_save', methods: ['POST'])]
    public function save(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = new Data();
        $data->setUser($this->getUser());

        $form = $this->createForm(DataType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($data);
            $em->flush();

            return new JsonResponse(['status' => 'ok']);
        }

        $html = $this->renderView('data/_form.html.twig', [
            'form' => $form->createView(),
        ]);

        return new JsonResponse(['status' => 'error', 'form' => $html]);
    }

    #[Route('/data/form', name: 'data_form')]
    public function form(Request $request): Response
    {
        $data = new Data();
        $data->setDate(new \DateTime());
        $data->setUser($this->getUser());

        $form = $this->createForm(DataType::class, $data);

        return $this->render('data/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/data/export', name: 'data_export')]
    public function export(DataExportService $exportService): StreamedResponse
    {
        $spreadsheet = $exportService->generateSpreadsheet();
        $writer = $exportService->createWriter($spreadsheet);

        $response = new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="data.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }


}
