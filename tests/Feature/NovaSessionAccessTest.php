<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class NovaSessionAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_admin_can_access_nova_search(): void
    {
        if (config('honey.spammer_blocking.table_name') && ! Schema::hasTable(config('honey.spammer_blocking.table_name'))) {
            Schema::create(config('honey.spammer_blocking.table_name'), function (Blueprint $table) {
                $table->id();
                $table->string('ip_address');
                $table->unsignedInteger('attempts')->default(0);
                $table->dateTime('blocked_at')->nullable();
                $table->timestamps();
            });
        }
        Gate::define('viewNova', fn ($user) => $user->email === 'admin@example.com');
        $user = new User;
        $user->forceFill(['id' => 1, 'email' => 'admin@example.com', 'master' => true]);
        $this->actingAs($user)->getJson('/nova-api/search?search=')->assertOk();
    }
}
