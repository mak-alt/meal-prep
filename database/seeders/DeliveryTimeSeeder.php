<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DeliveryTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Setting::updateOrCreateSettings([
            'delivery_times' => [
                [
                    'day' => '6',
                    'time' => '23:59',
                    'days_available' => [
                        [
                            'day' => '1',
                            'times' => [
                                [
                                    'since' => '8:00 AM',
                                    'until' => '12:30 PM',
                                ],
                                [
                                    'since' => '1:00 PM',
                                    'until' => '4:30 PM',
                                ],
                                [
                                    'since' => '6:00 PM',
                                    'until' => '8:45 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '2',
                            'times' => [
                                [
                                    'since' => '8:00 AM',
                                    'until' => '12:30 PM',
                                ],
                                [
                                    'since' => '1:00 PM',
                                    'until' => '4:30 PM',
                                ],
                                [
                                    'since' => '6:00 PM',
                                    'until' => '8:45 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '3',
                            'times' => [
                                [
                                    'since' => '8:00 AM',
                                    'until' => '12:30 PM',
                                ],
                                [
                                    'since' => '1:00 PM',
                                    'until' => '4:30 PM',
                                ],
                                [
                                    'since' => '6:00 PM',
                                    'until' => '8:45 PM',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'day' => '7',
                    'time' => '22:00',
                    'days_available' => [
                        [
                            'day' => '1',
                            'times' => [
                                [
                                    'since' => '8:00 AM',
                                    'until' => '1:00 PM',
                                ],
                                [
                                    'since' => '5:00 PM',
                                    'until' => '8:45 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '2',
                            'times' => [
                                [
                                    'since' => '8:00 AM',
                                    'until' => '1:00 PM',
                                ],
                                [
                                    'since' => '5:00 PM',
                                    'until' => '8:45 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '3',
                            'times' => [
                                [
                                    'since' => '8:00 AM',
                                    'until' => '1:00 PM',
                                ],
                                [
                                    'since' => '5:00 PM',
                                    'until' => '8:45 PM',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'pickup_times' => [
                [
                    'day' => '6',
                    'time' => '23:59',
                    'days_available' => [
                        [
                            'day' => '1',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '9:00 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '2',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '9:00 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '3',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '9:00 PM',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'day' => '7',
                    'time' => '22:00',
                    'days_available' => [
                        [
                            'day' => '1',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '9:00 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '2',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '9:00 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '3',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '9:00 PM',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'pickup_times_brookhaven' => [
                [
                    'day' => '6',
                    'time' => '23:59',
                    'days_available' => [
                        [
                            'day' => '1',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '8:00 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '2',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '8:00 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '3',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '8:00 PM',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'day' => '7',
                    'time' => '22:00',
                    'days_available' => [
                        [
                            'day' => '1',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '8:30 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '2',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '8:30 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '3',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '8:30 PM',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);*/

        Setting::updateOrCreateSettings([
            'delivery_times' => [
                [
                    'day' => '6',
                    'time' => '15:00',
                    'days_available' => [
                        [
                            'day' => '1',
                            'times' => [
                                [
                                    'since' => '8:00 AM',
                                    'until' => '12:30 PM',
                                ],
                                [
                                    'since' => '1:00 PM',
                                    'until' => '4:30 PM',
                                ],
                                [
                                    'since' => '6:00 PM',
                                    'until' => '8:45 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '3',
                            'times' => [
                                [
                                    'since' => '8:00 AM',
                                    'until' => '12:30 PM',
                                ],
                                [
                                    'since' => '1:00 PM',
                                    'until' => '4:30 PM',
                                ],
                                [
                                    'since' => '6:00 PM',
                                    'until' => '8:45 PM',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'pickup_times' => [
                [
                    'day' => '6',
                    'time' => '15:00',
                    'days_available' => [
                        [
                            'day' => '1',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '9:00 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '3',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '9:00 PM',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'pickup_times_brookhaven' => [
                [
                    'day' => '6',
                    'time' => '15:00',
                    'days_available' => [
                        [
                            'day' => '1',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '8:30 PM',
                                ],
                            ],
                        ],
                        [
                            'day' => '3',
                            'times' => [
                                [
                                    'since' => '12:00 PM',
                                    'until' => '8:30 PM',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
