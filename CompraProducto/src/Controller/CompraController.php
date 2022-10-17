<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompraController extends AbstractController
{
    #[Route('/compra', name: 'app_compra')]
    public function index(): Response{
        return $this->render('compra/index.html.twig', [
            'controller_name' => 'CompraController',
        ]);
    }


    //Se debe poder listar, buscar, editar, insertar y modificar la entidad



    //Modificar esto Y ver QUE necesito


        //Buscar compra 

        //Mostrar una compra por su id
        /**
        * @Route("/provincia/ficha/{codigo}", name="ficha_provincia")
        */
        public function ficha(ManagerRegistry $doctrine, $codigo): Response{
            $repositorio = $doctrine->getRepository(Provincia::class);
            $provincia = $repositorio->find($codigo);
    
            return $this->render('provincia/fichaProvincia.html.twig', ['provincia' => $provincia]);
    
        }
    
    

        //Insertar

    
        //Insertar un formulario y guardar la provincia rellenada
        #[Route('/provincia/nueva', name: "nueva_provincia")]
        public function nuevo(ManagerRegistry $doctrine, Request $request){
            $provincia = new Provincia();
    
            $formulario =  $this->createForm(ProvinciaFormType::class, $provincia);
                        
            $formulario->handleRequest($request);
    
            if($formulario->isSubmitted() && $formulario->isValid()){
                $provincia = $formulario->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($provincia);
                $entityManager->flush();
                return $this->redirectToRoute('ficha_provincia', ["codigo"=>$provincia->getId()]);
            }
            
            return $this->render('provincia/nueva.html.twig', array('formulario' => $formulario->createView()));
    
    
    
        }
            
    
    
    
        //Borrar compra

        #[Route('/provincia/delete/{id}', name: 'eliminar_provincia')]
        public function delete(ManagerRegistry $doctrine, $id): Response{
            $entityManager = $doctrine->getManager();
            $repositorio = $doctrine->getRepository(Provincia::class);
            $provincia = $repositorio->find($id);
            if(! $provincia){
                return $this->render('provincia/fichaProvincia.html.twig', [ 'provincia'=>null]);
            }
    
            try{
                $entityManager->remove($provincia);
                $entityManager->flush();
                return new Response("Provincia eliminada");
            } catch (\Exception $e){
                return new Response("Error eliminando objeto.\nCompruebe que ningún contacto pertenezca a esa provincia");
            }
        }
    


        //Editar
        //Enviar un formulario y modificar la provincia del id dado
        /**
         * @Route("/provincia/editar/{codigo}", name="editar_provincia", requirements={"codigo"="\d+"})
         */
        public function editar(ManagerRegistry $doctrine, Request $request, $codigo){
            
            $repositorio = $doctrine->getRepository(Provincia::class);
            $provincia = $repositorio->find($codigo);
    
            
            $formulario=  $this->createForm(ProvinciaFormType::class, $provincia);
            $formulario->handleRequest($request);
    
            if($formulario->isSubmitted() && $formulario->isValid()){
                $provincia = $formulario->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($provincia);
                $entityManager->flush();
            }
    
            return $this->render('provincia/editar.html.twig', array('formulario' => $formulario->createView()));
        
        }
}
