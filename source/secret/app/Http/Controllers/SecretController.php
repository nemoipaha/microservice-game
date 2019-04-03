<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entity\BaseModel;
use App\Entity\Secret;
use App\Http\Transformer\SecretTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

final class SecretController extends Controller
{
    private $secretTransformer;
    private $manager;

    public function __construct(SecretTransformer $secretTransformer, Manager $manager)
    {
        $this->secretTransformer = $secretTransformer;
        $this->manager = $manager;
    }

    public function getSecretCollection(Request $request): JsonResponse
    {
        $data = Secret::all();

        return $this->createCollectionResponse($data, $this->secretTransformer);
    }

    public function getSecretById(string $id): JsonResponse
    {
        $secret = Secret::query()->find($id);

        return $this->createItemResponse($secret, $this->secretTransformer);
    }

    private function createCollectionResponse(Collection $collection, TransformerAbstract $transformer): JsonResponse
    {
        $data = new FractalCollection($collection->all(), $transformer);
        $data = $this->manager->createData($data)->toArray();

        return response()->json($data);
    }

    private function createItemResponse(BaseModel $model, TransformerAbstract $transformer): JsonResponse
    {
        $data = new Item($model, $transformer);
        $data = $this->manager->createData($data)->toArray();

        return response()->json($data);
    }

    public function newSecret(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string|unique:secrets,name',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'location_name' => 'required|string'
        ]);

        $secret = Secret::query()->create(array_merge($request->all(), ['id' => Str::uuid()]));

        return $this->createItemResponse($secret, $this->secretTransformer);
    }
}
