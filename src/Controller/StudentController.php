<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\throwException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\Persistence\ManagerRegistry as StudentManagerRegistry;

class StudentController extends AbstractController
{
    private $em;
    public function __construct(StudentManagerRegistry $registry)
    {
        $this->em = $registry;
    }
       /**
     * @Route("/student", name="student_index")
     */
 
    public function studentIndex() {
        $students = $this->em->getRepository(Student::class)->findAll();
        return $this->render("student/index.html.twig",
        [
            'students' => $students
        ]);
    }



    /**
     * @Route("/student/delete/{id}", name="student_delete")
     */
    public function studentDelete($id) {
        $student = $this->em->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash("Error","Delete student failed");
        } else {
            $manager = $this->em->getManager();
            $manager->remove($student);
            $manager->flush();
            $this->addFlash("Success","Delete student succeed");
        }
        return $this->redirectToRoute("student_index");
    }

   /**
     * @Route("/student/add", name="student_add")
     */
    public function studentAdd(Request $request) {
        $student = new Student();
        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $student->getCover();
            $imgName = uniqid();
            $imgExtension = $image->guessExtension();
            $imageName = $imgName . "." . $imgExtension;
            try {
              $image->move(
                  $this->getParameter('student_cover'), $imageName
              ); 
            } catch (FileException $e) {
                throwException($e);
            }
            $student->setCover($imageName);
            $manager = $this->em->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash("Success","Add student succeed !");
            return $this->redirectToRoute("student_index");
        }

        return $this->renderForm("student/add.html.twig",
        [
            'form' => $form
        ]);
    }

    /**
     * @Route("/student/edit/{id}", name="student_edit")
     */
    public function studentEdit(Request $request, $id) {
        $student = $this->em->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['cover']->getData(); 
            if ($file != null) { 
                $image = $student->getCover();
                $imgName = uniqid();
                $imgExtension = $image->guessExtension();
                $imageName = $imgName . "." . $imgExtension;
                try {
                $image->move(
                    $this->getParameter('student_cover'), $imageName
                ); 
                } catch (FileException $e) {
                    throwException($e);
                }
                $student->setCover($imageName);
            }
            
            $manager = $this->em->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash("Success","Edit student succeed !");
            return $this->redirectToRoute("student_index");
        }

        return $this->renderForm("student/edit.html.twig",
        [
            'form' => $form
        ]);
    }

    /**
     * @Route("/student/sort/asc", name="sort_student_id_asc")
     */
    public function sortStudentByIdAsc (StudentRepository $repository) {
        $students = $repository->sortIdAsc();
        return $this->render("student/index.html.twig",
        [
            'student' => $students
        ]);
    }

     /**
     * @Route("/student/sort/desc", name="sort_student_id_desc")
     */
    public function sortStudentByIdDesc (StudentRepository $repository) {
        $students = $repository->sortIdDesc();
        return $this->render("student/index.html.twig",
        [
            'students' => $students
        ]);
    }

    /**
     * @Route("/student/search", name="search_student_title")
     */
    public function searchStudentByTitle (StudentRepository $repository, Request $request) {
        $title = $request->get("title");
        $students = $repository->searchStudent($title);
        return $this->render("student/index.html.twig",
        [
            'students' => $students
        ]);
    }
}