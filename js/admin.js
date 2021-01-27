/*
Plugin Name: Noun-Captcha
Plugin URI: http://profiles.wordpress.org/cyrille37
Description: Adds NounCaptcha anti-spam solution to WordPress on the comment form, registration form, and other forms.
Version: 0.1
Author: Cyrille Giquello
Author URI: http://cyrille37.myopenid.com/
License: GNU GPL3
*/
jQuery(document).ready(function($)
{
    var $screen = $('#nouncaptcha-preview');
    if( $screen.length <= 0 )
        return ;
    console.log( nouncaptcha );

    render(nouncaptcha.nouns);

    function render( nouns )
    {
        for( var name in nouns )
        {
            var noun = nouns[name] ;
            var $noun = $('<div class="noon">');
            $(
                '<h3>'+name+'</h3>'
                +'<p>'
                +'<a href="'+noun.attribution.url+'">'+noun.attribution.text+'</a>'
                +'</p>'
            ).appendTo($noun);
            for( var question in noun.questions )
            {
                var $q = $('<div>');
                var q = noun.questions[question];
                $(
                    '<p>'+ q.text +'</p>'
                ).appendTo($q);
                var $ul = $('<ul>');

                $(
                    '<li class="answer"><img src="'+nouncaptcha.nouns_url+'/'+name+'/'+q.answer+'" /></li>'
                ).appendTo($ul);    
                for( var image in q.images )
                {
                    $(
                        '<li class="'
                            +(q.answer == q.images[image] ? 'answer ' : '' )
                            +'"><img src="'+nouncaptcha.nouns_url+'/'+name+'/'+q.images[image]+'" /></li>'
                    ).appendTo($ul);    
                }
                $ul.appendTo($q);
                $q.appendTo($noun);

            }// noun.questions
            $noun.appendTo($screen);

        }// for nouns
    }

});
