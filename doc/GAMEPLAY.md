# Gameplay

## Actions

Entities are assigned actions which they can undertale. These actions can be related to a character class,
race, a progresson scale

- Move (or use a movement skill)

The move action literally moves an entity from one tile to another.
From a tile, an entity can only move to tiles visible from that one by moving.

Different types of movement can be allowed to reach different types of tiles from a single tile,
consider a climbing speed compared to a movement speed. The move action can only reach the tiles horizontally visible,
whereas the climb action could be able to reach otherwise unreachable tiles.
