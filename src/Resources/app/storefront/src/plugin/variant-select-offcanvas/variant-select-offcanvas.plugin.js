import Plugin from 'src/plugin-system/plugin.class';
import HtmlOffCanvas from 'src/plugin/offcanvas/html-offcanvas.plugin';

export default class VariantSelectOffcanvas extends Plugin {
    static options = {
        /**
         * Specifies the text that is prompted to the user
         * @type string
         */
        text: 'seems like there\'s nothing more to see here.',
    };

    init() {
        const that = this;
    }

    getElement(){
        document.getElementById('size-off-canvas').onclick = function() {
            HtmlOffCanvas.open('.product-detail-configurator-type-text', 'right', true, 200);
        };
    }
}
