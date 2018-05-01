<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    public function testHome()
    {
        $response = $this->get('/api');
        $response->assertJson(['version' => '1.0.0']);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testList()
    {
        $user = factory(User::class)->create();
        $products = factory(Product::class)->create();

        $response = $this->actingAs($user, 'api')
            ->get('/api/products');

        $response->assertJson($products);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testShow()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $response = $this->actingAs($user, 'api')
            ->get('/api/products/1', $product);

        $response->assertJson($product);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testCreate()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->make();

        $response = $this->actingAs($user, 'api')
            ->post('/api/products', $product);

        $this->assertDatabaseHas('products', $product);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testCreateWithErrors()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->states(['price' => '1 dollar'])->make();

        $response = $this->actingAs($user, 'api')
            ->post('/api/products', $product);

        $response->assertJsonValidationErrors([
            'Price is failed',
        ]);

        $this->assertDatabaseMissing('products', $product);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $this->assertDatabaseHas('products', $product);

        $product['price'] = 8500;

        $response = $this->actingAs($user, 'api')
            ->put('/api/products/1', $product);

        $this->assertDatabaseHas('products', $product);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdateWithErrors()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class, 'api')->create();
        $this->assertDatabaseHas('products', $product);

        $product['price'] = '1 dollar';

        $response = $this->actingAs($user, 'api')
            ->put('/api/products/1', $product);

        $response->assertJsonValidationErrors([
            'Price is failed',
        ]);

        $this->assertDatabaseMissing('products', $product);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testDelete()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $this->assertDatabaseHas('products', $product);

        $response = $this->actingAs($user, 'api')
            ->delete('/api/products/1', $product);

        $this->assertDatabaseMissing('products', $product);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
