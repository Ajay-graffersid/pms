<?php

use Illuminate\Database\Seeder;

class Month_leaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $month=[
        [
            'month' =>'jan',
            'no'=>1,
            'sl' =>12,
            'cl' =>10,
            'status' =>1,
            
        ],

            [
                'month' =>'feb',
                'no'=>2,
                'sl' =>11,
                'cl' =>9,
                'status' =>1,
                
            ],
            [
                'month' =>'Mar',
                'no'=>3,
                'sl' =>10,
                'cl' =>8,
                'status' =>1,
                
            ],
                [
                    'month' =>'april',
                    'no'=>4,
                    'sl' =>9,
                    'cl' =>7,
                    'status' =>1,
                    
                    ] ,
                    
                    [
                        'month' =>'may',
                        'no'=>5,
                        'sl' =>8,
                        'cl' =>6,
                        'status' =>1,
                        
                        ]  ,
                    
                        [
                            'month' =>'june',
                            'no'=>6,
                            'sl' =>7,
                            'cl' =>5.5,
                            'status' =>1,
                            
                            ]  ,      
                            [
                                'month' =>'july',
                                'no'=>7,
                                'sl' =>6,
                                'cl' =>5,
                                'status' =>1,
                                
                                ]  ,

                                [
                                    'month' =>'aug',
                                    'no'=>8,
                                    'sl' =>5,
                                    'cl' =>4.5,
                                    'status' =>1,
                                    
                                    ] ,
                                    [
                                        'month' =>'sep',
                                        'no'=>9,
                                        'sl' =>4,
                                        'cl' =>4,
                                        'status' =>1,
                                        
                                        ] ,
                                        [
                                            'month' =>'oct',
                                            'no'=>10,
                                            'sl' =>3,
                                            'cl' =>3,
                                            'status' =>1,
                                            
                                        ],
                                            
                                            [
                                                'month' =>'nov',
                                                'no'=>11,
                                                'sl' =>2,
                                                'cl' =>2,
                                                'status' =>1,
                                                
                                            ],
                                                [
                                                    'month' =>'dec',
                                                    'no'=>12,
                                                    'sl' =>1,
                                                    'cl' =>1,
                                                    'status' =>1,
                                                    
                                                    ]
            ];

        DB::table('month_leves')->insert($month);
    }
}
