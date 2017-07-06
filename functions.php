<?php
/**
 * metronic functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package metronic
 */

if (!function_exists('metronic_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function metronic_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on metronic, use a find and replace
         * to change 'metronic' to the name of your theme in all the template files.
         */
        load_theme_textdomain('metronic', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'metronic'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('metronic_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');
    }
endif;
add_action('after_setup_theme', 'metronic_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function metronic_content_width()
{
    $GLOBALS['content_width'] = apply_filters('metronic_content_width', 640);
}

add_action('after_setup_theme', 'metronic_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function metronic_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'metronic'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'metronic'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'metronic_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function metronic_scripts()
{
    wp_enqueue_style('metronic-style', get_stylesheet_uri());

    wp_enqueue_script('metronic-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);

    wp_enqueue_script('metronic-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'metronic_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

require get_template_directory() . '/inc/registration.php';

function true_status_custom()
{
    register_post_status('completed', array(
        'label' => 'Completed',
        'label_count' => _n_noop('Completed <span class="count">(%s)</span>', 'Completeds <span class="count">(%s)</span>'),
        'public' => true,
        'show_in_admin_status_list' => true // если установить этот параметр равным false, то следующий параметр можно удалить
    ));
}

add_action('init', 'true_status_custom');

function true_append_post_status_list()
{
    global $post;
    $optionselected = '';
    $statusname = '';
    if ($post->post_type == 'post') { // если хотите, можете указать тип поста, для которого регистрируем статус, а можете и вовсе избавиться от этого условия
        if ($post->post_status == 'completed') { // если посту присвоен статус архива
            $optionselected = ' selected="selected"';
            $statusname = "$('#post-status-display').text('Completeds');";
        }
        /*
         * Код jQuery мы просто выводим в футере
         */
        echo "<script>
		jQuery(function($){
			$('select#post_status').append('<option value=\"completed\"$optionselected>Completed</option>');
			$statusname
		});
		</script>";
    }
}

add_action('admin_footer-post-new.php', 'true_append_post_status_list'); // страница создания нового поста
add_action('admin_footer-post.php', 'true_append_post_status_list'); // страница редактирования поста

function true_status_display($statuses)
{
    global $post;
    if (get_query_var('post_status') != 'completed') { // проверка, что мы не находимся на странице всех постов данного статуса
        if ($post->post_status == 'completed') { // если статус поста - Архив
            return array('Completed');
        }
    }
    return $statuses;
}

add_filter('display_post_states', 'true_status_display');


## Оставляет пользователя на той же странице при вводе неверного логина/пароля в форме авторизации wp_login_form()
add_action('wp_login_failed', 'my_front_end_login_fail');
function my_front_end_login_fail($username)
{
    $referrer = $_SERVER['HTTP_REFERER'];  // откуда пришел запрос

    // Если есть referrer и это не страница wp-login.php
    if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin')) {
        wp_redirect(add_query_arg('login', 'failed', $referrer));  // редиркетим и добавим параметр запроса ?login=failed
        exit;
    }
}
add_action('admin_menu', 'admin_menu_invoice');
function admin_menu_invoice(){
    add_menu_page(
        'Invoice', 'Invoice', 'manage_options', 'invoice', 'func_admin_menu_invoice', get_stylesheet_directory_uri() . '/assets/img/icons-sidebar/plugins-grey.png', 7
    );
}
function func_admin_menu_invoice(){
    require "inc/admin/invoice.php";
}

add_action('admin_menu', 'admin_menu_vreo_plugins');
function admin_menu_vreo_plugins(){
    add_menu_page(
        'Vreo Plugins', 'Vreo Plugins', 'manage_options', 'vreo_plugins', 'func_admin_menu_vreo_plugins', get_stylesheet_directory_uri() . '/assets/img/icons-sidebar/plugins-grey.png', 7
    );
}
function func_admin_menu_vreo_plugins(){
 require "inc/admin/vreo_plugins.php";
}
function vreo_styles(){
    wp_enqueue_style("vreo_styles",get_bloginfo('stylesheet_directory')."/assets/css/vreo_styles.css");
}

add_action('admin_head', 'vreo_styles');
add_action( 'wp_default_scripts', function( $scripts ) {
    if ( ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
    }
} );
add_action('admin_menu', 'register_my_custom_menu_page');
function register_my_custom_menu_page()
{
    add_menu_page(
        'Activities', 'Activities', 'manage_options', 'activities', 'my_custom_menu_page', get_stylesheet_directory_uri() . '/assets/img/icons-sidebar/activites-grey.png', 6
    );
}

function my_custom_menu_page()
{ ?>
    <h3><?php _e('Activities message for users', 'your_domain'); ?></h3>
    <form method="POST" id="formx" action="<?php echo get_stylesheet_directory_uri() ?>/inc/admin-message.php" ">
    <?php wp_editor('', 'activitiesAdmin', array(
    'wpautop' => 1,
    'media_buttons' => 0,
    'textarea_name' => 'activitiesAdmin', //нужно указывать!
    'textarea_rows' => 10,
    'tabindex' => null,
    'editor_css' => '',
    'editor_class' => '',
    'teeny' => 0,
    'dfw' => 0,
    'tinymce' => 1,
    'quicktags' => 1,
    'drag_drop_upload' => false
)); ?>
    <br>
    <div id="timePublish"></div>
    <button onclick="timeMessageAdmin();">Send to message</button>
    <script>
        function timeMessageAdmin() {
            Data = new Date();
            var Year = Data.getFullYear();
            var Month = Data.getMonth() + 1;
            var Day = Data.getDate();
            var Hour = Data.getHours();
            var Minutes = Data.getMinutes();
            var Seconds = Data.getSeconds();
            var out = Year + '-' + Month + '-' + Day + ' ' + Hour + ':' + Minutes + ':' + Seconds;
            var timePublish = document.getElementById('timePublish');
            timePublish.outerHTML = '<input type="hidden" name="timePublish" value="' + out + '">'
        }
    </script>
    <?php
    if (isset($_GET['status'])) :
        switch ($_GET['status']) :
            case 'ok': {
                echo '<div class="success" style="font-size: 20px; font-weight: bold; color: #16a728;">Your messange sent.</div>';
                break;
            }
            case 'required': {
                echo '<div class="error" style="font-size: 20px; font-weight: bold; color: #b93b41;">Please fill in all required fields.</div>';
                break;
            }
        endswitch;
    endif;
    ?>
    </form>

<?php }

add_action('draft_post', 'draft_post_action', 10, 2);
function draft_post_action($post_id, $post)
{
    $cur_user_id = get_current_user_id();
    $user_info = get_userdata($cur_user_id);
    if (in_array('administrator', $user_info->roles)) $role = 'administrator';
    if ($role == "administrator") {
        global $wpdb;
        $post = get_post($post_id);

        $timezone = timezone_name_from_abbr("", intval($_COOKIE['timezone']) * 60, 0);
        $date = new DateTime("", new DateTimeZone($timezone));
        $date = $date->format('Y-m-d H:i:s');
        $wpdb->insert(
            'activities',
            array(
                'id_user' => $post->post_author,
                'type_notifications' => 'adminMessageAll',
                'message' => "Your advertising campaign "
                    . "<form action=\"" . get_site_url() . "/edit-campaign/edit\" class=\"form__close_cmpgn\" method=\"post\" >
                    <input type=\"hidden\" name=\"edit\" value=\"$post_id\" />
                    <button type='submit'>$post->post_title</button>            
                    </form> closed",
                'status' => 0,
                'data' => $date,
                'categories' => '',
                'hash_tag' => ''
            ),
            array('%s', '%s')
        );
    }
}

function true_include_myuploadscript()
{
    // у вас в админке уже должен быть подключен jQuery, если нет - раскомментируйте следующую строку:
    // wp_enqueue_script('jquery');
    // дальше у нас идут скрипты и стили загрузчика изображений WordPress
    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
    // само собой - меняем admin.js на название своего файла
    wp_enqueue_script('myuploadscript', get_stylesheet_directory_uri() . '/js/slider_admin/admin.js', array('jquery'), null, false);
}

add_action('admin_enqueue_scripts', 'true_include_myuploadscript');
function jquery_connect() {
    // отменяем зарегистрированный jQuery
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', false, null, true );
    wp_enqueue_script( 'jquery' );
}

add_action( 'admin_enqueue_scripts', 'jquery_connect' );

function true_image_uploader_field($name, $value = '', $w = 115, $h = 90)
{
    $default = get_stylesheet_directory_uri() . "/assets/img/no_photo.jpg";
    if ($value) {
        $image_attributes = wp_get_attachment_image_src($value[0], array($w, $h));
        $src = $image_attributes[0];
    } else {
        $src = $default;
    }
    echo '
	<div class="upload__image__wrap">
		<img data-src="' . $default . '" src="' . $src . '" width="' . $w . 'px" height="' . $h . 'px" />
		<div>
		    <input type="hidden" name="path" value="' . $default . '" class="pathEmpty">
			<button type="submit" class="upload_image_button button">Upload</button>
			<button type="submit" class="remove_image_button button">&times;</button>
		</div>
	</div>
	';
}

function true_add_options_page_u()
{
    if (isset($_GET['page']) && $_GET['page'] == 'uplsettings') {
        if (isset($_REQUEST['action']) && 'save' == $_REQUEST['action']) {
            update_option('uploader_custom', $_REQUEST['uploader_custom']);
            header("Location: " . site_url() . "/wp-admin/options-general.php?page=uplsettings&saved=true");
            die;
        }
    }
    add_submenu_page('options-general.php', 'Дополнительные настройки', 'Slider', 'edit_posts', 'uplsettings', 'true_print_options_u');
}

function true_print_options_u()
{
    if (isset($_REQUEST['saved'])) {
        echo '<div class="updated"><p>Saved.</p></div>';
    }
    ?>
    <div class="wrap">
        <form method="post">
            <?php
            if (function_exists('true_image_uploader_field')) {
                true_image_uploader_field('uploader_custom', get_option('uploader_custom'));
            }
            ?><p class="submit">
                <!--            <input type="button" class="add__upload__image" onclick="event.preventDefault()" value="Add Image" class="button action" />-->
                <input name="save" type="submit" class="button-primary" value="Save changes"/>
                <input type="hidden" name="action" value="save"/>
            </p>
        </form>

    </div>
    <?php
    if (!empty(get_option('uploader_custom'))) {
        foreach (get_option('uploader_custom') as $image) {
            if (!empty(wp_get_attachment_url($image))) {
                echo "<img src=\"" . wp_get_attachment_url($image) . "\" style='width:200px; margin-right:20px; margin-bottom:20px;'>";
            }
        }
    }
}

add_action('admin_menu', 'true_add_options_page_u');



?>
