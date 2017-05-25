<?php
/**
 * Created by PhpStorm.
 * User: markos
 * Date: 12.05.17
 * Time: 16:29
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Tag;
use AppBundle\Form\ProductType;
use AppBundle\Entity\ProductTag;
use AppBundle\Form\TagType;
use Doctrine\Common\Util\Debug;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends Controller
{

    /**
     * @Route("/product/create", name="product_create")
     */

    public function newProduct(Request $request){

        $product = new Product();


        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        //check validation
        //$validator = $this->get('validator');
        //$errors = $validator->validate($product);


        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $product = $form->getData();

            $file = $product->getImage();

            //save file
            $this->saveImage($product, $file);

            //set Date
            $product->setDate(time());

            // tells Doctrine I want to save the Product
            $em->persist($product);

            // executes the queries
            $em->flush();

            //success message for redirection
            $this->addFlash(
                'notice',
                'Saved new product with id '.$product->getId()
            );

            //redirection to products list page
            return $this->redirectToRoute('products_list');
        }

        //rendering page with form
        return $this->render('default/newProduct.html.twig', array(
            'form' => $form->createView()
        ));

    }


    /**
     * @Route("/product/{id}/edit", name="product_edit")
     */
    public function editProduct(Request $request, Product $product, $id){

        $em = $this->getDoctrine()->getManager();

        //remove all associations in jC_ProductsTags for the product with id=$id
        if ($request->isMethod('POST')) {
            $entityTags = $em->getRepository(ProductTag::class)->findBy(
                array('product' => $id)
            );

            if ($entityTags) {
                foreach ($entityTags as $entityTag) {
                    $em->remove($entityTag);
                }
            }

            // executes the queries
            $em->flush();
        }

        //get the original image
        $originalImage = $product->getImage();


        $editForm = $this->createForm(ProductType::class, $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // get the uploaded file
            $files = $request->files;
            $uploadedFile = $files->get('product')['image'];


            if(count($uploadedFile)==0)
                //no uploaded file => set the original image
                $product->setImage($originalImage);
            else { //save file => only if there's an uploaded file

                $this->saveImage($product, $uploadedFile);

                //delete the original image
                $fileDelete = $this->getParameter('images_directory') . '/' . $originalImage;
                if (file_exists($fileDelete)) unlink($fileDelete);
            }

            // executes the queries
            $em->flush();

            //success message for redirection
            $this->addFlash(
                'notice',
                'Product with id '.$product->getId().' updated'
            );

            //redirection to products list page
            return $this->redirectToRoute('products_list');
        }

        //rendering page with form
        return $this->render('default/editProduct.html.twig', array(
            'product' => $product,
            'form' => $editForm->createView()
        ));
    }

    /**
     * @Route("/tag/create")
     */
    public function newTag(Request $request){

        $tag = new Tag();


        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        //check validation
        //$validator = $this->get('validator');
        //$errors = $validator->validate($tag);


        if($form->isSubmitted() && $form->isValid()){
            $tag = $form->getData();

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine I want to save the Tag
            $em->persist($tag);

            try { //executes the queries
                $em->flush();
            }
            catch (UniqueConstraintViolationException $e) { //pay attention: the tag already exist
                //error message for redirection
                $this->addFlash(
                    'notice',
                    'A tag with a name \''.$tag->getName().'\' is already stored in the database'
                );

                //rendering page with form
                return $this->render('default/newTag.html.twig', array(
                    'form' => $form->createView()
                ));
            }

            //success message for redirection
            $this->addFlash(
                'notice',
                'Saved new tag \''.$tag->getName().'\' with id '.$tag->getId()
            );

            //check if I've to back to a specific page
            if($request->query->get('back') != ""){ //build the route to the previous page
                if($request->query->get('id') != "")
                    $url = $this->redirectToRoute($request->query->get('back'), array('id' => $request->query->get('id')));
                else $url = $this->redirectToRoute($request->query->get('back'));
            }else{
                //build the route to the home
                $url = $this->redirectToRoute('home');
            }

            //redirect
            return $url;
        }

        //rendering page with form
        return $this->render('default/newTag.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/product/list", name="products_list")
     */
    public function productsList(){
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository(Product::class);
        $products = $repository->findAll();

        //get Tags for each product
        $tagsProducts = array();
        foreach ($products as $product){

            $productId = $product->getId();

            $entityTags = $em->getRepository(ProductTag::class)->findBy(
                array('product' => $productId)
            );

            $tagsProducts[$productId] = "";
            if ($entityTags) {
                $tagsProduct = "";
                foreach ($entityTags as $entityTag) {
                    if($tagsProduct != '')
                        $tagsProduct .= ' - ';
                    $tagsProduct .= $entityTag->getTag()->getName();
                }
                $tagsProducts[$productId] = $tagsProduct;
            }
        }

        //rendering page with form
        return $this->render('default/productsList.html.twig', array(
            'products' => $products,
            'tags' => $tagsProducts
        ));
    }

    /**
     * @Route("/", name="home")
     */
    public function home(){
        //rendering page
        return $this->render('base.html.twig');
    }

    //save image on the server
    public function saveImage(Product $product, $uploadedFile){

        // Generate a unique name for the file before saving it
        $fileName = md5(uniqid()) . '.' . $uploadedFile->guessExtension();

        //save Image
        $uploadedFile->move(
            $this->getParameter('images_directory'),
            $fileName
        );

        //set Image
        $product->setImage($fileName);

    }
}