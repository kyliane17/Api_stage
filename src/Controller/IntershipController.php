<?php

namespace App\Controller;

use App\Entity\Intership;
use App\Repository\CompagniesRepository;
use App\Repository\IntershipRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class IntershipController extends AbstractController
{
    /**
     * @Route("/api/intership", name="app_intership" ,methods={"GET"}))
     */
    public function index(IntershipRepository $intershipRepository, NormalizerInterface $normalizerInterface): JsonResponse
    {

        $intership = $intershipRepository->findAll();

        $json = json_encode($intership);

        $intershipNormalised = $normalizerInterface->normalize($intership,'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        
        dd($intership, $json, $intershipNormalised);
        
        return $this->json([
            'message' => 'Welcome to your new controller!',
        ]);
    }

    /**
     * @Route("/api/intership", name="app_api_intership_add", methods={"POST"})
     */

     public function add(Request $request ,EntityManagerInterface $entityManager, StudentRepository $studentRepository, CompagniesRepository $compagniesRepository): JsonResponse
     {
         //on attend une requète au format json
         // TODO: Vérifier le Content-type
         // Récupération du body que l'on transforme depuis du json en tableau
         //dd($request->toArray());
 
         $dataFromRequest = $request->toArray();
 
         //**************************************** les données sont vérifier*/
         $students = $studentRepository->find( $dataFromRequest['idstudent'] );
         $compagnies = $compagniesRepository->find( $dataFromRequest['idcompagnies'] );
         $startDate = new \DateTime($dataFromRequest['startdate'] );
         $endDate = new \DateTime($dataFromRequest['endate'] );
 
         //création de nouvelle istances
 
         $intership = new intership();
         $intership->setIdstudent($students);
         $intership->setIdcompagnies($compagnies);
         $intership->setStartdate($startDate);
         $intership->setEndate( $endDate);
         
        
 
         //insertion en base de l'instance student
         $entityManager->persist($intership);
         $entityManager->flush();

         return $this->json([
            'status' => 'Ajout d un nouveau stage Ok ',
            
        ]);
        

     }
}
