<?php

use Illuminate\Database\Seeder;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $programs = [
            [
                'name'              => 'Savings',
                'slug'              => 'savings',
                'image_banner_path' => '/public/assets/program_services/programs/savings.png',
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 1,
                'type'              => 2,
                'cost'              => null,
                'form_path'         => '/savings/create',
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ], 
            [
                'name'              => 'Financing',
                'slug'              => 'financing',
                'image_banner_path' => null,
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 2,
                'type'              => 2,
                'cost'              => '0.00',
                'form_path'         => null,
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ], 
            [
                'name'              => 'Housing',
                'slug'              => 'housing',
                'image_banner_path' => null,
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 3,
                'type'              => 2,
                'cost'              => '0.00',
                'form_path'         => null,
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ], 
            [
                'name'              => 'Hospitalization',
                'slug'              => 'hospitalization',
                'image_banner_path' => null,
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 4,
                'type'              => 2,
                'cost'              => '0.00',
                'form_path'         => null,
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ], 
            [
                'name'              => 'Education',
                'slug'              => 'education',
                'image_banner_path' => null,
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 5,
                'type'              => 2,
                'cost'              => '0.00',
                'form_path'         => null,
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ], 
            [
                'name'              => 'Franchise',
                'slug'              => 'franchise',
                'image_banner_path' => null,
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 6,
                'type'              => 2,
                'cost'              => '0.00',
                'form_path'         => null,
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ], 
            [
                'name'              => 'Damayan',
                'slug'              => 'damayan',
                'image_banner_path' => '/public/assets/program_services/programs/damayan.jpg',
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 7,
                'type'              => 2,
                'cost'              => '650.00',
                'form_path'         => '/damayan/create',
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
        ];

        DB::table('program_services')->insert($programs);
    }
}
