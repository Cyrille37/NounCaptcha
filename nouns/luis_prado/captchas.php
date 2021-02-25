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
        'text' => 'CC BY 3.0, Luis Prado from "The Noun Project"',
        'text-fr' => 'CC BY 3.0, Luis Prado de "The Noun Project"',
        'url' => 'https://thenounproject.com/Luis',
    ],
    'questions' => [

        [
            'text' => 'I walk in the savanna, find me!',
            'text-fr' => 'Je me promène dans la savane, qui suis-je ?',
            'answer' => 'noun_project_14048.png',
            'images' => ['noun_project_2959.png','noun_project_9390.png', 'noun_project_13687.png',
                'noun_project_13708.png', 'noun_project_14093.png', 'noun_diver_3462606.png'],
        ],
        [
            'text' => 'Be you discovering the Geek?',
            'text-fr' => 'Seriez-vous retrouver le Geek ?',
            'answer' => 'noun_project_13708.png',
            'images' => ['noun_project_8900.png', 'noun_project_9539.png', 'noun_project_11537.png',
                'noun_project_12674.png', 'noun_project_15274.png', 'noun_project_3107.png', 'noun_project_9390.png',
                'noun_Fishing_3462686.png', 'noun_diver_3462606.png'],            
        ],
        [
            'text' => 'I am well in my mom ’s arms, find me!',
            'text-fr' => 'Je suis bien dans les bras de ma maman, où suis-je ?',
            'answer' => 'noun_project_9539.png',
            'images' => ['noun_project_3107.png', 'noun_project_8900.png', 'noun_project_9455.png',
                'noun_project_12697.png'],
        ],
        [
            'text' => 'My Popemobile is ecological, find me!',
            'text-fr' => 'Ma Papamobile est écologique, retrouvez-moi !',
            'answer' => 'noun_project_13687.png',
            'images' => ['noun_project_9390.png', 'noun_project_11393.png', 'noun_project_12674.png',
                'noun_project_14048.png', 'noun_project_14093.png', 'noun_project_15274.png', 'noun_project_14048.png'],            
        ],
        [
            'text' => 'We are three, find us!',
            'text-fr' => 'Nous sommes trois, retrouvez-nous !',
            'answer' => 'noun_project_3707.png',
            'images' =>[ 'noun_project_3415.png', 'noun_project_3706.png', 'noun_Fishing_3462686.png',
                'noun_project_3716.png', 'noun_project_8900.png', 'noun_diver_3462606.png'],            
        ],
        [
            'text' => 'I’m riding a bike, where am I?',
            'text-fr' => 'je me déplace à vélo, où suis-je ?',
            'answer' => 'noun_project_15274.png',
            'images' =>['noun_project_3415.png','noun_diver_3462606.png','noun_project_14048.png', 'noun_project_12674.png',
                'noun_project_12697.png', 'noun_project_11537.png','noun_project_13708.png'],
        ],
    ]

];
