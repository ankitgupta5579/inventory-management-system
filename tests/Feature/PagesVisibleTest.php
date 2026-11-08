<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class PagesVisibleTest extends TestCase
{
    public function test_main_pages_and_create_forms_render_for_authenticated_users(): void
    {
        $user = new User;
        $user->forceFill([
            'name' => 'Preview User',
            'email' => 'preview@example.com',
        ]);

        $this->actingAs($user);

        foreach ([
            '/',
            '/products',
            '/products/create',
            '/categories',
            '/suppliers',
            '/suppliers/create',
            '/purchases',
            '/purchases/create',
            '/sales',
            '/sales/create',
            '/reports',
        ] as $uri) {
            $this->get($uri)->assertOk();
        }
    }
}
