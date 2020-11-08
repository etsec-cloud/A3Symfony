<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Joueur;
use App\Entity\Tournois;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
/**
* @Route("/admin")
*/
{
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $equipes = $em->getRepository(Equipe::class)->findAll();
        $joueurs = $em->getRepository(Joueur::class)->findAll();
        $tournois = $em->getRepository(Tournois::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'tournois'=>$tournois,
            'joueurs'=>$joueurs,
            'equipes'=>$equipes
        ]);
    }
}
