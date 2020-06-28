<?php


namespace App\Controller;

use App\Entity\Concert;
use App\Form\ConcertType;
use App\Repository\ConcertRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/concert")
 */
class ConcertController extends AbstractRestController
{

    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, ConcertRepository $repository)
    {

        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Rest\Get("")
     */
    public function getAll()
    {
        $concerts = $this->repository->findAll();

        return $this->json($concerts);
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function getOne(int $id) // pour en récupérer un seul
    {
        $entity = $this->repository->find($id);

        if ($entity == null) {
            return $this->json("Il n'y a aucun Concert pour cet identifiant", 404);
        }

        return $this->json($entity);
    }


    /**
     * @Rest\Post("")
     */
    public function add(Request $request)
    {
        $concert = new Concert();

        $form = $this->createForm(ConcertType::class, $concert);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            //check if doublon
            $this->entityManager->persist($concert);
            $this->entityManager->flush();

            return $this->json($concert);
        } else {
            return $this->json($form, 400);
        }
    }

    /**
     * @Rest\Put("/{id}")
     */
    public function edit(Request $request, int $id)
    {

        $concert = $this->repository->find($id);

        $form = $this->createForm(ConcertType::class, $concert);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // check if doublon

            $this->entityManager->persist($concert);
            $this->entityManager->flush();

            return $this->json($concert);

        } else {
            return $this->json($form, 400);
        }
    }

    /**
     * @Rest\Delete("/{id}")
     */
    public function delete(int $id)
    {

        $concert = $this->repository->find($id);

        if ($concert == null) {
            return $this->json("Introuvable", 404);
        }

        $this->entityManager->remove($concert);
        $this->entityManager->flush();

        return $this->json("OK");

    }

}