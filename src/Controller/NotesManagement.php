<?php

namespace App\Controller;

use App\Entity\Note;
use App\Repository\CategoryRepository;
use App\Repository\NoteRepository;
use App\Services\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotesManagement extends AbstractController
{
    #[Route(path: "/", name: "noteList")]
    public function notesList(NoteRepository $noteRepository)
    {
        $notes = $noteRepository->getNotesOrderedByDate();
        $descriptions = [];
        foreach ($notes as $note) {
            array_push($descriptions, $note->getIdCategory()->getDescription());
        }

        return $this->render("allNotes.html.twig", [
            "notes" => $notes,
            "descriptions" => $descriptions,
        ]);
    }

    #[Route(path: "/deleteNote/{description}", name: "deleteNote")]
    public function deleteNote(NoteRepository $noteRepository, $description)
    {
        $note = $noteRepository->findNotesByDescription($description);
        $noteRepository->remove($note);

        return new Response("You deleted a note");
    }

    #[Route(path: "/note/{id}", name: "noteId")]
    public function noteDetail(NoteRepository $noteRepository, CategoryRepository $categoryRepository, $id, Utilities $utilities)
    {
        $note = $noteRepository->find($id);
        $category = $categoryRepository->find($note->getId());
        if ($note != null) {
            return $this->render("specificNote.html.twig", [
                "note" => $note,
                "category" => $category,
                "image" => $utilities->getFile(),
                "prettyDate" => $utilities->formatDate($note->getCreatedAt()),
            ]);
        } else {
            throw $this->createNotFoundException('The product does not exist');
        }
    }

    #[Route(path: "/addNote", name: "addNote")]
    public function addNote(NoteRepository $noteRepository, Request $request, CategoryRepository $categoryRepository)
    {
        $note = new Note();
        $categories = $categoryRepository->findAll();
        $form = $this->createFormBuilder($note)
            ->add('description')
            ->add('createdAt')
            ->add('idCategory', ChoiceType::class, [
                'choices' => [
                    $categories[0]->getDescription() => $categories[0],
                    $categories[1]->getDescription() => $categories[1]
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Save'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $noteRepository->add($post);

            $this->addFlash('success', 'You added a new note');
            return $this->redirectToRoute('addNote');
        }
        return $this->render(
            'Addnotes.html.twig',
            [
                'form' => $form
            ]
        );
    }

    #[Route(path: "/updateNote/{description}", name: "updateNote")]
    public function updateNote(NoteRepository $noteRepository, Request $request, CategoryRepository $categoryRepository, $description)
    {
        $note = $noteRepository->findNotesByDescription($description);
        $categories = $categoryRepository->findAll();
        $form = $this->createFormBuilder($note)
            ->add('description')
            ->add('createdAt')
            ->add('idCategory', ChoiceType::class, [
                'choices' => [
                    $categories[0]->getDescription() => $categories[0],
                    $categories[1]->getDescription() => $categories[1]
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Save'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $noteRepository->add($post);

            return $this->redirectToRoute('noteList');
        }
        return $this->render(
            'updateNotes.html.twig',
            [
                'form' => $form
            ]
        );
    }
}
