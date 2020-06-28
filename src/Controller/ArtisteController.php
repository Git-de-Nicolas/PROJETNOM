<?php


namespace App\Controller;


use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/artiste")
 */
class ArtisteController extends AbstractRestController
{

    private $entityManager;
    private $repository; // permet de faire des requêtes

    public function __construct(EntityManagerInterface $entityManager,
                                ArtisteRepository $repository)
    {

        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Rest\Get("")
     */
    public function getAll()
    {
        $artistes = $this->repository->findAll();

        return $this->json($artistes);
    }

    // getAllwithConcert ?

    /**
     * @Rest\Get("/{id}")
     */
    public function getOne(int $id) // pour en récupérer un seul
    {
        $entity = $this->repository->find($id);

        if ($entity == null) {
            return $this->json("Il n'y a aucun Artiste pour cet identifiant", 404);
        }

        return $this->json($entity);
    }

    /**
     * @Rest\Post("")
     */
    public function add(Request $request)
    {

        $artiste = new Artiste();

        $form = $this->createForm(ArtisteType::class, $artiste);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // check if doublon

            $this->entityManager->persist($artiste);
            $this->entityManager->flush();

            return $this->json($artiste);

        } else {
            return $this->json($form, 400);
        }

    }

    /**
     * @Rest\Put("/{id}")
     */
    public function edit(Request $request, int $id)
    {

        $artiste = $this->repository->find($id);

        $form = $this->createForm(ArtisteType::class, $artiste);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // check if doublon

            $this->entityManager->persist($artiste);
            $this->entityManager->flush();

            return $this->json($artiste);

        } else {
            return $this->json($form, 400);
        }
    }

    /**
     * @Rest\Delete("/{id}")
     */
    public function delete(int $id)
    {

        $artiste = $this->repository->find($id);

        if ($artiste == null) {
            return $this->json("Introuvable", 404);
        }

        $this->entityManager->remove($artiste);
        $this->entityManager->flush();

        return $this->json("OK");

    }

}