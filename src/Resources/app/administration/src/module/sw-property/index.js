import enGB from './snippet/en-GB.json';
import deDE from './snippet/de-DE.json';

Shopware.Locale.extend('en-GB', enGB);
Shopware.Locale.extend('de-DE', deDE);

Shopware.Component.override('sw-property-detail-base', {
    data() {
        return {
            sortingTypes: [
                { value: 'numeric', label: this.$tc('sw-property.detail.numericSortingType') },
                { value: 'alphanumeric', label: this.$tc('sw-property.detail.alphanumericSortingType') },
                { value: 'position', label: this.$tc('sw-property.detail.positionSortingType') }
            ],
            displayTypes: [
                { value: 'media', label: this.$tc('sw-property.detail.mediaDisplayType') },
                { value: 'text', label: this.$tc('sw-property.detail.textDisplayType') },
                { value: 'color', label: this.$tc('sw-property.detail.colorDisplayType') },
                { value: 'size', label: this.$tc('simple-sw-property.detail.sizeDisplayType') }
            ]
        };
    }
});
