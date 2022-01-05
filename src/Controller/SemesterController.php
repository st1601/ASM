<?php

namespace App\Controller;

use App\Entity\Semester;
use App\Form\SemesterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as SemesterManagerRegistry;

class SemesterController extends AbstractController
{
    private $em;
    public function __construct(SemesterManagerRegistry $registry)
    {
        $this->em = $registry;
    }
    /**
 * @Route("/semester", name="semester_index")
 */ 
public function semesterIndex(){
    $semesters = $this -> em->getRepository(Semester::class)->findAll();
        return $this -> render ("semester/index.html.twig",
        [
            'semesters' => $semesters
        ]) ;
    }  
    

/**
 * @Route("/semester/delete/{id}" ,name="semester_delete")
 */ 
public function semesterDelete($id){
    $semester = $this -> em->getRepository(Semester::class)->find($id);
    if($semester == null){
        $this -> addFlash("Error","Delete semester failed");
    }else{
        $manager = $this->em->getManager();
        $manager-> remove($semester);
        $manager->flush();
        $this -> addFlash("Success","Delete semester succeed");
    }
    return $this-> redirectToRoute("semester_index");

}

/**
 * @Route("/semester/add" ,name="semester_add")
 */ 
public function semesterAdd(Request $request){
    $semester = new Semester;
    $form = $this->createForm(SemesterType::class, $semester);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) { 
        $manager = $this->em->getManager();
        $manager->persist($semester);
        $manager->flush();
        $this -> addFlash("Success","Add semester success");
        return $this->redirectToRoute('semester_index');
    }
        return $this -> renderForm("semester/add.html.twig",[
            'form' => $form
        ]);
    }


/**
 * @Route("/semester/edit/{id}" ,name="semester_edit")
 */ 
public function semesterEdit(Request $request, $id){
    
    $semester =$this-> em-> getRepository(Semester::class)->find($id);
    $form = $this->createForm(SemesterType::class, $semester);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) 
    {
        $manager = $this->em->getManager();
        $manager->persist($semester);
        $manager->flush();
        $this -> addFlash("Success","edit semester success");
        return $this->redirectToRoute('semester_index');
    }
        return $this -> renderForm("semester/edit.html.twig",[
            'form' => $form
        ]);
    }
}
