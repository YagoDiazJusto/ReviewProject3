<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Note;
use App\Repository\CategoryRepository;
use App\Services\CategoryService;
use App\Services\NoteService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response as FlexResponse;

class EntitiesCreation extends AbstractController
{
    #[Route('/notes/create', name: 'createNotes')]
    function notesCreation(NoteService $service, EntityManagerInterface $managerInterface, CategoryRepository $categoryRepository)
    {
        foreach ($service->getNotes() as $n) {
            $category = $categoryRepository->find($n["idCategory"]);
            $note = new Note();
            $note->setDescription($n["description"]);
            $note->setIdCategory($category);
            $managerInterface->persist($note);
            $managerInterface->flush();
        }
        return new Response("You added notes");
    }

    #[Route('/categories/create', name: 'createCategories')]
    function categoriesCreation(CategoryService $service, EntityManagerInterface $managerInterface)
    {
        foreach ($service->getNotes() as $n) {
            $category = new Category();
            $category->setDescription($n["description"]);
            $managerInterface->persist($category);
            $managerInterface->flush();
        }
        return new Response("You added categories");
    }
}
