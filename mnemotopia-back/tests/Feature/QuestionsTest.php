<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testQuestions()
    {

        $data = ['text' => 'testQuestion'];
        $response = $this->post('/api/questions', $data);

//        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertJson(
            [
                'type' => 1,
                'text_id' => 16
            ]
        );

        $id = $response->json('id');


        $response = $this->delete("/api/questions/$id", $data);

        $this->assertEquals(1, $response->json());

//        $this->assertTrue(false);
    }
}
