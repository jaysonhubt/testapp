<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowProjectTest extends TestCase
{

    use DatabaseMigrations;

    public function testShowAllProjectsSuccess()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);
        $this->call('POST', '/projects', $request);

        $response = $this->call('GET', '/projects');

        $response->assertStatus(200);

        $response->assertJson([
            [
                'id' => 1,
                'name' => $request['name'],
                'information' => $request['information'],
                'deadline' => $request['deadline'],
                'type' => $request['type'],
                'status' => $request['status']
            ],
            [
                'id' => 2,
                'name' => $request['name'],
                'information' => $request['information'],
                'deadline' => $request['deadline'],
                'type' => $request['type'],
                'status' => $request['status']
            ]
        ]);

    }

    public function testShowAllProjectsSuccessButHaveNoMember()
    {

        $response = $this->call('GET', '/projects');

        $response->assertStatus(200);

        $response->assertJson([]);

    }

    public function testShowSpecificProjectSuccess()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $response = $this->call('GET', '/projects/1');

        $response->assertStatus(200);

        $response->assertJson([
            'id' => 1,
            'name' => $request['name'],
            'information' => $request['information'],
            'deadline' => $request['deadline'],
            'type' => $request['type'],
            'status' => $request['status']
        ]);

    }

    public function testShowSpecificProjectFail()
    {
        $request = [
            'name' => 'Test Prj',
            'information' => "Test Prj's info",
            'deadline' => '2000-01-01',
            'type' => 'lab',
            'status' => 'planned'
        ];

        $this->call('POST', '/projects', $request);

        $response = $this->call('GET', '/projects/2');

        $this->assertDatabaseMissing('projects', [
            'id' => 2
        ]);
    }
}
