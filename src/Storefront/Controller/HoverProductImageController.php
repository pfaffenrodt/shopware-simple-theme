<?php declare(strict_types=1);

namespace Sas\Simple\Storefront\Controller;

use Shopware\Core\Content\Product\Exception\ProductNotFoundException;
use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"sales-channel-api"})
 */
class HoverProductImageController extends StorefrontController
{
    /**
     * @Route("sales-channel-api/v{version}/sas/product/{productId}", name="sas.product.Image", methods={"GET"})
     * @param Context $context
     * @param $productId
     * @param SalesChannelContext $salesChannelContext
     * @return JsonResponse
     * @throws InconsistentCriteriaIdsException
     * @throws ProductNotFoundException
     */
    public function getImage(SalesChannelContext $salesChannelContext, string $productId): JsonResponse
    {

        /** @var EntityRepositoryInterface $productRepository */
        $productRepository = $this->container->get('product.repository');

        /** @var ProductCollection $productCollection */
        $productCollection = $productRepository->search(
            (new Criteria([$productId]))->addAssociation('media'),
            $salesChannelContext->getContext()
        )->getEntities();

        /** @var ProductEntity|null $firstProduct */
        $firstProduct = $productCollection->first();
        $specificProduct = $productCollection->get($productId);

        if ($firstProduct === null) {
            throw new ProductNotFoundException($productId);
        }

        $media = $firstProduct->getMedia();
        if ($media === null) {
            // throw custom exception
        }

       // dd($specificProduct->getMedia()->last()->getMedia());

        return new JsonResponse($specificProduct->getMedia()->last()->getMedia()->getUrl());
    }
}
