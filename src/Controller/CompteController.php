<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Partenaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class CompteController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/api/compteNewPartenaire", name="creation_compte_NewPartenaire", methods={"POST"})
     */
    public function compteNew_Partenaire(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
       
        $values = json_decode($request->getContent());
        if(isset($values->email,$values->password,$values->ninea,$values->montantdepot))
        {
            $datecreation = new \DateTime();
            $depot = new Depot();
            $compte = new Compte();                     
            $user = new User();
            $partenaire = new Partenaire();                                                             
            // AFFECTATION DES VALEURS AUX DIFFERENTS TABLE
                    #####   USER    ######
            $roleRepo = $this->getDoctrine()->getRepository(Role::class);
            $role = $roleRepo->find($values->role);
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setEmail($values->email);
            $user->setPassword($userPasswordEncoder->encodePassword($user, $values->password));
            $user->setRole($role);
            $user->setPartenaire($partenaire);

            $entityManager->persist($user);

                ### Partenaire ###

            $partenaire->setNinea($values->ninea);
            $partenaire->setRc($values->rc);
            $partenaire->setTel($values->tel);
            $partenaire->setAdresse($values->adresse);
            

            $entityManager->persist($partenaire);
            $entityManager->flush();

            ####    GENERATION DU NUMERO DE COMPTE  ####
            $annee = Date('y');
            $cpt = $this->getLastCompte();
            $long = strlen($cpt);
            $ninea2 = substr($partenaire->getNinea() , -2);
            $numcompte = str_pad("SN".$annee.$ninea2, 11-$long, "0").$cpt;
                    #####   COMPTE    ######
            // recuperer de l'utilisateur qui cree le compte et y effectue un depot initial
            $user = $this->tokenStorage->getToken()->getUser();
            $compte->setNumCompte($numcompte);
            $compte->setSolde(0);
            $compte->setDatecreation($datecreation);
            $compte->setUser($user);
            $compte->setPartenaire($partenaire);

            $entityManager->persist($compte);
            $entityManager->flush();
                    #####   DEPOT    ######
            $depot-> setDatedepot($datecreation);
            $depot->setMontantDepot($values->montantdepot);
            $depot->setUser($user);
            $depot->setCompte($compte);

            $entityManager->persist($depot);
            $entityManager->flush();

            ####    MIS A JOUR DU SOLDE DE COMPTE   ####
            $NouveauSolde = ($values->montantdepot+$compte->getSolde());
            $compte->setSolde($NouveauSolde);
            $entityManager->persist($compte);
            $entityManager->flush();
            $data = [
                'status' => 201,
                'message' => 'Le compte du partenaire est bien cree avec un depot initia de: '.$values->montantdepot
            ];
            return new JsonResponse($data, 201);
        }
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner un login et un passwordet un ninea pour le partenaire, le numero de compte ainsi que le montant a deposer'
        ];
        return new JsonResponse($data, 500);
    }
    public function getLastCompte(){
        $ripo = $this->getDoctrine()->getRepository(Compte::class);
        $compte = $ripo->findBy([], ['id'=>'DESC']);
        if(!$compte){
            $cpt = 1;
        }else{
            $cpt = ($compte[0]->getId()+1);
        }
        return $cpt;
      }
       /**
     * @Route("/api/comptePartenaireEx", name="compte_partenaire_ex")
     */
    public function compte_PartenaireExistent(Request $request, EntityManagerInterface $entityManager)
    {
       $values = json_decode($request->getContent());
       if(isset($values->ninea,$values->montantdepot))
       {
           // je controle si l'utilisateur a le droit de creer un compte (appel CompteVoter)
           //$this->denyAccessUnlessGranted('POST_EDIT',$this->getUser());
           $ReposPartenaire = $this->getDoctrine()->getRepository(Partenaire::class);
              // recuperer de l'utilisateur proprietaire du compte
              $partenaire = $ReposPartenaire->findOneByNinea($values->ninea);
          if ($partenaire) 
          {
              if ($values->montantdepot > 0) 
              {
                  $datecreation = new \DateTime();
                  $depot = new Depot();
                  $compte = new Compte();
                  #####   COMPTE    ######
               
                  // recuperer de l'utilisateur qui cree le compte et y effectue un depot initial
                  $user = $this->tokenStorage->getToken()->getUser();

                  ####    GENERATION DU NUMERO DE COMPTE  ####
                  $annee = Date('y');
                  $cpt = $this->getLastCompte();
                  $long = strlen($cpt);
                  $ninea2 = substr($partenaire->getNinea(), -2);
                  $numCompte = str_pad("SN".$annee.$ninea2, 11-$long, "0").$cpt;
                  $compte->setNumCompte($numCompte);
                  $compte->setSolde($values->montantdepot);
                  $compte->setdatecreation($datecreation);
                  $compte->setUser($user);
                  $compte->setPartenaire($partenaire);

                  $entityManager->persist($compte);
                  $entityManager->flush();
                  #####   DEPOT    ######
                  $CompteRepos = $this->getDoctrine()->getRepository(Compte::class);
                  $compte = $CompteRepos->findOneBynumcompte($numCompte);
                  $depot-> setDatedepot($datecreation);
                  $depot->setMontantdepot($values->montantdepot);
                  $depot->setUser($user);
                  $depot->setCompte($compte);

                  $entityManager->persist($depot);
                  $entityManager->flush();
                  $data = [
                      'status' => 201,
                      'message' => 'Le compte du partenaire est bien cree avec un depot initia de: '.$values->montantdepot
                         
                      ];
                  return new JsonResponse($data, 201);
              }
              $data = [
                  'status' => 500,
                  'message' => 'Veuillez saisir un montant de depot valide'
                  ];
                  return new JsonResponse($data, 500);
          }
          $data = [
              'status' => 500,
              'message' => 'Desole le NINEA saisie n est ratache a aucun partenaire'
              ];
              return new JsonResponse($data, 500);
      }
      $data = [
           'status' => 500,
          'message' => 'Vous devez renseigner le ninea du partenaire, le numero de compte ainsi que le montant a deposer'
          ];
          return new JsonResponse($data, 500);
   } 
}