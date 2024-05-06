<?php

namespace App\Controller;

use App\Entity\Patients;
use App\Form\PatientsType;
use Doctrine\ORM\EntityManager;
use App\Repository\PatientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/patients')]
class PatientsController extends AbstractController
{
    private $security;
    private $imagesDirectory;

    public function __construct(Security $security, ParameterBagInterface $parameterBag)
    {
        $this->security = $security;
        $this->imagesDirectory = $parameterBag->get('images_directory');
    }

    #[Route('/', name: 'app_patients_index', methods: ['GET'])]
    public function index(
        PatientsRepository $patientsRepository,
    ): Response {
        $user = $this->getUser();
        return $this->render('patients/index.html.twig', [
            'patients' => $patientsRepository->findBy(['user' => $user]),
        ]);
    }

    #[Route('/new', name: 'app_patients_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        $patient = new Patients();
        $form = $this->createForm(PatientsType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Associer l'utilisateur actuel au patient
            $user = $this->security->getUser();
            $patient->setUser($user);

            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('app_patients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patients/new.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/details-patient/{id}', name: 'app_patients_show', methods: ['GET'])]
    public function show(Patients $patient): Response
    {
        return $this->render('patients/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_patients_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patients $patient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PatientsType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_patients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patients/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/supprimer-patient/{id}', name: 'app_patients_delete', methods: ['POST'])]
    public function delete(Request $request, Patients $patient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $patient->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_patients_index', [], Response::HTTP_SEE_OTHER);
    }
}
