<?php

namespace Tests\Feature;

use App\Models\Product;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    public function testHome()
    {
        $this->json('get', '/api')
            ->assertJson(['version' => '1.0.0'])
            ->assertStatus(Response::HTTP_OK);
    }

    public function testList()
    {
        $user = factory(User::class)->create();
        /** @var Collection $products */
        $products = factory(Product::class, 1)->create();

        $this->actingAs($user, 'api')
            ->json('get', '/api/products')
            ->assertJson([
                "current_page" => 1,
                "data" => $products->toArray(),
                "first_page_url" => env('APP_URL') . "/api/products?page=1",
                "from" => 1,
                "last_page" => 1,
                "last_page_url" => env('APP_URL') . "/api/products?page=1",
                "next_page_url" => null,
                "path" => env('APP_URL') . "/api/products",
                "per_page" => 15,
                "prev_page_url" => null,
                "to" => $products->count(),
                "total" => $products->count()
            ])
            ->assertStatus(Response::HTTP_OK);
    }

    public function testShow()
    {
        $user = factory(User::class)->create();
        /** @var Collection $product */
        $product = factory(Product::class)->create();

        $this->actingAs($user, 'api')
            ->json('get', '/api/products/1', $product->toArray())
            ->assertJson($product->toArray())
            ->assertStatus(Response::HTTP_OK);
    }

    public function testCreate()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->make();

        $this->actingAs($user, 'api')
            ->json('post', '/api/products', $product->toArray())
            ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('products', $product->toArray());
    }

    public function testCreateWithErrors()
    {
        $user = factory(User::class)->create();
        /** @var Collection $product */
        $product = factory(Product::class)->make(['price' => '1 dollar']);

        $this->actingAs($user, 'api')
            ->json('post', '/api/products', $product->toArray())
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'price' => ['Поле price должно быть числом.'],
                ],
            ]);

        $this->assertDatabaseMissing('products', $product->toArray());
    }

    public function testCreateSame()
    {
        $user = factory(User::class)->create();
        /** @var Collection $products */
        $products = factory(Product::class, 2)->create();

        $this->actingAs($user, 'api')
            ->json('post', '/api/products', $products->first()->toArray())
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'name' => ['Такое значение поля name уже существует.'],
                ],
            ]);

        $this->assertCount(1, DB::table('products')->where('name', $products->first()->name)->get());
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();
        /** @var Collection $product */
        $product = factory(Product::class)->create();
        $this->assertDatabaseHas('products', $product->toArray());

        $product['price'] = 8500;

        $this->actingAs($user, 'api')
            ->json('put', '/api/products/1', $product->toArray())
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('products', $product->toArray());
    }

    public function testUpdateSame()
    {
        $user = factory(User::class)->create();
        /** @var Collection $products */
        $products = factory(Product::class, 2)->create();
        $product = $products->first();

        $product['name'] = $products->last()->name;

        $this->actingAs($user, 'api')
            ->json('put', '/api/products/1', $product->toArray())
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'name' => ['Такое значение поля name уже существует.'],
                ],
            ]);

        $this->assertCount(1, DB::table('products')->where('name', $products->last()->name)->get());
    }

    public function testUpdateWithErrors()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $this->assertDatabaseHas('products', $product->toArray());

        $product['price'] = '1 dollar';

        $this->actingAs($user, 'api')
            ->json('put', '/api/products/1', $product->toArray())
            ->assertJson([
                'errors' => [
                    'price' => ['Поле price должно быть числом.'],
                ],
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertDatabaseMissing('products', $product->toArray());
    }

    public function testDelete()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $this->assertDatabaseHas('products', $product->toArray());

        $this->actingAs($user, 'api')
            ->json('delete', '/api/products/1', $product->toArray())
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('products', $product->toArray());
    }
}
