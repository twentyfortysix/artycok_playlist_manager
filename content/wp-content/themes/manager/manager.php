<?php 
/*
Template name: playlist manager
 */
get_header();
if(is_user_logged_in()){
 ?>
	<div class="container" ng-controller="PhoneListCtrl">
		<div class="row">
			<div class="span4">
				<?php $current_user = wp_get_current_user();
				echo "<h4><small>Hi</small> " . $current_user->display_name ." <small>this is your playground.</small></h4>"; ?>
			</div>
		
			<div class="span4">
				{{tmp}}
				<h4>Playlist</h4>
				<?php 
				$user_playlist_switch = get_the_author_meta( "playlist_switch", $current_user->ID ) ;
				if(!empty($user_playlist_switch)){
					$switch_value = 'true';
				}else{
					$switch_value = 'false';
				}
				?>
				<input type="checkbox" name="playlist_switch" ng-model="playlist_switch" ng-init="playlist_switch=<?php echo $switch_value ?>"> Použij přednastavený playlist <br>
				<h5>Můj playlist</h5>
				<div class="playlist"><small>&nbsp;</small>

					<ul ui-sortable ui-options="{update: update, axis: 'y'}" ng-model="videos">
				<li ng-repeat="item in videos | orderBy:pos:reverse" fadey="500">
					<span class="item"><span class="muted">{{item.pos}} </span><i class="icon-resize-vertical"></i> {{item.name}}</span> <i class="rem icon-remove-sign" ng-click="doneFalse()"></i>
				</li>
			</ul>
					<!-- <ul ui-sortable ui-options="{update: update, axis: 'y'}" ng-model="videos">
						<li ng-repeat="item in videos | orderBy:pos:reverse" fadey="500">
							<span class="item">{{item.pos}} / {{item.name}}</span> <i class="icon-eject" ng-click="doneFalse()"></i>
						</li>
					</ul>
 -->
					<!-- START later with wordpress use nonce -->
					<?php	// secure the connection
					$nonce = wp_create_nonce  ('artycok-playlist-nonce');

					echo '<input type="hidden" name="nonce" value="'. $nonce .'" ng-init="nonce=\''.$nonce.'\'"/>';
					// <input type="hidden" name="master._wp_http_referer" value="'. get_permalink( $post->ID ).'" ng-init="master._wp_http_referer='.get_permalink( $post->ID ).'" />';
					wp_nonce_field( 'f2046_name_3t2thv23lj626', 'nonce_field' ); ?>
					<!-- END later with wordpress use nonce -->

					
					<!-- <pre ng-bind="videos | orderBy:pos | json "></pre> -->
				</div>
				<!-- save tha playlist -->
				<input class="form_submit wide" type="submit" ng-click="submit()" value="Save" />
				<div ng-bind-html-unsafe="answer" class="message"></div>
			<!-- 	
					<ul ui-sortable ui-options="{update: update, axis: 'y'}" ng-model="items">
						<li ng-repeat="item in items | filter:{done:true}">
							<span class="item">i{{$index}} {{ item.pos }} / {{ item.name }}</span> <i class="icon-eject" ng-click="doneFalse()"></i>
						</li>
					</ul> -->
				

				<!-- {{ items | filter:{done:true} }} -->
			</div>


			<div class="span4 list">
				<!--Sidebar content-->
				<h4>Obsah <small>({{items.length}})</small></h4> 
				<input type="text" class="wide" ng-model="query" placeholder="filter">
				

				<!--Body content-->

				<ul class="items">
					<li ng-repeat="item in items | filter:{done:false} | filter:query " ng-click="doneTrue()" class="item">
						<i class="icon-chevron-left"></i> {{item.name}}

						<!-- <div class="hide">
							<br><small><b>360p: </b>{{item.360p}}</small>
							<br><small><b>720p: </b>{{item.720p}}</small>
							<br><small><b>1080p: </b>{{item.1080p}}</small>
						</div> -->
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php 
} // end is logged in
else{
	dynamic_sidebar('001');
}
get_footer();