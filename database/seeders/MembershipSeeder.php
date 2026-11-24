<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Student', 'Regular', 'Senior Citizen', 'Corporate'] as $name) MembershipCategory::create(['name' => $name, 'is_active' => true]);
        foreach ([['Basic', 500, 6], ['Silver', 1000, 12], ['Gold', 2000, 12], ['Platinum', 3500, 24]] as [$name, $fee, $months]) MembershipLevel::create(['name' => $name, 'fee' => $fee, 'validity_months' => $months, 'is_active' => true]);
    }
}
