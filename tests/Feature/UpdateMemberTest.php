<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateMemberTest extends TestCase
{
    use DatabaseMigrations;

    public function testUpdateMemberSuccessWithoutAvatar()
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

        $updateRequest = [
            'name' => 'Test Member',
            'information' => "Updated",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => null,
            'position' => 'junior',
            'gender' => '1',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/members/1', $updateRequest);

        $response->assertJson([
        	'id' => 1,
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender'],
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s')
        ]);
    }

    public function testUpdateMemberSuccessWithAvatar()
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

        $newFile = new UploadedFile(base_path('public\avatar\new-avatar.png'),
            'new-avatar.png', 'image/png', 10, $error = null, $test = true);

        $updateRequest = [
            'name' => 'Test Member',
            'information' => "Updated",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $newFile,
            'position' => 'junior',
            'gender' => '1',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/members/1', $updateRequest);

        $response->assertJson([
        	'id' => 1,
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'new-avatar.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender'],
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s')
        ]);
    }

    public function testUpdateMemberFailName()
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

        $updateRequest = [
            'name' => 'Test Member@',
            'information' => "Updated",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => null,
            'position' => 'junior',
            'gender' => '1',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/members/1', $updateRequest);

        $response->assertSessionHasErrors('name');
    }

    public function testUpdateMemberFailInfo()
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

        $updateRequest = [
            'name' => 'Test Member',
            'information' => str_random(301),
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => null,
            'position' => 'junior',
            'gender' => '1',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/members/1', $updateRequest);

        $response->assertSessionHasErrors('information');
    }

    public function testUpdateMemberFailPhone()
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

        $updateRequest = [
            'name' => 'Test Member',
            'information' => "Updated",
            'phone' => '(+84a) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => null,
            'position' => 'junior',
            'gender' => '1',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/members/1', $updateRequest);

        $response->assertSessionHasErrors('phone');
    }

    public function testUpdateMemberFailDob()
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

        $updateRequest = [
            'name' => 'Test Member',
            'information' => "Updated",
            'phone' => '(+84) 912 345 678',
            'dob' => '1940-01-01',
            'avatar' => null,
            'position' => 'junior',
            'gender' => '1',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/members/1', $updateRequest);

        $response->assertSessionHasErrors('dob');
    }

    public function testUpdateMemberFailPosition()
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

        $updateRequest = [
            'name' => 'Test Member',
            'information' => "Updated",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => null,
            'position' => 'super junior',
            'gender' => '1',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/members/1', $updateRequest);

        $response->assertSessionHasErrors('position');
    }

    public function testUpdateMemberFailGender()
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

        $updateRequest = [
            'name' => 'Test Member',
            'information' => "Updated",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => null,
            'position' => 'junior',
            'gender' => '2',
            '_method' => 'PUT'
        ];

        $response = $this->call('POST', '/members/1', $updateRequest);

        $response->assertSessionHasErrors('gender');
    }
}
