<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Patient;
use App\Entity\Consultation;
use DateTime;

class PatientController extends AbstractController
{
    /**
     * @Route("/patient", name="patient")
     */
    public function index()
    {

        // INSERTION D'UN NOUVEAU PATIENT
        $patient = new Patient();
        $consultation = new Consultation();
        $repository = $this->getDoctrine()->getManager()->getRepository(Patient::class);

        // HYDRATATION DU PATIENT
        $patient->setNumSS( '168077151115257' );
        $patient->setNom( 'Watt' );
        $patient->setPrenom( 'Willer' );
        $patient->setDateNaissance( new DateTime( '1978-12-09' ) );
        $patient->setSexe( "M" );

        // RECHERCHE DE L'UTILISATEUR DANS BDD
        $searchPatient = $repository->findBy(
            array(
                'nom'       => $patient->getNom(),
                'prenom'    => $patient->getPrenom(),
                'numSS'    => $patient->getNumSS()
            )
        );

        // SI UTILISATEUR N'EXISTE PAS ALORS ON L'AJOUTE
        if( empty( $searchPatient ) ) {
            // AJOUTER UNE CONSULTATION
            $consultation->setPatient( $patient );
            $consultation->setDateHeure( new DateTime( 'NOW' ) );
            $patient->addConsultation( $consultation );
    
            // RECUPERATION DU SERVICE DOCTRINE
            $doctrine = $this->getDoctrine();
    
            // RECUPERATION DU SERVICE DE GESTIONNE D'ENTITES
            $entityManager = $doctrine->getManager();
    
            // GARDER L'ENTITE PATIENT EN MEMOIRE
            $entityManager->persist( $consultation );
            $entityManager->persist( $patient );
    
            // OUVRE UNE TRANSACTION ET ENREGISTE TOUTES LES ENTITES
            $entityManager->flush();
        }
        
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }

    /**
     * @Route("/patient/list", name="patient_list")
     */
    public function list() {

        $repository = $this->getDoctrine()->getManager()->getRepository(Patient::class);

        $listPatients = $repository->findAll();

        return $this->render('patient/list.html.twig', [
            'controller_name' => 'PatientController',
            'patients'        => $listPatients
        ]);
    }
}
