<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectAssigned;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUpTheTestEnvironment(): void
    {
        parent::setUpTheTestEnvironment();
        $this->seed(PermissionSeeder::class);
        $this->seed(RoleSeeder::class);
        $this->user = User::factory(1)->create([
            'terms_accepted' => true
        ])->first();    
        
        Client::factory(1)->create();
    }

    // protected function setUp(): void
    // {
    //     parent::setUp();
        
    // }

    // protected function tearDown(): void
    // {
    //     $this->refreshDatabase();
    //     parent::tearDown();
    // }

    public function test_get_all_projects_unsuccess_with_unauth(){
        $response = $this->get(route('projects.index'));
        
        $response->assertRedirectToRoute('login');
    }

    public function test_get_all_projects_unsuccess_with_auth_terms_unaccepted(){
        $this->user->terms_accepted = false;
        $this->user->save();
        $response = $this->actingAs($this->user)->get(route('projects.index'));

        $response->assertRedirectToRoute('terms.index');
    }

    public function test_get_all_projects(){
        $response = $this->actingAs($this->user)->get(route('projects.index'));
        $response->assertStatus(200);
        $response->assertViewIs('Project.index');
        $response->assertViewHas('projectsPaginator');
        $response->assertViewHas('showDeleted',false);
    }

    public function test_show_create_project_screen(){
        $response = $this->actingAs($this->user)->get(route('projects.create'));
        $response->assertStatus(200);
        $response->assertViewIs('Project.create');
        $response->assertViewHasAll(['clients','users']);
    }

    public function test_create_new_project_unsuccess_with_invalid_data(){
        $newProject = [
            'title' => '',
            'description' => '',
            'deadline' => '',
            'assigned_user' => '',
            'assigned_client' => '',
            'status' => '',
        ];
        $response = $this->actingAs($this->user)->post(route('projects.store'),$newProject);
        $response->assertInvalid();
        $response->assertRedirect();
    }

    public function test_create_new_project_success_with_valid_data(){
        Notification::fake();
        $projectArray = Project::factory(1)->create()->first()->toArray();
        
        $response = $this->actingAs($this->user)->post(route('projects.store'),$projectArray);



        $response->assertValid();
        Notification::assertSentTo($this->user,ProjectAssigned::class);
        $response->assertRedirectToRoute('projects.index');
    }

    // TODO://///////////////////////!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    // public function test_create_new_project_success_with_valid_data_with_file(){
    //     Notification::fake();
    //     Client::factory(1)->create();
    //     Storage::fake('local');
    //     config()->set('filesystems.disks.media', [
    //         'driver' => 'local',
    //         'root' => Storage::disk('local')->path(''),
    //     ]);

    //     $file = UploadedFile::fake()->image('profile.jpg',100,100,);
    //     $projectArray = Project::factory(1)->create()->first()->toArray();

    //     $projectArray['file'] = $file;
        
    //     $response = $this->actingAs($this->user)->post(route('projects.store'),$projectArray);
        
    //     // dd(Storage::disk('local')->allFiles());
    //     Storage::disk('local')->assertExists('1/profile.jpg');
    //     $response->assertValid();
    //     Notification::assertSentTo($this->user,ProjectAssigned::class);
    //     $response->assertRedirectToRoute('projects.index');
    // }

    public function test_show_project_screen(){
        $project = Project::factory(1)->create()->first();

        $response = $this->actingAs($this->user)->get(route('projects.show',$project));
        $response->assertStatus(200);
        $response->assertViewIs('Project.show');
        $response->assertViewHasAll(['project']);
    }

    public function test_show_edit_project_screen(){
        $project = Project::factory(1)->create()->first();

        $response = $this->actingAs($this->user)->get(route('projects.edit',$project));
        $response->assertStatus(200);
        $response->assertViewIs('Project.edit');
        $response->assertViewHasAll(['project','users','clients']);
    }

    public function test_edit_project_unsuccess_with_invalid_data(){
        
        $project = Project::factory(1)->create()->first();
        // $projectArray = $project->toArray();
        $newProject = [
            'title' => '',
            'description' => '',
            'deadline' => '',
            'assigned_user' => '',
            'assigned_client' => '',
            'status' => '',
        ];
        $response = $this->actingAs($this->user)->put(route('projects.update',$project),$newProject);
        $response->assertInvalid();
        $response->assertRedirect();
    }

    public function test_edit_project_success_with_valid_data(){
        Notification::fake();
        
        $project = Project::factory(1)->create()->first();
        $projectArray = $project->toArray();

        $projectArray['title'] = 'Very Big Project';
        
        $response = $this->actingAs($this->user)->put(route('projects.update',$project),$projectArray);

        // $response->dd();
        $response->assertValid();
        Notification::assertSentTo($this->user,ProjectAssigned::class);
        $response->assertRedirectToRoute('projects.index');
    }

    public function test_edit_project_success_with_valid_data_user_change_prevUser_doesnt_get_notif(){
        Notification::fake();
        $project = Project::factory(1)->create()->first();
        $user2 = User::factory(1)->create([
            'terms_accepted' => true
        ])->first();
        $projectArray = $project->toArray();
        $projectArray['assigned_user'] = $user2->id;
        $response = $this->actingAs($this->user)->put(route('projects.update',$project),$projectArray);

        $response->assertValid();
        Notification::assertNotSentTo($this->user,ProjectAssigned::class);
        Notification::assertSentTo($user2,ProjectAssigned::class);
        $response->assertRedirectToRoute('projects.index');
    }

    // TODO://///////////////////////!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    // public function test_create_new_project_success_with_valid_data_with_file(){
    //     Notification::fake();
    //     Client::factory(1)->create();
    //     Storage::fake('local');
    //     config()->set('filesystems.disks.media', [
    //         'driver' => 'local',
    //         'root' => Storage::disk('local')->path(''),
    //     ]);

    //     $file = UploadedFile::fake()->image('profile.jpg',100,100,);
    //     $projectArray = Project::factory(1)->create()->first()->toArray();

    //     $projectArray['file'] = $file;
        
    //     $response = $this->actingAs($this->user)->post(route('projects.store'),$projectArray);
        
    //     // dd(Storage::disk('local')->allFiles());
    //     Storage::disk('local')->assertExists('1/profile.jpg');
    //     $response->assertValid();
    //     Notification::assertSentTo($this->user,ProjectAssigned::class);
    //     $response->assertRedirectToRoute('projects.index');
    // }

    public function test_delete_project(){
        $project = Project::factory(1)->create()->first();


        $response = $this->actingAs($this->user)->delete(route('projects.destroy',$project));

        
        $this->assertSoftDeleted('projects',$project->toArray());
        $response->assertRedirectToRoute('projects.index');
    }



}
