<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteMemberTest extends TestCase
{
    use DatabaseMigrations;

    public function testDeleteMemberSuccess()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $this->call('POST', '/members', $request);

        $deleteRequest = ['_method' => 'Delete'];

        $response = $this->call('POST', '/members/1', $deleteRequest);

        $response->assertSeeText('Deleted member success');
    }

    public function testDeleteMemberFail()
    {
        $deleteRequest = ['_method' => 'Delete'];

        $response = $this->call('POST', '/members/2', $deleteRequest);

        $response->assertSeeText('Member does not exist');
    }
}
