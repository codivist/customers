<?php

class CustomersControllerTest extends TestCase
{
    public function testAdminIndex()
    {
        $response = $this->call('GET', 'admin/customers');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreFails()
    {
        $input = ['email' => 'test'];
        $this->call('POST', 'admin/customers', $input);
        $this->assertRedirectedToRoute('admin.customers.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $input = [
            'email' => 'test@test.com',
            'first_name' => 'test',
            'last_name' => 'test',
            'password' => 'testtest',
            'password_confirmation' => 'testtest',
        ];
        $this->call('POST', 'admin/customers', $input);
        $this->assertRedirectedToRoute('admin.customers.edit', ['id' => 2]);
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $input = [
            'email' => 'test@test.com',
            'first_name' => 'test',
            'last_name' => 'test',
            'password' => 'testtest',
            'password_confirmation' => 'testtest',
            'exit' => true,
        ];
        $this->call('POST', 'admin/customers', $input);
        $this->assertRedirectedToRoute('admin.customers.index');
    }

    // @Todo add test to test for duplicate email
}
