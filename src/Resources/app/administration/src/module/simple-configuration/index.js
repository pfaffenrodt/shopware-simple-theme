import deDE from './snippet/de-DE.json';
import enGB from './snippet/en-GB.json';

import './page/simple-configuration-index/index';

Shopware.Module.register('simple-configuration', {
    type: 'plugin',
    name: 'Custom',
    title: 'simple-settings.general.mainMenuItemGeneral',
    description: 'Settings module for the simple theme',
    color: '#62ff80',
    icon: 'default-object-lab-flask',

    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },

    routes: {
        list: {
            component: 'simple-configuration-index',
            path: 'list'
        }
    },

    navigation: [{
        label: 'simple-settings.general.mainMenuItemGeneral',
        color: '#62ff80',
        path: 'simple.configuration.list',
        icon: 'default-web-layout'
    }]
});
