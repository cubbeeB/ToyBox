<?php

namespace Tests\Feature;

use Database\Seeders\ToyBoxSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->withoutVite();
        $this->seed(ToyBoxSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('ToyBox');
    }

    public function test_public_store_pages_are_available(): void
    {
        $this->withoutVite();
        $this->seed(ToyBoxSeeder::class);

        foreach ([
            route('catalog.index'),
            route('products.show', 'mishka-sonya'),
            route('cart.index'),
            route('about'),
            route('contacts'),
            route('articles.index'),
            route('articles.show', 'kak-vybrat-igrushku-po-vozrastu'),
            route('promotions.index'),
            route('reviews.index'),
            route('login'),
            route('register'),
        ] as $url) {
            $this->get($url)->assertOk();
        }
    }
}
