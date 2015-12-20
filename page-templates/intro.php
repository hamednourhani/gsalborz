<?php
/**
* Template Name: Intro Page
*
*
*/
get_header(); ?>

    <main class="site-main intro-main">
        <?php if(have_posts()){ ?>
            <?php while(have_posts()) { the_post(); ?>
               <div class="intro-content">
                    <section class="layout">
                        <div class="intro-logo">
                            <?php echo '<img src="'.get_template_directory_uri().'/images/gsalborz-logo.png" />';?>
                        </div>
                        <div class="intro-text">
                            <?php echo '<img src="'.get_template_directory_uri().'/images/gsalborz-text.png" />';?>
                        </div>

                    </section>
                </div>
                <div class="intro-buttons">
                    <a href="#" class="intro-fa-button">
                        <?php echo '<img src="'.get_template_directory_uri().'/images/gsalborz-ib-fa.png" />'?>
                    </a>
                    <a href="#" class="intro-en-button">
                        <?php echo '<img src="'.get_template_directory_uri().'/images/gsalborz-ib-en.png" />'?>
                    </a>
                </div>
            <?php } ?>

        <?php } else { ?>

            <div class="intro-content">
                <section class="layout">

                </section>
            </div>

        <?php } ?>

    </main>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".intro-content").addClass('show-intro');
            $(".intro-buttons").addClass('show-intro');

        });
    </script>
    <noscript>
        <style>
            .intro-content{
                display : block;
            }
            .intro-buttons{
                display: block;
            }
        </style>
    </noscript>

<?php get_footer(); ?>