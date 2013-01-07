<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="span8 offset2 header">
			<h1><?php bloginfo('name') ?></h1>
			<h2><?php bloginfo('description') ?></h2>
		</div>
	</div>
	<div class="row">
		<div class="span4 offset4">
			<?php 
			if(is_user_logged_in()){
				$current_user = wp_get_current_user();
				echo "Ciao ". $current_user->display_name;
				dynamic_sidebar('002');
			}else{
				
				dynamic_sidebar('001');
			}
			 ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>

