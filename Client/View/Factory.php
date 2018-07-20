<?php declare(strict_types=1);

namespace Zvax\DNDMapper\Client\View;

interface Factory {
    public function make(string $type): \Zvax\DNDMapper\Client\View\View;
}
