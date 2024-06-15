<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\MockObject\GeneratedAsMockObject;
use Tests\TestCase;


class UserTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PermissionSeeder::class);
        $this->seed(RoleSeeder::class);
        $this->user = User::factory(1)->create([
            'terms_accepted' => false
        ])->first();
        
        $this->admin = User::factory(1)->create([
            'terms_accepted' => true
        ])->first()->removeRole('user')->assignRole('admin');
        $this->admin->save();
    }

    
    
    public function test_unAuthUser_should_redirect_to_login(){
        $response = $this->get(route('users.index'));
        
        $response->assertRedirectToRoute('login');
    }

    public function test_authUser_should_redirect_to_terms_page(){
        $response = $this->actingAs($this->user)->get(route('users.index'));
        $response->assertRedirectToRoute('terms.index');
    }

    public function test_authNonUserTerm_should_get_403_error(){
        $this->user->terms_accepted = true;
        $this->user->save();
        $response = $this->actingAs($this->user)->get(route('users.index'));
        $response->assertStatus(403);
    }

    public function test_auth_admin_user_should_get_1_users_index(){
        $response = $this->actingAs($this->admin)->get(route('users.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('User.index');
        // TODO : check if there is a way to check to Paginator's value
        // $response->assertViewHas('usersPaginator',new Paginator($this->user->toArray(),20));
        $response->assertViewHas('usersPaginator');
        $response->assertViewHas('showDeleted',false);
    }

    public function test_should_return_create_user_login_form_visitin_users_create(){
        $response = $this->actingAs($this->admin)->get(route('users.create'));

        $response->assertStatus(200);
        $response->assertViewIs('User.create');
    }

    public function test_authAdminUser_fails_to_create_user_with_invalid_input(){
        $newUserData = [
            'first_name' => '',
            'last_name' => '',
            'email' =>'',
            'password' => '',
        ];
        $response = $this->actingAs($this->admin)->post(route('users.store',$newUserData));
        // $response->dd();
        $response->assertStatus(302);
        $response->assertInvalid();
        // $response->assertViewIs('User.create');
    }

    public function test_authAdminUser_creates_create_user_with_valid_input(){
        Event::fake();
        $newUserData = [
            'first_name' => 'Ali',
            'last_name' => 'GG',
            'email' => 'test@test.com',
            'password' => '12345678',
        ];
        $response = $this->actingAs($this->admin)->post(route('users.store'),$newUserData);

        // $response->dd();
        
        $response->assertValid();
        $response->assertStatus(302);
        Event::assertDispatched(Registered::class);
        $response->assertRedirectToRoute('users.index');
    }

    public function test_should_return_edit_user_login_form_visitin_users_edit(){
        $response = $this->actingAs($this->admin)->get(route('users.edit',$this->admin));

        $response->assertStatus(200);
        $response->assertViewIs('User.edit');
    }

    public function test_authAdminUser_fails_to_edit_user_with_invalid_input(){
        $newUserData = [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'password' => '',
        ];
        $response = $this->actingAs($this->admin)->put(route('users.update',$this->user),$newUserData);
        // $response->dd();
        $response->assertStatus(302);
        $response->assertInvalid();
        
    }

    public function test_authAdminUser_success_to_edit_with_valid_input(){
        $editUserData = $this->user->toArray();
        $editUserData['first_name'] = 'Ali';
        // dd($editUserData);
        $response = $this->actingAs($this->admin)->put(route('users.update',$this->user),$editUserData);

        // $response->dd();
        
        $response->assertValid();
        $response->assertStatus(302);
        $response->assertRedirectToRoute('users.index');
    }

    public function test_authAdminUser_deletes_user(){
        $response = $this->actingAs($this->admin)->delete(route('users.destroy',$this->user));

        // $response->assertStatus(302);
        
        $this->assertSoftDeleted('users',$this->user->toArray());   
    }





    
    
}
