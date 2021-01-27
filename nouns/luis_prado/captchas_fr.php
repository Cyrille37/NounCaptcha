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
            'text' => 'Je me promène dans la savane, qui suis-je ?',
            'answer' => 'noun_project_14048.png',
            'images' => ['noun_project_2959.png','noun_project_9390.png', 'noun_project_13687.png', 'noun_project_13708.png', 'noun_project_14093.png', 'noun_diver_3462606.png'],
        ],
        [
            'text' => 'Seriez-vous retrouver le Geek ?',
            'answer' => 'noun_project_13708.png',
            'images' => ['noun_project_8900.png', 'noun_project_9539.png', 'noun_project_11537.png', 'noun_project_12674.png', 'noun_project_15274.png', 'noun_project_3107.png', 'noun_project_9390.png', 'noun_Fishing_3462686.png', 'noun_diver_3462606.png'],            
        ],
        [
            'text' => 'Je suis bien dans les bras de ma maman, où suis-je ?',
            'answer' => 'noun_project_9539.png',
            'images' => ['noun_project_3107.png', 'noun_project_8900.png', 'noun_project_9455.png', 'noun_project_12697.png'],
        ],
        [
            'text' => 'Ma papamobile est écologique, retrouvez-moi !',
            'answer' => 'noun_project_13687.png',
            'images' => ['noun_project_9390.png', 'noun_project_11393.png', 'noun_project_12674.png', 'noun_project_14048.png', 'noun_project_14093.png', 'noun_project_15274.png'],            
        ],
        [
            'text' => 'Nous sommes trois, retrouvez-nous !',
            'answer' => 'noun_project_3707.png',
            'images' =>[ 'noun_project_3415.png', 'noun_project_3706.png', 'noun_Fishing_3462686.png', 'noun_project_3716.png', 'noun_project_8900.png', 'noun_diver_3462606.png'],            
        ],

    ]

];
