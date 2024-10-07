<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * @var array|array[]
     */
    private array $pagesData = [
        [
            'name'      => 'deliveryAndPickup',
            'slug'      => '/delivery-and-pickup',
            'is_static' => true,
            'title'     => 'Delivery & Pickup',
            'data'      => [
                'delivery_and_pickup_timing' => [
                    'title' => 'Delivery & Pickup timing',
                    'items' => [
                        [
                            'title'       => 'Orders placed by Friday at 11:00PM',
                            'description' => 'Delivery from Decatur between 8 - 12:30 PM, 1 - 4:30 PM or 6 - 8:45 PM <br>
Delivery from Thrive Fitness Brookhaven between 8 - 12:30 PM, 1 - 4:30 PM or 6 - 8:45 PM <br>
Pickup in Decatur between 12:00 PM - 8:30 PM <br>
Pickup at Thrive Fitness Brookhaven between 7:00 AM - 6:00 PM',
                        ],
                        [
                            'title'       => 'Orders Placed by Sunday at 11:00PM',
                            'description' => 'Delivery from Decatur between 10:30-2:00 PM or 5:30-8:45 PM <br>
Delivery from Thrive Fitness Brookhaven between 8-12:30 PM, 1-4:30 PM or 6-8:45 PM <br>
Pickup in Decatur between 12:00 PM - 8:30 PM <br>
Pickup at Thrive Fitness Brookhaven between 7:00 AM - 6:00 PM',
                        ]
                    ],
                ],

                'delivery_fees' => [
                    'title'       => 'Delivery fees',
                    'coefficient' => '0.5',
                    'description' => 'Enter your delivery location ZIP code to learn the price',
                    'button'      => 'Search',
                    'placeholder' => 'E.g. 30002',
                ],

                'pickup_locations' => [
                    'title'       => 'Pickup locations',
                    'description' => 'Enter your delivery location ZIP code to learn the price',
                    'items'       => [
                        [
                            'name'    => 'Decatur',
                            'address' => '2752 E Ponce De Leon Ave, Decatur, GA 30030'
                        ],
                        [
                            'name'    => 'Brookhaven',
                            'address' => '4276 Peachtree Rd NE, Brookhaven, GA 30319'
                        ]
                    ]

                ],

                'contact_info' => [
                    'title'   => 'Contacts',
                    'address' => '2870, United States (US), Georgia, Atlanta<br>Peachtree Rd NE Unit 145',
                    'phone'   => '(404) 805-4726',
                    'email'   => 'order@atlantamealprep.com',
                ]
            ]
        ],

        [
            'name'      => 'partnersAndReferences',
            'slug'      => '/partners-and-references',
            'is_static' => true,
            'title'     => 'Partners & References',
            'data'      => [
                'first_local_partners'         => [
                    'title' => 'Local partners 1',
                    'items' => [
                        [
                            'image' => '/assets/frontend/img/local-partners-1.jpg',
                            'text'  => 'The first natural, non-GMO, grain-free and great tasting alternative to traditional grain-based bread that is gluten, wheat, dairy, peanut, soy, yeast and guilt-free.
knowfoods.com'
                        ],
                        [
                            'image' => '/assets/frontend/img/local-partners-2.jpg',
                            'text'  => 'The first natural, non-GMO, grain-free and great tasting alternative to traditional grain-based bread that is gluten, wheat, dairy, peanut, soy, yeast and guilt-free.
knowfoods.com'
                        ]
                    ]
                ],
                'second_local_partners'        => [
                    'title' => 'Local partners 2',
                    'items' => [
                        [
                            'image' => '/assets/frontend/img/local-partners-3.jpg',
                            'text'  => 'Atlanta Magazine’s January 2017 Issue'
                        ],
                        [
                            'image' => '/assets/frontend/img/local-partners-4.jpg',
                            'text'  => 'AJC.com August 2016'
                        ],
                    ]
                ],
                'recipe_adaptation_references' => [
                    'title' => 'Recipe Adaptation References',
                    'items' => [
                        [
                            'image' => '/assets/frontend/img/partners-img-1.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-2.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-3.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-4.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-5.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-6.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-7.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-8.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-9.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-10.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-11.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-12.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-13.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-14.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-15.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-16.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-17.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-18.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-19.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-20.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-21.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-22.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-23.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-24.png',
                            'link'  => '#'
                        ],
                        [
                            'image' => '/assets/frontend/img/partners-img-25.png',
                            'link'  => '#'
                        ],
                    ]
                ]
            ]
        ],

        [
            'name'      => 'galleryAndReviews',
            'slug'      => '/gallery-and-reviews',
            'is_static' => true,
            'title'     => 'Gallery & Reviews',
            'data'      => [
                'gallery'      => [
                    'title' => 'Gallery',
                    'items' => [
                        [
                            'image' => '/assets/frontend/img/galery-1.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/galery-2.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/galery-3.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/galery-4.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/galery-5.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/galery-6.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/galery-7.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/galery-8.jpg',
                        ],
                    ]
                ],
                'reviews'      => [
                    'title' => 'Reviews',
                    'items' => [
                        [
                            'image' => '/assets/frontend/img/review-1.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/review-2.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/review-3.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/review-4.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/review-5.jpg',
                        ],
                        [
                            'image' => '/assets/frontend/img/review-6.jpg',
                        ]
                    ]
                ]
            ],
        ],

        [
            'name'      => 'weeklyMenu',
            'slug'      => '/weekly-menu',
            'is_static' => true,
            'title'     => 'Weekly menu',
            'data'      => [],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Page::truncate();

        foreach ($this->pagesData as $pageData) {
            Page::updateOrCreate(['slug' => $pageData['slug']], $pageData);
        }
    }
}
