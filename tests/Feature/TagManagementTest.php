<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tag;

class TagManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_all_tags()
    {
        Tag::factory()->create(['name' => 'Tag 1']);
        Tag::factory()->create(['name' => 'Tag 2']);

        $response = $this->get('/tags');

        $response->assertStatus(200);
        $response->assertSee('Tag 1');
        $response->assertSee('Tag 2');
    }

    public function test_user_can_create_tag()
    {
        $response = $this->post('/tags', ['name' => 'New Tag']);

        $response->assertRedirect('/tags');
        $this->assertDatabaseHas('tags', ['name' => 'New Tag']);
    }

    public function test_user_can_edit_tag()
    {
        $tag = Tag::factory()->create(['name' => 'Old Tag']);

        $response = $this->put("/tags/{$tag->id}", ['name' => 'Updated Tag']);

        $response->assertRedirect('/tags');
        $this->assertDatabaseHas('tags', ['id' => $tag->id, 'name' => 'Updated Tag']);
    }

    public function test_user_can_delete_tag()
    {
        $tag = Tag::factory()->create(['name' => 'Tag to delete']);

        $response = $this->delete("/tags/{$tag->id}");

        $response->assertRedirect('/tags');
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }
}
