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

        $response->assertStatus(200);

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

    public function testCreateMemberFailNameNull()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => null,
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors([
            'name' => 'Name is required'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailNameLengthMoreThan50()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => str_random(51),
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors([
            'name' => 'Max length of name is 50 character'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailNameHaveSpecialCharacter()
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

        $response->assertSessionHasErrors([
            'name' => 'Name only contain alphanumberic, dash, dot and space'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailInfoLengthMoreThan300()
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

        $response->assertSessionHasErrors([
            'information' => 'Max length of information is 300 character'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailPhoneNull()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => null,
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors([
            'phone' => 'Phone is required'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailPhoneLengthMoreThan20()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678 901 234',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors([
            'phone' => 'Max length of phone is 20 character'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailPhoneHaveSpecialCharacter()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678ff',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors([
            'phone' => 'Phone only contain number, round brackets, dash, dot, slash, plus and space'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailDobNull()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => null,
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors([
            'dob' => 'Dob is required'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailDobAfterToday()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2019-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors([
            'dob' => 'The dob must be a date before today.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailDobBefore60Year()
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

        $response->assertSessionHasErrors([
            'dob' => 'The dob must be a date after 60 years ago.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailDobWrongFormat()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '198-01-01',
            'avatar' => $file,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors([
            'dob' => 'Dob is invalid datetime format'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailAvatarIsNull()
    {
        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => 'A(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => null,
            'position' => 'junior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors([
            'avatar' => 'The avatar field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailAvatarIsNotImage()
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

        $response->assertSessionHasErrors([
            'avatar' => 'The avatar must be an image.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailAvatarMimes()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.jpeg'),
            'logo.jpeg', 'image/jpeg', 10, $error = null, $test = true);

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

        $response->assertSessionHasErrors([
            'avatar' => 'The avatar must be a file of type: jpg, png, gif.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailAvatarSize()
    {
        $file = new UploadedFile(base_path('public\avatar\oversize2.png'),
            'oversize2.png', 'image/png', 10, $error = null, $test = true);

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

        $response->assertSessionHasErrors([
            'avatar' => 'The avatar may not be greater than 10240 kilobytes.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberSuccessPositionIsIntern()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'intern',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

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

    public function testCreateMemberSuccessPositionIsJunior()
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

    public function testCreateMemberSuccessPositionIsSenior()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'senior',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

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

    public function testCreateMemberSuccessPositionIsPm()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'pm',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

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

    public function testCreateMemberSuccessPositionIsCeo()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'ceo',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

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

    public function testCreateMemberSuccessPositionIsCto()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'cto',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

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

    public function testCreateMemberSuccessPositionIsBo()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'bo',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

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

    public function testCreateMemberFailPositionNull()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => null,
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors([
            'position' => 'The position field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailPositionUnavailable()
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

        $response->assertSessionHasErrors([
            'position' => 'The selected position is invalid.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberSuccessGenderIs0()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'bo',
            'gender' => '0'
        ];

        $response = $this->call('POST', '/members', $request);

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

    public function testCreateMemberSuccessGenderIs1()
    {
        $file = new UploadedFile(base_path('public\avatar\logo.png'),
            'logo.png', 'image/png', 10, $error = null, $test = true);

        $request = [
            'name' => 'Test Member',
            'information' => "Test Member's info",
            'phone' => '(+84) 912 345 678',
            'dob' => '2000-01-01',
            'avatar' => $file,
            'position' => 'bo',
            'gender' => '1'
        ];

        $response = $this->call('POST', '/members', $request);

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

    public function testCreateMemberFailGenderNull()
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
            'gender' => null
        ];

        $response = $this->call('POST', '/members', $request);

        $response->assertSessionHasErrors([
            'gender' => 'The gender field is required.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }

    public function testCreateMemberFailGenderDifferent0And1()
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

        $response->assertSessionHasErrors([
            'gender' => 'The selected gender is invalid.'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'information' => $request['information'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'avatar' => time() . 'logo.png',
            'position' => $request['position'],
            'gender' => $request['gender']
        ]);
    }
}
