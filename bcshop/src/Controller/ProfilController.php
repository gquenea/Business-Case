<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditPasswordType;
use App\Form\EditProfilType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil")
 */
class ProfilController extends AbstractController
{
    #[Route('/', name: 'profil')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }

    /**
     * @Route("/change{id}", name="changeprofil")
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function changeProfil(User $user, Request $request, EntityManagerInterface $manager){

        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $form->getData();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('message', 'Profil mis à jour');

            return $this->redirectToRoute('profil');
        }
        return $this->renderForm('profil/editInfos.html.twig', ['form'=> $form]);
    }

    /**
     * @Route("changepassword{id}", name="changepassword")
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function changePassword(User $user, Request $request,UserPasswordHasherInterface $hashPassword,UserRepository $repository, EntityManagerInterface $manager){

        $user = $this->getUser();
        $form = $this->createForm(EditPasswordType::class, $user);
        $form->handleRequest($request);

        if ($request->isMethod('post')){
            $oldpass = $request->request->get('oldPassword');
            $newpass1 = $request->request->get('newPassword');
            $newpass2 = $request->request->get('newPassword2');


            if ($oldpass!== "" && $newpass1!== "" && $newpass2!== ""){
                $match = $hashPassword->isPasswordValid($user, $oldpass);

                if (!$match){
                    $this->addFlash('message', 'Le mot de passe actuel est incorrect');
                }else{

                    if ($newpass1 === $newpass2){
                        $user->setPassword($hashPassword->hashPassword($user, $oldpass));
                        $manager->persist($user);
                        $manager->flush();
                        $this->addFlash('message', 'Mot de passe mis à jour');

                    }else{
                        $this->addFlash('message', 'Les mots de passe ne sont pas identiques');
                        return $this->redirectToRoute('changepassword', ['id'=>$user->getId()]);

                    }
                }
            }else{
                $this->addFlash('message', 'Certains champs ne sont pas remplis');
            }


            return $this->redirectToRoute('profil');
        }

        return $this->renderForm('profil/editPassword.html.twig', ['form'=> $form]);
    }

    /**
     * @Route("delete{id}", name="deleteprofil")
     * @param EntityManagerInterface $manager
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(EntityManagerInterface $manager, User $user, SessionInterface $session){

        if ($user === $this->getUser()){
            $manager->remove($user);
            $manager->flush();
            $session = new Session();
            $session->invalidate();

        }
        return $this->redirectToRoute('homepage');
    }
}
