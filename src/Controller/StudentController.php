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
    * @Route("/student/create/{projectId}", name="student_create", methods={"POST"})
    */
    public function create(Request $r, int $projectId): Response
    {
        return $this->render('student/create.html.twig', [
            'projectId' => $projectId,
        ]);
    }

    /**
    * @Route("/student/store/{projectId}", name="student_store", methods={"POST"})
    */
    public function store(Request $r, ValidatorInterface $validator, int $projectId): Response
    {
        $student = new Student();
        $student->
        setName($r->request->get('student_name'))->
        setSurname($r->request->get('student_surname'));

        $project = $this->getDoctrine()->getRepository(Project::class)->find($projectId);
        $student->setProject($project);

        $em = $this->getDoctrine()->getManager();
        $em->persist($student);
        $em->flush();

        return $this->redirectToRoute('project_details', [
            'id' => $projectId,
        ]);
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

        return $this->redirectToRoute('project_details');
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

        return $this->redirectToRoute('project_details');
    }

    /**
    * @Route("/student/assign/{id}", name="student_assign", methods={"POST"})
    */
    public function assign(Request $request, ValidatorInterface $validator, int $id): Response
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);

        $data = json_decode($request->getContent(), true);

        $groupId = $data['groupId'];
        $projectId = $data['projectId'];

        $group = $this->getDoctrine()->getRepository(Group::class)->find($groupId);
        $group->addStudent($student);

        $em = $this->getDoctrine()->getManager();
        $em->persist($group);
        $em->flush();

        return $this->redirectToRoute('project_details', [
            'id' => $projectId,
        ]);
    }
}