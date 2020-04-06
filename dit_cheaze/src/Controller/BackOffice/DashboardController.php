<?php


namespace App\Controller\BackOffice;



use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class DashboardController extends AbstractController
{


    /**
     * @Route("/admin/Dashboard", name="admin.dashboard")
     */
    public function index()
    {
        return $this->render('BackOffice/dashboard.html.twig', [

        ]);
    }

}
