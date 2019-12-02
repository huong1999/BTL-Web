<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentUnitTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /** @test*/
    public function it_can_create_an_student()
    {
        $data = [
            'name' => $this->faker->name,
            'student_id' => $this->faker->postcode,
            'date_time' => $this->faker->date,
            'class' => $this->faker->sentence,
            'exam_subjects' => $this->faker->sentence,
            'shift' => $this->faker->name,
        ];

        $this->post(route('students.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }
}
