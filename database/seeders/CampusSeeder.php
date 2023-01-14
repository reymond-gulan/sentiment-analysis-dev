<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campus;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campus = Campus::where('id', 1)->first();

        $campus_name = 'Super Admin Dummy Campus';
        $campus_address = 'N/A';
        $email_address = 'support@sentiment-analysis.com';
        $contact_information = 'N/A';

        if(empty($campus)) {
            Campus::create([
                'campus_name' => $campus_name,
                'campus_address' => $campus_address,
                'email_address' => $email_address,
                'contact_information' => $contact_information,
            ]);
        } else {
            $campus->update([
                'campus_name' => $campus_name,
                'campus_address' => $campus_address,
                'email_address' => $email_address,
                'contact_information' => $contact_information,
            ]);
        }
    }
}
