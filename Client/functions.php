<?php declare(strict_types=1);

namespace Zvax\DNDMapper;

use Auryn\Injector;
use Symfony\Component\Yaml\Yaml;
use Templating\Renderer;
use Templating\TwigAdapter;


// TODO get menus from database and context, possibly leveraging auryn's delegation with a factory and a context object
/*
 * this should fetch menus from the database
 * then filter the ones user can see
 * build the array (with children in relevant places) that shows navigation state
 */
function generateMenus(): array
{
    return Yaml::parseFile(__DIR__ . '/../Data/menus.yml');
}

