
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

<div id="nouncaptcha">
	<label>
		<?php echo $question['text'] ?>
		<span class="required">*</span>
	</label>
	<ul>
		<?php
		for( $i=0; $i<count($question['images']); $i++)
		{
			$image = $question['images'][$i];
			?>
			<li>
				<img
					data-pos="<?php echo ($i+1) ?>"
					src="<?php echo $question['folder'].'/'.$image ?>"
				/>
			</li>
			<?php
		}
		?>
	</ul>
	<input type="hidden" name="nouncaptcha_code" id="nouncaptcha_code" value="<?php echo $question['response'] ?>" />
	<input type="hidden" name="nouncaptcha_response" id="nouncaptcha_response" value="" />

	<span class="attribution tooltip-box">
		© icons
		<a class="tooltip-text" href="<?php echo $question['attribution']['url'] ?>" target="_blank">
		<?php echo $question['attribution']['text'] ?></a>
	</span>

</div>
