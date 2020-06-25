import Plugin from 'src/plugin-system/plugin.class';
import DomAccess from 'src/helper/dom-access.helper';

export default class Notification extends Plugin {

    init() {
        this.el.addEventListener('click', this._onClickCloseMenuTrigger.bind(this, this.el));
    }

    _onClickCloseMenuTrigger(trigger) {
        const notificationBar = document.getElementsByClassName("notification-bar");
    }
}
