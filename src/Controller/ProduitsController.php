<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use Doctrine\ORM\EntityManager;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/produits')]
class ProduitsController extends AbstractController
{
    private $security;
    private $imagesDirectory;

    public function __construct(Security $security, ParameterBagInterface $parameterBag)
    {
        $this->security = $security;
        $this->imagesDirectory = $parameterBag->get('images_directory');
    }

    #[Route('/', name: 'app_produits_index', methods: ['GET'])]
    public function index(
        ProduitsRepository $produitsRepository,
    ): Response {
        $user = $this->getUser();
        return $this->render('produits/index.html.twig', [
            'produits' => $produitsRepository->findBy(['user' => $user]),
        ]);
    }

    #[Route('/new', name: 'app_produits_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupérer le fichier téléchargé
            $imageFile = $form->get('image')->getData();

            // Vérifier si un fichier a été téléchargé
            if ($imageFile) {
                // Définir un nouveau nom de fichier
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                // Déplacer le fichier dans le répertoire de destination
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'), // Répertoire de destination (configuré dans services.yaml)
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'exception si le déplacement échoue
                }

                // Mettre à jour la propriété 'image' de l'entité Produits avec le nom du fichier
                $produit->setImage($newFilename);

                $produit->setUser($user);
                $entityManager->persist($produit);
                $entityManager->flush();

                return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
            }

            // Associer l'utilisateur actuel au produit
            $user = $this->security->getUser();
            $produit->setUser($user);

            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/details-produit/{id}', name: 'app_produits_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produits_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/supprimer-produit/{id}', name: 'app_produits_delete', methods: ['POST'])]
    public function delete(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
    }
}
