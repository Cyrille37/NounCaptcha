<?php
use Cyrille\NounCaptcha\Plugin ;
?>
<!--
NounCaptcha admin options page
-->
<div class="wrap metabox-holder">

	<?php /* PHP Deprecated:  screen_icon est <strong>obsolète</strong> depuis la version 3.8.0, aucune alternative n’est disponible.
	screen_icon('NounCaptcha'); */ ?>
	<h1>
		<img src="<?php echo $this->images_url ?>/nouncaptcha-logo.png"
			style="width: 90px; vertical-align: middle;" />
		<?php _e('NounCaptcha ') ?>
	</h1>

	<div class="postbox">
		<div class="postbox-header">
			<h2 class="hndle">Settings</h2>
		</div>
		<div class="inside" >

			<form id="<?php echo Plugin::NAME ?>-form" method="post" action="options.php">
				<?php
					// Output nonce, action, and option_page fields for a settings page.
					settings_fields( Plugin::NAME );
				?>

				<table class="form-table">
					<tbody>

						<!-- Option: on_registration -->

						<tr valign="top">
							<th scope="row"><?php _e( 'Activate on registration form' ); ?></th>
							<td>
								<input type="checkbox"
									name="<?php echo Plugin::NAME ?>[on_registration]" value="1"
									<?php checked( '1', $this->get_option('on_registration') ); ?>
									/>
								<p class="description">
								TODO
									<?php _e( 'NounCaptcha can be activated on Wordpress registration form' ); ?>
								</p>
							</td>
						</tr>

						<!-- Option: on_comment -->

						<tr valign="top">
							<th scope="row"><?php _e( 'Activate on comment' ); ?></th>
							<td>
								<input type="checkbox"
									name="<?php echo Plugin::NAME ?>[on_comment]" value="1"
									<?php \checked( '1', $this->get_option('on_comment') ); ?>
									/>
								<p class="description">
									<?php _e( 'NounCaptcha can be activated on Wordpress comment' ); ?>
								</p>
							</td>
						</tr>

						<!-- Option: on_wpcf7 -->

						<tr valign="top">
							<th scope="row"><?php _e( 'Activate on Contact Form7' ); ?></th>
							<td>
								<input type="checkbox"
									name="<?php echo Plugin::NAME ?>[on_wpcf7]" value="1"
									<?php \checked( '1', $this->get_option('on_wpcf7') ); ?>
									/>
								<p class="description">
									<?php _e( 'NounCaptcha can be activated on Contact Form7' ); ?>
								</p>
							</td>
						</tr>

						<!-- Option: nouns -->

						<tr valign="top">
							<th scope="row"><?php _e( 'Drawning theme' ); ?></th>
							<td>
								<select 
									name="<?php echo Plugin::NAME ?>[nouns][]"
									multiple="multiple"
									>
									<?php
									$nouns = $this->get_option( 'nouns', [] );
									foreach( $this->getNounsNames() as $name )
									{ ?>
										<option value="<?php echo $name ?>"
											<?php echo (in_array($name, $nouns) ? 'selected="selected"':'') ?>
											>
											<?php echo $name; ?>
										</option>
									<?php
									}
									?>
							</select>
								<p class="description">
									<?php _e( 'Select one or more drawing theme' ); ?>
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
	</div>

	<div class="postbox">
		<div class="postbox-header">
			<h2 class="hndle">Themes preview</h2>
		</div>
		<div class="inside" id="<?php echo Plugin::NAME ?>-preview">
		</div>
	</div>

</div>
