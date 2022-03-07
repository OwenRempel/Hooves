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
            'success'=>'Cow successfully created!',
            'subArrays'=>['weight', 'medical'],
            'subLink'=>'CowID',
            'items'=>[
                [
                    'name'=>'Tag',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Tag',
                    
                ],
                [
                    'name'=>'BuyDate',
                    'typeName'=>'FormInput',
                    'type'=>'date',
                    'inputLabel'=>'Date Bought',
                    
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

                //TODO:Get this working once the pens system is in place

              /*  [
                    'name'=>'PenDate',
                    'typeName'=>'FormInput',
                    'type'=>'date',
                    'inputLabel'=>'Into Pen Date',
                    
                ],
                [
                    'name'=>'Pen',
                    'typeName'=>'FormSelect',
                    'inputLabel'=>'Pen',
                    'options'=>[
                        [
                            "value"=>'Owen',
                            "option"=>'owen'
                        ],
                        
                    ]
                    
                ],*/
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
                    'placeolder'=>'Type your remarks here',
                    'inputLabel'=>'Remarks'
                    
                ],
                [
                    'name'=>'Description',
                    'typeName'=>'FormTextarea',
                    'placeolder'=>'Type your description here',
                    'inputLabel'=>'Description'
                    
                ],
                [
                    'name'=>'Source',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Meg No',
                    
                ],

                //TODO:add CalfState, CalfDate
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
            'items'=>[
                [
                    'name'=>'CowWeight',
                    'typeName'=>'FormInput',
                    'type'=>'number',
                    'inputLabel'=>'Weight',
                    
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
            'items'=>[
                [
                    'name'=>'CowVaccine',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Medicine',
                    
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
        'server'=>[
            'view'=>True
        ],
        'users'=>[
            'formTitle'=>'Add Company',
            'formName'=>'CompanyAddItem',
            'items'=>[
                [
                    'name'=>'CompanyName',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Company Name',
                    
                ],
                [
                    'name'=>'UserEmail',
                    'typeName'=>'FormSelect',
                    'selectLabel'=>'User',
                    'options'=>[
                        [
                            "value"=>'Owen',
                            "option"=>'owen'
                        ],
                        [
                            "value"=>'Terrilee',
                            "option"=>'terrilee'
                        ],
                        [
                            "value"=>'Dustin',
                            "option"=>'dustin'
                        ]  
                    ]
                    
                ],
                [
                    'name'=>'UserPassword',
                    'typeName'=>'FormInput',
                    'type'=>'password',
                    'inputLabel'=>'Password'
                    
                ],
                [
                    'name'=>'Age',
                    'typeName'=>'FormCheckbox',
                    'checkboxTitle'=>'18+',
                    'checkboxLabel'=>'Age',
                    "required"=>true
                    
                ],
                [
                    'name'=>'Address',
                    'typeName'=>'FormInput',
                    'type'=>'text',
                    'inputLabel'=>'Address'
                    
                ],
                [
                    'name'=>'Message',
                    'typeName'=>'FormTextarea',
                    'placeolder'=>'Type your message here',
                    'textareaLabel'=>'Message'
                    
                ]
            ]
        ],
        'pens'=>[
            'formTitle'=>'Add Pen',
            'formName'=>'PenAddItem',
            'loginAuth'=>true,
            'tableName'=>'Pens',
            'success'=>'Pen successfully added!',
            'UUID'=>false,
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