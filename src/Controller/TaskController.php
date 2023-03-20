<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{

    /**
     * @var ManagerRegistry
     */
    public $entityManager ;


    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }

    /**
     * show list of all task 
     * @param TaskRepository $taskRepository
     * @Route("/tasks", name="task_list")
     */
    public function listAction(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findAll()]);
    }

    /**
     * create a task 
     * @param Request $request
     * @IsGranted("ROLE_USER")
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class,$task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setAuthor($this->getUser());
            $this->entityManager->persist($task);
            $this->entityManager->flush();
            $this->addFlash('success','La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * edit a task 
     * @param Task $task
     * @param Request $request
     * @IsGranted("ROLE_USER")
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class,$task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success','La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * change the state of the task 
     * @param Task $task
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->entityManager->flush();
        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.',$task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * delete a task 
     * @param Task $task
     * @IsGranted("ROLE_USER")
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task = null)
    {
        if ($task === null) {
            $this->addFlash('error','Vous ne pouvez pas supprimer cette tâche');
            return $this->redirectToRoute('task_list');
        }

        if (!($task->getAuthor() === $this->getUser() 
        || ($task->getAuthor() === null && $this->isGranted('ROLE_ADMIN') ) )) {
 
            $this->addFlash('error','Vous ne pouvez pas supprimer cette tâche');
            return $this->redirectToRoute('task_list');
 
        }
        
        $this->entityManager->remove($task);
        $this->entityManager->flush();
        $this->addFlash('success','La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
