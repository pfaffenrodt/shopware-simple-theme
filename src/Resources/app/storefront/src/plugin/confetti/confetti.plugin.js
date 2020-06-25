import Plugin from 'src/plugin-system/plugin.class';
import AddToCartPlugin from 'src/plugin/add-to-cart/add-to-cart.plugin';
import confetti from '../node_modules/canvas-confetti';

export default class Confetti extends AddToCartPlugin {
    init() {
        console.log('okay, se');
        //confetti();
    }
}
