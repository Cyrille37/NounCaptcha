<?php
/**
 * To work whit Contact Form 7.
 * 
 * Largely inspired by "[WP Captcha](https://fr.wordpress.org/plugins/wp-captcha/)" by Devnath Verma. Thanks to him !
 * 
 * Around Captcha
 * - [Adding captcha to Contact Form 7 ](https://www.sterupdesign.com/dev/wordpress/plugins/flexible-captcha/documentation/adding-captcha-to-contact-form-7/)
 * - https://gist.github.com/jrobinsonc/6d70feac58bfa24a93d19f28303f4e5a
 * Around validation
 * - https://contactform7.com/2015/03/28/custom-validation/
 * 
 */

namespace Cyrille\NounCaptcha\Services ;

use Cyrille\NounCaptcha\Utils ;
use Cyrille\NounCaptcha\Plugin ;

/**
 * 
 * 
 */
class ContactForm7
{
    public function __construct()
    {
        Utils::debug(__METHOD__);

        //add_filter( 'wpcf7_form_elements', [$this,'wpcf7_form_elements'] );
		// validate the captcha answer on contact form 7
		//\add_filter( 'wpcf7_validate_wpcaptcha', [$this, 'wpcf7_validate_wpcaptcha'], 10, 2 );

        if( is_blog_admin() )
        {
            // adds the Tag to Contact form 7 plugin
    		add_action( 'admin_init', [$this, 'wpcf7_add_tag_generator'], 45 );

        }
        else if( is_admin() )
        {
        }
        else
        {
            //add_action( 'wpcf7_init', array( $this, 'wpcf7_init') );
        }

    }

    public function wpcf7_form_elements( $form )
    {
        //Utils::debug(__METHOD__, ['form'=>$form]);
        return $form ;
    }
    public function wpcf7_validate_wpcaptcha( $result, $tag )
    {
        //Utils::debug(__METHOD__, ['form'=>$form]);
        return $result ;
    }

    public function wpcf7_init()
    {
        if(function_exists('wpcf7_add_form_tag') )
            wpcf7_add_form_tag( Plugin::NAME, array( $this, 'wpcf7_wpcaptcha_shortcode_handler' ), true );
        else if (function_exists('wpcf7_add_shortcode'))
            wpcf7_add_shortcode( Plugin::NAME, array( $this, 'wpcf7_wpcaptcha_shortcode_handler' ), true );
        /*else
            throw new Exception( 'functions wpcf7_add_form_tag and wpcf7_add_shortcode not found.' );*/

    }

    	/**
	 * Create WP Captcha " Tag " in Contact Form 7 Plugin.
	 * @package  WP Captcha
	 * @version  1.0.0
	 * @author   Devnath verma <devnathverma@gmail.com>
	 */
	public function wpcf7_add_tag_generator() {
		
		if ( ! function_exists( 'wpcf7_add_tag_generator' ) )
		    return;

        \wpcf7_add_tag_generator(
            Plugin::NAME,
            __( 'Noun Captcha', Plugin::NAME ),
            Plugin::NAME,
            [$this, 'wpcf7_tg_pane']
        );
	
	}
	
	/**
	 * Create Noun Captcha "Tag attributes" in contact form 7 Plugin.
	 * @package  WP Captcha
	 * @version  1.0.0
	 * @author   Devnath verma <devnathverma@gmail.com>
	 */
	public function wpcf7_tg_pane( $contact_form ) { ?>
		
		<div class="control-box">
			<fieldset>
				<table class="form-table">
					<tbody>
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