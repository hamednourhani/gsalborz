<!-- ********************************************************************* -->
<!--****************** Site footer      ***********************************-->
<!-- ********************************************************************* -->


<footer class="site-footer">

    <?php get_sidebar('footer-first'); ?>

    <div class="credit-holder">
        <section class="layout">
            <div class="footer-logo">
                <?php
                    if(is_rtl()){
                        echo '<img src="' . get_template_directory_uri() . '/images/gsalborz-logo-fa-200.png" class="footer-fa-logo" />';

                    }else {
                        echo '<img src="' . get_template_directory_uri() . '/images/gsalborz-logo-en-200.png" class="footer-en-logo" />';

                    }
                ?>
            </div>

            <div class="credit">
                <?php echo __('Alborz Industrial Group © 2015. All Right Reserved', 'gsalborz'); ?>
                <span class="site-holder">
                    <?php echo __('Designed by ','gsalborz').'<a href="http://karait.com">'.__('Farakaranet','gsalborz').'</a>';?>
                </span>
            </div>

        </section>
    </div>
</footer>


</div>

<?php wp_footer(); ?>
</body><!-- body -->
</html><!-- html -->