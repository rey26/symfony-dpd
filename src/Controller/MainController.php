<?php
namespace App\Controller;
use App\Entity\BranchModel;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController{
     /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('home/main.html.twig');
    }

    /**
     * @Route("/api/branches/all")
     */

    public function getAllBranchesJSON()
    {
        return new JsonResponse(BranchModel::getAllBranches());
    }

    /**
     * @Route("/api/branches/detail/{id}")
     */
    public function getBranchDetail($id)
    {
        return new JsonResponse(BranchModel::getBranchDetail($id));
    }

}
?>