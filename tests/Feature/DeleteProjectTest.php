<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteProjectTest extends TestCase
{
    use DatabaseMigrations;

    public function testDeleteProjectSuccess()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $deleteRequest = ['_method' => 'Delete'];

        $response = $this->call('POST', '/projects/1', $deleteRequest);

        $response->assertJson([
            'message' => 'Deleted project success'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }

    public function testDeleteProjectFail()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $response = $this->call('POST', '/projects', $request);

        $deleteRequest = ['_method' => 'Delete'];

        $response = $this->call('POST', '/projects/2', $deleteRequest);

        $response->assertJson([
            'message' => 'Project does not exist'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);
    }
}
