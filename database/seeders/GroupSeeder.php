<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();
        
        if ($users->count() < 2) {
            $this->command->warn('Need at least 2 users to create sample groups. Run UserSeeder first.');
            return;
        }

        // Create sample groups
        $groups = [
            [
                'name' => 'General Discussion',
                'description' => 'A place for general team discussions and announcements.',
                'created_by' => $users->first()->id,
            ],
            [
                'name' => 'Project Alpha',
                'description' => 'Discussion about Project Alpha development and progress.',
                'created_by' => $users->skip(1)->first()->id,
            ],
            [
                'name' => 'Random',
                'description' => 'For random conversations and fun topics.',
                'created_by' => $users->first()->id,
            ],
        ];

        foreach ($groups as $groupData) {
            $group = Group::create($groupData);
            
            // Add creator as admin member
            $creator = User::find($groupData['created_by']);
            $group->addMember($creator, true);
            
            // Add other random members
            $otherUsers = $users->where('id', '!=', $groupData['created_by'])->shuffle()->take(rand(1, min(3, $users->count() - 1)));
            
            foreach ($otherUsers as $user) {
                $group->addMember($user, false);
            }
            
            $this->command->info("Created group: {$group->name} with " . ($otherUsers->count() + 1) . " members");
        }
    }
} 