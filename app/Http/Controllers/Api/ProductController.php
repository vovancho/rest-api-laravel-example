<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

/**
 * @SWG\Swagger(
 *     basePath="/api",
 *     host="rest-api-laravel.local",
 *     schemes={"https"},
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="RestAPI Laravel Example",
 *         description="HTTP JSON API",
 *     ),
 *     @SWG\SecurityScheme(
 *         securityDefinition="OAuth2",
 *         type="oauth2",
 *         flow="password",
 *         tokenUrl="https://rest-api-laravel.local/api/oauth/token"
 *     ),
 *     @SWG\SecurityScheme(
 *         securityDefinition="Bearer",
 *         type="apiKey",
 *         name="Authorization",
 *         in="header"
 *     )
 * )
 */
class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *     path="/products",
     *     description="Вывод всех продуктов",
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Product")
     *         ),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return $this->service->all();
    }

    /**
     * @SWG\Post(
     *     path="/products",
     *     description="Добавление нового продукта",
     *     @SWG\Parameter(
     *         description="Наименование",
     *         in="query",
     *         name="name",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="Стоимость",
     *         in="query",
     *         name="price",
     *         required=true,
     *         type="number",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $this->service->create($request);
        return response('', Response::HTTP_CREATED);
    }

    /**
     * @SWG\Get(
     *     path="/products/{productId}",
     *     description="Вывод продукта с ИД {productId}",
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(ref="#/definitions/Product"),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     *
     * Display the specified resource.
     *
     * @param Product $product
     * @return Response|Model
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * @SWG\Put(
     *     path="/products/{productId}",
     *     description="Обновление продукта с определенным идентификатором",
     *     @SWG\Parameter(
     *         description="ИД продукта",
     *         in="path",
     *         name="productId",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         description="Наименование",
     *         in="query",
     *         name="name",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="Стоимость",
     *         in="query",
     *         name="price",
     *         required=true,
     *         type="number",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     *
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->service->edit($product, $request);
        return response('', Response::HTTP_OK);
    }

    /**
     * @SWG\Delete(
     *     path="/products/{productId}",
     *     description="Удаление продукта с определенным идентификатором",
     *     @SWG\Parameter(
     *         description="ИД продукта",
     *         in="path",
     *         name="productId",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->service->remove($product);
        return response('', Response::HTTP_NO_CONTENT);
    }
}

/**
 * @SWG\Definition(
 *     definition="Product",
 *     type="object",
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="price", type="number"),
 *     @SWG\Property(property="created_at", type="string"),
 *     @SWG\Property(property="updated_at", type="string"),
 * )
 */
