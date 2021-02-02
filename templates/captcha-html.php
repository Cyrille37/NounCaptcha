
<script type="text/javascript">
jQuery(document).ready(function($)
{
	var nouncaptcha_imgs ;
	nouncaptcha_imgs = $('#nouncaptcha ul img');
	nouncaptcha_imgs.click( function(e)
	{
		nouncaptcha_imgs.removeClass('nouncaptcha-selected');
		var o = $(this);
		o.addClass('nouncaptcha-selected');
		$('#nouncaptcha_image').val( o.attr('data-pos') );
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
	<input type="hidden" name="nouncaptcha_response" id="nouncaptcha_response" value="<?php echo $question['response'] ?>" />
	<input type="hidden" name="nouncaptcha_image" id="nouncaptcha_image"
		value=""
		<?php echo (!empty($class) ? 'class="'.$class.'"' : '' ) ?>
		aria-required="true" />

	<span class="attribution tooltip-box">
		© icons
		<a class="tooltip-text" href="<?php echo $question['attribution']['url'] ?>" target="_blank">
		<?php echo $question['attribution']['text'] ?></a>
	</span>

</div>
