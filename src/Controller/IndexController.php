<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations AS FOS;

class IndexController extends AbstractFOSRestController
{
    /**
     * @FOS\Get("/", name="index")
     */
    public function index(): Response
    {
        return $this->handleView($this->view([
            'message' => 'Welcome to the API'
        ]));
    }
}
