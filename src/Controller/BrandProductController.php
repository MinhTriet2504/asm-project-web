<?php

namespace App\Controller;
use App\Entity\BrandProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\BrandProductType;
class BrandProductController extends AbstractController
{
/**
 * @Route("/brandProduct", name="brandProduct_list")
 */
public function listAction()
{
    $em = $this->getDoctrine()->getManager();
    $brandProducts= $em->getRepository('App\Entity\BrandProduct')->findAll();

   
    return $this->render('brand_product/index.html.twig', [
        'brandProducts' => $brandProducts
    ]);
}

/**
 * @Route("/brand/product/create", name="brand_product_create", methods={"GET","POST"})
 */
public function createAction(Request $request)
{
    $product = new BrandProduct();
    $form = $this->createForm(BrandProductType::class, $product);
    
    if ($this->saveChanges($form, $request, $product)) {
        $this->addFlash(
            'notice',
            'product Added'
        );
        
        return $this->redirectToRoute('brandProduct_list');
    }
    
    return $this->render('brand_product/create.html.twig', [
        'form' => $form->createView()
    ]);
}

public function saveChanges($form, $request, $product)
{
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $product = $form -> getData();
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        
        return true;
    }
    return false;
}


/**
 * @Route("/brand_product/delete/{id}", name="brandProduct_delete")
 */
public function deleteAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $brandProduct = $em->getRepository('App\Entity\BrandProduct')->find($id);
    $response = $this->forward('App\Controller\ProductController::deleteAllAction', ['id'  =>  $id,]);

    $em->remove($brandProduct);
    $em->flush();
    
    $this->addFlash(
        'error',
        'brand deleted'
    );
    
    return $this->redirectToRoute('brandProduct_list');
}


}
