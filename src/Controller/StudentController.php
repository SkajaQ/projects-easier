<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Group;
use App\Entity\Student;
use App\Entity\Project;

class StudentController extends AbstractController
{
    /**
    * @Route("/project/{id}", methods={"GET"})
    */
    public function getProjectStudents()
    {
        $students = $this->getDoctrine()->getRepository(Student::class)->findBy([],['surname'=>'asc']);
        return $this->render('student/index.html.twig', [
            'student' => $students,
        ]);
    }

    /**
    * @Route("/student/{id}", name="student_index", methods={"GET"})
    */
    public function getStudentById(int $id)
    {
        $students = $this->getDoctrine()->getRepository(Student::class)->findBy($id);
        return $this->render('student/index.html.twig', [
            'student' => $students,
        ]);
    }
    
    /**
    * @Route("/student/create", name="student_create", methods={"GET"})
    */
    public function create(Request $r): Response
    {
        return $this->render('student/create.html.twig', []);
    }

    /**
    * @Route("/student/store", name="student_store", methods={"POST"})
    */
    public function store(Request $r, ValidatorInterface $validator): Response
    {
        $student = new Student();
        $student->
        setName($r->request->get('student_name'))->
        setSurname($r->request->get('student_surname'));

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $project = $this->getDoctrine()->getRepository(Project::class)->find($student->getProjectId());
        //     $student->setProject($project);

        //     $em = $this->getDoctrine()->getManager();
        //     $em->persist($student);
        //     $em->flush();

        //     return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        // }

        $em = $this->getDoctrine()->getManager();
        $em->persist($student);
        $em->flush();

        return $this->redirectToRoute('student_index');
    }

    /**
    * @Route("/student/edit/{id}", name="student_edit", methods={"GET"})
    */
    public function edit(Request $r, int $id): Response
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        
        $student_name = $r->getSession()->getFlashBag()->get('student_name', []);
        $student_surname = $r->getSession()->getFlashBag()->get('student_surname', []);

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'errors' => $r->getSession()->getFlashBag()->get('errors', []),
            'student_name' => $student_name[0] ?? '',
            'student_surname' => $student_surname[0] ?? '',
        ]);
    }

    /**
    * @Route("/student/update/{id}", name="student_update", methods={"POST"})
    */
    public function update(Request $r, ValidatorInterface $validator, int $id): Response
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);

        $student->
        setName($r->request->get('student_name'))->
        setSurname($r->request->get('student_surname'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($student);
        $em->flush();

        return $this->redirectToRoute('student_index');
    }

    /**
    * @Route("/student/delete/{id}", name="student_delete", methods={"POST"})
    */
    public function delete(int $id): Response
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();

        return $this->redirectToRoute('student_index');
    }
}