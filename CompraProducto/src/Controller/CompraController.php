<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Compra;
use App\Entity\Producto;
use App\Form\CompraFormType;
use Doctrine\Persistence\ManagerRegistry ;

use Symfony\Component\HttpFoundation\Request;


class CompraController extends AbstractController
{
    #[Route('/compra', name: 'app_compra')]
    public function index(): Response{
        return $this->render('compra/index.html.twig', [
            'controller_name' => 'CompraController',
        ]);
    }



        //Mostrar una compra por su id
        /**
        * @Route("/compra/ficha/{codigo}", name="ficha_compra")
        */
        public function ficha(ManagerRegistry $doctrine, $codigo): Response{
            $repositorio = $doctrine->getRepository(Compra::class);
            $compra = $repositorio->find($codigo);
    
            return $this->render('compra/fichaCompra.html.twig', ['compra' => $compra]);
    
        }
    
    

        //Insertar

    
        //Insertar un formulario y guardar la compra rellenada
        //Actualizar para que funcione con colecciones de productos 
        #[Route('/compra/nueva', name: "nueva_compra")]
        public function nuevo(ManagerRegistry $doctrine, Request $request){
            $compra = new Compra();
    
            $formulario =  $this->createForm(CompraFormType::class, $compra);
                        
            $formulario->handleRequest($request);
    
            if($formulario->isSubmitted() && $formulario->isValid()){
                $compra = $formulario->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($compra);
                $entityManager->flush();
                return $this->redirectToRoute('ficha_compra', ["codigo"=>$compra->getId()]);
            }
            
            return $this->render('compra/nueva.html.twig', array('formulario' => $formulario->createView()));
    
    
    
        }
            
    
    
    
        //Borrar compra
        #[Route('/compra/delete/{id}', name: 'eliminar_compra')]
        public function delete(ManagerRegistry $doctrine, $id): Response{
            $entityManager = $doctrine->getManager();
            $repositorio = $doctrine->getRepository(Compra::class);
            $compra = $repositorio->find($id);
            if(! $compra){
                return $this->render('compra/fichaCompra.html.twig', [ 'compra'=>null]);
            }
    
            try{
                $entityManager->remove($compra);
                $entityManager->flush();
                return new Response("Compra eliminada");
            } catch (\Exception $e){
                return new Response("Error eliminando objeto.\nCompruebe que dicha compra no esté relacionada con ningún producto");
            }
        }
    


        //Editar
        //Enviar un formulario y modificar la compra del id dado
        /**
         * @Route("/compra/editar/{codigo}", name="editar_compra", requirements={"codigo"="\d+"})
         */
        public function editar(ManagerRegistry $doctrine, Request $request, $codigo){
            
            $repositorio = $doctrine->getRepository(Compra::class);
            $compra = $repositorio->find($codigo);
    
            
            $formulario=  $this->createForm(CompraFormType::class, $compra);
            $formulario->handleRequest($request);
    
            if($formulario->isSubmitted() && $formulario->isValid()){
                $compra = $formulario->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($compra);
                $entityManager->flush();
            }
    
            return $this->render('compra/editar.html.twig', array('formulario' => $formulario->createView()));
        
        }
}
