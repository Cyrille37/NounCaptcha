<?php
/**
 * Captcha definition
 * project NounCaptcha, a captcha as a Wordpress Plugin
 * 
 * Tips:
 * SVG to 48x48 PNG : `mogrify -format png -resize 48x48 *.svg`
 */
return [

    'attribution'=>[
        'text' => 'CC BY 3.0, Luis Prado from The Noun Project',
        'url' => 'http://thenounproject.com/Luis',
    ],
    'questions' => [

        [
            'text' => 'My popemobile is ecological, find me!',
            'answer' => 'noun_project_14048.png',
            'images' => ['noun_project_2959.png','noun_project_9390.png', 'noun_project_13687.png', 'noun_project_13708.png', 'noun_project_14093.png', 'noun_diver_3462606.png'],
        ],
        [
            'text' => 'I walk in the savanna, find me!',
            'answer' => 'noun_project_13708.png',
            'images' => ['noun_project_8900.png', 'noun_project_9539.png', 'noun_project_11537.png', 'noun_project_12674.png', 'noun_project_15274.png', 'noun_project_3107.png', 'noun_project_9390.png', 'noun_Fishing_3462686.png', 'noun_diver_3462606.png'],            
        ],
        [
            'text' => 'Be you discovering the Geek?',
            'answer' => 'noun_project_9539.png',
            'images' => ['noun_project_3107.png', 'noun_project_8900.png', 'noun_project_9455.png', 'noun_project_12697.png'],
        ],
        [
            'text' => 'I am well in my mom ’s arms, find me!',
            'answer' => 'noun_project_13687.png',
            'images' => ['noun_project_9390.png', 'noun_project_11393.png', 'noun_project_12674.png', 'noun_project_14048.png', 'noun_project_14093.png', 'noun_project_15274.png'],            
        ],
        [
            'text' => 'We are three, find us!',
            'answer' => 'noun_project_3707.png',
            'images' =>[ 'noun_project_3415.png', 'noun_project_3706.png', 'noun_Fishing_3462686.png', 'noun_project_3716.png', 'noun_project_8900.png', 'noun_diver_3462606.png'],            
        ],

    ]

];
