<?php

namespace Codivist\Modules\Customers\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use Codivist\Modules\Customers\Http\Requests\FormRequest;
use Codivist\Modules\Customers\Models\Customer;
use Codivist\Modules\Customers\Repositories\EloquentCustomer;

class AdminController extends BaseAdminController
{
    public function __construct(EloquentCustomer $customer)
    {
        parent::__construct($customer);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('customers::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->createModel();
        $model->permissions = [];
        $model->roles = [];

        return view('customers::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \Codivist\Modules\Customers\Models\Customer $customer
     *
     * @return \Illuminate\View\View
     */
    public function edit(Customer $customer)
    {
        $customer->permissions = $customer->permissions()->pluck('name')->all();
        $customer->roles = $customer->roles()->pluck('id')->all();

        return view('customers::admin.edit')
            ->with(['model' => $customer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Codivist\Modules\Customers\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $data = $request->all();

        $customerData = array_except($data, ['exit', 'permissions', 'roles', 'password_confirmation']);
        $customerData['password'] = Hash::make($data['password']);

        $customer = $this->repository->create($customerData);

        if ($customer) {
            $roles = $data['roles'] ?? [];
            $customer->roles()->sync($roles);
            $permissions = $data['permissions'] ?? [];
            $customer->syncPermissions($permissions);
        }

        return $this->redirect($request, $customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Codivist\Modules\Customers\Models\Customer               $customer
     * @param \Codivist\Modules\Customers\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Customer $customer, FormRequest $request)
    {
        $data = $request->all();

        $customerData = array_except($data, ['exit', 'permissions', 'roles', 'password_confirmation']);

        if (!isset($customerData['password']) || $customerData['password'] === '') {
            $customerData = array_except($customerData, 'password');
        } else {
            $customerData['password'] = Hash::make($data['password']);
        }

        $roles = $data['roles'] ?? [];
        $permissions = $data['permissions'] ?? [];
        $customer->roles()->sync($roles);
        $customer->syncPermissions($permissions);

        $this->repository->update($customer->id, $customerData);

        return $this->redirect($request, $customer);
    }
}
