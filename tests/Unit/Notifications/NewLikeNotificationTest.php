<?php

namespace Tests\Unit\Notifications;

use App\Models\User;
use App\Models\Status;
use App\Notifications\NewLikeNotification;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewLikeNotificationTest extends TestCase
{
    use RefreshDatabase;
     
    /** @test */
    public function the_notification_is_stored_in_the_database()
    {
        $statusOwner = User::factory()->create();
        $likeSender = User::factory()->create();
        
        $status = Status::factory()->create(['user_id' => $statusOwner]);
        
        $status->likes()->create([
            'user_id' => $likeSender
        ]);

        $statusOwner->notify(new NewLikeNotification($status, $likeSender));

        $this->assertCount(1, $statusOwner->notifications);

        $notificationsData = $statusOwner->notifications->first()->data;

        $this->assertEquals($status->path(), $notificationsData['link']);
        $this->assertEquals("A {$likeSender->name} le gustó tu publicación.", $notificationsData['message']);
    }
}
