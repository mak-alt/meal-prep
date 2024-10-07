<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreateSettings([
            "seo_title" => "Atlanta Meal",
            "seo_description" => "Atlanta Diet Meal Plan",
            "seo_keywords" => null,
            "support_email" => "order@atlantamealprep.com",
            "order_email" => "amptestsiteorders@gmail.com",
            "support_phone_number" => "(404) 805-4726",
            "portion_sizes" => [
                ["size" => "5", "percentage" => "0"],
                ["size" => "6", "percentage" => "10"],
                ["size" => "8", "percentage" => "15"]
            ],
            "delivery" => [
                "within_i_285" => "0",
                "outside_i_285" => "5.5",
                "zip_codes" => [
                    [
                        "code" => "30301",
                        "price" => '0'
                    ],
                    [
                        "code" => "30302",
                        "price" => '0'
                    ],
                    [
                        "code" => "30303",
                        "price" => '0'
                    ],
                    [
                        "code" => "30304",
                        "price" => '0'
                    ],
                    [
                        "code" => "30305",
                        "price" => '0'
                    ],
                    [
                        "code" => "30306",
                        "price" => '0'
                    ],
                    [
                        "code" => "30307",
                        "price" => '0'
                    ],
                    [
                        "code" => "30308",
                        "price" => '0'
                    ],
                    [
                        "code" => "30309",
                        "price" => '0'
                    ],
                    [
                        "code" => "30310",
                        "price" => '0'
                    ],
                    [
                        "code" => "30311",
                        "price" => '0'
                    ],
                    [
                        "code" => "30312",
                        "price" => '0'
                    ],
                    [
                        "code" => "30313",
                        "price" => '0'
                    ],
                    [
                        "code" => "30314",
                        "price" => '0'
                    ],
                    [
                        "code" => "30315",
                        "price" => '0'
                    ],
                    [
                        "code" => "30316",
                        "price" => '0'
                    ],
                    [
                        "code" => "30317",
                        "price" => '0'
                    ],
                    [
                        "code" => "30318",
                        "price" => '0'
                    ],
                    [
                        "code" => "30319",
                        "price" => '0'
                    ],
                    [
                        "code" => "30320",
                        "price" => '0'
                    ],
                    [
                        "code" => "30321",
                        "price" => '0'
                    ],
                    [
                        "code" => "30322",
                        "price" => '0'
                    ],
                    [
                        "code" => "30324",
                        "price" => '0'
                    ],
                    [
                        "code" => "30325",
                        "price" => '0'
                    ],
                    [
                        "code" => "30326",
                        "price" => '0'
                    ],
                    [
                        "code" => "30327",
                        "price" => '0'
                    ],
                    [
                        "code" => "30328",
                        "price" => '0'
                    ],
                    [
                        "code" => "30329",
                        "price" => '0'
                    ],
                    [
                        "code" => "30331",
                        "price" => '0'
                    ],
                    [
                        "code" => "30332",
                        "price" => '0'
                    ],
                    [
                        "code" => "30333",
                        "price" => '0'
                    ],
                    [
                        "code" => "30334",
                        "price" => '0'
                    ],
                    [
                        "code" => "30336",
                        "price" => '0'
                    ],
                    [
                        "code" => "30337",
                        "price" => '0'
                    ],
                    [
                        "code" => "30338",
                        "price" => '0'
                    ],
                    [
                        "code" => "30339",
                        "price" => '0'
                    ],
                    [
                        "code" => "30340",
                        "price" => '0'
                    ],
                    [
                        "code" => "30341",
                        "price" => '0'
                    ],
                    [
                        "code" => "30342",
                        "price" => '0'
                    ],
                    [
                        "code" => "30343",
                        "price" => '0'
                    ],
                    [
                        "code" => "30344",
                        "price" => '0'
                    ],
                    [
                        "code" => "30345",
                        "price" => '0'
                    ],
                    [
                        "code" => "30346",
                        "price" => '0'
                    ],
                    [
                        "code" => "30348",
                        "price" => '0'
                    ],
                    [
                        "code" => "30349",
                        "price" => '0'
                    ],
                    [
                        "code" => "30350",
                        "price" => '0'
                    ],
                    [
                        "code" => "30353",
                        "price" => '0'
                    ],
                    [
                        "code" => "30354",
                        "price" => '0'
                    ],
                    [
                        "code" => "30355",
                        "price" => '0'
                    ],
                    [
                        "code" => "30356",
                        "price" => '0'
                    ],
                    [
                        "code" => "30357",
                        "price" => '0'
                    ],
                    [
                        "code" => "30358",
                        "price" => '0'
                    ],
                    [
                        "code" => "30359",
                        "price" => '0'
                    ],
                    [
                        "code" => "30360",
                        "price" => '0'
                    ],
                    [
                        "code" => "30361",
                        "price" => '0'
                    ],
                    [
                        "code" => "30362",
                        "price" => '0'
                    ],
                    [
                        "code" => "30363",
                        "price" => '0'
                    ],
                    [
                        "code" => "30364",
                        "price" => '0'
                    ],
                    [
                        "code" => "30366",
                        "price" => '0'
                    ],
                    [
                        "code" => "30368",
                        "price" => '0'
                    ],
                    [
                        "code" => "30369",
                        "price" => '0'
                    ],
                    [
                        "code" => "30370",
                        "price" => '0'
                    ],
                    [
                        "code" => "30371",
                        "price" => '0'
                    ],
                    [
                        "code" => "30374",
                        "price" => '0'
                    ],
                    [
                        "code" => "30375",
                        "price" => '0'
                    ],
                    [
                        "code" => "30377",
                        "price" => '0'
                    ],
                    [
                        "code" => "30378",
                        "price" => '0'
                    ],
                    [
                        "code" => "30380",
                        "price" => '0'
                    ],
                    [
                        "code" => "30384",
                        "price" => '0'
                    ],
                    [
                        "code" => "30385",
                        "price" => '0'
                    ],
                    [
                        "code" => "30388",
                        "price" => '0'
                    ],
                    [
                        "code" => "30392",
                        "price" => '0'
                    ],
                    [
                        "code" => "30394",
                        "price" => '0'
                    ],
                    [
                        "code" => "30396",
                        "price" => '0'
                    ],
                    [
                        "code" => "30398",
                        "price" => '0'
                    ],
                    [
                        "code" => "31106",
                        "price" => '0'
                    ],
                    [
                        "code" => "31107",
                        "price" => '0'
                    ],
                    [
                        "code" => "31119",
                        "price" => '0'
                    ],
                    [
                        "code" => "31126",
                        "price" => '0'
                    ],
                    [
                        "code" => "31131",
                        "price" => '0'
                    ],
                    [
                        "code" => "31136",
                        "price" => '0'
                    ],
                    [
                        "code" => "31139",
                        "price" => '0'
                    ],
                    [
                        "code" => "31141",
                        "price" => '0'
                    ],
                    [
                        "code" => "31145",
                        "price" => '0'
                    ],
                    [
                        "code" => "31146",
                        "price" => '0'
                    ],
                    [
                        "code" => "31150",
                        "price" => '0'
                    ],
                    [
                        "code" => "31156",
                        "price" => '0'
                    ],
                    [
                        "code" => "31192",
                        "price" => '0'
                    ],
                    [
                        "code" => "31193",
                        "price" => '0'
                    ],
                    [
                        "code" => "31195",
                        "price" => '0'
                    ],
                    [
                        "code" => "31196",
                        "price" => '0'
                    ],
                    [
                        "code" => "39901",
                        "price" => '0'
                    ]
                ]
            ],
            "amountInviterGets" => '20',
            "amountInviteeGets" => '20',
        ]);
    }
}
