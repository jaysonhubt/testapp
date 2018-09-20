<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProjectTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testCreateProjectSuccess()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectSuccessNameLengthIs10()
    {
        $request = [
            'name' => str_random(10),
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectFailNameNull()
    {
        $request = [
            'name' => null,
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectFailNameLengthMoreThan10()
    {
        $request = [
            'name' => str_random(11),
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertSessionHasErrors([
            'name' => 'The name may not be greater than 10 characters.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectFailNameHaveSpecialCharacter()
    {
        $request = [
            'name' => 'Test Prj @',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertSessionHasErrors([
            'name' => 'The name format is invalid.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectFailInfoLengthMoreThan300()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => str_random(301),
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertSessionHasErrors([
            'information' => 'The information may not be greater than 300 characters.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectSuccessDeadlineNull()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => null,
            'type' => 'lab',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectFailDeadlineWrongFormat()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '198-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertSessionHasErrors([
            'deadline' => 'The deadline is not a valid date.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectSuccessTypeIsLab()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectSuccessTypeIsSingle()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectSuccessTypeIsAcceptance()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'acceptance',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectFailTypeNull()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => null,
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertSessionHasErrors([
            'type' => 'The type field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectFailTypeUnavailable()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'product',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertSessionHasErrors([
            'type' => 'The selected type is invalid.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectSuccessStatusIsPlanned()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectSuccessStatusIsOnhold()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'onhold'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectSuccessStatusIsDoing()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'doing'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectSuccessStatusIsDone()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'done'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectSuccessStatusIsCancelled()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'cancelled'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectFailstatusNull()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => null
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertSessionHasErrors([
            'status' => 'The status field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testCreateProjectFailstatusUnavailable()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'super junior',
            'status' => '2'
        ];

        $response = $this->call('POST', '/projects', $request);

        $response->assertSessionHasErrors([
            'status' => 'The selected status is invalid.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }
}
