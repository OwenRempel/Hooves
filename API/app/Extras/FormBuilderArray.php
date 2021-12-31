<?php

/*

//These are some templates for how the forms will work

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
    'name'=>'Age',
    'typeName'=>'FormCheckbox',
    'checkboxTitle'=>'18+',
    'checkboxLabel'=>'Age',
    "required"=>true
],


[
    'name'=>'Message',
    'typeName'=>'FormTextarea',
    'placeolder'=>'Type your message here',
    'textareaLabel'=>'Message'
    
]



*/



$FormBuilderArray = [
    'Routes'=>[
        'companies'=>[
            'formTitle'=>'Add Company',
            'formName'=>'CompanyAddItem',
            'passwordCheck'=>'UserPassword',
            'tableName'=>'Companies',
            'secondTableName'=>'Users',
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
                    'type'=>'Email',
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
                [   //TODO: Work on getting the passwords match to work before the form is submited
                    'name'=>'UserPassword-confirm',
                    'typeName'=>'FormInput',
                    'type'=>'password',
                    'inputLabel'=>'Confirm Password'
                ]
            ]
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
        ]

    ]
];