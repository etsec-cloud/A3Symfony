<?php

namespace App\Controller;

use App\Entity\Tournois;
use App\Form\TournoisType;
use App\Service\GeneSlug;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/tournois")
 */
class TournoisController extends AbstractController
{
    /**
     * @Route("/", name="tournois")
     */
    public function index(Request $request, GeneSlug $geneSlug): Response
    {
        $em = $this->getDoctrine()->getManager();
        $tournois = new Tournois;
        $form = $this->createForm(TournoisType::class, $tournois);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $slug = $geneSlug->generateUniqueSlug($tournois->getNom(), 'Tournois');
            $tournois->setSlug($slug);
            $em->persist($tournois);
            $em->flush();
            $this->addFlash(
                'success',
                'tournois ajoutée');
        }
        $tournoisPlu = $em->getRepository(Tournois::class)->findAll();

        return $this->render('tournois/index.html.twig', [
            'tournois' => $tournoisPlu,
            'ajout'=>$form->createView()
        ]);
    }
    /**
     * @Route("/{slug}", name="equipeShow")
     */
    public function equipeShow(Tournois $tournois= null, Request $request)
    {
        if($tournois==null){
            $this->addFlash(
                'erreur',
                'Cette tournois n\'existe pas'
            );
            return $this->redirectToRoute('tournois');
        }
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(TournoisType::class, $tournois);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $slug = $this->generateUniqueSlug($tournois->getNom());
            $tournois->setSlug($slug);
            $em->persist($tournois);
            $em->flush();
            $this->addFlash(
                'success',
                'tournois modifié');
        } 
        return $this->render('tournois/tournoiShow.html.twig', [
            'tournois' => $tournois,
            'modif' => $form->createView()
        ]);
    }
    /** 
    * @Route("/delete/{slug}", name="delete_tournois")
    */
   public function delete(Tournois $tournois = null){
       if($tournois == null){
           $this->addFlash('erreur', 'Tournois introuvable');
           return $this->redirectToRoute('tournois');
       }

       $em = $this->getDoctrine()->getManager();
       $em->remove($tournois);
       $em->flush();

       $this->addFlash('success', 'tournois supprimé');
       return $this->redirectToRoute('tournois');
   }
}
