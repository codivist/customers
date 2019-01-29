<?php

namespace Codivist\Modules\Customers\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Codivist\Modules\Customers\Http\Requests\FormRequestRegister;
use Codivist\Modules\Customers\Models\Customer;
use Codivist\Modules\Customers\Notifications\CustomerRegistered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new customers as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersCustomers;

    /**
     * Where to redirect customers after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('customers::register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \TypiCMS\Modules\Customers\Http\Requests\FormRequestRegister $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(FormRequestRegister $request)
    {
        $customer = $this->create($request->all());

        event(new Registered($customer));

        $customer->notify(new CustomerRegistered($customer));

        return redirect()
            ->back()
            ->with('status', __('Your account has been created, check your email for the activation link'));
    }

    /**
     * Create a new customer instance after a valid registration.
     *
     * @param array $data
     *
     * @return Customer
     */
    protected function create(array $data)
    {
        return Customer::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Confirm a customer’s email address.
     *
     * @param string $token
     *
     * @return mixed
     */
    public function activate($token)
    {
        $customer = Customer::where('token', $token)->firstOrFail();

        $customer->activate();

        return redirect()
            ->route('login')
            ->with('status', __('Your account has been activated, you can now log in'));
    }
}
