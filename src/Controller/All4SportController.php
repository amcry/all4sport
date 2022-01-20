<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\Avis; 
use App\Form\AvisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
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

    /**
     * @Route("all4/sport/detail/{id<\d+>}", name="all4_sport_detail")
     */
    public function viewProduit($id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $produitRepository = $entityManager->getRepository(Produits::class);
        $produit = $produitRepository->find($id);
        $avisRepository = $entityManager->getRepository(Avis::class);
        $avis = $avisRepository->findAll();
        $avi = new Avis();
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avi = $form->getData();
            $avi->setDateAvis(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $avi->setProduits($produit);
            $avi->setPseudo("Anonyme");
            $entityManager->persist($avi);
            $entityManager->flush();

            return $this->redirectToRoute('all4_sport_detail',array( "id" => $id));
        }

       
        return $this->render('all4_sport/produit_show.html.twig', [
            'produit' => $produit,
            'avis' => $avis,
            'form' => $form->createView(),
        ]);
    }

}
