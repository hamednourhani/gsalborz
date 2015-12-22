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

add_filter( 'image_size_names_choose', 'gsalborz_custom_image_sizes' );

function gsalborz_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'banner' => __('1040px by 430px'),
        'archive-thumb' => __('270px by 270px'),
        'product-thumb' => __('163px by 163px'),
        'widget-thumb' => __('53px by 53px'),

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
   

  if(ICL_LANGUAGE_CODE == 'en' || ICL_LANGUAGE_CODE == 'it'){
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
   

  if(ICL_LANGUAGE_CODE == 'en' || ICL_LANGUAGE_CODE == 'it'){
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



if ( ICL_LANGUAGE_CODE=='en'){ 
  
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

/* DON'T DELETE THIS CLOSING TAG */ 
/*---------------Widgets----------------------*/

// Creating the widget 
//class last_products_widget extends WP_Widget {
//
//    function __construct() {
//        parent::__construct(
//        // Base ID of your widget
//        'last_products_widget',
//
//        // Widget name will appear in UI
//        __('Last Products Widget', 'gsalborz'),
//
//        // Widget description
//        array( 'description' => __( 'Display Last Products', 'gsalborz' ), )
//        );
//    }
//
//    // Creating widget front-end
//    // This is where the action happens
//    public function widget( $args, $instance ) {
//        global $wp_query;
//
//        $title = apply_filters( 'widget_title', $instance['title'] );
//        $number = $instance['number'];
//        $term = get_term($instance['cat'],'product_cat');
//
//        //var_dump($instance);
//        $products = get_posts(array(
//            'post_type' => 'product',
//            'posts_per_page' => $number,
//            'product_cat'         => $term->slug,
//            )
//        );
//
//        $content = '<ul class="widget-list">';
//        foreach($products as $product) : setup_postdata( $product );
//          $url = get_the_permalink($product->ID);
//          $thumb = get_the_post_thumbnail($product->ID,'product-thumb');
//          $name = $product->post_title;
//          $content .='<li><a href="'.$url.'">'.$thumb.'<span>'.$name.'</span></a><li>';
//        endforeach;
//        $content .= '</ul>';
//
//
//
//
//
//        // before and after widget arguments are defined by themes
//        echo $args['before_widget'];
//
//        if ( ! empty( $title ) )
//          echo $args['before_title'] . $title . $args['after_title'];
//          echo $content;
//        // This is where you run the code and display the output
//          echo $args['after_widget'];
//    }
//
//    // Widget Backend
//    public function form( $instance ) {
//        if ( isset( $instance[ 'title' ] ) ) {
//            $title = $instance[ 'title' ];
//        }else {
//            $title = __( 'Last Products', 'gsalborz' );
//        }
//        if ( isset( $instance[ 'number' ] ) ) {
//            $number = $instance[ 'number' ];
//        }else {
//            $number = 5;
//        }
//        if ( isset( $instance[ 'cat' ] ) ) {
//            $cat = $instance[ 'cat' ];
//        }else {
//            $cat ="";
//        }
//        // Widget admin form
//        ?>
<!--        <p>-->
<!--            <label for="--><?php //echo $this->get_field_id( 'title' ); ?><!--">--><?php //_e( 'Title:' ); ?><!--</label> -->
<!--            <input class="widefat" id="--><?php //echo $this->get_field_id( 'title' ); ?><!--" name="--><?php //echo $this->get_field_name( 'title' ); ?><!--" type="text" value="--><?php //echo esc_attr( $title ); ?><!--" />-->
<!--        </p>-->
<!--         <p>-->
<!--            <label for="--><?php //echo $this->get_field_id( 'number' ); ?><!--">--><?php //_e( 'product Numbers :','gsalborz' ); ?><!--</label>-->
<!--            <input class="widefat" id="--><?php //echo $this->get_field_id( 'number' ); ?><!--" name="--><?php //echo $this->get_field_name( 'number' ); ?><!--" type="text" value="--><?php //echo esc_attr( $number ); ?><!--" />-->
<!--        </p>-->
<!--        <p>-->
<!--            <label for="--><?php //echo $this->get_field_id( 'cat' ); ?><!--">--><?php //_e( 'Product Category :','gsalborz' ); ?><!--</label>-->
<!--           --><?php //wp_dropdown_categories(array(
//                  'name'               => $this->get_field_name( 'cat' ),
//                  'id'                 => $this->get_field_id( 'cat' ),
//                  'class'              => 'widefat',
//                  'taxonomy'           => 'product_cat',
//                  'echo'               => '1',
//                  'selected'          =>esc_attr( $cat ),
//            )); ?>
<!---->
<!---->
<!--        </p>-->
<!--        -->
<!--        --><?php //
//    }
//
//    // Updating widget replacing old instances with new
//    public function update( $new_instance, $old_instance ) {
//        $instance = array();
//        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
//        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
//        $instance['cat'] = ( ! empty( $new_instance['cat'] ) ) ? strip_tags( $new_instance['cat'] ) : '';
//        //var_dump($instance);
//        return $instance;
//    }
//} // Class wpb_widget ends here



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
                            'category'         => $a['cat'],
                            )
                        ); ?>
  <div class="last-products-shortcode">
      <section class="layout">
        <div class="single-cat-title">
          <h3><?php echo $a['title'] ?></h3>
        </div>
      </section>
      <?php if(!empty($products)){ ?>


      <section class="layout">
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
        </section>
      </div>
  <?php }
  wp_reset_postdata();
}
add_shortcode( 'products', 'gsalborz_products_in_cat' );

/*----------------Pharmacy search -----------------------*/
// class Pharmacy {
//       public $name = "";
//       public $hobbies  = "";
//       public $birthdate = "";
//    }
  
//    $p = new Pharmacy();
//    $p->name = "sachin";
//    $p->hobbies  = "sports";
//    $p->birthdate = date('m/d/Y h:i:s a', "8/5/1974 12:20:03 p");
//    $p->birthdate = date('m/d/Y h:i:s a', strtotime("8/5/1974 12:20:03"));

//   json_encode($p);
//   json_decode ($json [,$assoc = false [, $depth = 512 [, $options = 0 ]]])




// $jsonIterator = new RecursiveIteratorIterator(
//     new RecursiveArrayIterator(json_decode($json, TRUE)),
//     RecursiveIteratorIterator::SELF_FIRST);

// foreach ($jsonIterator as $key => $val) {
//     if(is_array($val)) {
//         echo "$key:\n";
//     } else {
//         echo "$key => $val\n";
//     }
// }


// $fruits = array("a" => "lemon", "b" => "orange", array("a" => "apple", "p" => "pear"));

// $iterator = new RecursiveArrayIterator($fruits);

// while ($iterator->valid()) {

//     if ($iterator->hasChildren()) {
//         // print all children
//         foreach ($iterator->getChildren() as $key => $value) {
//             echo $key . ' : ' . $value . "\n";
//         }
//     } else {
//         echo "No children.\n";
//     }

//     $iterator->next();
// }


// $string = file_get_contents("/home/michael/test.json");
// dirname(__FILE__)
// string dirname ( string $path [, int $levels = 1 ] )
// getcwd();
// chdir( $dir );



// function get_file_dir() {
//     global $argv;
//     $dir = dirname(getcwd() . '/' . $argv[0]);
//     $curDir = getcwd();
//     chdir($dir);
//     $dir = getcwd();
//     chdir($curDir);
//     return $dir;
// }
// So you can use it like this:
// include get_file_dir() . '/otherfile.php';
// // or even..
// chdir(get_file_dir());
// include './otherfile.php';


//------------ product order form ----------------
//function html_form_code() {
//
//   $posts = get_posts(array(
//          'post_type' => 'product',
//          'posts_per_page' => -1,
//          'suppress_filters' => false,
//          )
//      );
//
//      $product_select = '<select multiple="multiple" class="select-products" name="cf-products[]" >';
//      foreach($posts as $post) : setup_postdata( $post );
//        $name = $post->post_title;
//        $product_select .='<option value="'.$name.'">'.$name.'</option>';
//      endforeach;
//     $product_select .= '</select>';
//
//
//  echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post" class="order-products">';
//  echo '<p>';
//  echo __('Your Name (required)','gsalborz'). '<br/>';
//  echo '<input type="text" name="cf-name"  value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" />';
//  echo '</p>';
//  echo '<p>';
//  echo __('Your Email (required)','gsalborz'). '<br/>';
//  echo '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
//  echo '</p>';
//   echo __('Your Phone (required)','gsalborz'). '<br/>';
//  echo '<input type="text" name="cf-phone" value="' . ( isset( $_POST["cf-phone"] ) ? esc_attr( $_POST["cf-phone"] ) : '' ) . '" size="40" />';
//  echo '</p>';
//  echo '<p>';
//  echo  __('Products List (required)','gsalborz'). '<br/>';
//  echo  $product_select;
//  echo '</p>';
//  echo '<p>';
//  echo  __('More Information (required)','gsalborz'). '<br/>';
//  echo '<textarea rows="10" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
//  echo '</p>';
//  echo '<p><input type="submit" name="cf-submitted" value="'.__('Order Products','gsalborz').'"></p>';
//  echo '</form>';
//}
//
//
//function set_html_content_type() {
//  return 'text/html';
//}
//
//function deliver_mail() {
//
//  // if the submit button is clicked, send the email
//  if ( isset( $_POST['cf-submitted'] ) ) {
//    $ordered_products ="";
//    $counter = 1;
//    // sanitize form values
//    $name    = sanitize_text_field( $_POST["cf-name"] );
//    $email   = sanitize_email( $_POST["cf-email"] );
//    $phone   = sanitize_text_field( $_POST["cf-phone"] );
//    $products = $_POST["cf-products"];
//
//    foreach ($_POST['cf-products'] as $product){
//       $ordered_products .= '<span>'.$counter.' - '.$product.'</span><br />';
//       $counter++;
//    }
//
//    $message = "<div style='direction:rtl;text-align:right;'>";
//    $message .= "<p>".__('Name : ','gsalborz').$name."</p>"."\r\n";
//    $message .= "<p>".__('Phone Number : ','gsalborz').$phone."</p><br />"."\r\n";
//    $message .= "<p>".__('Email : ','gsalborz').$email."</p><br />"."\r\n";
//    $message .= "<p>".__('Products : ','gsalborz')."</p><br /><p>"."\r\n".$ordered_products."</p><br />"."\r\n";
//    $message .= "<p>".esc_textarea( $_POST["cf-message"] )."\r\n"."</p>"."</div>";
//
//    // get the blog administrator's email address
//    $to = get_option( 'admin_email' );
//
//    $headers = array('From: '.$name.'<'.$email.'>');
//    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
//
//
//    // If email has been process for sending, display a success message
//    if ( wp_mail( $to, __('Order Products','gsalborz'), $message, $headers ) ) {
//      echo '<div>';
//      echo '<p class="success-message">'.__('Thanks for Ordering Products, We will contact you as soon as posible.','gsalborz'). '</p>';
//      echo '</div>';
//    } else {
//      echo '<p class="failed-message">'.__('An unexpected error occurred','gsalborz').'</p>';
//    }
//
//    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
//
//  }
//}
//
//function cf_shortcode() {
//  ob_start();
//  deliver_mail();
//  html_form_code();
//
//  return ob_get_clean();
//}
//
//add_shortcode( 'product_order_form', 'cf_shortcode' );




?>