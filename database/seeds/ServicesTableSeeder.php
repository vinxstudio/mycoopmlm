<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $services = [
            [
                'name'              => 'eHotel',
                'slug'              => 'eHotel',
                'image_banner_path' => null,
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 1,
                'type'              => 1,
                'form_path'         => '',
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
            [
                'name'              => 'eLoading',
                'slug'              => 'eLoading',
                'image_banner_path' => null,
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 2,
                'type'              => 1,
                'form_path'         => '',
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
            [
                'name'              => 'eCommerce',
                'slug'              => 'eCommerce',
                'image_banner_path' => null,
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 2,
                'type'              => 1,
                'form_path'         => '/ecommerce/index',
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
            [
                'name'              => 'eTicket',
                'slug'              => 'eTicket',
                'image_banner_path' => null,
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 3,
                'type'              => 1,
                'form_path'         => '',
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
            [
                'name'              => 'eTours',
                'slug'              => 'eTours',
                'image_banner_path' => null,
                'image_icon_path'   => '/public/assets/program_services/default.png',
                'publish_date'      => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'publish_status'    => 1,
                'order'             => 4,
                'type'              => 1,
                'form_path'         => '',
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
        ];

        DB::table('program_services')->insert($services);
    }
}
