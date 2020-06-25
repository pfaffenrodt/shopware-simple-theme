<?php declare(strict_types=1);

namespace Sas\Simple\Storefront\Subscriber;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ShowTagsInDetailView
 * @package Simple\Storefront\Subscriber
 */
class ShowTagsInDetailView implements EventSubscriberInterface
{
    /**
     * @var EntityRepositoryInterface
     */
    private $tagRepository;

    public function __construct(EntityRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductPageLoadedEvent::class => 'getAllTags'
        ];
    }

    public function getAllTags(ProductPageLoadedEvent $event): void
    {

        $tagIds = $event->getPage()->getProduct()->getTagIds();

        if($tagIds == null) {
            return;
        }

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsAnyFilter('id', $tagIds));

        $tagResults = $this->tagRepository->search($criteria, $event->getContext());

        $event->getPage()->addExtension('tags', $tagResults);
    }
}
