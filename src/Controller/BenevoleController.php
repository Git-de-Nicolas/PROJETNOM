<?php


namespace App\Controller;

use App\Repository\BenevoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("/api/benevole")
 */
class BenevoleController extends AbstractRestController
{

    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager,
                                BenevoleRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Rest\Get("")
     */
    public function getAll()
    {
        $benevoles = $this->repository->findAll();

        return $this->json($benevoles);
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function getOne(int $id) // pour en récupérer un seul
    {
        $entity = $this->repository->find($id);

        if ($entity == null) {
            return $this->json("Il n'y a aucun Bénévole pour cet identifiant", 404);
        }

        return $this->json($entity);
    }
}