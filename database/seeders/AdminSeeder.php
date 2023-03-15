<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = env('ADMIN_ONE');
        $user->email = env('ADMIN_ONE');
        $user->password = bcrypt(env('ADMIN_ONE_PASSWORD'));
        $user->save();

        $adminTeam = new Team();
        $adminTeam->name = 'Admin Team';
        $adminTeam->personal_team = false;
        $adminTeam->user_id = $user->id;
        $adminTeam->save();

        $user->current_team_id = $adminTeam->id;
        $user->save();
        $adminTeam->users()->attach($user->id, ['role' => 'admin']);

        $user = new User();
        $user->name = env('ADMIN_TWO');
        $user->email = env('ADMIN_TWO');
        $user->password = bcrypt(env('ADMIN_TWO_PASSWORD'));
        $user->save();

        $user->current_team_id = $adminTeam->id;
        $user->save();
        $adminTeam->users()->attach($user->id, ['role' => 'admin']);
    }
}
