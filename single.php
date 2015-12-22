<?php get_header(); ?>
	
	<main class="site-main single-article">
		<?php if(have_posts()){ ?>
			<?php while(have_posts()) { the_post(); ?>

				
				
				<div class="site-content">
					<section class="layout">
						
						<div class="primary">

							<article class="hentry">
								<header class="article-header">
										<?php if( get_post_meta(get_the_ID(),'_gsalborz_title',1) !== 'no'){ ?>
											<div class="featured-image">
												<?php echo get_the_post_thumbnail();?>
											</div>
											<div class="article-title">
												<a href="<?php the_permalink(); ?>">
													<h1><?php the_title(); ?></h1>
												</a>
											</div>
											<div class="article-excerpt">
												<?php the_excerpt(); ?>
											</div>
										<?php } ?>
								</header>
								<main class="article-body">
									<?php
											$article_gallery = get_post_meta(get_the_ID(),'_gsalborz_image_list' ,1);
											if(!empty($article_gallery)){
												foreach($article_gallery as $image_src){?>
													<?php $img_thumb_src = gsalborz_get_image_src($image_src,'163x163'); ?>

													<a href="<?php echo $image_src; ?>" rel="prettyPhoto" >
														<img class="article-gallery-image" src="<?php echo $img_thumb_src; ?>" width="163" height="163" />
													</a>


												<?php }
											}
										the_content();
										get_template_part('library/post','meta');
									?>

								</main>
							</article>
											
						</div><!-- primary -->

						<div class="secondary">
							<?php get_sidebar(); ?>
						</div><!-- secondary -->
					</section>
				</div>
			<?php } ?>

		<?php } else { ?>	
			
			<div class="site-content">
				<section class="layout">
					<div class="secondary">
						<?php get_sidebar(); ?>
					</div><!-- secondary -->
				</section>
			</div>

		<?php } ?>
		
	</main>

<?php get_footer(); ?>