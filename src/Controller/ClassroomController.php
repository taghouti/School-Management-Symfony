<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    /**
     * @param ClassroomRepository $repository
     * @return Response
     * @Route("/classroom/", name="index")
     */
    public function index(ClassroomRepository $repository): Response
    {
        $classrooms = $repository->findAll();
        return $this->render('classroom/index.html.twig', [
                'classrooms' => $classrooms
            ]
        );
    }

    /**
     * @param int $id
     * @param ClassroomRepository $repository
     * @return Response
     * @Route("/classroom/show/{id}", name="show")
     */
    public function show(int $id, ClassroomRepository $repository): Response
    {
        $classroom = $repository->find($id);
        return $this->render('classroom/show.html.twig', [
                'classroom' => $classroom
            ]
        );
    }

    /**
     * @Route("/classroom/delete/{id}", name="delete")
     * @param int $id
     * @param ClassroomRepository $classroomRepository
     * @return Response
     */
    public function delete(int $id, ClassroomRepository $classroomRepository): Response
    {
        $classroom = $classroomRepository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/classroom/add", name="add")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->add('add', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('index');
        }
        return $this->render('classroom/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/classroom/update/{id}", name="update")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function update(int $id, Request $request): Response
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('index');

        }
        return $this->render('classroom/update.html.twig', ['form' => $form->createView()]);
    }
}
