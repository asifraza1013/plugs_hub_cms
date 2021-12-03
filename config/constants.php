<?php

return [
    'appRole' => [
        1 => 'Customer',
        2 => 'Service Providor',
    ],
    'status' => [
        1 => 'Active',
        2 => 'Terminated',
        3 => 'Unverified',
    ],
    'charger_type' => [
        1 => 'Charger Box',
        2 => 'Charging Plug Type',
        3 => 'Car Brand',
    ],
    'country_list' => [
        1 => 'United Arab Emirates',
        2 => 'Oman',
        3 => 'Saudi Arabia',
        4 => 'Turky',
        5 => 'Yeman',
        6 => 'Dubai',
    ],
    'charge_box' => [
        'GEWISSI-CON' => 'GEWISSI-CON',
        'Parche Charging Dock' => 'Parche Charging Dock',
        'Tesla Wall Connector GEN2' => 'Tesla Wall Connector GEN2',
    ],
    'charging_plug_type' => [
        'supercharger' => 'supercharger',
        'ccs/SAE' => 'ccs/SAE',
        'CHAdeMO' => 'CHAdeMO',
        'J-1772' => 'J-1772',
        'Tesla' => 'Tesla',
        'Tesla Roadster' => 'Tesla Roadster',
        'Type 2' => 'Type 2',
        'Nema 14-50' => 'Nema 14-50',
        'WALL' => 'WALL',
    ],
    'charger_level' => [
        1 => 'Level 2',
        2 => 'Level 3',
    ],
    'charger_level_obj' => [
        (object) [
            'id' => 1,
            'name' => 'Level 2',
        ],
        (object) [
            'id' => 2,
            'name' => 'Level 3',
        ],
    ],

    'charger_capacity' => [
        1 => '7 Kw - 10 Kw',
        2 => '11 Kw - 22 Kw',
        3 => '23 Kw - 50 Kw',
        4 => '51 Kw - 200 Kw',
    ],

    'charger_capacity_obj' => [
        (object)[
            'id' => 1,
            'name' => '7 Kw - 10 Kw',
        ],
        (object)[
            'id' => 2,
            'name' => '11 Kw - 22 Kw',
        ],
        (object)[
            'id' => 3,
            'name' => '23 Kw - 50 Kw',
        ],
        (object)[
            'id' => 4,
            'name' => '51 Kw - 200 Kw',
        ],
    ],
    'charger_voltage' => [
        1 => '120V/220V Phase 1',
        2 => '220V Phase 3',
        3 => '400V Phase 3',
    ],
    'charger_voltage_obj' => [
        (object)[
            'id' => 1,
            'name' => '120V/220V Phase 1',
        ],
        (object)[
            'id' => 2,
            'name' => '220V Phase 3',
        ],
        (object)[
            'id' => 3,
            'name' => '400V Phase 3',
        ],
    ],
    'request_status' => [
        1 => 'Pending',
        2 => 'Approved',
        3 => 'Completed',
    ],
    'charger_info' => [
        1 => 'Charger Box',
        2 => 'Charger Plug type',
        3 => 'Car Brand',
    ],
];

?>
