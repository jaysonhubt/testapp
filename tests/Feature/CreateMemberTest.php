<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateMemberTest extends TestCase
{
	use DatabaseMigrations;
    
    public function testCreateMemberSuccess()
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

        $response = $this->call('POST', '/members', $request);

        $response->assertJson([
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailName()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member @',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors('name');
    }

    public function testCreateMemberFailInfo()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => str_random(301),
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors('information');
    }

    public function testCreateMemberFailPhone()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => 'A(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors('phone');
    }

    public function testCreateMemberFailDob()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '1940-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors('dob');
    }

    public function testCreateMemberFailAvatar()
    {
        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => 'A(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => 'logo.png',
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors('avatar');
    }

    public function testCreateMemberFailPosition()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'super junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors('position');
    }

    public function testCreateMemberFailGender()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'super junior',
            'gender' => '2'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors('gender');
    }
}
