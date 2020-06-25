import ImageHover from './plugin/image-hover-plugin/image-hover.plugin';

const PluginManager = window.PluginManager;

PluginManager.register('ImageHover', ImageHover, '[data-image-hover-plugin]');

if (module.hot) {
    module.hot.accept();
}
