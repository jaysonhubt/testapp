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

        $response->assertStatus(200);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseHas('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);

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

        $response->assertStatus(200);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseHas('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'new-avatar.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);

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

    public function testUpdateMemberFailNameNull()
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
            'name' => null,
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'name' => 'Name is required'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailNameLengthMoreThan50()
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
            'name' => str_random(51),
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'name' => 'Max length of name is 50 character'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailNameHaveSpecialCharacter()
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
            'name' => 'Test Member @',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'name' => 'Name only contain alphanumberic, dash, dot and space'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailInfoLengthMoreThan300()
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
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'information' => 'Max length of information is 300 character'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailPhoneNull()
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
            'information' => "Test Member's info",
            'phone' => null,
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'phone' => 'Phone is required'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailPhoneLengthMoreThan20()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678 901 234',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'phone' => 'Max length of phone is 20 character'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailPhoneHaveSpecialCharacter()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678ff',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'phone' => 'Phone only contain number, round brackets, dash, dot, slash, plus and space'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailDobNull()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => null,
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'dob' => 'Dob is required'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailDobAfterToday()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2019-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'dob' => 'The dob must be a date before today.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailDobBefore60Year()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '1940-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'dob' => 'The dob must be a date after 60 years ago.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailDobWrongFormat()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '198-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'dob' => 'Dob is invalid datetime format'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailAvatarIsNull()
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
            'information' => "Test Member's info",
            'phone' => 'A(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => null,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'avatar' => 'The avatar field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailAvatarIsNotImage()
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
            'information' => "Test Member's info",
            'phone' => 'A(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => 'logo.png',
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'avatar' => 'The avatar must be an image.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailAvatarMimes()
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

        $file = new UploadedFile(base_path('public\avatar\logo.jpeg'),
            'logo.jpeg', 'image/jpeg', 10, $error = null, $test = true);

        $updateRequest = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => 'A(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'avatar' => 'The avatar must be a file of type: jpg, png, gif.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailAvatarSize()
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
        
        $file = new UploadedFile(base_path('public\avatar\oversize2.png'),
            'oversize2.png', 'image/png', 10, $error = null, $test = true);

        $updateRequest = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => 'A(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'avatar' => 'The avatar may not be greater than 10240 kilobytes.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberSuccessPositionIsIntern()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'intern',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testUpdateMemberSuccessPositionIsJunior()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testUpdateMemberSuccessPositionIsSenior()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'senior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testUpdateMemberSuccessPositionIsPm()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'pm',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testUpdateMemberSuccessPositionIsCeo()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'ceo',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testUpdateMemberSuccessPositionIsCto()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'cto',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testUpdateMemberSuccessPositionIsBo()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'bo',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testUpdateMemberFailPositionNull()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => null,
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'position' => 'The position field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailPositionUnavailable()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'super junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'position' => 'The selected position is invalid.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberSuccessGenderIs0()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'bo',
            'gender' => '0'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testUpdateMemberSuccessGenderIs1()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'bo',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertStatus(200);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testUpdateMemberFailGenderNull()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => null
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'gender' => 'The gender field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }

    public function testUpdateMemberFailGenderDifferent0And1()
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
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'super junior',
            'gender' => '2'
        ];

        $response = $this->call('POST', '/members', $updateRequest);

        $response->assertSessionHasErrors([
            'gender' => 'The selected gender is invalid.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);

        $this->assertDatabaseMissing('members', [
            'name' => $updateRequest['name'],
            'information' => $updateRequest['information'],
            'phone' => $updateRequest['phone'],
            'dob' => $updateRequest['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $updateRequest['position'],
            'gender' => $updateRequest['gender']
        ]);
    }
}
