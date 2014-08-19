<?php

$with_require_star = isset($with_require_star) ? $with_require_star : false ;

$noun_name = nouncaptcha_get_option('noun_name');

$captcha_folder = NOUNCAPTCHA_NOUNS_PATH.'/'.$noun_name ;
$language = substr( get_locale(), 0, 2 );
$captcha_file = $captcha_folder.'/captchas_'.$language.'.txt' ;
if( ! file_exists($captcha_file ))
	$captcha_file = $captcha_folder.'/captchas.txt' ;
if( ! file_exists($captcha_file ))
	wp_die(NOUNCAPTCHA_BAD_CONFIG_MESSAGE);

$captchas = parse_ini_file($captcha_file, true);

$captchasCount = 0 ;
for( $qi=1; $qi<100; $qi++)
{
	if( ! isset($captchas['Q'.$qi] ))
		break;
	$captchasCount ++ ;
	//echo 'X'.$captchasCount;
}
if( $captchasCount == 0 )
	wp_die(NOUNCAPTCHA_BAD_CONFIG_MESSAGE);

// Select a random question
$captcha = $captchas['Q'.rand(1,$captchasCount)];

$captcha_images = explode(',',$captcha['images']);
shuffle($captcha_images);
$captcha_images = array_slice( $captcha_images, 0, 3 );
$captcha_images[] = $captcha['image_good'];
shuffle($captcha_images);

$nouncaptcha_code = '?';
?>

<script type="text/javascript">
var nouncaptcha_imgs ;
jQuery(document).ready(function($) {
	nouncaptcha_imgs = jQuery('#nouncaptcha img.nouncaptcha_img');
	nouncaptcha_imgs.click( function(e) {
		nouncaptcha_imgs.removeClass('nouncaptcha_img_selected');
		var o = jQuery(this);
		o.addClass('nouncaptcha_img_selected');
		jQuery('#nouncaptcha_response').val( o.attr('data-pos') );
	} );

});
</script>
<style type="text/css">
<!--

-->
</style>
<div id="nouncaptcha">
	<p>
		<label>
			<?php echo $captcha['text'] ?>
			<?php if( $with_require_star ){ ?>
				<span class="required">*</span>
			<?php } ?>
		</label>
	</p>
	<ul>
		<?php
		$image_good = $captcha['image_good'];
		for( $i=0; $i<count($captcha_images); $i++)
		{
			$image = trim($captcha_images[$i]);
			if(	$image == $image_good )
				$nouncaptcha_code = sha1(nouncaptcha_get_secret_key().$i);
		?>
		<li style="float: left">
			<a href="javascript:void(0)">
				<img
					class="nouncaptcha_img"
					data-pos="<?php echo ($i+1) ?>"
					src="<?php echo NOUNCAPTCHA_NOUNS_URL.'/'.$noun_name.'/'.$image ?>"
				/>
			</a>
		</li>
		<?php
		}
		?>
	</ul>
	<input type="hidden" name="nouncaptcha_code" id="nouncaptcha_code" value="<?php echo $nouncaptcha_code ?>" />
	<input type="hidden" name="nouncaptcha_response" id="nouncaptcha_response" value="" />

	<p class="attribution" style="clear: both;">drawings attribution: <a href="<?php echo $captchas['attribution']['url'] ?>" target="_blank">
		<?php echo $captchas['attribution']['text'] ?></a>
	</p>
</div>

