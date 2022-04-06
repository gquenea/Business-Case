<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Category;
use App\Entity\User;
use App\Form\AnimalType;
use App\Form\CategoryType;
use App\Form\EditProfilType;
use App\Form\UserType;
use App\Repository\AnimalRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

//    gestion des utilisateurs

    /**
     * @Route("/users/index", name="usersIndex")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function indexUser(UserRepository $userRepository)
    {

        return $this->render('admin/users/index.html.twig',
            ['users' => $userRepository->findAll()]);
    }


    /**
     * @Route("/users/edit{id}", name="usersEdit")
     * @param Request $request
     * @param EntityManagerInterface $manager
     */
    public function editUser(User $user, Request $request, EntityManagerInterface $manager)
    {


        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('message', 'Utilisateur mis à jour');

            return $this->redirectToRoute('usersIndex');
        }
        return $this->renderForm('admin/users/edit.html.twig', ['form' => $form]);
    }

    /**
     * @Route("/users/delete{id}", name="usersDelete")
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteUser(User $user, EntityManagerInterface $manager)
    {

        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('usersIndex');
    }

//    Gestion des animaux

    /**
     * @Route("/animaux/index", name="animauxIndex")
     * @param AnimalRepository $animalRepository
     * @return Response
     */
    public function indexAnimaux(AnimalRepository $animalRepository)
    {

        return $this->render('admin/animaux/index.html.twig',
            ['animaux' => $animalRepository->findAll()]);
    }

    /**
     * @Route("/animaux/new", name="animauxNew")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAnimaux(Request $request, EntityManagerInterface $manager){

        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($animal);
            $manager->flush();

            return $this->redirectToRoute('animauxIndex');
        }
        return $this->renderForm('admin/animaux/new.html.twig',['form'=> $form]);

    }

    /**
     * @Route("animaux/edit{id}", name="animauxEdit")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAnimaux(Animal $animal,Request $request, EntityManagerInterface $manager){


        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $form->getData();
            $manager->persist($animal);
            $manager->flush();

            return $this->redirectToRoute('animauxIndex');
        }
        return $this->renderForm('admin/animaux/edit.html.twig', ['form'=>$form]);
    }


    /**
     * @Route("/animaux/delete{id}", name="animauxDelete")
     * @param Animal $animal
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAnimaux(Animal $animal,EntityManagerInterface $manager){

        $manager->remove($animal);
        $manager->flush();

        return $this->redirectToRoute('animauxIndex');
    }


//    Gestion des categories


    /**
     * @Route("/categories/index", name="categoriesIndex")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function indexCategory(CategoryRepository $categoryRepository)
    {

        return $this->render('admin/categories/index.html.twig',
            ['categories' => $categoryRepository->findAll()]);
    }


    /**
     * @Route("/categories/new", name="categoriesNew")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newCategory(Request $request, EntityManagerInterface $manager){

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('categoriesIndex');
        }

        return $this->renderForm('admin/categories/new.html.twig', ['form'=>$form]);
    }


    /**
     * @Route("categories/edit{id}", name="categoriesEdit")
     * @param Category $category
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editCategory(Category $category, Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $form->getData();
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('categoriesIndex');
        }
        return $this->renderForm('admin/categories/edit.html.twig', ['form'=>$form]);
    }


    /**
     * @Route("categories/delete{id}", name="categoriesDelete")
     * @param Category $category
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCategory(Category $category, EntityManagerInterface $manager){

        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('categoriesIndex');
    }
}
