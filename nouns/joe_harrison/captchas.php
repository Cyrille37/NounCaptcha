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
        'text' => 'CC BY 3.0, Joe Harrison from «The Noun Project»',
        'text-fr' => 'CC BY 3.0, Joe Harrison de «The Noun Project»',
        'url' => 'https://thenounproject.com/joe_harrison',
    ],
    'questions' => [
        [
            'text' => 'Point the object out to wake up in the morning',
            'text-fr' => 'Indiquez l’objet pour se réveiller le matin',
            'answer' => 'noun_project_15824.png',
            'images' => ['noun_project_15827.png', 'noun_project_15829.png', 'noun_project_15831.png',
                'noun_project_16214.png', 'noun_project_16193.png', 'noun_180027.png', 'noun_180007.png'],
        ],
        [
            'text' => 'I need to be watered, who am I?',
            'text-fr' => 'J’ai besoin d’être arrosé, qui suis-je ?',
            'answer' => 'noun_project_16218.png',
            'images' => ['noun_project_15831.png', 'noun_project_15836.png', 'noun_project_15840.png',
                'noun_project_16183.png', 'noun_project_16216.png','noun_project_15827.png'],
        ],
        [
            'text' => 'With which object I will be able to shave myself?',
            'text-fr' => 'Indiquez-moi avec quel objet je vais pouvoir me raser',
            'answer' => 'noun_project_15840.png',
            'images' => ['noun_project_15824.png', 'noun_project_15827.png', 'noun_project_15831.png',
                'noun_project_16193.png', 'noun_project_16216.png', 'noun_180028.png', 'noun_180027.png', 'noun_180007.png'],
        ],
        [
            'text' => 'I’am so warm, Point out the object to freshen me up',
            'text-fr' => 'J’ai si chaud, indiquez moi l’objet pour me rafraîchir',
            'answer' => 'noun_project_16214.png',
            'images' => ['noun_project_15824.png', 'noun_project_15829.png', 'noun_project_16183.png',
                'noun_project_16216.png', 'noun_project_16218.png', 'noun_180007.png'],
        ],
        [
            'text' => 'I’m running out of salt, could you help me?',
            'text-fr' => 'Je manque de sel, pourriez-vous m’aider ?',
            'answer' => 'noun_180036.png',
            'images' => ['noun_180019.png', 'noun_180020.png', 'noun_180027.png', 'noun_180028.png',
                'noun_180030.png', 'noun_project_15829.png','noun_project_15827.png'],
        ],
    ],
];
