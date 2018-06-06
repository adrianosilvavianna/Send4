<?php

namespace Tests\Feature;

use App\Models\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    private $database = 'contacts';

    private function createContact() : Contact
    {
        return factory(Contact::class)->create();
    }

    private function getArrayToUpdate() : array
    {
        return [
            'name' => "Um nome teste",
            'last_name' => "Um sobrenome teste",
            'email' => 'um email test',
            'phone' => "um telefone test"
        ];
    }

    private function getArrayCompareDatabase(Contact $contact) : array
    {
        return [
            'name'          => $contact->name,
            'last_name'     => $contact->last_name,
            'email'         => $contact->email,
            'phone'         => $contact->phone,
            'created_at'    => $contact->created_at,
            'updated_at'    => $contact->updated_at,
            'deleted_at'    => $contact->deleted_at,
        ];
    }

    public function testCanBeCreated() : void
    {
        $contact = $this->createContact();
        $this->assertDatabaseHas($this->database, $this->getArrayCompareDatabase($contact));
    }

    public function testCanBeUpdated() : void
    {
        $contact = $this->createContact();
        $result = $contact->update($this->getArrayToUpdate());
        $this->assertTrue($result);
    }

    public function testCanBeDeleted() : void
    {
        $contact = $this->createContact();
        $contact->delete();
        $contact->refresh();
        $this->assertTrue($contact->trashed());
    }
}
