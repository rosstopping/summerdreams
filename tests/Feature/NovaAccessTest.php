<?php

namespace Tests\Feature;

use Tests\TestCase;

class NovaAccessTest extends TestCase
{
    public function test_guest_cannot_read_admin_resources(): void
    {
        $this->getJson('/nova-api/users')->assertUnauthorized();
    }

    public function test_guest_cannot_upload_through_the_editor(): void
    {
        $this->postJson('/nova-tiptap/api/file')->assertUnauthorized();
        $this->postJson('/nova-tiptap/api/image')->assertUnauthorized();
    }
}
