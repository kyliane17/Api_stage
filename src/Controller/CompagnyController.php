<?php

namespace App\Controller;

use App\Entity\Compagnies;
use App\Entity\Student;
use App\Repository\CompagniesRepository;
use App\Repository\StudentRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CompagnyController extends AbstractController
{
    /**
     * @Route("/api/compagny", name="app-api-compagny", methods={"GET"})
     */
    public function index( CompagniesRepository $compagniesRepository, NormalizerInterface $normalizer ): JsonResponse
    {



        //Récupérer tout mes students
        // Récupération de tous les étudiants
        $compagnies = $compagniesRepository->findAll();

        // Sérialisation au format JSON
        $json = json_encode($compagnies);
        // Ne va pas fonctionner car les attributs sont en private
        // Il faut normaliser!

        $compagniesNormalised = $normalizer->normalize($compagnies, 'json',[
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // Debug in PostMan
        dd($compagnies, $json, $compagniesNormalised);


        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiStudentController.php',
        ]);
    }

    /**
     * @Route("/api/compagny", name="app_api_student_add", methods={"POST"})
     */

    public function add(Request $request ,EntityManagerInterface $entityManager): JsonResponse
    {
        //on attend une requète au format json
        // TODO: Vérifier le Content-type
        // Récupération du body que l'on transforme depuis du json en tableau
        //dd($request->toArray());

        $dataFromRequest = $request->toArray();

        //**************************************** les données sont vérifier*/

        //création de nouvelle istances

        $compagnies = new Compagnies();
        $compagnies->setNom($dataFromRequest['nom']);
        $compagnies->setStreet($dataFromRequest['street']);
        $compagnies->setZipcode($dataFromRequest['zipcode']);
        $compagnies->setCity( $dataFromRequest['city']);
        $compagnies->setWebsite($dataFromRequest['website']);
        //dd($compagnies);

        //insertion en base de l'instance student
        $entityManager->persist($compagnies);
        $entityManager->flush();

        

        return $this->json([
            'status' => 'Ajout OK',
            
        ]);
    }
}
