<?php declare(strict_types=1);

namespace Sas\Simple;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Plugin;
use Shopware\Storefront\Framework\ThemeInterface;

class SasSimple extends Plugin implements ThemeInterface
{
    public function getThemeConfigPath(): string
    {
        return 'theme.json';
    }

    public function install(Plugin\Context\InstallContext $context): void
    {
        $this->setupCustomFields($context->getContext());
    }

    public function update(Plugin\Context\UpdateContext $context): void
    {
        $this->setupCustomFields($context->getContext());
    }

    public function uninstall(Plugin\Context\UninstallContext $context): void
    {
        parent::uninstall($context);

        if ($context->keepUserData()) {
            return;
        }

        $this->removeCustomFields($context->getContext());
    }

    public function activate(Plugin\Context\ActivateContext $context): void
    {
        $this->setupCustomFields($context->getContext());
        parent::activate($context);
    }

    public function deactivate(Plugin\Context\DeactivateContext $context): void
    {
        parent::deactivate($context);
    }

    public function setupCustomFields(Context $context): void {
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        $customFieldSetProduct = 'faf2e5b89d4b42cb8777acf98ff8f693';
        $customFieldSetProduct = [
            'id' => $customFieldSetProduct,
            'name' => 'sas_simple_theme',
            'config' => [
                "label" => [
                    "en-GB" => "Simple Theme",
                    "de-DE" => "Simple Theme"
                ],
                "translated" => "true"
            ],
            'active' => boolval(1)
        ];
        $customFieldSetRepository->upsert([$customFieldSetProduct], $context);

        /** @var EntityRepositoryInterface $customFieldSetRelationRepository */
        $customFieldSetRelationRepository = $this->container->get('custom_field_set_relation.repository');
        $data = [
            'id' => '75c76dd4203b48769c2efeedbaaf9e15',
            'customFieldSet' => $customFieldSetProduct,
            'entityName' => 'product'
        ];
        $customFieldSetRelationRepository->upsert([$data] , $context);

        $customFieldRepository = $this->container->get('custom_field.repository');
        $data = [
            [
                'id' => 'b8044f8df7134378804e61c38b1c642c',
                'name' => 'sas_product_short_description',
                'type' => 'text',
                'config' => [
                    "label" => [
                        "en-GB" => "Short product description",
                        "de-DE" => "Kurze Produkt Beschreibung"
                    ],
                    "helpText" => [
                        "en-GB" => null,
                        "de-DE" => null
                    ],
                    "componentName" => "sw-field",
                    "customFieldType" => "text",
                    "customFieldPosition" => 1
                ],
                'active' => boolval(1),
                'customFieldSet' => $customFieldSetProduct
            ]
        ];

        $customFieldRepository->upsert($data, $context);
    }

    public function removeCustomFields(Context $context): void {
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        $customFieldSetRepository ->delete([['id' => 'faf2e5b89d4b42cb8777acf98ff8f693']], $context);
    }
}
