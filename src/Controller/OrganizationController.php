<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class OrganizationController extends Controller
{
    /**
     * @Route("/", name="organization")
     */
    public function indexAction()
    {
        $repositories = $this->get('app.repository.organization')->findRepositories($this->getParameter('app.organization.name'));

        return $this->render(
            'index.html.twig',
            array(
                'repositories' => $repositories
            )
        );
    }
}
