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
        'text' => 'CC BY 3.0, Paulo Sá Ferreira from «The Noun Project»',
        'text-fr' => 'CC BY 3.0, Paulo Sá Ferreira de «The Noun Project»',
        'url' => null,
    ],
    'questions' => [
        [
            'text' => 'Which of these objects indicates the time?',
            'text-fr' => 'Lequel de ces objets indique l’heure ?',
            'answer' => 'noun_project_14286.png',
            'images' => ['noun_project_12747.png', 'noun_project_14283.png', 'noun_project_14284.png', 'noun_project_14287.png'],
        ],
        [
            'text' => 'Who is the surfer?',
            'text-fr' => 'Qui est le surfeur ?',
            'answer' => 'noun_project_12072.png',
            'images' => ['noun_project_12074.png', 'noun_project_12075.png', 'noun_project_12079.png',
                'noun_project_12081.png', 'noun_project_12086.png', 'noun_project_12138.png', 'noun_project_12144.png',
                'noun_project_12151.png'],
        ],
        [
            'text' => 'Show me the mexican',
            'text-fr' => 'Montrez-moi le mexicain',
            'answer' => 'noun_project_12138.png',
            'images' => ['noun_project_12074.png', 'noun_project_12075.png', 'noun_project_12079.png', 'noun_project_12086.png',
                'noun_project_12142.png', 'noun_project_12144.png', 'noun_project_12151.png', 'noun_project_12710.png'],
        ],
        [
            'text' => 'Show me the young girl',
            'text-fr' => 'Montrez-moi la jeune fille',
            'answer' => 'noun_project_12142.png',
            'images' => ['noun_project_12074.png', 'noun_project_12075.png', 'noun_project_12079.png', 'noun_project_12081.png',
                'noun_project_12086.png', 'noun_project_12144.png', 'noun_project_12710.png', 'noun_project_12711.png'],
        ],
    ],
];
