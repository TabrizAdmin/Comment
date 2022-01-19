<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $fullname;
    protected $text;

    protected function setUp(): void
    {
        parent::setUp();
        $this->migrate();
        $this->setUpFaker();

        $this->fullname = $this->faker->name();
        $this->text = Str::random(50);
    }

    /** @test */
    public function a_comment_can_be_added() {
        $response = $this->post('/api/v1/send-comment', $this->data());
        $comment = Comment::first();

        // $this->assertCount(2, User::all());
        $this->assertEquals($this->fullname, $comment->full_name);
        $this->assertEquals($this->text, $comment->text);
        $this->assertEquals('0', $comment->mother_id);
        $response->assertStatus(200);
    }

    /** @test */
    public function fields_are_required() {
        $collection = collect(['full_name' => 'full name', 'text' => 'text', 'mother_id' => 'mother id']);

        foreach ($collection as $field => $errorField) {
            $response = $this->post('/api/v1/send-comment', array_merge($this->data(), [$field => '']));
                
            $response->assertJson(['data' => 'error', 'message' => ['The '.$errorField.' field is required.']]);
            $response->assertStatus(400);
            $this->assertCount(0, Comment::all());
        }
    }

    /** @test */
    public function fields_must_be_string() {
        $collection = collect(['full_name' => 'full name', 'text' => 'text']);

        foreach ($collection as $field => $errorField) {
            $response = $this->post('/api/v1/send-comment', array_merge($this->data(), [$field => 123456]));
                
            $response->assertJson(['data' => 'error', 'message' => ['The '.$errorField.' must be a string.']]);
            $response->assertStatus(400);
            $this->assertCount(0, Comment::all());
        }
    }

    /** @test */
    public function mother_id_must_be_string() {
        $response = $this->post('/api/v1/send-comment', array_merge($this->data(), ['mother_id' => 'string']));
            
        $response->assertJson(['data' => 'error', 'message' => ['The mother id must be a number.']]);
        $response->assertStatus(400);
        $this->assertCount(0, Comment::all());
    }

    /** @test */
    public function full_name_must_be_less_than_191() {
        $response = $this->post('/api/v1/send-comment', array_merge($this->data(), ['full_name' => Str::random(192)]));
            
        $response->assertJson(['data' => 'error', 'message' => ['The full name must not be greater than 191 characters.']]);
        $response->assertStatus(400);
        $this->assertCount(0, Comment::all());
    }

    /** @test */
    public function comments_list_can_be_retrieved() {
        $comment = Comment::create($this->data());

        $response = $this->get('/api/v1/get-comments');

        $response->assertJson(['data' => [
                ['full_name' => $this->fullname, 'text' => $this->text, 'mother_id' => 0]
            ]
        ]);
        $response->assertStatus(200);
        $this->assertCount(1, Comment::all());
    }

    private function data() {
        return [
            'full_name' => $this->fullname,
            'text' => $this->text,
            'mother_id' => 0
        ];
    }
}
