<?php

namespace xGrz\LaraGus\Http\Controllers;

use App\Http\Controllers\Controller;
use GusApi\Exception\InvalidUserKeyException;
use xGrz\LaraGus\Exceptions\DataNotFoundException;
use xGrz\LaraGus\Exceptions\InvalidApiKeyException;
use xGrz\LaraGus\Exceptions\InvalidVatIdNumberException;
use xGrz\LaraGus\Http\Requests\SearchGusDataRequest;
use xGrz\LaraGus\Services\GusService;


class SearchGusDataController extends Controller
{
    /**
     * @throws DataNotFoundException
     * @throws InvalidVatIdNumberException
     * @throws InvalidApiKeyException
     */
    public function __invoke(SearchGusDataRequest $request): array
    {

        try {
            $data = GusService::vat_id($request->validated('vat_id'))->toArray();
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (InvalidVatIdNumberException $e) {
            abort(422, $e->getMessage());
        } catch (InvalidApiKeyException $e) {
            abort(503, $e->getMessage());
        }

        return $data;

    }
}
