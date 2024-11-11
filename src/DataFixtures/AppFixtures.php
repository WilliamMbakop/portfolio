<?php

namespace App\DataFixtures;

use App\DataFixtures\Provider\AppProvider;
use App\Entity\Presentation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $description_presentation = " Fort de dix ans d'expérience professionnelle dans le secteur de la banque et de l'assurance, j'ai pris la décision audacieuse de me réorienter vers l'informatique. Cette transition a débuté par le développement web, un domaine où j'ai pu exprimer ma créativité tout en acquérant des compétences techniques solides. Au fil du temps, mon intérêt s'est naturellement dirigé vers les systèmes et réseaux, un secteur dynamique et en constante évolution.

Aujourd'hui, je suis déterminé à me spécialiser dans l'administration de réseaux ou dans la cybersécurité, des domaines qui me passionnent profondément. Mon parcours, marqué par la curiosité et l'envie d'apprendre, reflète ma conviction que l'innovation et la technologie peuvent transformer notre monde. Chaque jour, je m'efforce d'approfondir mes connaissances et de relever de nouveaux défis.

Comme le dit si bien Nelson Mandela : 'Je ne perds jamais. Soit je gagne, soit j'apprends.'

Cette citation incarne ma philosophie : chaque expérience est une occasion de grandir, et je suis résolument engagé à avancer sur ce chemin de découverte et d'excellence";


        $presentation = new Presentation();
        $presentation->setName($_SERVER['AUTHOR_NAME']);
        $presentation->setPicture('http://127.0.0.1:8000/images/avatar-NB.jpg');
        $presentation->setJob('Technicien Systèmes et Réseaux');
        $presentation->setPassion('Passionné de cybersécurité');
        $presentation->setTel($_SERVER['AUTHOR_TEL']);
        $presentation->setEmail($_SERVER['AUTHOR_EMAIL']);
        $presentation->setLocalization('Ile-de-france');
        $presentation->setDescription($description_presentation);

        $manager->persist($presentation);
        $manager->flush();
    }
}
