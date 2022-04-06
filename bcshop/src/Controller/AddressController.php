<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{


    /**
     * @Route("/addAddress", name="addAddress")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function addAddress(Request $request, EntityManagerInterface $manager){

        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $address->setUser($this->getUser());
            $manager->persist($address);
            $manager->flush();

            return $this->redirectToRoute('profil');
        }
        return $this->renderForm('address/addAddress.html.twig',['form'=> $form]);
    }

    /**
     * @Route("/editAddress{id}", name="editAddress")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function changeAddress(Request $request, EntityManagerInterface $manager, Address $address){


        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $form->getData();
            $address->setUser($this->getUser());
            $manager->persist($address);
            $manager->flush();
            $this->addFlash('message', 'Adresse ajoutée avec succès');

            return $this->redirectToRoute('profil');
        }
        return $this->renderForm('address/editAddress.html.twig', ['form'=>$form]);
    }

    /**
     * @Route ("/deleteAddress{id}", name="deleteAddress")
     * @param Address $address
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAddress(Address $address, EntityManagerInterface $manager){

        $manager->remove($address);
        $manager->flush();
        $this->addFlash('message', 'Addresse supprimée avec succès');

        return $this->redirectToRoute('profil');
    }


}
