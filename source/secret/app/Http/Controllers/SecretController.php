<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entity\Secret;
use App\Http\Transformer\SecretTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;
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

    private function createCollectionResponse(Collection $collection, TransformerAbstract $transformer): JsonResponse
    {
        $data = new FractalCollection($collection->all(), $transformer);
        $data = $this->manager->createData($data)->toArray();

        return response()->json($data);
    }
}
