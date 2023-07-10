<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Finder\Finder;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Articles;

use App\Repository\ArticlesRepository;

class MainController extends AbstractController
{

    public function __construct (ArticlesRepository $r) {

        $this->repo = $r ;



    }




    #[Route('/', name: 'app_main' , methods:['GET' , 'POST'])]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $finder = new Finder();



        // ouvrir et Vérifier si le dossier contient des fichiers CSV 

        // pour exemple ce dossier Controller
 
        $finder->files()->in(__DIR__)->name('*.csv');
         $files = array() ;
        foreach ($finder as $file) {
            array_push($files,[ 'name' => basename($file->getRelativePathname()) , 'path' => $file->getRealPath()  ])  ; 
        }





        


        return $this->render('main/index.html.twig', [
            'files' => $files  ,
            'current_directory' => __DIR__
        ]);
    }



    #[Route('/insert/{path}', name: 'app_main_insert' , methods:['GET' , 'POST'])]
    public function insert(EntityManagerInterface $entityManager,$path): Response
    {

            // ouvrir le contenue du ficher 
        
            $csvFile = fopen($path,'r');

            // convertir a une list 
            while (!feof($csvFile) ) {
                $lines[] =  fgetcsv($csvFile);
            }
            array_shift($lines) ;
            fclose($csvFile);
    
    
    
            // insert a la base donnes
            try {
                
                foreach ($lines as $line) {
    
                    $article = $this->repo->find($line[0]);
        
                    if ($article) {
        
                        $article->setDesignation($line[1]);
                        $article->setQuantités($line[2]);
                        $article->setPrix($line[3]);
            
                        $entityManager->persist($article);
            
                        $entityManager->flush();
                       
                    }else if(!$article){
        
                        $article = new Articles();
                        $article->setRéférence($line[0]);
                        $article->setDesignation($line[1]);
                        $article->setQuantités($line[2]);
                        $article->setPrix($line[3]);
            
                        $entityManager->persist($article);
            
                        $entityManager->flush();
        
                    }
        
                  
        
                    
                }; 
            } catch (\Throwable $th) {
                throw $th ;
            }

            $this->addFlash('success', 'inséré avec succès a la table articles');

            return $this->redirectToRoute('app_main');

          

      
    }



        



    
}
