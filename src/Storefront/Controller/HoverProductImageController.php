<?php declare(strict_types=1);

namespace Sas\Simple\Storefront\Controller;

use Shopware\Core\Content\Product\Aggregate\ProductMedia\ProductMediaEntity;
use Shopware\Core\Content\Product\Exception\ProductNotFoundException;
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

        /** @var ProductEntity|null $product */
        $product = $productRepository->search(
            (new Criteria([$productId]))->addAssociation('media'),
            $salesChannelContext->getContext()
        )->getEntities()->first();

        if ($product === null) {
            throw new ProductNotFoundException($productId);
        }

        if ($product->getMedia()->count() < 2) {
            throw new \Exception('This product have no image to show');
        }

        /** @var ProductMediaEntity $nextMedia */
        $nextMedia = [];
        foreach ($product->getMedia() as $mediaId => $media) {
            if ($mediaId === $product->getCoverId()) {
                continue;
            }

            $nextMedia = $media;
            break;
        }

        return new JsonResponse($nextMedia->getMedia()->getUrl());
    }
}
