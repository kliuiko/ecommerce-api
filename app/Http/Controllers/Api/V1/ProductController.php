<?php

namespace app\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Responses\ApiResponse;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $sort = [
            'sort_by' => $request->get('sort_by', 'created_at'),
            'sort_order' => $request->get('sort_order', 'desc')
        ];

        $products = $this->productRepository->getAll($sort);

        return ApiResponse::success(ProductResource::collection($products));
    }

    /**
     * @param ProductStoreUpdateRequest $request
     * @return JsonResponse
     */
    public function store(ProductStoreUpdateRequest $request): JsonResponse
    {
        $product = $this->productRepository->store($request->validated());

        return ApiResponse::success(new ProductResource($product), 'Product created successfully', 201);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $product = $this->productRepository->getById($id);

        return ApiResponse::success(new ProductResource($product), 'Product received successfully');
    }

    /**
     * @param ProductStoreUpdateRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(ProductStoreUpdateRequest $request, Product $product): JsonResponse
    {
        $this->productRepository->update($request->validated(), $product->id);

        $product->fill($request->validated());

        return ApiResponse::success(new ProductResource($product), 'Product updated successfully');
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->productRepository->delete($id);

        return ApiResponse::success(null, 'Product deleted successful', 204);
    }
}
