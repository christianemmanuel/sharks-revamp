<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sharksbilliardleague
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
  <!-- Mobile -->
  <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

	<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_directory'); ?>/assets/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/assets/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/assets/favicon/favicon-16x16.png">

	<meta name="msapplication-TileColor" content="#EB6900">
	<meta name="theme-color" content="#ffffff">

	<?php wp_head(); ?>
	<title>Sharks - The Mecca Of Pool</title>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<div class="main-content">
    <header class="db-top-menu">
      <div class="open-aside"></div>
      
			<a href="/" class="nav-logo">
				<img src="<?php bloginfo('template_directory'); ?>/assets/revamp/logo.svg" alt="Sharks logo">
			</a>
			
			<div class="navbar">
				<ul>
					<li><a href="/">Home</a></a></li>
					<li><a href="/schedules">Schedules</a></a></li>
					<li><a href="/standings">Standings</a></a></li>
					<li><a href="/teams">Teams</a></a></li>
					<li><a href="/players">Players</a></a></li>
					<li><a href="/videos">Videos</a></a></li>
					<li><a href="/shop">Shop</a></a></li>
				</ul>
			</div>

			<div class="btn-login">
				<?php global $current_user; wp_get_current_user(); ?>
				<?php if ( is_user_logged_in() ) : ?>
					<a class="btn-header" href="javascript:void(0);">Hi, <?php echo $current_user->display_name ?> <i class="icon icon-user" style="border-radius: 50%; background-image: url(<?php echo get_avatar_url( get_current_user_id(), array( 'size' => 50 ) ); ?>);"></i></a>
					<div class="user-dropdown">
						<?php if(current_user_can('editor') || current_user_can('administrator')) { ?>
							<a href="<?php echo get_home_url() . '/wp-admin' ?>">Dashboard</a>
						<?php } ?>
						<!-- <a href="/edit-profile">Edit Profile</a> -->
						<a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a>
					</div>
				<?php else: ?>
					<a class="btn-header" href="<?php echo get_home_url() . '/login' ?>">Watch Now!</a>
				<?php endif; ?>
			</div>
			
    </header>
    
