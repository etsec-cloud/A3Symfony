<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Form\JoueurType;
use App\Service\GeneSlug;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
 /**
 * @Route("/joueur")
 */
class JoueurController extends AbstractController
{
    /**
     * @Route("/", name="joueur")
     */
    public function index(Request $request, GeneSlug $geneSlug): Response
    {
        $em = $this->getDoctrine()->getManager();
        $joueur = new Joueur;
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $slug = $geneSlug->generateUniqueSlug($joueur->getPseudo(), 'Joueur');
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

    
    /**
     * @Route("/{slug}", name="show")
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
    /** 
    * @Route("/delete/{slug}", name="delete_joueur")
    */
   public function delete(Joueur $joueur = null){
    if($joueur == null){
        $this->addFlash('erreur', 'Joueur introuvable');
        return $this->redirectToRoute('joueur');
    }

    $em = $this->getDoctrine()->getManager();
    $em->remove($joueur);
    $em->flush();

    $this->addFlash('success', 'Joueur supprimé');
    return $this->redirectToRoute('joueur');
}
}
