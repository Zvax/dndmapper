const menu_opener = (() => {
    let uninitialized = true;
    let bottom;
    const init = () => {
        bottom = document.getElementById('bottom');
        uninitialized = false;
    };
    window.addEventListener('DOMContentLoaded', () => {
        init();
    });
    return {
        handle: event => {
            if (uninitialized) {
                return false;
            }
            console.log('handling escape key press');
            bottom.classList.toggle('hidden');
        }
    };
})();

const KEYS = {
    ESCAPE: 'Escape'
};

const key_handlers = {
    [KEYS.ESCAPE]: menu_opener.handle
};

const key_binding = ((KEYS, key_handlers) => {

    const init = () => {
        window.addEventListener('keydown', event => {
            console.groupCollapsed('Managing keydown.');
            console.log(event);
            if (key_handlers[event.code]) {
                key_handlers[event.code](event);
            }
            console.groupEnd();
        });
    };

    init();

    return {};
})(KEYS, key_handlers);
