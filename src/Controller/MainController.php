<?php
namespace App\Controller;
use App\Entity\BranchModel;
use Symfony\Component\HttpClient\HttpClient;
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
        return new JsonResponse($this->getAllBranches());
    }

    /**
     * @Route("/api/branches/detail/{id}")
     */
    public function getBranchDetail($id)
    {
        $branches = $this->getAllBranches();
        foreach($branches as $key => $branch){
            if($branch['internalId'] != $id)
                unset($branches[$key]);
        }
        return new JsonResponse($branches);
    }

    private function getAllBranches()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://www.dpdparcelshop.cz/api/get-all');
        if($response->getStatusCode() != 200){
            return 'External service error';
        }
        
        $content = $response->getContent();
        $content = json_decode($content);

        $branches = array();
        foreach($content->data->items as $item){
            $branch = new BranchModel($item);
            array_push($branches, $branch->getBranchData());
        }
        return $branches;
    }
}
?>