<?php get_header(); ?>
	
	<main class="site-main single-page">
		<?php if(have_posts()){ ?>
			<?php while(have_posts()) { the_post(); ?>

				
				
				<div class="site-content">
					<section class="layout">
						
						<div class="primary">

							<article class="hentry">
								<?php if( get_post_meta(get_the_ID(),'_gsalborz_title',1 ) !== 'no'){ ?>
									<header class="article-title">
											<h1><?php the_title(); ?></h1>
									</header>
								<?php } ?>
								<main class="article-body">
									<?php the_content(); ?>
									
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