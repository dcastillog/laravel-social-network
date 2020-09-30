<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_register()
    {
        $this->get(route('register'))->assertSuccessful();

        $userData = $this->userValidData();

        $response = $this->post(route('register'), $userData);
        
        $response->assertRedirect(RouteServiceProvider::HOME);

        $this->assertDatabaseHas('users',[
            'name' => $userData['name'],
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
            'email' => $userData['email']
        ]);
        
        $this->assertTrue(
            Hash::check('password', User::first()->password),
            'The password needs to be hashed'
        );

    }

    /** @test */
    public function the_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => null])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => 1234])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => Str::random(61)])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => Str::random(2)])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_unique()
    {
        User::factory()->create(['name' => 'testname']);

        $this->post(
            route('register'),
            $this->userValidData(['name' => 'testname'])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_may_only_contain_letters_and_numbers()
    {
        $this->post(
            route('register'),
            $this->userValidData(['name' => 'Test Name'])
        )->assertSessionHasErrors('name');

    }

    /** @test */
    public function the_first_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => null])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 1234])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => Str::random(2)])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => Str::random(61)])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['first_name' => 'Invalid Name_5'])
        )->assertSessionHasErrors('first_name');

    }

    /** @test */
    public function the_last_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => null])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 1234])
        )->assertSessionHasErrors('last_name');
    }
    
    /** @test */
    public function the_last_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => Str::random(2)])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => Str::random(61)])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_may_only_contain_letters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['last_name' => 'Invalid LastName1'])
        )->assertSessionHasErrors('last_name');

    }

    /** @test */
    public function the_email_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => null])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => 1234])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => Str::random(61)])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_a_valid_email_address()
    {
        $this->post(
            route('register'),
            $this->userValidData(['email' => 'invalid'])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        User::factory()->create(['email' => 'test@email.com']);

        $this->post(
            route('register'),
            $this->userValidData(['email' => 'test@email.com'])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_password_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => null])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => 1234])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_at_least_8_characters()
    {
        $this->post(
            route('register'),
            $this->userValidData(['password' => Str::random(9)])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
        $this->post(
            route('register'),
            $this->userValidData([
                'password' => Str::random(9),
                'password_confirmation' => null
            ])
        )->assertSessionHasErrors('password');
    }

    /**
     * @param array $overrides
     * @return array
     */
    protected function userValidData($overrides = []): array
    {
        return array_merge([
            'name' => 'testname',
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            'email' => 'test@email.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ], $overrides);
    }
}

