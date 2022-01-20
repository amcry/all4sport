<?php

namespace App\Controller;

use App\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class All4SportController extends AbstractController
{
    /**
     * @Route("all4/sport", name="all4_sport")
     */
    public function index(): Response
    {
        $produits = $this->getDoctrine()->getRepository(Produits::class)->findAll();
        return $this->render('all4_sport/index.html.twig', [
            'produits'=>$produits
        ]);

    }
}
