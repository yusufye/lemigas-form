<?php

namespace App\Infolists\Components;

use Filament\Infolists\Components\Component;

class CudeURL extends Component
{
    protected string $view = 'infolists.components.cude-u-r-l';

    public static function make(): static
    {
        return app(static::class);
    }
}
