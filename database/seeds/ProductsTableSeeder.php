<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Eloquent::unguard();

        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('products')->truncate();

        $products = [
            [
                'name'              => 'KOJIC AND PAPAYA',
                'slug'              => 'kojic',
                'price'             => 200.00,
                'rebates'           => 130.00,
                'image'             => '1_Kojic.png',
                'description'       => '<p>White Silk Kojic contains Kojic acids from mushrooms and Papaya extract, both known to brighten the skin. Kojic is used as skin brightening agent for people who may have sun spots, and other forms of pigmentation on their face, hands and neck. Papaya extract, on the other hand, is known to effectively whiten the skin. Kojic acid and Papaya extract have been used in various skin care and anti-ageing products. In soap form, its primary function is exfoliating the skin slowly to get rid of pigmentation and dark spots by buffing away the damaged skin cells, thus resulting into a beautiful, fair and young-looking skin.</p><p>Experience the promise of beautiful, smooth, fair and young-looking skin and pamper yourself with its</p><p><strong>INGREDIENTS</strong></p><p>Coconut Oil, Palm Oil, Glycerin, Water, Sodium Lactate, Kojic Acid, Papaya Extract, Fragrance.</p><p><strong>DIRECTIONS FOR USE</strong></p><p>Wet face and body with water. Lather soap all over. Massage lather onto skin in gentle, circular motion. Rinse well.</p>',
                'publish'           => 1,
                'type'              => 0,
                'category'          => 1,
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'updated_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
            [
                'name'              => 'GLUTATHIONE &amp; VITAMIN E',
                'slug'              => 'gluta',
                'price'             => 200.00,
                'rebates'           => 130,
                'image'             => '2_Glutatahione.png',
                'description'       => '<p>Each bar contains Glutathione and Vitamin E, a powerful combination of two ingredients known to effectively lighten, repair rough and dry skin. Glutathione contains properties that lighten the skin, get rid of freckles, dark spots, age spots and pimple marks. On the other hand, Vitamin E is known to support healthy skin, making it soft, supple and young-looking. Experience the promise of beautiful, smooth, fair and young-looking skin and pamper yourself with its rich creamy lather while soothing your senses with the luxurious scent of Bulgarian Rose Essence.</p><p><strong>INGREDIENTS</strong><p>Coconut Oil, Palm Oil, Glycerin, Water, Sodium Lactate, Glutathione, Vitamin E, Perfume.</p><p><strong>DIRECTIONS FOR USE</strong></p><p>Wet face and body with water. Lather soap all over. Massage lather onto skin in gentle, circular motion. Rinse well.</p>',
                'publish'           => 1,
                'type'              => 0,
                'category'          => 1,
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'updated_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
            [
                'name'              => 'Night Serum',
                'slug'              => 'night-serum',
                'price'             => 658.00,
                'rebates'           => 458.00,
                'image'             => '3_night_serum.png',
                'description'       => '<p>WHITE SILK Night Serum is the perfect solution to dull, tired and aging skin as it works best during sleep. It penetrates deeply into skin to achieve a fresher and renewed looking skin in the morning.</p><ul><li>Enriched with Alpha Arbutin and Glutathione that works to whiten skin</li><li>Intensified with Vitamin C which helps in the production of collagen</li><li>Contains collagen, an active agent that delays skin aging.</li></ul><p><strong>DIRECTIONS FOR USE</strong></p><p>Apply serum every night by gently massaging into face and neck in upward and circular motion. For best results, cleanse face with WHITE SILK Cleansing and Brightening Toner.</p>',
                'publish'           => 1,
                'type'              => 0,
                'category'          => 1,
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'updated_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
            [
                'name'              => 'Cleansing &amp; Brightening Toner',
                'slug'              => 'toner',
                'price'             => 586.00,
                'rebates'           => 410.00,
                'image'             => '4_toner.png',
                'description'       => '<p>WHITE SILK Cleansing and Brightening Toner is infused with Alpha Arbutin, Glutathione and Vitamin E that effectively whitens skin, tightens pores and promotes healthy complexion. It has micro-exfoliation technology that deeply cleanses and removes dead skin cells making it glow with youthful radiance.</p><p><strong>DIRECTIONS FOR USE</strong></p><p>Moisten a piece of cotton. Gently dab over entire face and neck. For best results, use day and night after washing face with WHITE SILK Nature’s Beauty Bar Soap</p>',
                'publish'           => 1,
                'type'              => 0,
                'category'          => 1,
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'updated_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
            [
                'name'              => 'My-C',
                'slug'              => 'my-c',
                'price'             => 800.00,
                'rebates'           => 600.00,
                'image'             => '5_my_C.png',
                'description'       => '<p></p>',
                'publish'           => 1,
                'type'              => 0,
                'category'          => 1,
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'updated_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
            [
                'name'              => 'Ultiman',
                'slug'              => 'ultiman',
                'price'             => 586.00,
                'rebates'           => 410.00,
                'image'             => '6_ultiman.png',
                'description'       => '<p>Health support for men\'s active lifestyle and sexual health. </p><p>Improves blood circulation, thus addressing erectile dysfunction. </p><p>Promotes general wellness and prostate health.</p><p>Enhances stamina and immune system. 
Addresses both signs of of sexual dysfunction and thier deeper causes.</p><p>Proven effective and safe.</p><p>Made in France, using the most advanced LEMS technology that guarantees freshness and effectivenes.</p>',
                'publish'           => 1,
                'type'              => 0,
                'category'          => 1,
                'created_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
                'updated_at'        => date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d'))))),
            ],
        ];

        DB::table('products')->insert($products);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
