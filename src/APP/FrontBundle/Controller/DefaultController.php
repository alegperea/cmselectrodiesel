<?php

namespace APP\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('FrontBundle:Default:index.html.twig');
    }

    public function articlesAction() {
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Article')->findAll();

        return $this->render('FrontBundle:Default:articles.html.twig', array(
                    'entities' => $entities,
        ));
    }

}
