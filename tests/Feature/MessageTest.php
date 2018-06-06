<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Message;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    private $database = 'messages';

    private function createMessage() : Message
    {
        return factory(Message::class)->create();
    }

    private function getArrayToUpdate() : array
    {
        return [
            'description' => "Uma descrição teste",
        ];
    }

    private function getArrayCompareDatabase(Message $message) : array
    {
        return [
            'description' => $message->description,
        ];
    }

    public function testCanBeCreated() : void
    {
        $message = $this->createMessage();
        $this->assertDatabaseHas($this->database, $this->getArrayCompareDatabase($message));
    }

    public function testCanBeUpdated() : void
    {
        $message = $this->createMessage();
        $result = $message->update($this->getArrayToUpdate());
        $this->assertTrue($result);
    }

    public function testCanBeDeleted() : void
    {
        $message = $this->createMessage();
        $message->delete();
        $message->refresh();
        $this->assertTrue($message->trashed());
    }
}
