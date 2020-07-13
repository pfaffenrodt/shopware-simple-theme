import Plugin from 'src/plugin-system/plugin.class';
import StoreApiClient from 'src/service/store-api-client.service';

export default class ImageHover extends Plugin {
    static options = {
        /**
         * selector for the zoom modal
         *
         * @type string
         */
        imageHoverSelector: '.product-image-hover'
    };

    init() {
        this._client = new StoreApiClient();

        this.el.addEventListener('mouseenter', () => {
            if(this.el.dataset.loaded === 'false') {
                this.fetch();
            }
        });
    }

    /**
     * Fetch the current cart widget template by calling the api
     * and persist the response to the browser's session storage
     */
    fetch() {
        this._client.get(`/sales-channel-api/v1/sas/product/${this.el.dataset.productId}`, (response) => {

            const thumbnail = JSON.parse(response);

            const image = new Image();
            image.src = thumbnail;
            image.id = this.el.dataset.productId;
            image.classList.add('product-overlay');

            setTimeout( () => {
                this.el.appendChild(image);
            }, 250);

            this.el.dataset.loaded = true;

        });
    }

    /*
     * Removes the generated image from the DOM
     */
    destroy() {
        this.el.lastChild.remove();
    }
}
