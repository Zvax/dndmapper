const HTTP = (() => {
    const getXHR = () => {
        return new XMLHttpRequest();
    };
    return {
        get: url => {
            return new Promise(resolve => {
                const xhr = getXHR();
                xhr.onload = () => {
                    resolve(xhr.responseText)
                };
                xhr.open('GET', url);
                xhr.send();
            });
        }
    };
})();


window.addEventListener('DOMContentLoaded', () => {

    const canvas = document.getElementById('map-viewport');
    let start_x;
    let start_y;
    let origin_x = 0;
    let origin_y = 0;

    if (canvas) {

        const context = canvas.getContext('2d');
        const TILE_WIDTH = 100;
        let TILES = [
            [
                {color: 'black'},
                {color: 'black'},
                {color: 'black'},
            ],
            [
                {color: 'black'},
                {color: 'black'},
                {color: 'black'},
            ],
        ];

        const clear_canvas = () => {
            context.clearRect(0, 0, canvas.width, canvas.height);
        };

        const tick = () => {
            console.groupCollapsed('Drawing tiles.');
            clear_canvas();
            TILES.forEach((row, x) => {
                row.forEach((tile, y) => {
                    console.log('drawing tile %o', tile);
                    context.fillStyle = tile.color;
                    context.fillRect(
                        (x + origin_x) * TILE_WIDTH,
                        (y + origin_y) * TILE_WIDTH,
                        TILE_WIDTH,
                        TILE_WIDTH
                    );
                    context.strokeStyle = tile.selected ? 'blue' : 'white';
                    context.strokeRect(
                        (x + origin_x) * TILE_WIDTH,
                        (y + origin_y) * TILE_WIDTH,
                        TILE_WIDTH,
                        TILE_WIDTH
                    );
                });
            });
            console.groupEnd();
        };

        const toggle_tile = (x, y) => {
            if (TILES[x] && TILES[x][y]) {
                TILES[x][y]['selected'] = TILES[x][y]['selected'] ? !TILES[x][y]['selected'] : 'true';
            }
            tick();
        };

        const pixel_to_grid_coordinates = (x, y) => {
            const grid_x = Math.floor(x / TILE_WIDTH);
            const grid_y = Math.floor(y / TILE_WIDTH);
            return {x: grid_x, y: grid_y};
        };

        const click_event_handler = event => {
            const grid_coordinates = pixel_to_grid_coordinates(event.offsetX, event.offsetY);
            toggle_tile(grid_coordinates.x - origin_x, grid_coordinates.y - origin_y);
            console.groupCollapsed('Click on the grid at %i, %i', grid_coordinates.x, grid_coordinates.y);
            console.log('Pixel client coordinates: %s, %s', event.offsetX, event.offsetY);
            console.groupEnd();
        };

        let changed = false;
        const move_event_handler = event => {
            canvas.removeEventListener('click', click_event_handler);
            const abs_delta_x = Math.abs(event.clientX - start_x);
            if (abs_delta_x > TILE_WIDTH) {
                changed = true;
                const tile_delta_x = Math.floor(abs_delta_x / TILE_WIDTH);
                if (event.clientX < start_x) {
                    origin_x -= tile_delta_x;
                    start_x -= tile_delta_x * TILE_WIDTH;
                } else {
                    origin_x += tile_delta_x;
                    start_x += tile_delta_x * TILE_WIDTH;
                }
            }
            const abs_delta_y = Math.abs(event.clientY - start_y);
            if (abs_delta_y > TILE_WIDTH) {
                changed = true;
                const tile_delta_y = Math.floor(abs_delta_y / TILE_WIDTH);
                if (event.clientY < start_y) {
                    origin_y -= tile_delta_y;
                    start_y -= tile_delta_y * TILE_WIDTH;
                } else {
                    origin_y += tile_delta_y;
                    start_y += tile_delta_y * TILE_WIDTH;
                }
            }
            if (changed) {
                tick();
                changed = false;
            }
        };

        const mouseup_event_handler = event => {
            console.groupCollapsed('Managing the mouseup event.');
            console.log('Mouseup event: %o', event);
            console.log('Deleting mousemove event.');
            window.removeEventListener('mousemove', move_event_handler);
            window.removeEventListener('mouseup', mouseup_event_handler);
            console.groupEnd();
        };

        const mousedown_event_handler = event => {
            console.groupCollapsed('Managing the mousedown Event');
            console.log('Registering the mousemove and mouseup event.');
            canvas.addEventListener('click', click_event_handler);
            window.addEventListener('mousemove', move_event_handler);
            window.addEventListener('mouseup', mouseup_event_handler);
            start_x = event.clientX;
            start_y = event.clientY;
            console.log('mouse down registered on map, x: %s, y: %s', start_x, start_y);
            console.groupEnd();
        };

        console.groupCollapsed('Initiating map stuff.');
        canvas.addEventListener('mousedown', mousedown_event_handler);
        tick(context);
        console.groupEnd();

        HTTP.get('/tiles')
            .then(res => {
                const json = JSON.parse(res);
                console.log('got tiles! %o', json);
                TILES = json['tiles'];
                tick();
            });

        const ws = new WebSocket('ws://localhost:1337/live');
        ws.onmessage = event => {
            console.log(event.data);
        };
        document.getElementById('click').addEventListener('click', () => {
            ws.send('hello from client');
        });
    }
});
