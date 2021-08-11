<?php 
namespace App\Controller\apiController;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\TokenAuthenticatedController;
use Symfony\Component\HttpFoundation\Session\Session;
class ApiProductController extends AbstractController
{
    /**
     * @Route("api/product/new", name="product-new")
     */
    // public function index(): Response
    // {
      
    //     return $this->render('product/index.html.twig'
    //     );
    // }
    /**
     * @Route("/api/product/new", name="product-save")
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
     * @Route("/api/listProduct", name="product-index")
     */
    public function showAll(DocumentManager $dm){
        $repository = $dm->getRepository(Product::class);
        $products = $repository->findAll();
        if (! $products) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }
        return $this->json($products);
    }
     /**
     * @Route("/api/product/update", name="product-update")
     */
    public function update(DocumentManager $dm ,Request $request){
        die('111'.$request->request->get('name'));
        
        $repository = $dm->getRepository(Product::class);
        
        $id = $request->request->get('name');
        die('id '.$id);
        $product = $repository->find($id);
        die(var_dump($product));
        $name = $request->request->get('name');
        
        $price = $request->request->get('price');
        $product->setName($name);
        $product->setPrice($price);
        $dm->flush(); 
        
        return $this->redirectToRoute('product-index');
        
        
        // if( $request->getMethod() == 'GET'){
        //     $product = $repository->find($id);
        //     return $this->render('product/update.html.twig',['product'=>$product]
                
        //     );
        // }
        // $blert =1;
        // return $this->render('security/login.html.twig',['blert' =>$blert]);
    }
    /**
     * @Route("/api/product/edit/{id}", name="product-edit")
     */
    
    public function edit(DocumentManager $dm , $id, Request $request){
        $repository = $dm->getRepository(Product::class);
        $product = $repository->find($id);
       return $this->render('product/edit.html.twig',['product'=>$product]);
    }
    /**
     * @Route("/api/product/delete/{id}", name="product-delete")
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
