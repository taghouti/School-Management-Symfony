<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index(StudentRepository $rep): Response
    {
        $student = $rep->getNumberStudent(); 
        dump($student); 
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    /**
     * @Route("/student/list", name="list")
     */
    public function List(StudentRepository $rep)
    {
        $student=$rep->OrderByEmailQb(); 
        return $this->render('student/list.html.twig', [
            'students'=>$student
        ]);
        

    }

    /**
     * @Route("/student/list/{id}", name="list")
     */
    public function ListStudent(StudentRepository $rep, $id)
    {
        $student=$rep->listStudentByClass($id); 
        return $this->render('student/list.html.twig', [
            'students'=>$student
        ]);
        

    }


    
    /**
     * @Route("/student/ajouter", name="ajouter")
     */
    public function ajouter(Request $request) 
    {
        $student = new Student();
        $form= $this->createForm(StudentType::class, $student); // dans createform on met tjs 2 parametres
        // le type de form soit studenttype
        //et  var dans laquelle on stocke l info soit $student
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($student); // eq a insert into student
         $em->flush(); //pour sauvegarder a la bdd
        return $this->redirectToRoute('afficher'); // redirection avec le nom soit affiche
        }
        return $this->render('student/ajouter.html.twig', [
        'form' =>$form->createView() // la vue pour y afficher avec la form remplie en parametre
    ]);
    }
     
    /**
     * @Route("/student/afficher", name="afficher")
     */
     public function afficher(StudentRepository $rep)
     {
         $students=$rep->findAll(); 
         return $this->render('student/afficher.html.twig',[
             'students' =>$students
         ] ); 
     }
     /**
     * @Route("/student/recherche", name="recherche")
     */
    public function recherche (StudentRepository $rep, Request $request){
        $data=$request->get("search"); // c est l info saisie par l utilisateur 
        $student = $rep->findBy([
       'nsc'=> $data // nsc c est le critere de recherche et $data c l info saisie 
       // on les compare comme si on fait select where 
    ]); 
    return $this->render('student/afficher.html.twig',[
        'students'=>$student
    ]); 
    }
    /**
     * 
     * @Route("/Student/supprimer/{id}", name="delete")
     * @return Response 
     */
    public function supprimer($id, StudentRepository $std)
    {
    $student=$std->find($id); 
    $em=$this->getDoctrine()->getManager(); 
    $em->remove($student); 
    $em->flush(); 
    return $this->redirectToRoute('afficher'); // dans la redirection on met le nom de la route et 
    // pas la route elle meme 
    }
      /**
     * 
     * @Route("/Student/modifier/{id}", name="modif")
     * @return Response 
     */
    public function modifier($id, Request $request ){
        $std= $this->getDoctrine()->getRepository(Student::class)->find($id); 
        $form=$this->createForm(StudentType::class, $std);
        $form->handleRequest($request); 
         if ($form->isSubmitted() && $form->isValid() )
         {
             $em=$this->getDoctrine()->getManager(); 
             $em->flush(); 
            return $this->redirectToRoute('afficher'); 
            
         } 
     return $this->render('student/modif.html.twig',['form'=>$form->createView()]); 
     }

    }

