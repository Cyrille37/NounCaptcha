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
        'text' => 'CC BY 3.0, Luis Prado de The Noun Project',
    ],
    'questions' => [

        [
            'text' => 'Je me promène dans la savane, qui suis-je ?',
        ],
        [
            'text' => 'Seriez-vous retrouver le Geek ?',
        ],
        [
            'text' => 'Je suis bien dans les bras de ma maman, où suis-je ?',
        ],
        [
            'text' => 'Ma papamobile est écologique, retrouvez-moi !',
        ],
        [
            'text' => 'Nous sommes trois, retrouvez-nous !',
        ],

    ]

];
