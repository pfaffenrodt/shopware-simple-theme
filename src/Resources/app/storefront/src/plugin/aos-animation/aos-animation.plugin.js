import Plugin from 'src/plugin-system/plugin.class';
import AOS from '../node_modules/aos/dist/aos.js';

export default class AosAnimation extends Plugin {
    init() {
        $('.cms-block').attr('data-aos', 'fade-up');
        AOS.init();
    }
}
