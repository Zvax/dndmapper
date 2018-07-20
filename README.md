# DNDMapper

A web platform to create maps usable in the context of a pen and paper DnD game.
Hopefully this would be hosted at dndmapper.fractalesque.org some day.

as such, it features usual layers of a web application
 - application layer, where we manage the requests, response, configurations
 - domain layer, with actual dndmapper entities, relations, validation, creation
 - presentation layer, that renders templates and is fed data
 - authentification layer, to ensure a request can actually invoke the methods it's trying to
 - persistence layer, that contains long term storage of entities
 - service layer, that glues stuff together? like, the layer between domain, application and view?

It should allow
 1. For a GM to create a map of indefinite size with rooms across several floors and adventures in which these map exist.
 2. To create game systems, with races, classes, abilities, and to cast these from a character to an other entity.
 3. For a GM and players to log into a turn based game session and see the same map updated in real time.
 4. Universe wiki

Terms:
 - GM (Game Master)
 - DnD (Dungeons and Dragons, any edition)

## 1. Creating maps and aventures

One of the interface should allow GM's to create arbitrary maps with rooms, floors and event triggers (such as traps).

### Tile

The basic unit of the map is the... map! Maps are composed of tiles.
An entity can move from tile to tile.
Moving from a tile to another one uses a number of movement points.

Tiles can contain entities and objects, that can either be passable or impassable,
and this can be conditional on the entity (or its powers) that wants to pass through it.

A tile can contain a trigger that will dispatch an event when a set of conditions are met, such as a trap.

### Room

An arbitrary set of tiles can be organized as a room. Room can be applied modifiers, events or triggers.

### Floor

Rooms can be arranged in floors,
with passages between two rooms that correspond to stairs or ways to move from a floor to another one.
The game session map will typically show only a specific floor ar a time,
and generally only the part which has been explored by the characters.

Specific players can only see a specific subset of the map.

### Location

Not everything needs to be represented as a map,
characters could be located in a town where they could use the services of a blacksmith or go to the tavern.

### Adventure

An adventure is a set of maps and locations, such as towns. Maps could be reused between adventures.

### Minimal Specs

- Create a tile template that can be reused in a map.
- Link tiles to adjacent tiles.
- Customizes interactions between tiles.

## 2. Creating game systems, races, classes and abilities

There should be an interface, that allows to create a set of rules. These rules would define attributes, which can be... "attributed" to races and classes.

### Game System

The game system consists of an ensemble of actions, attributes, races and classes. Examples could be D20, pathfinder or DnD 5th edition.

### Action

Actions define what a character can do within a game system. They go from spells to simple things like move or jump. These actions can be modified by attributes.

Types of actions
- sequenced actions (casting spells, character class).
  They allow for a subset of action depending on a numeric "level".
  Each level unlocks specific sets of actions.
- simple / flat actions that can either be automatically available to any entity within a system,
  or necessitate a specific attribute / requirement. they are modified by attributes.
   - move
   - jump
   - pick lock

### Attribute

Attributes add modifiers to actions.
Each attribute can be optional or required for an entity to exist within a game system.

Types of attributes
- flat attribute (strength, intelligence). these have a numeric value that evolves during a character life,
  and each value has an associated modifier depending on its value.
- evolving attribute (skill, level). these also have numeric values but are related to a progression scale,
  and are dependant on one or more flat attributes. contrarily to the flat attribute,
  they don't have an associated bonus or malus, they are the bonus or malus, to a set of associated actions.
- "boolean" attribute (feat, access to specific range of actions).
  these are attributes that a character has or does not have.
  They can add modifiers to other attributes or actions, or allows a character to use actions.

### Race

A set of modifiers over flat and evolving attributes.

### Class

A set of sequenced actions (spell list, custom action) and evolving attributes (ranger's bonus against specific races).

### Character

The general entity within a game system. It consists of an ensemble of race, class and attributes.

## 3. Game Session

When a map has been created and characters exist within a game system,
a GM can create a session consisting of an ensemble of players, map game system and characters.
Players and GM can control one or several characters, the GM also has access to actions over the map.

### Player

Players can either be a players in the adventure designated, or the GM.

### Turn

The turns should be automated, with a possibility of limiting the turn time or not.

### Chat

There should be a way for the players to communicate between them, a general chat and private chatrooms.
Players should have a way to communicate without the GM knowing of it,
and there should be a way for the GM to communicate with all the players at once.

## 4. Universe wiki

A section that describes actions, attributes and technical definitions of a system in a wiki-like interface.
It could be a specific game system to give more lore about a specific race or class,
or a system agnostic description of a complex universe.

### Minimal Specs

- Upload pictures and hierarchically organize text (ex. omni outliner).
- A text field to edit and visualize the markdown.
