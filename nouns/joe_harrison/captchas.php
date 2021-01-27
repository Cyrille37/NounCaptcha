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
        'text' => 'CC BY 3.0, Joe Harrison from "The Noun Project"',
        'url' => 'https://thenounproject.com/joe_harrison',
    ],
    'questions' => [
        [
            'text' => 'Point the object out to wake up in the morning',
            'answer' => 'noun_project_15824.png',
            'images' => ['noun_project_15827.png', 'noun_project_15829.png', 'noun_project_15831.png',
                'noun_project_16214.png', 'noun_project_16193.png'],
        ],
        [
            'text' => 'I need to be watered, who am I?',
            'answer' => 'noun_project_16218.png',
            'images' => ['noun_project_15831.png', 'noun_project_15836.png', 'noun_project_15840.png',
                'noun_project_16183.png', 'noun_project_16216.png'],
        ],
        [
            'text' => 'With which object I will be able to shave myself?',
            'answer' => 'noun_project_15840.png',
            'images' => ['noun_project_15824.png', 'noun_project_15827.png', 'noun_project_15831.png',
                'noun_project_16193.png', 'noun_project_16216.png'],
        ],
        [
            'text' => 'I am so warm, Point out the object to freshen me up',
            'answer' => 'noun_project_16214.png',
            'images' => ['noun_project_15824.png', 'noun_project_15829.png', 'noun_project_16183.png',
                'noun_project_16216.png', 'noun_project_16218.png'],
        ],
    ],
];
