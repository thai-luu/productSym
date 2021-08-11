<?php 

namespace App\Controller;
use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\TokenAuthenticatedController;
use Symfony\Component\HttpFoundation\Session\Session;
class ProductController extends AbstractController
{
    /**
     * @Route("/product/new", name="product-new")
     */
    public function index(): Response
    {
      
        return $this->render('product/index.html.twig'
        );
    }
    /**
     * @Route("/product/save", name="product-save")
     */
    public function createAction(DocumentManager $dm, Request $request)
{ 
    session_start();
   
    if(isset($_SESSION['email'])){
    $product = new Product();
    $name = $request->get('name');
    $price = $request->get('price');
    $product->setName($name);
    $product->setPrice($price);
    $dm->persist($product);
    $dm->flush();

    return $this->redirectToRoute('product-index');
}
    $alert =1;
    return $this->render('security/login.html.twig',['alert' =>$alert]);
}
    /**
     * @Route("/", name="product-index")
     */
    public function showAll(DocumentManager $dm){
        $repository = $dm->getRepository(Product::class);
        $products = $repository->findAll();
        if (! $products) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }
        return $this->render('product/listProduct.html.twig', array('products' => $products));
    }
     /**
     * @Route("/product/update", name="product-update")
     */
    public function update(DocumentManager $dm ,Request $request){
        session_start();
        if(isset($_SESSION['email'])){
        $repository = $dm->getRepository(Product::class);
        
        $id = $request->get('id');
        $product = $repository->find($id);
        $name = $request->get('name');
        $price = $request->get('price');
        $product->setName($name);
        $product->setPrice($price);
        $dm->flush(); 
        return $this->redirectToRoute('product-index');
        }
        
        // if( $request->getMethod() == 'GET'){
        //     $product = $repository->find($id);
        //     return $this->render('product/update.html.twig',['product'=>$product]
                
        //     );
        // }
        $blert =1;
        return $this->render('security/login.html.twig',['blert' =>$blert]);
    }
    /**
     * @Route("/product/edit/{id}", name="product-edit")
     */
    
    public function edit(DocumentManager $dm , $id, Request $request){
        $repository = $dm->getRepository(Product::class);
        $product = $repository->find($id);
       return $this->render('product/edit.html.twig',['product'=>$product]);
    }
    /**
     * @Route("/product/delete/{id}", name="product-delete")
     */
    public function delete(DocumentManager $dm, $id){
        session_start();
        if(isset($_SESSION['email'])){
        $repository = $dm->getRepository(Product::class);
        $product = $repository->find($id);
        $dm->remove($product);
        $dm->flush();
        return $this->redirectToRoute('product-index');
        }
        $blert =1;
        return $this->render('security/login.html.twig',['blert' =>$blert]);
    }
}
