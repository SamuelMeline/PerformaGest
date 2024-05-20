<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Entity\EmergencyContact;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;


#[Route('/patients')]
class PatientsController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
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

        $form = $this->createForm(PatientType::class, $patient); // Utilisez PatientType
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('app_patients_index');
        }

        return $this->render('patients/new.html.twig', [
            'form' => $form->createView(),
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
            'form' => $form->createView(),
            'emergencyContacts' => $patient->getEmergencyContacts()
        ]);
    }
    #[Route('/patients/{id}/delete/{contactID}', name: 'app_patients_supprimer_contact')]
    public function deleteEmergencyContact(Patient $patient, EmergencyContact $contactID, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que le contact d'urgence est bien associé au patient
        if ($patient->getEmergencyContacts()->contains($contactID)) {
            $patient->removeEmergencyContact($contactID);
            $entityManager->remove($contactID);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_patients_edit', ['id' => $patient->getId()]);
    }

    // Modifiez votre route pour autoriser les requêtes GET et POST
    #[Route('/supprimer-patient/{id}', name: 'app_patients_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        // Vérifiez si la requête est POST
        if ($request->isMethod('POST')) {
            // Vérifiez le jeton CSRF
            if ($this->isCsrfTokenValid('delete' . $patient->getId(), $request->request->get('_token'))) {
                $entityManager->remove($patient);
                $entityManager->flush();
            }

            $this->addFlash('success', 'Patient supprimé avec succès');

            return $this->redirectToRoute('app_patients_index', [], Response::HTTP_SEE_OTHER);
        }

        // Si la requête n'est pas POST, redirigez ou renvoyez une erreur, selon votre logique
        // Par exemple, vous pouvez rediriger vers une autre page avec un message d'erreur
        return $this->redirectToRoute('app_patients_index');
    }
}
