<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Friendship;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanSeeFriendsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function guests_cannot_access_the_list_of_friends()
    {
        $this->get(route('friends.index'))->assertRedirect('login');
    }

    /** @test */
    public function a_user_see_a_list_of_friends()
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        Friendship::factory()->create([
            'sender_id' => $sender,
            'recipient_id' => $recipient,
            'status' => 'accepted'
        ]);

        $this->actingAs($sender)->get(route('friends.index'))->assertSee($recipient->name);
        $this->actingAs($recipient)->get(route('friends.index'))->assertSee($sender->name);


    }
}
