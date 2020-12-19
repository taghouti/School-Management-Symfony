<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClbController extends AbstractController
{
    /**
     * @Route("/clb", name="clb")
     */
    public function index(): Response
    {
        return $this->render('clb/index.html.twig', [
            'controller_name' => 'ClbController',
        ]);
    }

    /**
     * @param $nom
     * @Route("/show/{nom}" , name="nm")
     */
    public function showName($nom): Response {

        return $this->render('clb/index.html.twig', [
        'name' => $nom
        ]); 
    }

    /**
     * @Route("/club/list", name="list")
     */
    public function list() : Response {

        $formations = array(
            array('ref' => 'form147', 'Titre' => 'Formation Symfony
           4','Description'=>'formation pratique',
            'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
           'nb_participants'=>19) ,
            array('ref'=>'form177','Titre'=>'Formation SOA' ,
            'Description'=>'formation
           theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
            'nb_participants'=>0),
            array('ref'=>'form178','Titre'=>'Formation Angular' ,
            'Description'=>'formation
           theorique','date_debut'=>'10/06/2020','date_fin'=>'14/
           06/2020',
                   'nb_participants'=>12)); 

                   return $this->render('clb/list.html.twig', [
                    'formations' => $formations
                ]);
    }
     /**
     * @param $ref
     * @Route("/detail/{ref}", name="details")
     */
    public function detail($ref)
    {
        return $this->render('clb/detail.html.twig', ['ref'=>$ref] ) ; 
    }
 }

