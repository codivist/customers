<?php

namespace Codivist\Modules\Customers\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use Codivist\Modules\Customers\Models\Customer;
use Codivist\Modules\Customers\Repositories\EloquentCustomer;

class ApiController extends BaseApiController
{
    public function __construct(EloquentCustomer $customer)
    {
        parent::__construct($customer);
    }

    public function index(Request $request)
    {
        $data = QueryBuilder::for(Customer::class)
            ->allowedFilters([
                Filter::custom('first_name,last_name,email', FilterOr::class),
            ])
            ->paginate($request->input('per_page'));

        return $data;
    }

    public function updatePreferences(Request $request)
    {
        $customer = $request->customer();
        $customer->preferences = array_merge((array) $customer->preferences, request()->all());
        $customer->save();
    }

    public function destroy(Customer $customer)
    {
        $deleted = $this->repository->delete($customer);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
