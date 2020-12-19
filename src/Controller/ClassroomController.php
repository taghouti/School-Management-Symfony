<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Symfony\Bridge\Twig\Node\RenderBlockNode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    /**
     * @param ClassroomRepository $repository 
     * @Route("/classroom/affiche", name="affiche")
     * @return Response 
     */
    public function Affiche(ClassroomRepository $repository) :Response 
    {
     $classroom=$repository->findAll(); 
     return $this->render('classroom/affiche.html.twig', [
         'classroom' => $classroom 
     ]
     ); 
    }
    /**
     * 
     * @Route("/classroom/supprimer/{id}", name="delete")
     * @return Response 
     */
    public function supprimer($id, ClassroomRepository $clr)
    {
    $classroom=$clr->find($id); 
    $em=$this->getDoctrine()->getManager(); 
    $em->remove($classroom); 
    $em->flush(); 
    return $this->redirectToRoute('affiche'); // dans la redirection on met le nom de la route et 
    // pas la route elle meme 
    }
    /**
     * 
     * @Route("/classroom/ajouter", name="ajout")
     * @return Response 
     */
    public function ajouter(Request $request){
        // dans l ajout on utilise plutot request et non pas repository car on ne va pas recuperer
        // de la bdd 
    $classroom= new Classroom(); 
    $form= $this->createForm(ClassroomType::class, $classroom) ;   
    $form->add('ajouter',SubmitType::class); 
    $form->handleRequest($request);   
    if ($form->isSubmitted() && $form->isValid())
    {
        $em=$this->getDoctrine()->getManager(); 
        $em->persist($classroom); // persist pour l ajout et remove pour la suppression 
        $em->flush(); 
        return $this->redirectToRoute('affiche'); // redirection avec le nom soit affiche
    }
    return $this->render('classroom/ajouter.html.twig', [
        'f'=>$form->createView() 
    ]); 
    }
    /**
     * 
     * @Route("/classroom/update/{id}", name="modif")
     * @return Response 
     */
    public function modifier($id, Request $request ){
       $classroom= $this->getDoctrine()->getRepository(Classroom::class)->find($id); // si je ne passe 
       // pas rep en paramaetre 
    // si je passe repo en parametre 
    // je ferais tt simplement ca   $classroom=$clr->find($id); 

       $form=$this->createForm(ClassroomType::class, $classroom); // dans 
       // create form je passe en paranetre le type de form soit classroomtype 
       // et le classroom que je vais modifier 
       $form->handleRequest($request); // attendre et voir si le submit a ete fait ou pas 
       //$form->add('ajouter',SubmitType::class); // au lieu de faire l acreation 
       // du submit ici je le fais au ControllerType cad a la forme 
        if ($form->isSubmitted() && $form->isValid() )
        {
            $em=$this->getDoctrine()->getManager(); 
            $em->flush(); 
           return $this->redirectToRoute('affiche'); // dans la redirection on met le nom de la route et 
           
        } 
    return $this->render('classroom/modif.html.twig',['form'=>$form->createView()]); 
    }
}
