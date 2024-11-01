<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */ 
require_once dirname(__FILE__).'/libs/load_libs.php';
           
function simplelender_class($class_name){
	$class_instance = new $class_name();
	return $class_instance;
}

require_once dirname(__FILE__).'/data_manager/data_manager.php';
require_once dirname(__FILE__).'/user/simplelender_account.php';
require_once dirname(__FILE__).'/loans/simplelender_loan.php';
require_once dirname(__FILE__).'/simplelender_api.php';
require_once dirname(__FILE__).'/events/simplelender_events_manager.php';

class simplelender_init{
	
    public function init(){
		$this->load_hooks();
    }
	
    public function load_hooks(){
		$this->register_my_session();
		simplelender_class('simplelender_loan')->init();
        simplelender_class('simplelender_gravity_form_manager')->init();
		simplelender_class('simplelender_account')->init();
		simplelender_class('simplelender_raw_data')->init();
        if ( simplelender_fs()->is_plan('growth') ) {
            simplelender_class('simplelender_events_manager')->init();        
        }
        add_action('simplelender_borrower_top_menu',[$this,'borrower_top_menu']);
    }
        
    public function register_my_session(){
        if( ! session_id() ) {
            session_start();
        }
        //unset( $_SESSION["simplelender"]);
    }

    public function borrower_top_menu(){
        $top_menu_html = '<div class="logout_link_wrapper">
                    <div id="simplelender_dash_menu">
                        <nav id="site-navigation" class="simplelender_dash_menu" role="navigation" aria-label="Top Menu">
                        </nav>
                    </div>
                <span class="logout_link">';
       // $client_id=
        $user = wp_get_current_user();
        $client_id = mvc_model('simplelenderClientaccount')->find_one([
                        'conditions'=>[
                            'wp_user_id'=>$user->data->ID
                        ]])->id;
       $client_notification_count = mvc_model('simplelenderNotification')->count([
                                            'conditions'=>[
                                                'status'=>1,
                                                'user_id'=>$client_id
                                        ]]);
        $top_menu_html .= "<a href='". mvc_public_url(array('controller' => 'simplelender_clientloans', 'action' => 'index',))."'> <b>Loan Applications</b> </a> | ";
        if ( simplelender_fs()->is_plan('growth') ) {
            $top_menu_html .= "<a href='". mvc_public_url(array('controller' => 'simplelender_messages', 'action' => 'index',))."'> <b>Open Tickets</b> </a> | ";
        }
        $top_menu_html .= "<a href='". mvc_public_url(array('controller' => 'simplelender_clientloans', 'action' => 'notification','id'=>$client_id))."'> Notifications <b>(".$client_notification_count.")</b> </a> | ";
        $top_menu_html .= "<b> - ".$user->data->user_nicename." </b>";                
        $top_menu_html .= "<a href=".wp_logout_url($_SERVER['REDIRECT_URL'])."><button>Logout</button></a></span></div>";

        echo $top_menu_html;
    }
}

register_nav_menus( array(
        'simplelender_client_admin_menu' => __( 'Simplelender Client Admin menu', 'simplelender' ),
    ));
add_action('after_setup_theme', 'sl_remove_admin_bar');

function sl_remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar(false);
    }
}


function sl_request_business(){
	$messages = 'We are happy to be of service to you, <b>comminicate & follow up on leads like a pro.</b>';
	if ( !simplelender_fs()->is_plan('growth') ) {
		$url = MvcRouter::admin_url(array('controller' => 'simplelender_messages' , 'action' => 'go_pro'));
		$MvcAdminController = new MvcAdminController();
		$MvcAdminController->flash('notice', $messages );
		$MvcAdminController->redirect($url);
	}
}

add_action("sl_require_pro_action","sl_request_business");

function sl_do_track(){
	
	if (simplelender_fs()->is_plan('growth')){
		echo "
			<!-- Facebook Pixel Code -->
				<script>
					!function(f,b,e,v,n,t,s)
					{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
					n.callMethod.apply(n,arguments):n.queue.push(arguments)};
					if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
					n.queue=[];t=b.createElement(e);t.async=!0;
					t.src=v;s=b.getElementsByTagName(e)[0];
					s.parentNode.insertBefore(t,s)}(window,document,'script',
					'https://connect.facebook.net/en_US/fbevents.js');
					fbq('init', '2077079475867950'); 
					fbq('track', 'Subscribe', {
						value: 20,
						currency: 'usd',
						subscription_id: '1',
					  });
				</script>
				<noscript>
				 <img height='1' width='1' 
				src='https://www.facebook.com/tr?id=2077079475867950&ev=Subscribe
				&noscript=1'/>
				</noscript>
			<!-- End Facebook Pixel Code -->
		";
		update_option('sm_current_plan','growth');
	}
	
	if(simplelender_fs()->is_plan('connect')){
		echo "
			<!-- Facebook Pixel Code -->
				<script>
					!function(f,b,e,v,n,t,s)
					{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
					n.callMethod.apply(n,arguments):n.queue.push(arguments)};
					if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
					n.queue=[];t=b.createElement(e);t.async=!0;
					t.src=v;s=b.getElementsByTagName(e)[0];
					s.parentNode.insertBefore(t,s)}(window,document,'script',
					'https://connect.facebook.net/en_US/fbevents.js');
					fbq('init', '2077079475867950'); 
					fbq('track', 'Subscribe', {
						value: 70,
						currency: 'usd',
						subscription_id: '2',
					  });
				</script>
				<noscript>
				 <img height='1' width='1' 
				src='https://www.facebook.com/tr?id=2077079475867950&ev=Subscribe
				&noscript=1'/>
				</noscript>
			<!-- End Facebook Pixel Code -->
			";
		update_option('sm_current_plan','connect');
	}

	if(simplelender_fs()->is_plan('enterprise')){
		echo "
			<!-- Facebook Pixel Code -->
				<script>
					!function(f,b,e,v,n,t,s)
					{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
					n.callMethod.apply(n,arguments):n.queue.push(arguments)};
					if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
					n.queue=[];t=b.createElement(e);t.async=!0;
					t.src=v;s=b.getElementsByTagName(e)[0];
					s.parentNode.insertBefore(t,s)}(window,document,'script',
					'https://connect.facebook.net/en_US/fbevents.js');
					fbq('init', '2077079475867950'); 
					fbq('track', 'Subscribe', {
						value: 700,
						currency: 'usd',
						subscription_id: '3',
					  });
				</script>
				<noscript>
				 <img height='1' width='1' 
				src='https://www.facebook.com/tr?id=2077079475867950&ev=Subscribe
				&noscript=1'/>
				</noscript>
			<!-- End Facebook Pixel Code -->";
			update_option('sm_current_plan','enterprise');
	}

}

function sm_check_status(){
	//update_option('sm_current_plan','enterpriser');
	$sm_current_plan = get_option('sm_current_plan');
	
	if(!simplelender_fs()->is_plan($sm_current_plan) ){
		sl_do_track();
	}
}

function sl_hide_mitem(){
echo "
<script type='text/javascript'>
	jQuery('.current').hide();
</script>";
}

add_action("admin_footer",'sm_check_status');
?>

