<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Form\PatientsType;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/patients')]
class PatientsController extends AbstractController
{
    private $security;

    public function __construct(SecurityController $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_patients_index', methods: ['GET'])]
    public function index(PatientRepository $patientRepository): Response
    {
        $letters = range('A', 'Z');
        $patients = $patientRepository->findAll();

        return $this->render('patients/index.html.twig', [
            'letters' => $letters,
            'patients' => $patients,
        ]);
    }

    #[Route('/letter/{letter}', name: 'app_patients_by_letter', methods: ['GET'])]
    public function patientsByLetter(PatientRepository $patientRepository, string $letter): Response
    {
        $patients = $patientRepository->findByLetter($letter);

        return $this->render('patients/by_letter.html.twig', [
            'patients' => $patients,
            'letter' => $letter,
        ]);
    }

    #[Route('/new', name: 'app_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('app_patients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patients/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/details-patient/{id}', name: 'app_patients_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patients/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_patients_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
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
    public function delete(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $patient->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_patients_index', [], Response::HTTP_SEE_OTHER);
    }
}