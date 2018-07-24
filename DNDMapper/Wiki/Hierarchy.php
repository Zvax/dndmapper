<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Wiki;

use Amp;
use Templating;

class Hierarchy
{
    private $elements = [
        [
            'text' => 'elem 1',
            'children' => [
                [
                    'text' => 'elem 1',
                    'children' => 'elem 1',
                ],
                [ 'text' => 'elem 2' ],
                [ 'text' => 'elem 3' ],
                [ 'text' => 'elem 4' ],
            ],
        ],
        [ 'text' => 'elem 2' ],
        [ 'text' => 'elem 3' ],
        [ 'text' => 'elem 4' ],
    ];

    public function getElements(): array
    {
        return $this->elements;
    }
}