<?php
/**
 * To work whit Contact Form 7.
 * 
 * Largely inspired by "[WP Captcha](https://fr.wordpress.org/plugins/wp-captcha/)" by Devnath Verma. Thanks to him !
 * 
 * Around Captcha
 * - [Adding captcha to Contact Form 7 ](https://www.sterupdesign.com/dev/wordpress/plugins/flexible-captcha/documentation/adding-captcha-to-contact-form-7/)
 * - https://gist.github.com/jrobinsonc/6d70feac58bfa24a93d19f28303f4e5a
 * Around Contact Form 7
 * - [How To: Add a New Button Tag to Contact Form 7 Plugin](https://www.ryansutana.name/2020/04/how-to-add-contact-form-7-form-button-tag/)
 * - [Custom validation](https://contactform7.com/2015/03/28/custom-validation/)
 */

namespace Cyrille\NounCaptcha\Services ;

use Cyrille\NounCaptcha\Utils ;
use Cyrille\NounCaptcha\Plugin ;

/**
 * Require Contact Form 7 version > 4.6
 * 
 */
class ContactForm7
{
	/**
	 * Undocumented variable
	 *
	 * @var Plugin
	 */
	protected $nc ;

	/**
	 * Undocumented function
	 *
	 * @param Plugin $nounCaptcha
	 */
    public function __construct( Plugin $nounCaptcha )
    {
        //Utils::debug(__METHOD__);

		$this->nc = $nounCaptcha ;

        if( is_blog_admin() )
        {
			// adds the Tag to Contact form 7 plugin
			// to display in Form editor
    		add_action( 'admin_init', [$this, 'wpcf7_admin_register_tag'], 45 );

        }
        else if( is_admin() )
        {
        }
        else
        {
			// adds the required HTML for the captcha to the contact form 7		
			add_action( 'wpcf7_init', array( $this, 'wpcf7_init') );

			// validate the captcha answer on contact form 7
			add_filter( 'wpcf7_validate_nouncaptcha*', array( $this, 'wpcf7_validate_nouncaptcha' ), 10, 2 );
			// adds the error messages fields for the captcha to the contact form 7 plugin
			add_filter( 'wpcf7_messages', array( $this, 'wpcf7_messages' ) );

        //add_filter( 'wpcf7_form_elements', [$this,'wpcf7_form_elements'] );
		// validate the captcha answer on contact form 7
		//\add_filter( 'wpcf7_validate_wpcaptcha', [$this, 'wpcf7_validate_wpcaptcha'], 10, 2 );
    	}

    }

    public function wpcf7_init()
    {
        //if(function_exists('wpcf7_add_form_tag') )
		wpcf7_add_form_tag( Plugin::NAME.'*', array( $this, 'wpcf7_shortcode_handler' ), true );

		// Deprecated since 4.6
		//else if (function_exists('wpcf7_add_shortcode'))
        //    wpcf7_add_shortcode( Plugin::NAME, array( $this, 'wpcf7_shortcode_handler' ), true );
        /*else
            throw new Exception( 'functions wpcf7_add_form_tag and wpcf7_add_shortcode not found.' );*/

    }

	public function wpcf7_validate_nouncaptcha( $result, $tag )
	{
		$tag = new \WPCF7_FormTag( $tag );

		//Utils::debug(__METHOD__, [ 'result'=>$result, 'tag'=>$tag, ]);

		if( $this->nc->captchaCheck($_POST) )
        {
			$result['valid'] = true;
        }
		else
		{
			$result->invalidate( $tag, wpcf7_get_message('nouncaptcha_invalid') );
		}
		return $result;
	}

	/**
	 * Undocumented function
	 *
	 * @param array $messages
	 * @return array
	 */
	public function wpcf7_messages( $messages )
	{
		return array_merge(
			$messages,
			array(
				'nouncaptcha_invalid'	 => array(
					'description'	 => __( 'Invalid captcha', Plugin::NAME ),
					'default'		 => 'Invalid captcha',
				)
			)
		);
	}

	public function wpcf7_shortcode_handler( $tag )
	{
		/*Utils::debug(__METHOD__, [
			'tag'=>$tag,
		]);*/
		$tag = new \WPCF7_FormTag( $tag );

		if ( empty( $tag->name ) )
			return '';

		$validation_error = wpcf7_get_validation_error( $tag->name );
		$class = wpcf7_form_controls_class( $tag->type );

		if ( $validation_error )
			$class .= ' wpcf7-not-valid';

		return 
			$this->nc->captchaHtml( null, $class )
			// WPCF7 will add validation error in this wrapper
			. sprintf( '<span class="wpcf7-form-control-wrap %1$s"></span>', $tag->name)
			;
	}

	/**
	 * Register NounCaptcha button ("Tag attributes") in ContactForm7 editor.
	 */
	public function wpcf7_admin_register_tag()
	{
		if ( ! function_exists( 'wpcf7_add_tag_generator' ) )
		    return;

        \wpcf7_add_tag_generator(
            Plugin::NAME,
            __( 'Noun Captcha', Plugin::NAME ),
            Plugin::NAME,
            [$this, 'wpcf7_admin_render_tag']
        );
	}
	
	/**
	 * Create NounCaptcha button ("Tag attributes") in ContactForm7 editor.
	 */
	public function wpcf7_admin_render_tag( $contact_form )
	{
		?>
		<div class="control-box">
			<fieldset>
				<table class="form-table">
					<tbody>
						<tr>
							<th></th>
							<td>
							<label>
							<input type="checkbox" name="required"
									id="tag-generator-panel-<?php echo Plugin::NAME ?>-required"
									checked="checked" readonly="readonly" disabled="disabled"
									value="on" />
								Champ obligatoire
							</label>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="tag-generator-panel-<?php echo Plugin::NAME ?>-name"><?php _e( 'Name', 'contact-form-7' ); ?></label>
							</th>
							<td>
								<input type="text" name="name" class="tg-name oneline" id="tag-generator-panel-<?php echo Plugin::NAME ?>-name" />
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="tag-generator-panel-<?php echo Plugin::NAME ?>-id"><?php _e( 'Id attribute', 'contact-form-7' ); ?></label>
							</th>
							<td>
								<input type="text" name="id" class="idvalue oneline option" id="tag-generator-panel-<?php echo Plugin::NAME ?>-id" />
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="tag-generator-panel-<?php echo Plugin::NAME ?>-class"><?php _e( 'Class attribute', 'contact-form-7' ); ?></label>
							</th>
							<td>
								<input type="text" name="class" class="classvalue oneline option" id="tag-generator-panel-<?php echo Plugin::NAME ?>-class" />
							</td>
						</tr>
					</tbody>
				</table>
			</fieldset>
		</div>
		<div class="insert-box">
			<input type="text" name="<?php echo Plugin::NAME ?>" class="tag code" readonly="readonly" onfocus="this.select();">
			<div class="submitbox">
				<input type="button" class="button button-primary insert-tag" value="<?php _e( 'Insert Tag', 'contact-form-7' ); ?>">
			</div>
			<br class="clear">
		</div>
        <?php
    }

}