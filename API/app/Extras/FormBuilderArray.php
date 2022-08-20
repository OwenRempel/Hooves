<?php

$FormBuilderArray = [
    'Routes'=>[
        'companies'=>[
            'tokenAuth'=>'CompCreateAuth',
            'dbCreate'=>'CompanyName',
            'formTitle'=>'Add Company',
            'formName'=>'CompanyAddItem',
            'tableName'=>'Companies',
            'secondTable'=>'Users',
            'success'=>'Company and User successfully created!',
            'items'=>[
                [
                    'name'=>'CompanyName',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Company Name',
                    
                ],
                [
                    'name'=>'UserEmail',
                    'typeName'=>'FormInput',
                    'unique'=>True,
                    'type'=>'text',
                    'inputLabel'=>'User Email',
                    'secondTable'=>True
                    
                ],
                [
                    'name'=>'UserPassword',
                    'typeName'=>'FormInput',
                    'type'=>'password',
                    'inputLabel'=>'Password',
                    'secondTable'=>True                    
                ],
                [
                    'name'=>'UserPassword-confirm',
                    'typeName'=>'FormInput',
                    'passwordConfirm'=>'UserPassword',
                    'type'=>'password',
                    'inputLabel'=>'Confirm Password'
                ]
            ]
        ],
        'cattle'=>[
            'loginAuth'=>true,
            'formDesc'=>'Cow',
            'formName'=>'CattleAddItem',
            'tableName'=>'Cattle',
            'secondTable'=>'Weight',
            'success'=>'Cow successfully created!',
            'subArrays'=>['weight', 'medical'],
            'ListDisplayPref'=>true,
            'location'=>'Pen',
            'subLink'=>'CowID',
            'search'=>['Tag', 'StartDate', 'HerdsMan', 'Investor', 'Description'],
            'cleanUp'=>[
                'type'=>'delete',
                'target'=>['Weight', 'Medical'],
                'query'=>'CowID'
            ],
            'StatIncludes'=>[
                'LastWeight',
                'FirstWeight',
                'SecondLastWeight',
                'SecondLastDate',
                'DateWeight',
                'FirstDate'
            ],
            'items'=>[
                [
                    'name'=>'Tag',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Tag',
                    'required'=>true
                    
                ],
                [
                    'name'=>'StartDate',
                    'typeName'=>'FormInput',
                    'type'=>'date',
                    'inputLabel'=>'Date Born/Bought',
                    
                ],
                [
                    'name'=>'HerdsMan',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Herdsman',
                    
                ],
                [
                    'name'=>'Investor',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Investor',
                    
                ],
                [
                    'name'=>'Price',
                    'typeName'=>'FormInput',
                    'type'=>'number',
                    'inputLabel'=>'Price',
                    
                ],
                [
                    'name'=>'AgeState',
                    'typeName'=>'FormSelect',
                    'inputLabel'=>'Age-State',
                    'options'=>[
                        [
                            "value"=>'heffer',
                            "option"=>'Heffer'
                        ],
                        [
                            "value"=>'steer',
                            "option"=>'Steer'
                        ]
                    ]
                ],


               [
                    'name'=>'PenDate',
                    'typeName'=>'FormInput',
                    'type'=>'date',
                    'inputLabel'=>'Into Pen Date',
                    'noEdit'=>true
                    
                ],
                [
                    'name'=>'Pen',
                    'typeName'=>'FormSelect',
                    'inputLabel'=>'Pen',
                    'OptionsLoad'=>['Pens', 'Name'],
                    'noEdit'=>true
                    
                ],
                [
                    'name'=>'RecNo',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Rec No',
                    
                ],
                [
                    'name'=>'RegNo',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Reg No',
                    
                ],
                [
                    'name'=>'CellNo',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Cell No',
                    
                ],
                [
                    'name'=>'MegNo',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Meg No',
                    
                ],
                [
                    'name'=>'BankNo',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'BankNo',
                    
                ],
                [
                    'name'=>'Remarks',
                    'typeName'=>'FormTextarea',
                    'placeholder'=>'Type your remarks here',
                    'inputLabel'=>'Remarks'
                    
                ],
                [
                    'name'=>'Description',
                    'typeName'=>'FormTextarea',
                    'placeholder'=>'Type your description here',
                    'inputLabel'=>'Description'
                    
                ],
                [
                    'name'=>'Source',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Source',
                    
                ],
                [
                    'name'=>'CowWeight',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Cow Weight',
                    'secondTable'=>True
                    
                ],
                [
                    'name'=>'WeightDate',
                    'typeName'=>'FormInput',
                    'type'=>'date',
                    'inputLabel'=>'Date Weighed',
                    'secondTable'=>True
                ],
                
                //TODO:add CalfState, CalfDate
                [
                    'name'=>'MotherTag',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Mother Tag',
                    
                ],
                [
                    'name'=>'FeedTime',
                    'typeName'=>'Stat',
                    'type'=>'date-diff',
                    'statData'=>'StartDate',
                    'inputLabel'=>'Time in Feedlot',
                    'suffix'=>'Days',
                ],
                [
                    'name'=>'totalGain',
                    'typeName'=>'Stat',
                    'type'=>'diff',
                    'statData'=>['FirstWeight', 'LastWeight'],
                    'inputLabel'=>'Total Gain',
                    'suffix'=>'KG'
                ],
                [
                    'name'=>'currentWeight',
                    'typeName'=>'Stat',
                    'type'=>'format',
                    'statData'=>'LastWeight',
                    'inputLabel'=>'Current Weight',
                    'empty'=>0,
                    'suffix'=>'KG'
                ],
                [
                    'name'=>'lastWeightDate',
                    'typeName'=>'Stat',
                    'type'=>'format',
                    'statData'=>'DateWeight',
                    'empty'=>'',
                    'inputLabel'=>'Current Weight Date'
                ],
                [
                    'name'=>'lastWeight',
                    'typeName'=>'Stat',
                    'type'=>'format',
                    'statData'=>'SecondLastWeight',
                    'inputLabel'=>'Second Last Weight',
                    'empty'=>0,
                    'suffix'=>'KG'
                ],
                [
                    'name'=>'secondWeightDate',
                    'typeName'=>'Stat',
                    'type'=>'format',
                    'statData'=>'SecondLastDate',
                    'inputLabel'=>'Last Weight Date'
                ],
                [
                    'name'=>'lastWeightDiff',
                    'typeName'=>'Stat',
                    'type'=>'diff',
                    'statData'=>['SecondLastWeight', 'LastWeight'],
                    'inputLabel'=>'Last Weight Diff',
                    'suffix'=>'KG'
                ],
                [
                    'name'=>'AvgLastGain',
                    'typeName'=>'Stat',
                    'type'=>'avg-time-gain',
                    'statData'=>['SecondLastWeight', 'LastWeight', 'SecondLastDate', 'DateWeight'],
                    'inputLabel'=>'AVG Last Gain',
                    'suffix'=>'KG/Day'
                ],
                [
                    'name'=>'AvgDailyGain',
                    'typeName'=>'Stat',
                    'type'=>'avg-time-gain',
                    'statData'=>['FirstWeight', 'LastWeight', 'FirstDate', 'DateWeight'],
                    'inputLabel'=>'AVG Daily Gain',
                    'suffix'=>'KG/Day'
                ],
            ]
        ],
        'calves'=>[
            'loginAuth'=>true,
            'formDesc'=>'Cow',
            'formName'=>'CattleAddItem',
            'tableName'=>'Cattle',
            'success'=>'Cow successfully created!',
            'subArrays'=>['weight', 'medical'],
            'ListDisplayPref'=>true,
            'location'=>'Pen',
            'subLink'=>'CowID',
            'search'=>['Tag', 'StartDate', 'Description'],
            'cleanUp'=>[
                'type'=>'delete',
                'target'=>['Weight', 'Medical'],
                'query'=>'CowID'
            ],
            'items'=>[
                [
                    'name'=>'Tag',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Tag',
                    'required'=>true
                    
                ],
                [
                    'name'=>'StartDate',
                    'typeName'=>'FormInput',
                    'type'=>'date',
                    'inputLabel'=>'Date Born',
                    
                ],
                [
                    'name'=>'AgeState',
                    'typeName'=>'FormSelect',
                    'inputLabel'=>'Age-State',
                    'options'=>[
                        [
                            "value"=>'heffer',
                            "option"=>'Heffer'
                        ],
                        [
                            "value"=>'steer',
                            "option"=>'Steer'
                        ]
                    ]
                ],
                [
                    'name'=>'Pen',
                    'typeName'=>'FormSelect',
                    'inputLabel'=>'Pen',
                    'OptionsLoad'=>['Pens', 'Name'],
                    'noEdit'=>true
                    
                ],
                [
                    'name'=>'Remarks',
                    'typeName'=>'FormTextarea',
                    'placeholder'=>'Type your remarks here',
                    'inputLabel'=>'Remarks'
                    
                ],
                [
                    'name'=>'Description',
                    'typeName'=>'FormTextarea',
                    'placeholder'=>'Type your description here',
                    'inputLabel'=>'Description',
        
                    
                ],
                [
                    'name'=>'MotherTag',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Mother Tag',
                    
                ]
            ]
        ],
        'weight'=>[
            'loginAuth'=>true,
            'formDesc'=>'Weight',
            'formName'=>'WeightAddItem',
            'tableName'=>'Weight',
            'success'=>'Weight successfully added!',
            'masterTable'=>'Cattle',
            'masterLink'=>'CowID',
            'orderIndex'=>'WeightDate',
            'runStatsFunc'=>'weightUpdator',
            'items'=>[
                [
                    'name'=>'CowWeight',
                    'typeName'=>'FormInput',
                    'type'=>'number',
                    'inputLabel'=>'Weight',
                    'required'=>true
                ],
                [
                    'name'=>'WeightDate',
                    'typeName'=>'FormInput',
                    'type'=>'date',
                    'inputLabel'=>'Date Weighed',
                    
                ]
            ]
        ],
        'medical'=>[
            'loginAuth'=>true,
            'formDesc'=>'Medicine',
            'formName'=>'MedicalAddItem',
            'tableName'=>'Medical',
            'success'=>'Medicine successfully added!',
            'masterTable'=>'Cattle',
            'masterLink'=>'CowID',
            'orderIndex'=>'MedDate',
            'location'=>'CowVaccine',
            'items'=>[
                [
                    'name'=>'CowVaccine',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Medicine',
                    'required'=>true
                ],
                [
                    'name'=>'MedDate',
                    'typeName'=>'FormInput',
                    'type'=>'date',
                    'inputLabel'=>'Date Given',
                    
                ]
            ]
        ],
        'gen'=>[
            'view'=>true
        ],
        'company-add'=>[
            'view'=>true
        ],
        'server'=>[
            'view'=>True
        ],
        'pens'=>[
            'formTitle'=>'Add Pen',
            'formName'=>'PenAddItem',
            'formDesc'=>'Pen',
            'loginAuth'=>true,
            'tableName'=>'Pens',
            'success'=>'Pen successfully added!',
            'allowCompleteDelete'=>false,
            'UUID'=>false,
            'cleanUp'=>[
                'type'=>'move',
                'target'=>['Cattle'],
                'query'=>'Pen'
            ],
            'items'=>[
                [
                    'name'=>'Name',
                    'unique'=>true,
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Pen Name',
                ]
            ]
        ]
    ]
];