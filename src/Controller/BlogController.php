<?php
namespace App\Controller;
use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

// ...
class BlogController extends AbstractController{
public function createAction(DocumentManager $dm)
{
    $product = new Product();
    $product->setName('A Foo Bar');
    // $product->setPrice('19.99');

    $dm->persist($product);
    $dm->flush();

    return new Response('Created product id ' . $product->getId());
}
}
