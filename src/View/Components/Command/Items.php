<?php

namespace TallStackUi\View\Components\Command;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use TallStackUi\Foundation\Attributes\SoftPersonalization;
use TallStackUi\Foundation\Personalization\Contracts\Personalization;
use TallStackUi\TallStackUiComponent;

#[SoftPersonalization('command.items')]
class Items extends TallStackUiComponent implements Personalization
{
    public function __construct(
        public ?string $href = null,
        public ?string $icon = null,
        public ?string $position = 'left',
        public ?string $shortcut = null,
        public ?bool $default = true,
    ) {
        $this->position = $this->position === 'left' ? 'left' : 'right';
    }

    public function blade(): View
    {
        return view('tallstack-ui::components.command.items');
    }

    public function personalization(): array
    {
        return Arr::dot([
            'wrapper' => 'px-1',
            'item' => [
                'base' => 'relative flex cursor-default select-none items-center rounded-sm cursor-pointer px-2 py-1.5 w-full text-sm outline-none data-[disabled]:pointer-events-none data-[disabled]:opacity-50',
            ],
            'icon' => 'h-4 w-4 mr-2 text-gray-500 dark:text-dark-400',
            'shortcut' => 'ml-auto text-xs tracking-widest text-muted-foreground dark:text-dark-400',
        ]);
    }
}