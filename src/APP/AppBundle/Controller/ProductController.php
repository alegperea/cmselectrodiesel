<?php

namespace APP\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use APP\AppBundle\Entity\Product;
use APP\AppBundle\Form\ProductType;

/**
 * Product controller.
 *
 */
class ProductController extends Controller {

    /**
     * Lists all Products entities.
     *
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Product')->findAll();

        return $this->render('AppBundle:Product:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    public function imagenesAction($id) {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->find($id);

        foreach ($product->getImagenes() as $imagen) {

            //get an array which has the names of all the files and loop through it 
            $obj['name'] = $imagen->getPath(); //get the filename in array
            $obj['size'] = filesize("uploads/" . $imagen->getPath()); //get the flesize in array
            $result[] = $obj; // copy it to another array
        }

        $response = new \Symfony\Component\HttpFoundation\Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function uploadAction(Request $request, $id) {

        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
            $doc = $request->files->get('file');

            if (($doc instanceof \Symfony\Component\HttpFoundation\File\UploadedFile)) {

                if (($doc->getSize() < 4000000000)) {
                    $originalName = $doc->getClientOriginalName();
                    $archivo = $doc->getClientOriginalName();
                    $pathName = $doc->getPath();
                    $name_array = explode('.', $originalName);
                    $file_type = $name_array[sizeof($name_array) - 1];

                    $valid_filetypes = array('png', 'jpg', 'jpeg', 'gif');
                    if (in_array(strtolower($file_type), $valid_filetypes)) {

                        //Start Uploading File
                        $product = $em->getRepository("AppBundle:Product")->find($id);

                        $imagen = new \APP\CoreBundle\Entity\Imagen();

                        $imagen->setNombre($originalName);
                        $imagen->setPath($originalName);
                        $imagen->setArchivo($archivo);
                        $imagen->setProduct($product);

                        $imagen->setFile($doc);

                        $imagen->preUpload($file_type);
                        $imagen->upload();

                        $em->persist($imagen);
                        $em->flush();

                        print_r("Subir archivo");
                        exit();
                    } else {
                        print_r("archivo invalido");
                        exit();
                    }
                } else {
                    print_r("Tamaño del archivo exedido");
                    exit();
                }
            } else {
                print_r("Error de archivo");
                exit();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Creates a new Product entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Product();
        $form = $this->CreateForm(ProductType::class, $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $usuario = $this->get('security.token_storage')->getToken()->getUser();
            $entity->setUserAdd($usuario);
            $entity->setUserMod($usuario);
            $entity->setDateAdd(new \DateTime());
            $entity->setDateMod(new \DateTime());
            $entity->setDateUpdate(new \DateTime());
            $entity->setState(Product::published);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('product'));
        }

        return $this->render('AppBundle:Product:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Función para crear Products por Ajax
     */
    public function createAjaxAction(Request $request) {
        if ($request->getMethod() == "POST") {
            $em = $this->getDoctrine()->getManager();
            $name = $request->get('name');
            $entity = new Product();
            $entity->setNombre($name);
            $usuarioAlta = $this->get('security.token_storage')->getToken()->getUser();
            $entity->setUsuarioAlta($usuarioAlta);
            $em->persist($entity);
            $em->flush();
        }

        return $this->render("AppBundle:Default:_newOptionEntity.html.twig", array(
                    'entity' => $entity
        ));
    }

    /**
     * Displays a form to create a new Product entity.
     *
     */
    public function newAction() {
        $entity = new Product();
        $form = $this->CreateForm(ProductType::class, $entity);

        return $this->render('AppBundle:Product:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Product entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createForm(ProductType::class);

        return $this->render('AppBundle:Product:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createForm(ProductType::class, $entity);

        return $this->render('AppBundle:Product:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView()
        ));
    }

    /**
     * Edits an existing Product entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createForm(ProductType::class, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            /** @var $entity Product */
            $usuario = $this->get('security.token_storage')->getToken()->getUser();
            $entity->setDateMod(new \DateTime());
            $entity->setUserMod($usuario);
            $em->persist($entity);
            $em->flush();

            $this->setFlash('success', 'Los cambios se han realizado con éxito');
            return $this->redirect($this->generateUrl('product_edit', array('id' => $id)));
        }

        $this->setFlash('error', 'Ha ocurrido un error');
        return $this->render('AppBundle:Product:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Product entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Product')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('product'));
    }

    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('products_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    private function setFlash($index, $message) {
        $this->get('session')->getFlashBag()->clear();
        $this->get('session')->getFlashBag()->add($index, $message);
    }

}
