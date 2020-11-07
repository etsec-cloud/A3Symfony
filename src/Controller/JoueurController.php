<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Form\JoueurType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class JoueurController extends AbstractController
{
    /**
     * @Route("/joueur", name="joueur")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $joueur = new Joueur;
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $slug = $this->generateUniqueSlug($joueur->getPseudo());
            $joueur->setSlug($slug);
            $em->persist($joueur);
            $em->flush();
            $this->addFlash(
                'success',
                'Categorie ajoutée');
        }
        $joueurs = $em->getRepository(Joueur::class)->findAll();

        return $this->render('joueur/index.html.twig', [
            'joueurs' => $joueurs,
            'ajout'=>$form->createView()
        ]);
    }

    public function generateUniqueSlug($pseudo)
    {
        $slugger = new AsciiSlugger();
        $slug = $slugger -> slug($pseudo);
        $em = $this->getDoctrine()->getManager();
        $verification = $em ->getRepository(Joueur::class)->findOneBySlug($slug);
        if($verification != null){
            $slug .='-'.uniqid();
        }
        return $slug;
    }
    /**
     * @Route("/joueur/{slug}", name="show")
     */
    public function show(Joueur $joueur= null, Request $request)
    {
        if($joueur==null){
            $this->addFlash(
                'erreur',
                'Ce joueur n\'existe pas'
            );
            return $this->redirectToRoute('joueur');
        }
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $slug = $this->generateUniqueSlug($joueur->getPseudo());
            $joueur->setSlug($slug);
            $em->persist($joueur);
            $em->flush();
            $this->addFlash(
                'success',
                'Categorie modifié');
        } 
        return $this->render('joueur/show.html.twig', [
            'joueur' => $joueur,
            'modifier' => $form->createView()
        ]);
    }
}
