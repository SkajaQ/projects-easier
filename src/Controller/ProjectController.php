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

class ProjectController extends AbstractController
{
    /**
    * @Route("/project", name="project_index", methods={"GET"})
    */
    public function index(Request $r): Response
    {
        $projects = $this->getDoctrine()->getRepository(Project::class)->findBy([],['title'=>'asc']);
        return $this->render('project/index.html.twig', [
            'project' => $projects,
        ]);
    }

    /**
    * @Route("/project/create", name="project_create", methods={"GET"})
    */
    public function create(Request $r): Response
    {
        return $this->render('project/create.html.twig', []);
    }

    /**
    * @Route("/project/store", name="project_store", methods={"POST"})
    */
    public function store(Request $r, ValidatorInterface $validator): Response
    {
        $project = new Project();
        $project->
        setTitle($r->request->get('project_title'))->
        setGroups($r->request->get('group_count'))->
        setStudentLimit($r->request->get('project_student_limit'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();

        for ($i = 0; $i < ($r->request->get('group_count')); $i++) {
            $group = new Group();
            $group->setProject($project)->
            setName("Group #".($i+1));
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();
        }
    }

    /**
    * @Route("/project/edit/{id}", name="project_edit", methods={"GET"})
    */
    public function edit(Request $r, int $id): Response
    {
        $project = $this->getDoctrine()->getRepository(Project::class)->find($id);
        
        $project_title = $r->getSession()->getFlashBag()->get('project_title', []);

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'errors' => $r->getSession()->getFlashBag()->get('errors', []),
            'project_title' => $project_title[0] ?? '',
        ]);
    }

    /**
    * @Route("/project/update/{id}", name="project_update", methods={"POST"})
    */
    public function update(Request $r, ValidatorInterface $validator, int $id): Response
    {
        $project = $this->getDoctrine()->getRepository(Project::class)->find($id);

        $project->
        setTitle($r->request->get('title'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();

        return $this->redirectToRoute('project_index');
    }

    /**
    * @Route("/project/delete/{id}", name="project_delete", methods={"POST"})
    */
    public function delete(int $id): Response
    {
        $project = $this->getDoctrine()->getRepository(Project::class)->find($id);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();

        return $this->redirectToRoute('project_index');
    }
}