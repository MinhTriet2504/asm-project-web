<?php

namespace App\Controller;
use App\Entity\BrandProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\ProductType;
class ProductController extends AbstractController
{
/**
 * @Route("/Product", name="product_list")
 */
public function listAction()
{
    $em = $this->getDoctrine()->getManager();
    $products= $em->getRepository('App\Entity\Product')->findAll();

   
    return $this->render('product/index.html.twig', [
        'products' => $products
    ]);

}

/**
 * @Route("/product/details/{id}", name="product_details")
 */
public
function detailsAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $product= $em->getRepository('App\Entity\Product')->find($id);

   

    return $this->render('product/details.html.twig', [
        'product' => $product
    ]);
}


/**
 * @Route("/product/delete/{id}", name="product_delete")
 */
public function deleteAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $product = $em->getRepository('App\Entity\Product')->find($id);
    $em->remove($product);
    $em->flush();
    
    $this->addFlash(
        'error',
        'product deleted'
    );
    
    return $this->redirectToRoute('product_list');
}

/**
 * @Route("/product/create", name="product_create", methods={"GET","POST"})
 */
public function createAction(Request $request)
{
    $product = new Product();
    $form = $this->createForm(ProductType::class, $product);
    
    if ($this->saveChanges($form, $request, $product)) {
        $this->addFlash(
            'notice',
            'product Added'
        );
        
        return $this->redirectToRoute('product_list');
    }
    
    return $this->render('product/create.html.twig', [
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
 * @Route("/product/edit/{id}", name="product_edit")
 */
public function editAction($id, Request $request)
{
    $em = $this->getDoctrine()->getManager();
    $product = $em->getRepository('App\Entity\Product')->find($id);
    
    $form = $this->createForm(ProductType::class, $product);
    
    if ($this->saveChanges($form, $request, $product)) {
        $this->addFlash(
            'notice',
            'Todo Edited'
        );
        return $this->redirectToRoute('product_list');
    }
    
    return $this->render('product/edit.html.twig', [
        'form' => $form->createView()
    ]);
}

public function deleteAllAction($id)
{ 
    $em = $this->getDoctrine()->getManager();
    $product = $em->getRepository('App\Entity\Product')->findBy(['Brand' => $id]);
    foreach ($product as $item){    
      $em->remove($item);
      $em->flush();
    }
    return true;
}


}

