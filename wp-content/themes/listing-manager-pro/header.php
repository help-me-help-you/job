<!DOCTYPE html>
<html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="page-wrapper">
    <?php if ( is_active_sidebar( 'topbar-left' ) || is_active_sidebar( 'topbar-right' ) ) : ?>
        <div class="topbar-wrapper">
            <div class="topbar">
                <div class="topbar-inner">
                    <?php if ( is_active_sidebar( 'topbar-left' ) ) : ?>
                        <div class="topbar-left">
                            <?php dynamic_sidebar( 'topbar-left' ); ?>
                        </div><!-- /.topbar-left -->
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'topbar-right' ) ) : ?>
                        <div class="topbar-right">
                            <?php dynamic_sidebar( 'topbar-right' ); ?>
                        </div><!-- /.topbar-right -->
                    <?php endif; ?>
                </div><!-- /.topbar-inner -->
            </div><!-- /.topbar-->
        </div><!-- /.topbar-wrapper -->
    <?php endif; ?>

	<div class="header-wrapper">
        <div class="header">
			<div class="header-inner">
				<div class="header-content">
					<div class="site-branding">
                        <?php $logo = get_custom_logo(); ?>
                        <?php if ( ! empty( $logo ) ) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <a href="<?php echo home_url( '/' ); ?>">
                                <i class="icon-listing-manager listing-manager-logo"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ( 'blank' !== get_theme_mod( 'header_textcolor', true ) ) : ?>
                            <div class="site-branding-content">
                                <div class="site-title">
                                    <a href="<?php echo home_url( '/' ); ?>" class="site-name">
                                        <?php bloginfo( 'name' ); ?>
                                    </a>
                                </div><!-- /.site-title -->
                            </div><!-- /.site-branding-content -->
                        <?php endif; ?>
					</div><!-- /.site-branding -->

					<div class="site-navigation-toggle">
						<span></span>
						<span></span>
						<span></span>
					</div><!-- /.site-navigation-toggle -->

					<?php if ( is_user_logged_in() ) : ?>
                        <div class="user-navigation">
                            <div class="user-navigation-header">
								<?php $info = wp_get_current_user(); ?>

                                <span class="user-navigation-avatar">
                                    <i class="silk silk-user"></i>
		                        </span><!-- /.navbar-user-avatar -->

                                <span class="user-navigation-name">
	                                <?php echo esc_attr( $info->data->user_login ); ?>

                                    <i class="silk silk-chevron-down"></i>
	                            </span><!-- /.navbar-user-name -->
                            </div><!-- /.user-navigation-header -->

							<?php wp_nav_menu( [
								'menu_class'        => 'sub-menu',
								'fallback_cb'       => '',
								'theme_location'    => 'authenticated',
                                'depth'             => 0,
							] ); ?>
                        </div><!-- /.user-navigation -->
					<?php endif; ?>

                    <?php $add_page = get_theme_mod( 'listing_manager_pages_listing_add', null ); ?>
                    <?php if ( ! empty( $add_page ) ) : ?>
                        <div class="site-action-wrapper">
                            <a href="<?php the_permalink( $add_page ); ?>" class="site-action">
                                <i class="silk silk-chevron-down"></i>
                                <span><?php echo esc_html__( 'Submit Listing', 'listing-manager-pro' ); ?></span>
                            </a>

                            <?php if ( class_exists( '\ListingManager\Logic\SubmissionLogic' ) ) : ?>
                                <?php $forms = \ListingManager\Logic\SubmissionLogic::get_submission_forms(); ?>

                                <ul class="sub-menu">
                                    <?php foreach( $forms as $key => $value ) : ?>
                                        <li>
                                            <a href="<?php the_permalink( $add_page ); ?>?form=<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); 7?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div><!-- /.site-action-wrapper -->
                    <?php endif; ?>

					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<a href="<?php echo wc_get_cart_url(); ?>" class="site-cart">
                            <i class="silk silk-cart"></i>

							<?php $count = count( WC()->cart->cart_contents ); ?>
							<span class="badge <?php echo ( 0 === $count ) ? 'empty' : ''; ?>">
								<?php echo esc_html( $count ); ?>
							</span>
						</a>
					<?php endif; ?>

					<?php if ( has_nav_menu( 'primary' ) ) : ?>
						<div class="site-navigation">
							<?php wp_nav_menu( [
								'fallback_cb'       => '',
								'theme_location'    => 'primary',
							] ); ?>
						</div><!-- /.site-navigation -->
					<?php endif; ?>
				</div><!-- /.header-content -->
			</div><!-- /.header-inner -->
		</div><!-- /.header -->
	</div><!-- /.header-wrapper -->

	<?php do_action( 'listing_manager_pro_before_main' ); ?>