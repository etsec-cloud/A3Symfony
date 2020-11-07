<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class EquipeController extends AbstractController
{
    /**
     * @Route("/equipe", name="equipe")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $equipe = new Equipe;
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $slug = $this->generateUniqueSlug($equipe->getNom());
            $equipe->setSlug($slug);
            $em->persist($equipe);
            $em->flush();
            $this->addFlash(
                'success',
                'Categorie ajoutée');
        }
        $equipes = $em->getRepository(Equipe::class)->findAll();

        return $this->render('equipe/index.html.twig', [
            'equipes' => $equipes,
            'ajout'=>$form->createView()
        ]);
    }

    public function generateUniqueSlug($pseudo)
    {
        $slugger = new AsciiSlugger();
        $slug = $slugger -> slug($pseudo);
        $em = $this->getDoctrine()->getManager();
        $verification = $em ->getRepository(Equipe::class)->findOneBySlug($slug);
        if($verification != null){
            $slug .='-'.uniqid();
        }
        return $slug;
    }
    /**
     * @Route("/equipe/{slug}", name="equipeShow")
     */
    public function equipeShow(Equipe $equipe= null, Request $request)
    {
        if($equipe==null){
            $this->addFlash(
                'erreur',
                'Cette equipe n\'existe pas'
            );
            return $this->redirectToRoute('equipe');
        }
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $slug = $this->generateUniqueSlug($equipe->getNom());
            $equipe->setSlug($slug);
            $em->persist($equipe);
            $em->flush();
            $this->addFlash(
                'success',
                'Categorie modifié');
        } 
        return $this->render('equipe/equipeShow.html.twig', [
            'equipe' => $equipe,
            'modif' => $form->createView()
        ]);
    }
}
