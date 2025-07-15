<?php

namespace Tests\Browser\Carousel;

use Livewire\Component;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Browser\BrowserTestCase;

class CardCarouselTest extends BrowserTestCase
{
    #[Test]
    public function can_render_card_carousel(): void
    {
        Livewire::visit(new class extends Component
        {
            public function render(): string
            {
                return <<<'HTML'
                <div>
                    <x-carousel :images="[
                        [
                            'src' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-1.webp',
                            'title' => 'Card 1',
                            'description' => 'Description for card 1',
                        ],
                        [
                            'src' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-2.webp',
                            'title' => 'Card 2',
                            'description' => 'Description for card 2',
                        ],
                        [
                            'src' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-3.webp',
                            'title' => 'Card 3',
                            'description' => 'Description for card 3',
                        ],
                        [
                            'src' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-1.webp',
                            'title' => 'Card 4',
                            'description' => 'Description for card 4',
                        ],
                    ]" card-carousel />
                </div>
            HTML;
            }
        })
            ->assertSee('Card 1')
            ->assertSee('Card 2')
            ->assertSee('Card 3')
            ->assertDontSee('Card 4');
    }

    #[Test]
    public function can_navigate_card_carousel(): void
    {
        Livewire::visit(new class extends Component
        {
            public function render(): string
            {
                return <<<'HTML'
                <div>
                    <x-carousel :images="[
                        [
                            'src' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-1.webp',
                            'title' => 'Card 1',
                            'description' => 'Description for card 1',
                        ],
                        [
                            'src' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-2.webp',
                            'title' => 'Card 2',
                            'description' => 'Description for card 2',
                        ],
                        [
                            'src' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-3.webp',
                            'title' => 'Card 3',
                            'description' => 'Description for card 3',
                        ],
                        [
                            'src' => 'https://penguinui.s3.amazonaws.com/component-assets/carousel/default-slide-1.webp',
                            'title' => 'Card 4',
                            'description' => 'Description for card 4',
                        ],
                    ]" card-carousel />
                </div>
            HTML;
            }
        })
            ->assertSee('Card 1')
            ->assertSee('Card 2')
            ->assertSee('Card 3')
            ->assertDontSee('Card 4')
            ->pressAndWaitFor('@tallstackui_carousel_next')
            ->assertSee('Card 2')
            ->assertSee('Card 3')
            ->assertSee('Card 4')
            ->assertDontSee('Card 1');
    }
}