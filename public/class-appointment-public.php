<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.bookingtime.com/
 * @since      1.0.0
 *
 * @package    Appointment
 * @subpackage Appointment/public
 */

require_once(__DIR__ . '/Widgets/Appointment_Widget.php');
require_once(__DIR__ . '/../vendor/autoload.php');

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\XliffFileLoader;


/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Appointment
 * @subpackage Appointment/public
 * @author     bookingtime <appointment@bookingtime.com>
 */
class Appointment_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	public $locale;
	protected $twig;
	protected $translator;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		//add shortcodes
		add_action('init', [$this,'shortcodes_init']);

		//get page locale
		$this->locale = get_locale();
		if($this->locale === '') {
			$this->locale = 'en_EN';
		}

		//init translator
		$this->translator = new Translator($this->locale);
      $this->translator->addLoader('xlf', new XliffFileLoader());
		$this->translator->addResource('xlf',__DIR__.'/../languages/appointment.'.$this->locale.'.xlf',$this->locale);

		//init twig
      $this->twig = new Environment(new FilesystemLoader(__DIR__.'/templates/'));
		$this->twig->addExtension(new TranslationExtension($this->translator));

		add_action('widgets_init', function()
		{
			return register_widget('Appointment_Widget');
		});

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Appointment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Appointment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/appointment-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Appointment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Appointment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	}


	/**
	 *  shortcodes_init
	 * adds shoretcode
	 *
	 */
	public function shortcodes_init(){
		add_shortcode( 'appointment', [$this,'shortcode_appointment_function'] );
	}

	/**
	 * shortcode_appointment_function
	 * @param array $attr
	 * return string
	 */
	public function shortcode_appointment_function($attr):string {
		$onlinetermin = $this->findById($attr['id']);
		if(!empty($onlinetermin)) {
			$html = $this->twig->render('Frontend/Iframe.html.twig', [
				'onlinetermin' => $onlinetermin
			]);
		} else {
			$html = 'NOT FOUND';
		}
		return $html;
	}

	/**
	 * findById
	 * returns res from table appointment
	 * @return array
	 */
	public function findById($id):array {
		global $wpdb;
		$table_name = $wpdb->prefix . 'appointment';
		$res = $wpdb->get_results("SELECT * FROM $table_name WHERE id = $id");
		if(count($res)>0) {
			return (array) $res[0];
		} else {
			return [];
		}

	}

}
