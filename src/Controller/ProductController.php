<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductForm;
use App\Service\ProductService;
use App\Repository\ProductRepository;
use Psr\Cache\InvalidArgumentException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;

class ProductController extends AbstractController
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

//    /**
//     * @var EntityManagerInterface
//     */
//    private $entityManager;
//
//    public function __construct(
//        ProductRepository $productRepository,
//        EntityManagerInterface $entityManager
//    )
//    {
//        $this->productRepository = $productRepository;
//        $this->entityManager = $entityManager;
//    }

    #[Route('/product', name: 'homepage_product')]
    public function index(Request $request): Response
    {
        return $this->redirectToRoute('app_default');
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface|InvalidArgumentException
     */
    #[Route('/product/create', name: 'create_product')]
    public function createProduct(
        Request $request,
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository
    ): Response {
        $product = new Product();
        $form = $this->createForm(ProductForm::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setCreatedAt(new \DateTime());
            $this->addFlash(
                'success',
                'Your changes were saved!'
            );
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('list_products');
        }
        return $this->render('product/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @throws InvalidArgumentException
     */
    #[Route('/products/list', name: 'list_products')]
    public function listProducts(ProductService $productService): Response
    {
        $product = $productService->getProductsCache();

        return $this->render('product/list.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/product/{productId}/edit', name: 'edit_product')]
    public function editProduct(
        int $productId,
        Request $request,
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository
    ): Response {
        $product = $productRepository->find($productId);
        $form = $this->createForm(ProductForm::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setUpdatedAt(new \DateTime());
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('list_products');
        }
        return $this->render('product/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/product/{productId}/delete', name: 'delete_product')]
    public function deleteProduct(
        int $productId,
        Request $request,
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository
    ): Response {
        $product = $productRepository->find($productId);
        $entityManager->persist($product);
        $productRepository->remove($product, true);
        $entityManager->flush();
        return $this->redirectToRoute('list_products');
    }

//    /**
//     * @param Request $request
//     * @return JsonResponse
//     */
//    public function getAll(Request $request)
//    {
//        $products = $this->productsRepository->findAll();
//        $data = array_map(function (Product $products) {
//            return $this->mapEntityResponse($products);
//        }, $products);
//
//        return new JsonResponse($data);
//    }

}
