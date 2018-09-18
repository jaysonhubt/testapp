<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowMemberTest extends TestCase
{

	use DatabaseMigrations;

    public function testShowAllMembersSuccess()
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
        $this->call('POST', '/members', $request);

        $response = $this->call('GET', '/members');

        $response->assertJson([
        	[
	        	'id' => 1,
	            'name' => $request['name'],
	            'information' => $request['information'],
	            'phone' => $request['phone'],
	            'dob' => $request['dob'],
	            'avatar' => time() . 'logo.png',
	            'position' => $request['position'],
	            'gender' => $request['gender'],
	            'created_at' => now()->format('Y-m-d H:i:s'),
	            'updated_at' => now()->format('Y-m-d H:i:s')
		    ],
		    [
	        	'id' => 2,
	            'name' => $request['name'],
	            'information' => $request['information'],
	            'phone' => $request['phone'],
	            'dob' => $request['dob'],
	            'avatar' => time() . 'logo.png',
	            'position' => $request['position'],
	            'gender' => $request['gender'],
	            'created_at' => now()->format('Y-m-d H:i:s'),
	            'updated_at' => now()->format('Y-m-d H:i:s')
		    ]
		]);

    }

    public function testShowSpecificMemberSuccess()
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

        $response = $this->call('GET', '/members/1');

        $response->assertJson([
        	'id' => 1,
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender'],
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s')
        ]);

    }
}
