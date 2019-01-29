<?php

namespace Codivist\Modules\Customers\Repositories;

use TypiCMS\Modules\Core\Repositories\EloquentRepository;
use Codivist\Modules\Customers\Models\Customer;

class EloquentCustomer extends EloquentRepository
{
    protected $repositoryId = 'customers';

    protected $model = Customer::class;

    /**
     * Find customer by token.
     *
     * @param string $token
     */
    public function byToken($token)
    {
        return $this->createModel()->where('token', $token)->first();
    }
}
