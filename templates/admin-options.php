<!--
NounCaptcha admin options page
-->
<div class="wrap">
<<<<<<< HEAD
	<?php /* PHP Deprecated:  screen_icon est <strong>obsolète</strong> depuis la version 3.8.0, aucune alternative n’est disponible.
	screen_icon('NounCaptcha'); */ ?>
	<h2>
		<img src="<?php echo NOUNCAPTCHA_IMAGES_URL ?>/nouncaptcha-logo.png"
			style="width: 90px; vertical-align: middle;" />
=======
	<?php screen_icon('NounCaptcha'); ?>
	<h2>
>>>>>>> 872cbda841303318975071afaebb3203ce0eb19b
		<?php _e('NounCaptcha Settings') ?>
	</h2>

	<form method="post" action="options.php">
		<?php settings_fields( 'nouncaptcha_settings' ); ?>

		<table class="form-table">
			<tbody>

				<!-- Option: on_form_registration -->

				<tr valign="top">
					<th scope="row"><?php _e( 'Activate on registration form' ); ?></th>
					<td><input type="checkbox"
						id="nouncaptcha_settings[on_form_registration]"
						name="nouncaptcha_settings[on_form_registration]" value="1"
						<?php checked( '1', nouncaptcha_get_option('on_form_registration') ); ?> />
						<p class="description">
							<?php _e( 'NounCaptcha can be activated on registration form' ); ?>
						</p>
					</td>
				</tr>

				<!-- Option: on_comment -->

				<tr valign="top">
					<th scope="row"><?php _e( 'Activate on comment' ); ?></th>
					<td><input type="checkbox" id="nouncaptcha_settings[on_comment]"
						name="nouncaptcha_settings[on_comment]" value="1"
						<?php checked( '1', nouncaptcha_get_option('on_comment') ); ?> />
						<p class="description">
							<?php _e( 'NounCaptcha can be activated on comment' ); ?>
						</p>
					</td>
				</tr>

				<!-- Option: noun_name -->

				<tr valign="top">
					<th scope="row"><?php _e( 'Drawning theme' ); ?></th>
					<td><select id="nouncaptcha_settings[noun_name]"
						name="nouncaptcha_settings[noun_name]">
							<option value="" class="dummy_option">select a drawings theme ...</option>
							<?php
							if ($dir = opendir(NOUNCAPTCHA_NOUNS_PATH)) {
							while (false !== ($f = readdir($dir))) {
								//echo "$f\n";
								if( $f[0] == '.' )
									continue ;
								if( is_dir( NOUNCAPTCHA_NOUNS_PATH.'/'.$f ) ) {
<<<<<<< HEAD
									$captcha_file = NOUNCAPTCHA_NOUNS_PATH.'/'.$f.'/captchas.txt' ;
=======
									$captcha_file = NOUNCAPTCHA_NOUNS_PATH.'/'.$f.'/captchas.txt' ;
>>>>>>> 872cbda841303318975071afaebb3203ce0eb19b
									if( ! file_exists($captcha_file ))
										continue ;
							?>
							<option value="<?php echo $f ?>"
							<?php if( $f == nouncaptcha_get_option('noun_name') ) echo 'selected="selected"' ; ?>>
								<?php echo $f ?>
							</option>
							<?php }
							}
							closedir($dir);
						}
						?>
					</select>
						<p class="description">
							<?php _e( 'Select a drawings theme, by author' ); ?>
						</p>
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input name="submit" id="submit" class="button button-primary"
				value="<?php _e( 'Save Changes' ); ?>" type="submit">
		</p>

	</form>

</div>
