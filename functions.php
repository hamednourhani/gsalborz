<?php
/*
Author: Eddie Machado
URL: http://themble.com/gsalborz/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD gsalborz CORE (if you remove this, the theme will break)
require_once( 'library/gsalborz.php' );
// require_once( 'library/notifications.php' );

//Include and setup custom metaboxes and fields.
if( !class_exists("CMB2") ){
    require_once( dirname(__FILE__)."/library/cmb/init.php" );
}
require_once( 'library/cmb-functions.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
 //require_once( 'library/admin.php' );

/*********************
LAUNCH gsalborz
Let's get everything up and running.
*********************/

function gsalborz_ahoy() {

  //Allow editor style.
  //add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'gsalborz', get_template_directory() . '/languages' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'gsalborz_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'gsalborz_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'gsalborz_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'gsalborz_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'gsalborz_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'gsalborz_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  gsalborz_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'gsalborz_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'gsalborz_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'gsalborz_excerpt_more' );

} /* end gsalborz ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'gsalborz_ahoy' );

add_action( 'after_setup_theme', 'gsalborz_woocommerce_support' );
function gsalborz_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
/************* OEMBED SIZE OPTIONS *************/

// if ( ! isset( $content_width ) ) {
//  $content_width = 640;
// }

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'banner', 1040, 430, array( 'center', 'center' ) );
add_image_size( 'product-thumb', 270, 270, array( 'center', 'center' ) );
add_image_size( 'archive-thumb', 163, 163, array( 'center', 'center' ) );
add_image_size( 'widget-thumb', 53, 53, array( 'center', 'center' ) );
add_image_size( 'menu-thumb', 34, 34, array( 'center', 'center' ) );

add_filter( 'image_size_names_choose', 'gsalborz_custom_image_sizes' );

function gsalborz_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'banner' => __('1040px by 430px'),
        'archive-thumb' => __('270px by 270px'),
        'product-thumb' => __('163px by 163px'),
        'widget-thumb' => __('53px by 53px'),
        'menu-thumb' => __('34px by 34px'),

    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/


function gsalborz_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');

  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'gsalborz_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function gsalborz_register_sidebars() {
  register_sidebar(array(
    'id' => 'sidebar',
    'name' => __( 'Sidebar', 'gsalborz' ),
    'description' => __( 'The first (primary) sidebar.', 'gsalborz' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));
  register_sidebar(array(
    'id' => 'footer-col1',
    'name' => __( 'Footer first col', 'gsalborz' ),
    'description' => __( 'The first footer widget area', 'gsalborz' ),
    'before_widget' => '<aside id="%1$s" class="footer-first footer-col1 widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));
  register_sidebar(array(
    'id' => 'footer-col2',
    'name' => __( 'Footer 2d col', 'gsalborz' ),
    'description' => __( 'The first footer widget area', 'gsalborz' ),
    'before_widget' => '<aside id="%1$s" class="footer-first footer-col2 widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));
  register_sidebar(array(
    'id' => 'footer-col3',
    'name' => __( 'Footer 3rd col', 'gsalborz' ),
    'description' => __( 'The first footer widget area', 'gsalborz' ),
    'before_widget' => '<aside id="%1$s" class="footer-first footer-col3 widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));
   register_sidebar(array(
     'id' => 'footer-col4',
     'name' => __( 'Footer 4th Col', 'gsalborz' ),
     'description' => __( 'The first footer widget area', 'gsalborz' ),
     'before_widget' => '<aside id="%1$s" class="footer-first footer-col4 widget %2$s">',
     'after_widget' => '</aside>',
     'before_title' => '<h4 class="widgettitle">',
     'after_title' => '</h4>',
   ));



} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function gsalborz_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'gsalborz' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'gsalborz' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'gsalborz' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'gsalborz' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


function gsalborz_pagination(){
  global $wp_query;

    if($wp_query->max_num_pages > 1){
        $big = 999999999;
        echo /*__('Page : ','gsalborz').*/paginate_links( array(
          'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
          'format' => '?paged=%#%',
          'current' => max( 1, get_query_var('paged') ),
          'total' => $wp_query->max_num_pages,
          'prev_text'    => __('<i class="fa fa-angle-double-left"></i>','gsalborz'),
          'next_text'    => __('<i class="fa fa-angle-double-right"></i>','gsalborz')
        ) );
      }
}


function gsalborz_SearchFilter($query) {
    if ($query->is_search) {
      $query->set('post_type', array('post','product'));
    }
    return $query;
    }

add_filter('pre_get_posts','gsalborz_SearchFilter');

// Enable support for HTML5 markup.
  add_theme_support( 'html5', array(
    'comment-list',
    'search-form',
    'comment-form'
  ) );



/*---------------Widgets----------------------*/

function gsalborz_get_image_src($src="" , $size=""){
    $path_info = pathinfo($src);
    return $path_info['dirname'].'/'.$path_info['filename'].'-'.$size.'.'.$path_info['extension'];
}

//-----------Menu Walker------------------------




function gsalborz_search_form( $form ) {
  global $post,$wp_query,$wpdb;


  if( defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE == 'en'){
      $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
      <div><label class="screen-reader-text" for="s">' . __( 'Search for:','gsalborz' ) . '</label>
      <input type="text" value="' . get_search_query() . '" name="s" id="s" />
      <input type="submit" value="' .  __( 'Search' ) . '" name="submit" id="submit" />
      <input type="hidden" name="lang" value="'.ICL_LANGUAGE_CODE.'"/>
      </div>
      </form>';
  } else {
      $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
      <div><label class="screen-reader-text" for="s">' . __( 'Search for:','gsalborz') . '</label>
      <input type="text" value="' . get_search_query() . '" name="s" id="s" />
      <input type="submit" value="' .  __( 'Search' ) . '" name="submit" id="submit" />
      </div>
      </form>';
  }

  return $form;
}
function gsalborz_menu_search_form() {
  global $post,$wp_query,$wpdb;


  if( defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE == 'en'){
      $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
      <div class="search-form-inner">
        <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' .  __( 'Search' ) . '"/>
        <span name="submit" id="submit" ><i class="fa fa-search"></i></span>
        <input type="hidden" name="lang" value="'.ICL_LANGUAGE_CODE.'"/>
      </div>
      </form>';
  } else {
      $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
      <div  class="search-form-inner">
        <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' .  __( 'Search' ) . '"/>
        <span name="submit" id="submit" ><i class="fa fa-search"></i></span>
      </div>
      </form>';
  }

  return $form;
}



function gsalborz_excerpt_length( $length ) {
  return 20;
}
add_filter( 'excerpt_length', 'gsalborz_excerpt_length', 999 );



if ( defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE=='en'){

        remove_filter('the_title', 'ztjalali_persian_num');
        remove_filter('the_content', 'ztjalali_persian_num');
        remove_filter('the_excerpt', 'ztjalali_persian_num');
        remove_filter('comment_text', 'ztjalali_persian_num');
    // change arabic characters
        remove_filter('the_content', 'ztjalali_ch_arabic_to_persian');
        remove_filter('the_title', 'ztjalali_ch_arabic_to_persian');
        remove_filter('the_excerpt', 'ztjalali_ch_arabic_to_persian');
        remove_filter('comment_text', 'ztjalali_ch_arabic_to_persian');



}


/*------------------Widgets------------------------------------*/

class contact_info_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
        'contact_info_widget',

        // Widget name will appear in UI
        __('Contact Informaion Widget', 'gsalborz'),

        // Widget description
        array( 'description' => __( 'Display Contact Information', 'gsalborz' ), )
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {
        global $wp_query;

        $title = apply_filters( 'widget_title', $instance['title'] );
        $address = $instance['address'];
        $phone = $instance['phone'];
        $fax = $instance['fax'];
        $email = $instance['email'];


        $content = '<main class="widgetbody">';
        $content .='<p><i class="fa fa-map-marker"></i>'.__('Address : ','gsalborz').$address.'</p>';
        $content .='<p><i class="fa fa-phone"></i>'.__('Phone : ','gsalborz').$phone.'</p>';
        $content .='<p><i class="fa fa-fax"></i>'.__('Fax : ','gsalborz').$fax.'</p>';
        $content .='<p><i class="fa fa-envelope"></i>'.__('Email : ','gsalborz').$email.'</p>';
        $content .= '</main>';

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if ( ! empty( $title ) )
          echo $args['before_title'] . $title . $args['after_title'];
          echo $content;
        // This is where you run the code and display the output
          echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( 'Last Posts', 'gsalborz' );
        }

        if ( isset( $instance[ 'address' ] ) ) {
            $address = $instance[ 'address' ];
        }else {
            $address = "No. ----";
        }

        if ( isset( $instance[ 'phone' ] ) ) {
            $phone = $instance[ 'phone' ];
        }else {
            $phone = "+98 ----";
        }

        if ( isset( $instance[ 'fax' ] ) ) {
            $fax = $instance[ 'fax' ];
        }else {
            $fax = "+98 ----";
        }

        if ( isset( $instance[ 'email' ] ) ) {
            $email = $instance[ 'email' ];
        }else {
            $email = "info@email.com";
        }


        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
         <p>
            <label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address :','gsalborz' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text" value="<?php echo esc_attr( $address ); ?>" />
        </p>
         <p>
            <label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone :','gsalborz' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e( 'Fax :','gsalborz' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" type="text" value="<?php echo esc_attr( $fax ); ?>" />
        </p>



        <p>
            <label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email Address :','gsalborz' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
        </p>

        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['address'] = ( ! empty( $new_instance['address'] ) ) ? strip_tags( $new_instance['address'] ) : '';
        $instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? strip_tags( $new_instance['phone'] ) : '';
        $instance['fax'] = ( ! empty( $new_instance['fax'] ) ) ? strip_tags( $new_instance['fax'] ) : '';
        $instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
        return $instance;
    }
} // Class wpb_widget ends here





class last_posts_by_cat_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
        'last_posts_by_cat_widget',

        // Widget name will appear in UI
        __('Last Posts By Category Widget', 'gsalborz'),

        // Widget description
        array( 'description' => __( 'Display Last Posts in Category', 'gsalborz' ), )
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {
        global $wp_query;

        $title = apply_filters( 'widget_title', $instance['title'] );
        $number = $instance['number'];
        $cat = get_category($instance['cat']);


        $posts = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => $number,
            'category'         => $cat->term_id,
            )
        );


        $content = '<ul class="widget-list">';
        foreach($posts as $post) : setup_postdata( $post );
          $url = get_the_permalink($post->ID);
          $thumb = get_the_post_thumbnail($post->ID,'widget-thumb');
          $name = $post->post_title;
          $content .='<li><a href="'.$url.'">'.$thumb.'<span>'.$name.'</span></a></li>';
        endforeach;
        $content .= '</ul>';





        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if ( ! empty( $title ) )
          echo $args['before_title'] . $title . $args['after_title'];
          echo $content;
        // This is where you run the code and display the output
          echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( 'Last Posts', 'gsalborz' );
        }
        if ( isset( $instance[ 'number' ] ) ) {
            $number = $instance[ 'number' ];
        }else {
            $number = 5;
        }
        if ( isset( $instance[ 'cat' ] ) ) {
            $cat = $instance[ 'cat' ];
        }else {
            $cat = "";
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
         <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Post Numbers :','gsalborz' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Post Category :','gsalborz' ); ?></label>
        <?php wp_dropdown_categories(array(
                  'name'               => $this->get_field_name( 'cat' ),
                  'id'                 => $this->get_field_id( 'cat' ),
                  'class'              => 'widefat',
                  'taxonomy'           => 'category',
                  'echo'               => '1',
                  'selected'           => esc_attr($cat ),
            )); ?>
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
        $instance['cat'] = ( ! empty( $new_instance['cat'] ) ) ? strip_tags( $new_instance['cat'] ) : '';
        return $instance;
    }
} // Class wpb_widget ends here


// Register and load the widget
function gsalborz_widget() {
//  register_widget( 'last_products_widget' );
  register_widget( 'last_posts_by_cat_widget' );
  register_widget( 'contact_info_widget' );
}
add_action( 'widgets_init', 'gsalborz_widget' );

/*-----------Shortcodes-------------------------------*/
function gsalborz_products_in_cat( $atts, $content = null ) {
   global $wp_query;
    $a = shortcode_atts( array(
        'cat' => '',
        'title' => '',
        'qty' => -1,
        // ...etc
    ), $atts );

$products = get_posts(array(
                            'post_type' => 'post',
                            'posts_per_page' => $a['qty'],
                            'cat'         => $a['cat'],
                            'suppress_filters' => false,
                            )
                        ); ?>
  <div class="last-products-shortcode">
      <section class="layout">
        <div class="single-cat-title">
           <a href="<?php echo get_category_link($a['cat']); ?>">
            <h3><?php echo $a['title'] ?></h3>
          </a>
        </div>
      </section>
      <?php if(!empty($products)){ ?>


<!--      <section class="layout">-->
         <?php foreach($products as $product){
            setup_postdata( $product ) ; ?>

                <div class="product-grid">
                      <main class="product-body">
                        <div class="featured-image">
                           <a href="<?php echo get_post_permalink($product->ID); ?>">
                               <?php echo get_the_post_thumbnail($product->ID); ?>
                            </a>
                        </div>
                    </main>
                    <header class="product-title">

                       <a href="<?php echo get_post_permalink($product->ID); ?>">
                             <h4><?php echo $product->post_title; ?></h4>
                        </a>
                    </header>
                </div>
        <?php } ?>
<!--        </section>-->
      </div>
  <?php }
  wp_reset_postdata();
}
add_shortcode( 'products', 'gsalborz_products_in_cat' );

class Menu_With_Image extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth = '0', $args = array(), $id = '0') {
    global $wp_query;

    $class_names = $value = '';
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    global $sub_wrapper_before;
    $sub_wrapper_before = "";
    global $sub_wrapper_after;
    $sub_wrapper_after = '';

    if(in_array('mega-menu',$classes)){
      $sub_wrapper_before = '<div class="sub-menu-wrap">';
      $sub_wrapper_after = '</div>';
    }


    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $output .= "\n$indent\n";

    $menu_thumb = "";
    if($item->object == 'post'){
       $menu_thumb = get_the_post_thumbnail($item->object_id , 'menu-thumb');
       //var_dump($menu_thumb);
    }
    $products = array();
    $sub_content = "";

    if($item->object == 'category'){
        $term = get_term($item->object_id,'category');

//        var_dump($term);
        $products = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'category'         => $term->term_id,
            'suppress_filters' => false,

            )
        );
        $sub_content = '<ul class="sub-menu">'.$sub_wrapper_before;
        foreach($products as $product) : setup_postdata( $product );
          //var_dump($product);
          $url = get_the_permalink($product->ID);
          $thumb = get_the_post_thumbnail($product->ID,'menu-thumb');
          $name = $product->post_title;
          $sub_content .='<li id="menu-item-'.$product->ID.'" class="menu-item product-item menu-item-type-post_type menu-item-object-product"><a href="'.$url.'">'.$thumb.$name.'</a></li>';
        endforeach;
        $sub_content .= '</ul>';

    }





    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
    $class_names = ' class="' . esc_attr( $class_names ) . '"';

    $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
    $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
    $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
    $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before .$menu_thumb. '<span>'.apply_filters( 'the_title', $item->title, $item->ID ) .'</span>'. $args->link_after;
    //$item_output .= '<br /><span class="sub">' . $item->description . '</span>';
    $item_output .= '</a>';
     //$item_output .= ;
    //show posts of product cat
     $item_output .= $sub_content;

    $item_output .= $args->after;
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    // depth dependent classes
    global $sub_wrapper_before;
    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
    $classes = array(
        'sub-menu',
        ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
        ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
        'menu-depth-' . $display_depth
        );
    $class_names = implode( ' ', $classes );

    // build html
    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' .$sub_wrapper_before. "\n";
  }

}


?>