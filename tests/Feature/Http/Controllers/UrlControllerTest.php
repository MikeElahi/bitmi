<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Url;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_stores_the_url_and_returns_it_as_json(): void
    {
        $destination = $this->faker->url;
        $slug = $this->faker->slug;

        $response = $this->postJson(route('urls.store'), [
            'destination' => $destination,
            'slug' => $slug,
        ]);

        $response->assertCreated();
        $response->assertJsonFragment([
            'destination' => $destination,
            'slug' => $slug,
        ]);
        $this->assertDatabaseHas('urls', [
            'destination' => $destination,
            'slug' => $slug,
        ]);
    }

    /**
     * @test
     */
    public function it_returns_the_url_as_json(): void
    {
        $url = Url::factory()->create();

        $response = $this->getJson(route('urls.show', $url));

        $response->assertOk();
        $response->assertJsonFragment([
            'uuid' => $url->uuid,
            'destination' => $url->destination,
            'slug' => $url->slug,
        ]);
    }

    /**
     * @test
     */
    public function it_returns_the_urls_as_json(): void
    {
        $urls = Url::factory()->count(3)->create();

        $response = $this->getJson(route('urls.index'));

        $response->assertOk();
        $response->assertJsonCount(3);
        $response->assertJsonFragment(['data' => [
            [
                'uuid' => $urls[0]->uuid,
                'destination' => $urls[0]->destination,
                'slug' => $urls[0]->slug,
            ],
            [
                'uuid' => $urls[1]->uuid,
                'destination' => $urls[1]->destination,
                'slug' => $urls[1]->slug,
            ],
            [
                'uuid' => $urls[2]->uuid,
                'destination' => $urls[2]->destination,
                'slug' => $urls[2]->slug,
            ],
        ]]);
    }

    /**
     * @test
     */
    public function it_updates_the_url_and_returns_it_as_json(): void
    {
        $url = Url::factory()->create();
        $destination = $this->faker->url;
        $slug = $this->faker->slug;

        $response = $this->putJson(route('urls.update', $url), [
            'destination' => $destination,
            'slug' => $slug,
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'uuid' => $url->uuid,
            'destination' => $destination,
            'slug' => $slug,
        ]);
        $this->assertDatabaseHas('urls', [
            'uuid' => $url->uuid,
            'destination' => $destination,
            'slug' => $slug,
        ]);
    }

    /**
     * @test
     */
    public function it_deletes_the_url_and_returns_no_content(): void
    {
        $url = Url::factory()->create();

        $response = $this->deleteJson(route('urls.destroy', $url));

        $response->assertNoContent();
        $this->assertDatabaseMissing('urls', [
            'uuid' => $url->uuid,
        ]);
    }
}
