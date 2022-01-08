<?php 

$cow_weight = [
    "title"=>"Weight",
    "name"=>"mon_weight",
    "desc"=>'Weight',
    'API'=>'false',
    'log'=>"false",
    'lock'=>"false",
    'sort'=>"weightDate",
    'redirect'=>'cow_view?cow=',
    'redID'=>True,
    'sub_cross'=>'cowID',
    'main_weight_update'=>true,
    'action'=>'self',
    'view'=>"cow",
    "fields"=>[
        [
            "title"=>"Weight",
            "type"=>"text",
            "require"=>"yes",
            "name"=>"cowWeight",
            "display"=>"all"
        ],
        [
            "title"=>"Date Weighed",
            "type"=>"date",
            "require"=>"yes",
            "default"=>"today",
            "name"=>"weightDate",
            "display"=>"all"
        ],
        [
            "type"=>"data",
            'title'=>"Cow ID",
            "get"=>"cow",
            "name"=>"cowID",
            "display"=>"none"
        ],
    ]
];
$cow_medical = [
    "title"=>"Vaccine",
    "name"=>"mon_medical",
    "desc"=>'Vaccine',
    'redirect'=>'cow_view?cow=',
    'redID'=>True,
    'log'=>"false",
    'lock'=>"false",
    'sort'=>"medDate",
    'action'=>'self',
    'sub_cross'=>'cowID',
    'view'=>"cow",
    "fields"=>[
        [
            "title"=>"Vaccine",
            "type"=>"text",
            "require"=>"yes",
            "name"=>"cowVaccine",
            "display"=>"all"
        ],
        [
            "title"=>"Date Vaccinated",
            "type"=>"date",
            "require"=>"yes",
            "default"=>"today",
            "name"=>"medDate",
            "display"=>"all"
        ],
        [
            "type"=>"data",
            'title'=>"Cow ID",
            "get"=>"cow",
            "name"=>"cowID",
            "display"=>"none"
        ],
    ]
];
$cow_list = [
    "title"=>"Cattle",
    "name"=>"mon_cows",
    "desc"=>'Cow',
    'redirect'=>'cow_list',
    'redID'=>False,
    'log'=>"true",
    'API'=>'false',
    'lock'=>"true",
    'sort'=>"penDate",
    'action'=>'self',
    'sub_forms'=>[
        'weight'=>$cow_weight,
        'med'=>$cow_medical
    ],
    'view'=>"cow",
    'UUID'=>"true",
    'create_action'=>['pen_move', ['pen', 'ID','valueset:1', 'penDate']],
    "fields"=>[
        [
            "title"=>"Tag #",
            "type"=>"text",
            "require"=>"yes",
            "name"=>"tag",
            "display"=>"all"
        ],
        [
            "title"=>"Date Bought",
            "type"=>"date",
            "require"=>"yes",
            "default"=>"today",
            "name"=>"boughtDate",
            "display"=>"all"
        ],
        [
            "title"=>"Herdsman",
            "type"=>"text",
            "require"=>"no",
            "name"=>"herdsMan",
            "display"=>"all"
        ],
        [
            "title"=>"Investor",
            "type"=>"text",
            "require"=>"no",
            "name"=>"investor",
            "display"=>"some"
        ],
        [
            "title"=>"Price ₮",
            "type"=>"number",
            "require"=>"no",
            "name"=>"price",
            "display"=>"all"
        ],
        [
            "title"=>"Recipt No.",
            "type"=>"text",
            "require"=>"no",
            "name"=>"recNo",
            "display"=>"all"
        ],
        [
            "title"=>"Meg No.",
            "type"=>"text",
            "require"=>"no",
            "name"=>"megNo",
            "display"=>"all"
        ],
        [
            "title"=>"Registration No.",
            "type"=>"text",
            "require"=>"no",
            "name"=>"regNo",
            "display"=>"all"
        ],
        [
            "title"=>"Cell No.",
            "type"=>"text",
            "require"=>"no",
            "name"=>"cellNo",
            "display"=>"all"
        ],
        [
            "title"=>"Bank Account No.",
            "type"=>"text",
            "require"=>"no",
            "name"=>"bankNo",
            "display"=>"all"
        ],
        [
            "title"=>"Age/State",
            "type"=>"sel",
            "require"=>"yes",
            "name"=>"ageState",
            "display"=>"all",
            "data"=>[
                1=>"Heifer",
                2=>"Steer",
                3=>"Cow/Calf",
                4=>'Calf/M',
                5=>'Calf/F',
                6=>"Bull",
                7=>"Horse",
                8=>"Out to Pasture"
            ]
        ],
        [
            "title"=>"Into Pen Date",
            "type"=>"date",
            "require"=>"no",
            "default"=>"today",
            "name"=>"penDate",
            "display"=>"some"
        ],
        [
            "title"=>"Pen",
            "type"=>"sel",
            "require"=>"no",
            "name"=>"pen",
            "edit"=>False,
            "query"=>"SELECT name, ID from pens",
            "display"=>"some",
            'viewFunc'=>'getpenname',
            "data"=>[
                0=>"",
                1=>"Pen 1",
                2=>"Pen 2",
                3=>"Pen 3",
                4=>"Pen 5"
            ]
        ],
        [
            "title"=>"Remarks",
            "type"=>"textarea",
            "require"=>"no",
            "name"=>"remarks",
            "display"=>"some"
        ],
        [
            "title"=>"Description",
            "type"=>"textarea",
            "require"=>"no",
            "name"=>"desr",
            "display"=>"all"
        ],
        
        [
            "title"=>"Calf State",
            "type"=>"sel",
            "require"=>"no",
            "name"=>"calfState",
            "display"=>"some",
            "data"=>[
                0=>"",
                1=>"Open",
                2=>"Not Open"
            ]
        ],
        [
            "title"=>"Calf Date",
            "type"=>"date",
            "require"=>"no",
            "default"=>"none",
            "name"=>"calfDate",
            "display"=>"some"
        ],
        [
            "title"=>"Mother Tag",
            "type"=>"text",
            "require"=>"no",
            "name"=>"motherTag",
            "display"=>"some"
        ],
        [
            "type"=>"data",
            'title'=>"Died",
            "hidden"=>'none',
            "name"=>"death",
            "display"=>"none"
        ],
        [
            "type"=>"date",
            'title'=>"Death Date",
            "default"=>"none",
            "hidden"=>'none',
            "name"=>"death_date",
            "display"=>"some"
        ]
    ]

];
//this is the array for adding a bunch of animals at once
$cow_list_many = [
    "title"=>"Cattle",
    "name"=>"mon_cows",
    "desc"=>'Cow',
    'redirect'=>'cow_list',
    'main_weight_update'=>true,
    'redID'=>False,
    'log'=>"true",
    'API'=>'false',
    'lock'=>"true",
    'sort'=>"penDate",
    'action'=>'self',
    "many"=>True,
    'sub_forms'=>[
        'weight'=>$cow_weight,
        'med'=>$cow_medical
    ],
    'view'=>"cow",
    'UUID'=>"true",
    'create_action'=>['pen_move', ['pen', 'ID','valueset:1', 'penDate']],
    //'create_action'=>['pen_move', ['pen', 'UUID','valueset:1', 'penDate']],
    "fields"=>[
        [
            "title"=>"Tag #",
            "type"=>"text",
            "require"=>"yes",
            "name"=>"tag",
            "display"=>"all",
            "individual"=>True
        ],
        [
            "title"=>"Date Bought",
            "type"=>"date",
            "require"=>"yes",
            "default"=>"today",
            "name"=>"boughtDate",
            "display"=>"all"
        ],
        [
            "title"=>"Herdsman",
            "type"=>"text",
            "require"=>"no",
            "name"=>"herdsMan",
            "display"=>"all"
        ],
        [
            "title"=>"Investor",
            "type"=>"text",
            "require"=>"no",
            "name"=>"investor",
            "display"=>"some"
        ],
        [
            "title"=>"Price ₮",
            "type"=>"number",
            "require"=>"no",
            "name"=>"price",
            "display"=>"all",
            "individual"=>True
        ],
        [
            "title"=>"Recipt No.",
            "type"=>"text",
            "require"=>"no",
            "name"=>"recNo",
            "display"=>"all"
        ],
        [
            "title"=>"Meg No.",
            "type"=>"text",
            "require"=>"no",
            "name"=>"megNo",
            "display"=>"all"
        ],
        [
            "title"=>"Registration No.",
            "type"=>"text",
            "require"=>"no",
            "name"=>"regNo",
            "display"=>"all"
        ],
        [
            "title"=>"Cell No.",
            "type"=>"text",
            "require"=>"no",
            "name"=>"cellNo",
            "display"=>"all"
        ],
        [
            "title"=>"Bank Account No.",
            "type"=>"text",
            "require"=>"no",
            "name"=>"bankNo",
            "display"=>"all"
        ],
        [
            "title"=>"Age/State",
            "type"=>"sel",
            "require"=>"yes",
            "name"=>"ageState",
            "display"=>"all",
            "data"=>[
                1=>"Heifer",
                2=>"Steer",
                3=>"Cow/Calf",
                4=>'Calf/M',
                5=>'Calf/F',
                6=>"Bull",
                7=>"Horse",
                8=>"Out to Pasture"
            ],
            "individual"=>True
        ],
        [
            "title"=>"Into Pen Date",
            "type"=>"date",
            "require"=>"no",
            "default"=>"today",
            "name"=>"penDate",
            "display"=>"some"
        ],
        [
            "title"=>"Pen",
            "type"=>"sel",
            "require"=>"no",
            "name"=>"pen",
            "query"=>"SELECT name, ID from pens",
            "display"=>"some",
            'viewFunc'=>'getpenname',
            "data"=>[
                0=>"",
                1=>"Pen 1",
                2=>"Pen 2",
                3=>"Pen 3",
                4=>"Pen 5"
            ]
        ],
        [
            "title"=>"Remarks",
            "type"=>"textarea",
            "require"=>"no",
            "name"=>"remarks",
            "display"=>"some"
        ],
        [
            "title"=>"Description",
            "type"=>"textarea",
            "require"=>"no",
            "name"=>"desr",
            "display"=>"all",
            "individual"=>True
        ],
        
        [
            "title"=>"Calf State",
            "type"=>"sel",
            "require"=>"no",
            "name"=>"calfState",
            "display"=>"some",
            "data"=>[
                0=>"",
                1=>"Open",
                2=>"Not Open"
            ],
            "individual"=>True
        ],
        [
            "title"=>"Calf Date",
            "type"=>"date",
            "require"=>"no",
            "default"=>"none",
            "name"=>"calfDate",
            "display"=>"some",
            "individual"=>True
        ],
        [
            "title"=>"Mother Tag",
            "type"=>"text",
            "require"=>"no",
            "name"=>"motherTag",
            "display"=>"some",
            "individual"=>True
        ],
        [
            "type"=>"data",
            'title'=>"Died",
            "hidden"=>'none',
            "name"=>"death",
            "display"=>"none"
        ],
        [
            "type"=>"date",
            'title'=>"Death Date",
            "default"=>"none",
            "hidden"=>'none',
            "name"=>"death_date",
            "display"=>"some"
        ]
    ]

];
$extra = [
    "title"=>"In House",
    "type"=>"sel",
    "require"=>"yes",
    "name"=>"source",
    "display"=>"all",
    "data"=>[
        1=>"yes",
        2=>"no"
    ]
    ];
$cow_package = [
    "title"=>"Add Package",
    "name"=>"mon_package",
    'log'=>"false",
    'lock'=>"false",
    'sort'=>"adate",
    'action'=>'self',
    'view'=>"cow",
    "fields"=>[
        [
            "title"=>"Identifier",
            "type"=>"text",
            "require"=>"no",
            "name"=>"identifier",
            "display"=>"all"
        ],
        [
            "title"=>"Type",
            "type"=>"sel",
            "require"=>"yes",
            "name"=>"pac_type",
            "display"=>"all",
            "data"=>[
                "BACKSTRAP",
                "BONELESS",
                "RBS",
                "TBS",
                "FLK",
                "POR",
                "ROS",
                "FLT",
                "SRL",
                "ROR",
                "TRITIP", 
                "SLV", 
                "SLVS", 
                "SSLVS", 
                "MSLVS", 
                "TSS", 
                "STSS", 
                "MTSS", 
                "RAGU", 
                "RIB", 
                "LA", 
                "ENDS", 
                "CHR", 
                "FLAP", 
                "SHR", 
                "KEBAB", 
                "BSK", 
                "DCM", 
                "STM", 
                "GRB", 
                "BFP", 
                "SHK", 
                "SHKw", 
                "bone", 
                "BUL", 
                "CHB", 
                "STK", 
                "END", 
                "OXT", 
                "SPB", 
                "TNG", 
                "HANGER", 
                "CKM", 
                "KNC", 
                "TENDON", 
                "LIVER", 
                "KIDNEY",
                "HEART"
            ]
        ],
        [
            "title"=>"Weight",
            "type"=>"text",
            "require"=>"yes",
            "name"=>"weight",
            "display"=>"all"
        ],
        [
            "type"=>"data",
            'title'=>"sold",
            "hidden"=>'none',
            "name"=>"sold",
            "display"=>"none"
        ],
        [
            "type"=>"data",
            'title'=>"Price",
            "hidden"=>'none',
            "name"=>"price",
            "display"=>"none"
        ],
        [
            "type"=>"data",
            'title'=>"Cow ID",
            "get"=>"ID",
            "name"=>"cowID",
            "display"=>"none"
        ],
    ]
];

$arrays = [$cow_weight, $cow_medical, $cow_list, $cow_package];