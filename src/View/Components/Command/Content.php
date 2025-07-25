<?php

namespace TallStackUi\View\Components\Command;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use TallStackUi\Foundation\Attributes\SoftPersonalization;
use TallStackUi\Foundation\Personalization\Contracts\Personalization;
use TallStackUi\TallStackUiComponent;

#[SoftPersonalization('command.content')]
class Content extends TallStackUiComponent implements Personalization
{
    public function __construct(
        public ?string $group = null,
    ) {
        //
    }

    public function blade(): View
    {
        return view('tallstack-ui::components.command.content');
    }

    public function personalization(): array
    {
        return Arr::dot([
            'wrapper' => 'pb-1 space-y-1',
            'group' => [
                'wrapper' => 'overflow-hidden px-1 text-gray-700 dark:text-dark-300',
                'title' => 'px-2 py-1 my-1 text-xs font-medium text-neutral-500 dark:text-dark-400',
            ],
        ]);
    }
}