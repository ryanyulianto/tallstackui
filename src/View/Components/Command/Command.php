<?php

namespace TallStackUi\View\Components\Command;

use Illuminate\Support\Arr;
use Illuminate\Contracts\View\View;
use TallStackUi\TallStackUiComponent;
use TallStackUi\Foundation\Attributes\SkipDebug;
use TallStackUi\Foundation\Attributes\SoftPersonalization;
use TallStackUi\Foundation\Personalization\Contracts\Personalization;

#[SoftPersonalization('command')]
class Command extends TallStackUiComponent implements Personalization
{
    public function __construct(
        public ?string $placeholder = 'Type a command or search...',
        public ?bool $searchable = true,
        public ?int $maxHeight = 400,
        public ?int $minHeight = 300,
        public ?string $id = null,
        #[SkipDebug]
        public ?string $header = null,
    ) {
        $this->id = $this->id ?? 'command-' . uniqid();
    }

    public function blade(): View
    {
        return view('tallstack-ui::components.command.command');
    }

    public function personalization(): array
    {
        return Arr::dot([
            'wrapper' => 'flex min-h-[370px] justify-center w-full max-w-xl items-start',
            'container' => 'flex overflow-hidden flex-col w-full h-full bg-white rounded-lg border shadow-md dark:bg-dark-700 dark:border-dark-600',
            'search' => [
                'wrapper' => 'flex items-center px-3 border-b dark:border-dark-600',
                'icon' => 'mr-0 w-4 h-4 text-neutral-400 shrink-0 dark:text-dark-400',
                'input' => 'flex px-2 py-3 w-full h-11 text-sm bg-transparent rounded-md border-0 outline-none focus:outline-none focus:ring-0 focus:border-0 placeholder:text-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 dark:text-dark-300 dark:placeholder:text-dark-400',
            ],
            'content' => [
                'wrapper' => 'overflow-y-auto overflow-x-hidden',
                'list' => 'pb-1 space-y-1',
                'active' => 'bg-neutral-100 text-gray-900 dark:bg-dark-600 dark:text-dark-200',
                'inactive' => 'text-gray-700 dark:text-dark-300 hover:bg-gray-50 dark:hover:bg-dark-600',
            ],
            'header' => [
                'wrapper' => 'm-2',
            ],
            'group' => [
                'wrapper' => 'overflow-hidden px-1 text-gray-700 dark:text-dark-300',
                'title' => 'px-2 py-1 my-1 text-xs font-medium text-neutral-500 dark:text-dark-400',
            ],
        ]);
    }
}