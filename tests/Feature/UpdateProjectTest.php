<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProjectTest extends TestCase
{
    use DatabaseMigrations;

    public function testUpdateProjectSuccess()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Updated',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);

        $response->assertJson([
        	'id' => 1,
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectFailNameNull()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => null,
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testUpdateProjectFailNameLengthMoreThan10()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => str_random(11),
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertSessionHasErrors([
            'name' => 'The name may not be greater than 10 characters.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseMissing('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectFailNameHaveSpecialCharacter()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj@',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertSessionHasErrors([
            'name' => 'The name format is invalid.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseMissing('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectFailInfoLengthMoreThan300()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(301),
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertSessionHasErrors([
            'information' => 'The information may not be greater than 300 characters.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseMissing('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectSuccessDeadlineNull()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => null,
            'type' => 'lab',
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectFailDeadlineWrongFormat()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-14-14',
            'type' => 'lab',
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertSessionHasErrors([
            'deadline' => 'The deadline is not a valid date.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseMissing('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectSuccessTypeIsLab()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-01-01',
            'type' => 'lab',
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectSuccessTypeIsSingle()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-01-01',
            'type' => 'single',
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectSuccessTypeIsAcceptance()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-01-01',
            'type' => 'acceptance',
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectFailTypeNull()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-01-01',
            'type' => null,
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertSessionHasErrors([
            'type' => 'The type field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseMissing('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectFailTypeUnavailable()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2018-01-01',
            'type' => null,
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertSessionHasErrors([
            'type' => 'The type field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseMissing('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectSuccessStatusIsPlanned()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'onhold'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-01-01',
            'type' => 'lab',
            'status' => 'planned',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectSuccessStatusIsOnhold()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-01-01',
            'type' => 'lab',
            'status' => 'onhold',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectSuccessStatusIsDoing()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-01-01',
            'type' => 'lab',
            'status' => 'doing',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectSuccessStatusIsDone()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-01-01',
            'type' => 'lab',
            'status' => 'done',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectSuccessStatusIsCancelled()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-01-01',
            'type' => 'lab',
            'status' => 'cancelled',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectFailStatusNull()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-01-01',
            'type' => 'single',
            'status' => null,
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertSessionHasErrors([
            'status' => 'The status field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseMissing('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }

    public function testUpdateProjectFailStatusUnavailable()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'single',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $updateRequest = [
            'name' => 'Test Prj',
            'information' => str_random(300),
            'deadline' => '2018-01-01',
            'type' => 'single',
            'status' => 'plannedd',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/projects/1', $updateRequest);

        $response->assertSessionHasErrors([
            'status' => 'The selected status is invalid.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

        $this->assertDatabaseMissing('projects', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'deadline' => $updateRequest['deadline'],
            'type' => $updateRequest['type'],
            'status' => $updateRequest['status']
        ]);
    }
}
