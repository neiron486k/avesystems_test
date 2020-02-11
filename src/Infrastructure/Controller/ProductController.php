<?php

namespace App\Infrastructure\Controller;

use App\Infrastructure\Entity\Product;
use App\Infrastructure\Form\ProductType;
use App\Infrastructure\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends BaseController
{
    /**
     * @param Request $request
     * @param ProductRepository $repository
     * @return JsonResponse
     * @Route("/api/products", name="create_product", methods={"POST"})
     */
    public function create(Request $request, ProductRepository $repository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->submit($data);

        if (!$form->isValid()) {
            return $this->createValidationErrorResponse($form);
        }

        $data = $repository->save($product);
        return $this->json($data->toArray());
    }
}
