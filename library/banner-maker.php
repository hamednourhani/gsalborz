



<?php if(is_category() || is_tag() || is_tax()){ ?>
		

		
			<div class="banner-wrapper">
				<div class="single-cat-title">
					<section class="layout">
						<h1><?php single_cat_title('',true); ?></h1>
					</section>
				</div>
			</div>
			

<?php } elseif(is_singular()) {
		$banner_mod = get_post_meta(get_the_ID(),'_gsalborz_banner_mod',1);

		switch ($banner_mod) {
			case 'slider':
				$slider_shortcode = get_post_meta(get_the_ID(),'_gsalborz_slider_shortcode',1);
				echo '<div class="banner-wrapper">'.do_shortcode($slider_shortcode).'</div>';
				break;
			case 'image':
				$image = get_post_meta( get_the_ID(), '_gsalborz_image',1 );
				echo '<div class="banner-wrapper"><div class="banner-inner"><img class="page-banner" src="'.$image.'"/></div></div>';
				break;
			case 'map':
				$map = get_post_meta( get_the_ID(), '_gsalborz_map',1 );
				echo '<div class="banner-wrapper"><div class="banner-inner">'.$map.'</div></div>';
				break;
			default: 
				echo '<div class="banner-space"></div>';
				break;
		} ?>
<?php } elseif(is_search()){ ?>
	<?php echo '<div class="banner-wrapper"><div class="banner-inner">';
		  echo get_search_form('false');
			echo '</div></div>';
	?>
<?php } else{ ?>
		<div class="banner-space">
		</div>
<?php  } ?>