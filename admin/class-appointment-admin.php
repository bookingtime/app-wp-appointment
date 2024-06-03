<?php
if ( ! defined( 'ABSPATH' ) ) exit;

require_once(__DIR__ . '/../vendor/autoload.php');
include(ABSPATH . "wp-includes/pluggable.php");


use bookingtime\phpsdkapp\Sdk;
use bookingtime\phpsdkapp\Sdk\Exception\RequestException;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\XliffFileLoader;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.bookingtime.com/
 * @since      1.0.0
 *
 * @package    Appointment
 * @subpackage Appointment/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Appointment
 * @subpackage Appointment/admin
 * @author     bookingtime <appointment@bookingtime.com>
 */
class Appointment_Admin {

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
	public $timezone;
	protected $user;
	protected $sdk;
	protected $sectorList = [];
	protected $twig;
	protected $host;
	protected $framework;
	protected $translator;
	protected $countries;
	protected $organizationTemplateLanguageSuffix = 'EN';

   const APPOINTMENT_MODULE_CONFIG_SHORT = 'MODULE_CONFIG_SHORT';
   const APPOINTMENT_MODULE_ID = '23C4ejWwJt9G78gSYIAmhTrTzs2PoHb2';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		ob_start();

		//check for WP_HOME
		if (!defined('WP_HOME')) {
			$wp_home_array = $this->getFromOptionsTable('home');
			if(!empty($wp_home_array)) {
				define('WP_HOME',$wp_home_array[0]->option_value);
			} else {
				define('WP_HOME','');
			}
		}

		//check for file with globals for react
		$this->checkIfFileExists(plugin_dir_path( __DIR__ ).'blocks/appointment_globals.json');

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'admin_menu', array( $this, 'appointmentSetupMenu' ) );

		//get user/wp-config/global locale & timezone
		$this->user = wp_get_current_user();
		$this->locale = $this->getLocale();
		$this->timezone =  $this->getTimezone();

      //sdk connection
		$clientId = 'c5dIniVAkJUMQglgIeIOrKaDHiku3aCmBBKHU9uGH1jGm64gGcnYlsWJIseqgNrm';
		$clientSecret = 'hX8gUbPMa1gJZpjruvfYRBnfTR0AmK2WJAC73KnjJN498jDzUkFSYCCbX7swYqga';
		$configArray = [
			'appApiUrl'=>'https://api.bookingtime.com/app/v3/',
			'oauthUrl'=>'https://auth.bookingtime.com/oauth/token',
			'locale'=>$this->locale,
			'timeout'=>15,
			'mock'=>FALSE,
		];

		//make sdk auth
      $this->sdk = new Sdk($clientId,$clientSecret,$configArray);

      //get static sector list
      $this->sectorList = $this->sdk->static_sector_list([]);

		//get all countries
		$this->countries = $this->sdk->static_country_list([]);

		//init translator
		$this->translator = new Translator($this->locale);
      $this->translator->addLoader('xlf', new XliffFileLoader());
		$this->translator->addResource('xlf',__DIR__.'/../languages/appointment_'.$this->locale.'.xlf',$this->locale);

		//init twig
      $this->twig = new Environment(new FilesystemLoader(__DIR__.'/templates/'));
		$this->twig->addExtension(new TranslationExtension($this->translator));

		//build host
		$this->host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/';


		if($this->getLocale() === 'de') {
			$this->organizationTemplateLanguageSuffix = 'DE';
		} else {
			$this->organizationTemplateLanguageSuffix = 'EN';
		}


		if (!session_id()) {
			session_start();
		}
	}

	public function checkIfFileExists($file) {
		global $wp_filesystem;
		// Initialize the WP filesystem, no more using 'file-put-contents' function
		if (empty($wp_filesystem)) {
			require_once (ABSPATH . '/wp-admin/includes/file.php');
			WP_Filesystem();
		}

		// Überprüfen, ob das Dateisystem initialisiert ist
		if ( ! is_wp_error( $wp_filesystem ) && WP_Filesystem() ) {
			// Überprüfen, ob die Datei existiert
			if ( ! $wp_filesystem->exists( $file ) ) {
					$json = array(
						'wp_home' => home_url() // WP_HOME ersetzt durch home_url()
					);

					// Dateiinhalt vorbereiten
					$file_content = wp_json_encode( $json );

					// Datei schreiben
					if ( $wp_filesystem->put_contents( $file, $file_content, FS_CHMOD_FILE ) !== false ) {
						// Erfolgsmeldung oder weitere Aktionen bei Bedarf
						return;
					} else {
						// Fehlerbehandlung, falls das Schreiben der Datei fehlschlägt
						return;
					}
			}
		}
  }

	/**
	 * getFromOptionsTable
	 * Returns rows from the options table based on option_name
	 * @param string $option_name The name of the option to retrieve
	 * @return array|null Returns an array of rows if found, null otherwise
	 */
	public function getFromOptionsTable($option_name) {
		global $wpdb;
		$res = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}options WHERE option_name = %s", $option_name));
		return $res;
	}

	/**
	 * Register the stylesheets for the admin area.
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
		wp_enqueue_style( $this->plugin_name . '-lightbox', '/wp-content/plugins/bt_appointment/assets/css/lightbox.min.css', [], $this->version, 'all');
		wp_enqueue_style( $this->plugin_name . '-bootstrap-icons', '/wp-content/plugins/bt_appointment/assets/css/bootstrap-icons.min.css', [], $this->version, 'all');
		wp_enqueue_style( $this->plugin_name . '-bootstrap', '/wp-content/plugins/bt_appointment/assets/css/bootstrap.min.css', [], $this->version, 'all');
		wp_enqueue_style( $this->plugin_name . '-style', plugin_dir_url( __FILE__ ) . 'css/appointment-admin.css',[], $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script( $this->plugin_name . '-lightbox', '/wp-content/plugins/bt_appointment/assets/js/lightbox.min.js', [], $this->version, false);
		wp_enqueue_script( $this->plugin_name . '-bootstrap-bundle', '/wp-content/plugins/bt_appointment/assets/js/bootstrap.bundle.min.js', [], $this->version, false);
		wp_enqueue_script( $this->plugin_name . '-script', plugin_dir_url( __FILE__ ) . 'js/appointment-admin.js',[], $this->version, false );
	}

	/**
	 * appointmentSetupMenu
	 * loads menu
	 */
	public function appointmentSetupMenu() {
		add_menu_page( 'bookingtime', 'bookingtime', 'read', 'appointment-init', [$this, 'appointment_init'], WP_HOME . '/wp-content/plugins/bt_appointment/assets/icon.png' );
		add_submenu_page( null, 'Appointment Step 1', 'Step 1', 'read', 'appointment-step1', [$this, 'appointment_step1'] );
		add_submenu_page( null, 'Appointment Step 2', 'Step 2', 'read', 'appointment-step2', [$this, 'appointment_step2'] );
		add_submenu_page( null, 'Appointment Step 3', 'Step 3', 'read', 'appointment-step3', [$this, 'appointment_step3'] );
		add_submenu_page( null, 'Appointment get bookingtimepage-urls', 'Get bookingtimepage-urls', 'read', 'appointment-getbookingtimepageurls', [$this, 'appointment_getbookingtimepageurls'] );
		add_submenu_page( null, 'Appointment List', 'List', 'read', 'appointment-list', [$this, 'appointment_list'] );
		add_submenu_page( null, 'Appointment Edit', 'Edit', 'read', 'appointment-edit', [$this, 'appointment_edit'] );
		add_submenu_page( null, 'Appointment Add', 'Add', 'read', 'appointment-add', [$this, 'appointment_add'] );
		add_submenu_page( null, 'Appointment Preview', 'Preview', 'read', 'appointment-preview', [$this, 'appointment_preview'] );
	}

	/**
	 * appointment_getbookingtimepageurls
	 */
	public function appointment_getbookingtimepageurls() {
		return wp_send_json($this->findAll());
	}

	/**
	 * appointment_init
	 */
	public function appointment_init() {
		if($this->checkDBRows() < 1) {
			exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-step1')));
		} else {
			exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-list')));
		}
    	echo wp_kses($this->twig->render('Appointment/Init.html.twig', [
			'currentNavItem' => 'init'
		]),$this->getAllowedHtml());
	}

	/**
	 * appointment_step1
	 */
	public function appointment_step1() {
		//redirect to settings when rows in db
		if($this->checkDBRows() > 0) {
			exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-add')));
		}

		echo wp_kses($this->twig->render('Appointment/Step1.html.twig', [
			'currentNavItem' => 'step1',
			'flashMessages' => (isset($_SESSION['flashmessage']) ? $_SESSION['flashmessage'] : NULL),
			'locale' => $this->locale,
			'WP_HOME' => WP_HOME,
		]),$this->getAllowedHtml());

		//destroy session
		session_destroy();
	}

	/**
	 * appointment_step2
	 */
	public function appointment_step2() {

		//redirect to settings when rows in db
		if($this->checkDBRows() > 0) {
			exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-add')));
		}

		//validate step2
		if(!empty($_POST)) {
			$step2Data = $_POST;
			if($this->validateStep2($step2Data)) {

				$step2Data['appointment']['locale'] = $this->locale;
				$step2Data['appointment']['phpTimeZone'] = $this->timezone;
				$_SESSION['appointment']['email'] = sanitize_email($step2Data['appointment']['email']);

				//create contractAccount
				try {
					$contractAccount=$this->sdk->contractAccount_add([],$this->makeContractAccountDataArray($step2Data['appointment']));
				} catch(RequestException $e) {
					//flashmessage
					$_SESSION['flashmessage'][] = [
						'title' => $this->translator->trans('flashmessage.step2.error.contractAccount.title',['var1'=>$e->getCode()]),
						'message' => $this->translator->trans('flashmessage.step2.error.contractAccount.body',['var1'=>$e->getMessage()]),
						'alertclass' => 'error'
					];
					//redirect
					exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-step2')));
				}

				//create organization
				try {
					$step2Data['appointment']['contractAccount'] = $contractAccount;
					$organizantion = $this->sdk->organization_add([],$this->makeParentOrganizationDataArray($step2Data['appointment']));
				} catch(RequestException $e) {
					//flashmessage
					$_SESSION['flashmessage'][] = [
						'title' => $this->translator->trans('flashmessage.step2.error.organization.title',['var1'=>$e->getCode()]),
						'message' => $this->translator->trans('flashmessage.step2.error.organization.body',['var1'=>$e->getMessage()]),
						'alertclass' => 'error'
					];
					//redirect
					exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-step2')));
				}

				//write to db
				if($this->writeOrganizationResponseToDB($organizantion['recordList'])) {
					//flashmessage
					$_SESSION['flashmessage'][] = [
						'title' => $this->translator->trans('flashmessage.step2.title'),
						'message' => $this->translator->trans('flashmessage.step2.body'),
						'alertclass' => 'success'
					];
					//redirect to step3
					exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-step3')));
				} else {
					//flashmessage
					$_SESSION['flashmessage'][] = [
						'title' => $this->translator->trans('flashmessage.step2.title.error'),
						'message' => $this->translator->trans('flashmessage.step2.body.error'),
						'alertclass' => 'error'
					];
					exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-step2')));
				}

			} else {
				exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-step1')));
			}
		}

    	echo wp_kses($this->twig->render('Appointment/Step2.html.twig', [
			'currentNavItem' => 'step2',
			'locale' => $this->locale,
			'countries' => $this->countries['recordList'],
			'flashMessages' => (isset($_SESSION['flashmessage']) ? $_SESSION['flashmessage'] : NULL),
			'WP_HOME' => WP_HOME,
		]),$this->getAllowedHtml());

		unset($_SESSION['flashmessage']);
	}

	/**
	 * appointment_step3
	 */
	public function appointment_step3() {
    	echo wp_kses($this->twig->render('Appointment/Step3.html.twig', [
			'currentNavItem' => 'step3',
			'email' => isset($_SESSION['appointment']['email']) ? sanitize_email($_SESSION['appointment']['email']) : $this->translator->trans('step2.form.email.placeholder'),
			'locale' => $this->locale,
			'maxId' => 	$this->getMaxId(),
			'flashMessages' => (isset($_SESSION['flashmessage']) ? $_SESSION['flashmessage'] : NULL),
			'WP_HOME' => WP_HOME,
		]),$this->getAllowedHtml());

		unset($_SESSION['flashmessage']);
	}

	/**
	 * appointment_list
	 */
	public function appointment_list() {
		$bookingtimepageurls = $this->findAll();
    	echo wp_kses($this->twig->render('Appointment/List.html.twig', [
			'currentNavItem' => 'list',
			'bookingtimepageurls' => $bookingtimepageurls,
			'locale' => $this->locale,
			'flashMessages' => (isset($_SESSION['flashmessage']) ? $_SESSION['flashmessage'] : NULL),
			'WP_HOME' => WP_HOME,
		]),$this->getAllowedHtml());

		unset($_SESSION['flashmessage']);
	}

	/**
	 * appointment_add
	 */
	public function appointment_add() {

		//create
		if(isset($_POST['appointment']) && !empty($_POST['appointment']['url']) && $this->validateUrl($_POST['appointment']['url']) && $this->validateTitle($_POST['appointment']['title'])) {

			$data['url'] = sanitize_url($_POST['appointment']['url']);
			$data['title'] = sanitize_text_field($_POST['appointment']['title']);
			$this->appointment_create($data);
			exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-list')));
		}

    	echo wp_kses($this->twig->render('Appointment/Add.html.twig', [
			'currentNavItem' => 'add',
			'locale' => $this->locale,
			'flashMessages' => (isset($_SESSION['flashmessage']) ? $_SESSION['flashmessage'] : NULL),
			'WP_HOME' => WP_HOME,
		]),$this->getAllowedHtml());

		unset($_SESSION['flashmessage']);
	}

	/**
	 * appointment_edit
	 */
	public function appointment_edit() {
		//delete
		if(isset($_GET['delete_bookingtimepageurl']) && is_numeric($_GET['delete_bookingtimepageurl']) && intval($_GET['delete_bookingtimepageurl']) > 0) {
			$id = intval($_GET['delete_bookingtimepageurl']);
			$this->appointment_delete($id);
		}

		//update
		if(isset($_POST['appointment']) && !empty($_POST['appointment']['url']) && $this->validateUrl($_POST['appointment']['url']) && $this->validateTitle($_POST['appointment']['title'])) {
			$data['url'] = sanitize_url($_POST['appointment']['url']);
			$data['title'] = sanitize_text_field($_POST['appointment']['title']);
			$data['id'] = intval($_POST['appointment']['id']);
			$this->appointment_update($data);
		}

		$bookingtimepageurl = NULL;
		if(isset($_GET['edit_bookingtimepageurl']) && $_GET['edit_bookingtimepageurl'] > 0) {
 			$bookingtimepageurl = $this->findById((int) $_GET['edit_bookingtimepageurl']);
		} else {
			exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-list')));
		}

    	echo wp_kses($this->twig->render('Appointment/Edit.html.twig', [
			'currentNavItem' => 'preview',
			'bookingtimepageurl' => $bookingtimepageurl,
			'locale' => $this->locale,
			'flashMessages' => (isset($_SESSION['flashmessage']) ? $_SESSION['flashmessage'] : NULL),
			'WP_HOME' => WP_HOME,
		]),$this->getAllowedHtml());

		unset($_SESSION['flashmessage']);
	}

	/**
	 * appointment_preview
	 */
	public function appointment_preview() {
		$bookingtimepageurl = NULL;
		if(isset($_GET['preview_bookingtimepageurl']) && $_GET['preview_bookingtimepageurl'] > 0) {
 			$bookingtimepageurl = $this->findById((int) $_GET['preview_bookingtimepageurl']);
		} else {
			exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-list')));
		}

    	echo wp_kses($this->twig->render('Appointment/Preview.html.twig', [
			'currentNavItem' => 'preview',
			'bookingtimepageurl' => $bookingtimepageurl,
			'locale' => $this->locale,
			'flashMessages' => (isset($_SESSION['flashmessage']) ? $_SESSION['flashmessage'] : NULL),
			'WP_HOME' => WP_HOME,
		]),$this->getAllowedHtml());

		unset($_SESSION['flashmessage']);
	}


	/**
	 * appointment_delete
	 * @param int $bookingtimepageurl
	 * @return void
	 */
	public function appointment_delete(int $bookingtimepageurl):void {
		if($bookingtimepageurl > 0 && is_int($bookingtimepageurl)) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'appointment';
			$res = $this->findById($bookingtimepageurl);

			if($wpdb->delete( $table_name, ['id' => $bookingtimepageurl])) {
				//flashmessage
				$_SESSION['flashmessage'][] = [
					'title' => $this->translator->trans('flashmessage.delete.title',['var1'=>htmlentities($res['title'])]),
					'message' => $this->translator->trans('flashmessage.delete.body',['var1'=>$res['url']]),
					'alertclass' => 'success'
				];
			} else {
				//flashmessage
				$_SESSION['flashmessage'][] = [
					'title' => $this->translator->trans('flashmessage.delete.title.error'),
					'message' => $this->translator->trans('flashmessage.delete.body.error'),
					'alertclass' => 'error'
				];
			}

		}
		exit(esc_html(wp_redirect(WP_HOME . '/wp-admin/admin.php?page=appointment-list')));
	}


	/**
	 * getMaxId
	 * returns max id from table appointment
	 * @return int|false
	 */
	public function getMaxId() {
		global $wpdb;
		$res = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}appointment ORDER BY id DESC LIMIT 1");
		if(isset($res[0])) {
			return (int) $res[0]->id;
		} else {
			return false;
		}
	}

	/**
	 * findById
	 * returns res from table appointment
	 * @return array
	 */
	public function findById($id): array {
		global $wpdb;
		$res = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}appointment WHERE id = %d", $id));
		if (count($res) > 0) {
			return (array) $res[0];
		} else {
			return [];
		}
	}


	/**
	 * findAll
	 * returns all rows in table appointment
	 * @return array
	 */
	public function findAll(): array {
		global $wpdb;
		$res = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}appointment");
		return $res;
	}

	/**
	 * checkDBRows
	 * returns number of rows in table appointment
	 * @return int
	 */
	public function checkDBRows(): int {
		global $wpdb;
		$wpdb->get_results("SELECT * FROM {$wpdb->prefix}appointment");
		return $wpdb->num_rows;
	}

   /**
    * @param string $email
    * @return boolean
    */
   public function validateEmailAddress($email): bool {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
         return true;
      } else {
         return false;
      }
   }

	/**
	 * validateTitle
	 * @param string $title
	 *
	 * @return bool
	 */
	public function validateTitle($title):bool {
		if (trim($title) !== '') {
			return true;
		} else {
			//flashmessage
			$_SESSION['flashmessage'][] = [
				'title' => $this->translator->trans('flashmessage.validateTitle.title'),
				'message' => $this->translator->trans('flashmessage.validateTitle.body'),
				'alertclass' => 'error'
			];
			return false;
		}
	}

	/**
	 * validateUrl
	 * @param string $url
	 *
	 * @return bool
	 */
	public function validateUrl($url):bool {
		if (filter_var($url, FILTER_VALIDATE_URL)) {
			return true;
		} else {
			//flashmessage
			$_SESSION['flashmessage'][] = [
				'title' => $this->translator->trans('flashmessage.validateUrl.title'),
				'message' => $this->translator->trans('flashmessage.validateUrl.body'),
				'alertclass' => 'error'
			];
			return false;
		}
	}

   /**
	 * validateStep2
    * @param array $arguments
    */
   public function validateStep2($arguments):bool {

		if(!isset($arguments['terms']) && $arguments['terms'] != 1) {
			return false;
		}

		if(!isset($arguments['dsgvo'])  && $arguments['dsgvo'] != 1) {
			return false;
		}

      foreach ($arguments['appointment'] as $key => $value) {
         if(is_array($key))  {
            foreach ($key as $addressKey) {
               if (array_key_exists($addressKey, $arguments['appointment']['address'])) {
                  switch ($addressKey) {
                     case 'street':
                     case 'zip':
                     case 'city':
                     case 'country':
                        if ($arguments['appointment']['address'][$addressKey] == '') {
                           return false;
                        }
                     break;
                  }
               }
            }
         } else {
            if (array_key_exists($key, $arguments['appointment'])) {
               switch ($key) {
                  case 'firstname':
                  case 'lastname':
                  case 'company':
                     if ($arguments['appointment'][$key] == '') {
                        return false;
                     }
                     break;
                  case 'email':
                     if ($arguments['appointment'][$key] == '' || !$this->validateEmailAddress($arguments['appointment'][$key])) {
                        return false;
                     }
                     break;
               }
            } else {
               return false;
            }
         }
      }
      return true;
   }

   /**
    * put data from form in dataArray for customerGroup
    *
    * @param	array		$formArray: data from form
    * @return	array		$contractAccountDataArray: array with all data to create contractAccount
    */
   public function makeContractAccountDataArray($formData): array
   {
      $contractAccountDataArray = [
         'name' => $formData['company'],
         'locale' => $formData['locale'],
         'timeZone' => $formData['phpTimeZone'],
         'admin' => [
            'gender' => 'NOT_SPECIFIED',
            'firstName' => $formData['firstname'],
            'lastName' => $formData['lastname'],
            'email' => $formData['email'],
         ],
         'contactPerson' => [
            'gender' => 'NOT_SPECIFIED',
            'firstName' => $formData['firstname'],
            'lastName' => $formData['lastname'],
            'email' => $formData['email'],
         ],
         'address' => [
            'name' => $formData['company'],
            'street' => $formData['address']['street'],
            'zip' => $formData['address']['zip'],
            'city' => $formData['address']['city'],
            'country' => $formData['address']['country']
         ],
         'invoiceEmail' => $formData['email'],
      ];
      return $contractAccountDataArray;
   }

   /**
    *  put data from form in dataArray for organization
    *
    * @param	array		$formData: data from form
    * @return	array		$parentOrganizationDataArray: array with all data to create parentOrganization
    */
   public function makeParentOrganizationDataArray($formData): array
   {
      $parentOrganizationDataArray = [
         'name' => $formData['contractAccount']['name'],
         'contractAccountId' => $formData['contractAccount']['id'],
         'address' => [
            'name' => $formData['company'],
            'street' => $formData['address']['street'],
            'zip' => $formData['address']['zip'],
            'city' => $formData['address']['city'],
            'country' => $formData['address']['country']
         ],
         'sector' => '01ab',
         'email' => $formData['email'],
         'contactPerson' => [
            'gender' => 'NOT_SPECIFIED',
            'firstName' => $formData['firstname'],
            'lastName' => $formData['lastname'],
            'email' => $formData['email'],
         ],
         'settings' => [
            'locale' => $formData['locale'],
            'timeZone' => $formData['phpTimeZone'],
            'emailReply' => $formData['email'],
         ],
         'admin' => [
            'gender' => 'NOT_SPECIFIED',
            'firstName' => $formData['firstname'],
            'lastName' => $formData['lastname'],
            'email' => $formData['email'],
         ],
         'organizationTemplateList' => [
            'DEFAULT_' . $this->organizationTemplateLanguageSuffix
         ]
      ];
      return $parentOrganizationDataArray;
   }

   /**
    * writeOrganizationResponseToDB
    * @param array $recordList
    * @return bool
    */
   public function writeOrganizationResponseToDB(array $recordList):bool {
      foreach ($recordList as $key => $rec) {
         if($rec['class'] === self::APPOINTMENT_MODULE_CONFIG_SHORT && $rec['moduleId'] === self::APPOINTMENT_MODULE_ID) {
            //create new entry to db
            global $wpdb;
				$tablename = $wpdb->prefix . 'appointment';

				$wpdb->insert($tablename, array(
					'title' => sanitize_text_field($rec['moduleName']),
					'url' => sanitize_url('https://module.bookingtime.com/booking/organization/'.$rec['organizationId'].'/moduleConfig/' . $rec['id'])
				));
				return true;
         }
      }
      return false;
   }

   /**
    * appointment_create
    * @param array $data
    * @return bool
    */
	public function appointment_create(array $data):bool {
		global $wpdb;
		$tablename = $wpdb->prefix . 'appointment';

		//insert in db
		$wpdb->insert($tablename, array(
			'title' => sanitize_text_field(trim($data['title'])),
			'url' => sanitize_url($data['url'])
		));

		//flashmessage
		$_SESSION['flashmessage'][] = [
			'title' => $this->translator->trans('flashmessage.add_edit.title',['var1'=>htmlentities(trim($data['title']))]),
			'message' => $this->translator->trans('flashmessage.add_edit.body',['var1'=>$data['url']]),
			'alertclass' => 'success'
		];

		return true;
	}

   /**
    * appointment_update
    * @param array $data
    * @return bool
    */
	public function appointment_update(array $data):bool {
		global $wpdb;
		$tablename = $wpdb->prefix . 'appointment';

		//update db
		$wpdb->update($tablename,['title' => sanitize_text_field(trim($data['title'])),'url' => sanitize_url($data['url'])],['id' => $data['id']]);

		//flashmessage
		$_SESSION['flashmessage'][] = [
			'title' => $this->translator->trans('flashmessage.add_edit.title',['var1'=>sanitize_text_field(trim($data['title']))]),
			'message' => $this->translator->trans('flashmessage.add_edit.body',['var1'=>sanitize_url($data['url'])]),
			'alertclass' => 'success'
		];

		return true;
	}

	/**
	 * getLocale()
	 * @return string
	 */
	public function getLocale() {
		if(substr(get_user_meta($this->user->ID, 'locale', true),0,2) !== '') {
			return substr(get_user_meta($this->user->ID, 'locale', true),0,2);
		}
		if(get_locale() !== '') {
			if(strlen(get_locale())>2) {
				return substr(get_locale(),0,2);
			} else {
				return get_locale();
			}
		}
		if(locale_get_default() !== '') {
			if(strlen(locale_get_default())>2) {
				return substr(locale_get_default(),0,2);
			} else {
				return locale_get_default();
			}
		}
		return 'en';
	}

	/**
	 * getTimezone()
	 * @return string
	 */
	public function getTimezone() {
		if(get_user_meta($this->user->ID, 'timezone', true) !== '') {
			return get_user_meta($this->user->ID, 'timezone', true) !== '';
		}
		if(get_option('timezone_string') !== '') {
			return get_option('timezone_string');
		}
		if(date_default_timezone_get() !== '') {
			return date_default_timezone_get();
		}
		return 'Europe/Berlin';
	}

	function getAllowedHtml() {

		global $allowedposttags;
		$allowed_atts = [
			'align' => [],
			'class'=> [],
			'type' => [],
			'id' => [],
			'dir'=> [],
			'lang' => [],
			'style'=> [],
			'xml:lang' => [],
			'src'=> [],
			'alt'=> [],
			'href' => [],
			'rel'=> [],
			'rev'=> [],
			'target' => [],
			'novalidate' => [],
			'placeholder' => [],
			'required' => [],
			'checked' => [],
			'selected' => [],
			'type' => [],
			'value'=> [],
			'name' => [],
			'tabindex' => [],
			'action' => [],
			'method' => [],
			'for'=> [],
			'width'=> [],
			'height' => [],
			'data' => [],
			'title'=> [],
			'aria-label'=> [],
			'aria-labelledby'=> [],
			'aria-expanded'=> [],
			'aria-hidden'=> [],
			'data-bs-dismiss'=> [],
			'data-bs-toggle'=> [],
			'data-bs-target'=> [],
			'data-lightbox'=> [],
			'data-title'=> [],
		];
		$allowedposttags['button'] = $allowed_atts;
		$allowedposttags['form'] = $allowed_atts;
		$allowedposttags['label'] = $allowed_atts;
		$allowedposttags['input'] = $allowed_atts;
		$allowedposttags['textarea'] = $allowed_atts;
		$allowedposttags['select'] = $allowed_atts;
		$allowedposttags['option'] = $allowed_atts;
		$allowedposttags['checkbox'] = $allowed_atts;
		$allowedposttags['radio'] = $allowed_atts;
		$allowedposttags['iframe'] = $allowed_atts;
		$allowedposttags['script'] = $allowed_atts;
		$allowedposttags['style'] = $allowed_atts;
		$allowedposttags['strong'] = $allowed_atts;
		$allowedposttags['small'] = $allowed_atts;
		$allowedposttags['table'] = $allowed_atts;
		$allowedposttags['span'] = $allowed_atts;
		$allowedposttags['abbr'] = $allowed_atts;
		$allowedposttags['code'] = $allowed_atts;
		$allowedposttags['pre'] = $allowed_atts;
		$allowedposttags['div'] = $allowed_atts;
		$allowedposttags['img'] = $allowed_atts;
		$allowedposttags['h1'] = $allowed_atts;
		$allowedposttags['h2'] = $allowed_atts;
		$allowedposttags['h3'] = $allowed_atts;
		$allowedposttags['h4'] = $allowed_atts;
		$allowedposttags['h5'] = $allowed_atts;
		$allowedposttags['h6'] = $allowed_atts;
		$allowedposttags['ol'] = $allowed_atts;
		$allowedposttags['ul'] = $allowed_atts;
		$allowedposttags['li'] = $allowed_atts;
		$allowedposttags['em'] = $allowed_atts;
		$allowedposttags['hr'] = $allowed_atts;
		$allowedposttags['br'] = $allowed_atts;
		$allowedposttags['tr'] = $allowed_atts;
		$allowedposttags['td'] = $allowed_atts;
		$allowedposttags['p'] = $allowed_atts;
		$allowedposttags['a'] = $allowed_atts;
		$allowedposttags['b'] = $allowed_atts;
		$allowedposttags['i'] = $allowed_atts;
		return $allowedposttags;
	}

}
