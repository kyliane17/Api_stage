<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use App\Services\ApiKeyService;
use App\Services\ApiKeyServices;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Return_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class ApiStudentController extends AbstractController
{
    /**
     * @Route("/api/student", name="app_api_student", methods={"GET"})
     */
    public function index(StudentRepository $studentRepository, NormalizerInterface $normalizer, ApiKeyServices $apiKeyServices, Request $request ): JsonResponse
    {
            
        $authorized = $apiKeyServices->chechApiKey($request, );
       
        
        if($authorized == true)
        {
     

        //Récupérer tout mes students
        // Récupération de tous les étudiants
        $students = $studentRepository->findAll();
        

        // Sérialisation au format JSON
        $json = json_encode($students);
        // Ne va pas fonctionner car les attributs sont en private
        // Il faut normaliser!

        $studentsNormalised = $normalizer->normalize($students, 'json',[
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // Debug in PostMan
        dd($students, $json, $studentsNormalised);
    }
    else{
        return $this->json(['message'=>'relou je dois revoir le code maintenant']);
    }


        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiStudentController.php',
        ]);
    }

    /**
     * @Route("/api/student", name="app_api_student_add", methods={"POST"})
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

        $students = new Student();
        $students->setName($dataFromRequest['name']);
        $students->setFirstName($dataFromRequest['firstname']);
        $students->setPicture($dataFromRequest['picture']);
        $students->setDateOfBirth( new DateTime($dataFromRequest['date_of_birth']));
        $students->setGrade($dataFromRequest['grade']);
        //dd($students);

        //insertion en base de l'instance student
        $entityManager->persist($students);
        $entityManager->flush();

        

        return $this->json([
            'status' => 'Ajout OK',
            
        ]);
    }
}
?>