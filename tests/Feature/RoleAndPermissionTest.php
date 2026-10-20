<?php

namespace Tests\Feature;

use App\Enums\TopicType;
use App\Filament\Resources\RoleResource\Pages\ListRoles;
use App\Filament\Resources\Utility\InboxResource\Pages\ListInboxes;
use App\Models\Role;
use App\Models\User;
use App\Models\Utility\Inbox;
use Livewire\Livewire;
use Tests\TestCase;

class RoleAndPermissionTest extends TestCase
{
    protected User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->superAdmin = User::where('email', 'management@chandradaya-investasi.com')->firstOrFail();
    }

    protected function tearDown(): void
    {
        User::where('email', 'support-agent@chandradaya-investasi.com')->delete();
        Role::where('name', 'Contact Support Only')->delete();
        parent::tearDown();
    }

    public function test_superadmin_can_view_role_resource(): void
    {
        $this->actingAs($this->superAdmin);

        Livewire::test(ListRoles::class)
            ->assertSuccessful();
    }

    public function test_restricted_role_scoping_on_inboxes(): void
    {
        // Create a restricted role that only has inbox_contact permission
        $contactOnlyRole = Role::firstOrCreate(
            ['name' => 'Contact Support Only'],
            [
                'is_superadmin' => false,
                'permissions' => ['inbox_contact'],
            ]
        );

        $limitedUser = User::firstOrCreate(
            ['email' => 'support-agent@chandradaya-investasi.com'],
            [
                'name' => 'Support Agent',
                'password' => bcrypt('secret123'),
                'role_id' => $contactOnlyRole->id,
                'status' => 1,
            ]
        );

        $this->actingAs($limitedUser);

        // Verify limited user has permission for inbox_contact but not inbox_whistleblowing
        $this->assertTrue($limitedUser->hasPermission('inbox_contact'));
        $this->assertFalse($limitedUser->hasPermission('inbox_whistleblowing'));

        Livewire::test(ListInboxes::class)
            ->assertSuccessful();
    }
}
