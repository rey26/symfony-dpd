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
        $number = random_int(0, 100);
        return $this->render('home/main.html.twig', 
        ['number' => $number]);
    }

    /**
     * @Route("/api/all-branches")
     */

    public function getAllBranches()
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

        return new JsonResponse($branches);
    }
}
?>