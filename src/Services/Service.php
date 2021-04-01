<?php
namespace App\Services;

use App\Entity\Categorie;
use App\Entity\Intervention;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class Service {

    private $twig;
    private $path;
    private $route;
    private $em;

    public function __construct(Environment $twig, RequestStack $route,RequestStack $path,EntityManagerInterface $em){
        $this->route=$route->getCurrentRequest()->attributes->get('_route');
        $this->path=$path->getCurrentRequest()->getRequestUri();
        $this->twig=$twig;

        $this->em = $em;
        /*dump($this->twig);
         die();*/
    }
    public function setpath($path){
        $this->path=$path;
        return $this;

    }
    public function setroute($route){
        $this->route=$route;
        return $this;
    }
    public function getroute(){
        return $this->path;
    }

    public function getpath(){
        return $this->path;
    }

    public  function affichage_titre(){

        $strs = str_replace('_', ' ', $this->route);
        return $strs;

    }

    public function listeCategorie(){
        $repo = $this->em->getRepository(Categorie::class)->createQueryBuilder('c');
        return
            $repo->select('c.libelle')
                ->getQuery()
                ->getResult();
    }


}