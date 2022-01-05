<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\Persistence\ManagerRegistry as SubjectManagerRegistry;

class SubjectController extends AbstractController
{
    private $em;
    public function __construct(SubjectManagerRegistry $registry)
    {
        $this->em = $registry;
    }
    /**
* @Route("/subject", name="subject_index")
*/ 
public function subjectIndex(){
    $subjects = $this -> em->getRepository(Subject::class)->findAll();
        return $this -> render ("subject/index.html.twig",
        [
            'subjects' => $subjects
        ]) ;
    }  
    
/**
 * @Route("/subject/detail/{id}" ,name="subject_detail")
 */ 
public function subjectDetail($id){
$subject = $this->em->getRepository(Subject::class)->find($id);
if($subject == null ){
    $this -> addFlash("Error","subject not found");
    return $this-> redirectToRoute("subject_index");
}
return $this -> render("subject/detail.html.twig",
    [
        "subject" => $subject
    ]);
}
/**
 * @Route("/subject/delete/{id}" ,name="subject_delete")
 */ 
public function semesterDelete($id){
    $subject = $this -> em->getRepository(Subject::class)->find($id);
    if($subject == null){
        $this -> addFlash("Error","Delete subject failed");
    }else{
        $manager = $this->em->getManager();
        $manager-> remove($subject);
        $manager->flush();
        $this -> addFlash("Success","Delete subject succeed");
    }
    return $this-> redirectToRoute("subject_index");

}

/**
 * @Route("/subject/add" ,name="subject_add")
 */ 
public function subjectAdd(Request $request){
    $subject = new Subject;
    $form = $this->createForm(SubjectType::class, $subject);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) { 

        // up load and handle cover
        $file = $subject-> getMaterial();
        $fileName = uniqid();
        $fileExtension = $file -> guessExtension(); //jpg
        $coverName = $fileName.".". $fileExtension;
        try{
            $file -> move(
                $this->getParameter('student_cover'), $coverName
            );
        }catch(FileException $e){
            //throwException($e);
        }
        $subject -> setMaterial($coverName);

        //add data to db
        $manager = $this->em->getManager();
        $manager->persist($subject);
        $manager->flush();

        //display messes and redirect subject_index
        $this -> addFlash("Success","Add subject success");
        return $this->redirectToRoute('subject_index');
    }
        return $this -> renderForm("subject/add.html.twig",[
            'form' => $form
        ]);
    }    


/**
 * @Route("/subject/edit/{id}" ,name="subject_edit")
 */ 
public function subjectEdit(Request $request,$id){
    $subject =$this-> em-> getRepository(Subject::class)->find($id);
    $form = $this->createForm(SubjectType::class, $subject);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) 
    { 
        $img = $form['material']->getData();
        if($img != null)
            {
                // up load and handle cover
                $files = $subject -> getMaterial();
                $fileName = uniqid();
                $fileExtension = $files -> guessExtension(); //jpg
                $coverName = $fileName.".". $fileExtension;
                try{
                    $files -> move(
                        $this->getParameter('student_cover'), $coverName
                    );
                }catch(FileException $e){
                    //throwException($e) ;
                }
                $subject -> setMaterial($coverName);
            }
        
        $manager = $this->em->getManager();
        $manager->persist($subject);
        $manager->flush();
        //display messes and redirect subject_index
        $this -> addFlash("Success","edit subject success");
        return $this->redirectToRoute('subject_index');
    }
        return $this -> renderForm("subject/edit.html.twig",[
            'form' => $form
        ]);
    }
}
