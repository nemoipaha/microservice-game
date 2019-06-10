<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entity\BaseModel;
use App\Entity\Secret;
use App\Http\Transformer\SecretTransformer;
use App\Jobs\TestJob;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Datadogstatsd;

final class SecretController extends Controller
{
    private const APM_API_KEY = '40cb00c205207c9fcaff5a076fe57f86';
    private const APM_APP_KEY = '67e59370880697d1b2fdc755cb192d58612d7207';

    private $secretTransformer;
    private $manager;

    public function __construct(SecretTransformer $secretTransformer, Manager $manager)
    {
        $this->secretTransformer = $secretTransformer;
        $this->manager = $manager;
    }

    /**
     * Apm with datadog test
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSecretCollection(Request $request): JsonResponse
    {
        Datadogstatsd::configure(self::APM_API_KEY, self::APM_APP_KEY);

        $startTime = microtime();

        $data = Secret::all();

        Datadogstatsd::timing(
            'secrets.loading.time',
            microtime(true) - $startTime,
            1,
            [
                'service' => 'secret'
            ]
        );

        return $this->createCollectionResponse($data, $this->secretTransformer);
    }

    public function getSecretById(string $id): JsonResponse
    {
        $secret = Secret::query()->find($id);

        Datadogstatsd::increment(
            'secrets.get-by-id',
            1,
            [
                'service' => 'secret'
            ]
        );

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

    public function testQueue(Dispatcher $dispatcher): JsonResponse
    {
        $dispatcher->dispatch(new TestJob('wow'));

        return response()->json(null);
    }
}
