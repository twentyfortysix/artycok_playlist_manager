<?php 
/*
Template name: playlist manager
 */
get_header();
if(is_user_logged_in()){
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
 ?>
	<div class="container" ng-controller="PhoneListCtrl">
		<div class="row">
			<div class="span3">
				<?php $current_user = wp_get_current_user();
				echo "<h4><small>Ciao</small> " . $current_user->display_name ." <br /><small> tohle je tvoje hřiště.</small></h4>"; ?>
				<p>
					<i class="icon-play-circle"></i> otevře přehrávač <br />
					<i class="icon-remove-sign"></i> odstraní z playlistu <br />
					<i class="icon-resize-vertical"></i> přerovnání přetáhnutím myši<br />
					<i class="icon-hand-up"></i> kliknutím se video přesune do playlistu
				</p>
					<a class="btn" href="<?php wp_logout_url() ?>"><i class="icon-off"></i> odhlásit</a>
			</div>
		
			<div class="span5">
				<h4>Playlist</h4>
				<h5>Přednastavený playlist</h5>
				<div class="default_playlist">
					<ul class="hide">
						<li ng-repeat="item in default_playlist">
							<a href="#myModal" ng-click="showModal(item.360p)" class="play" data-target="#myModal" >
								<i class="icon-play-circle" title="Ukázat video"></i>
							</a>
							{{item.name}}
						</li>
					</ul>
					<div class="input-append">
						<span class="btn sh_default_playlist">zobrazit</span>
						<?php 
						$user_playlist_switch = get_the_author_meta( "playlist_switch", $current_user->ID ) ;
						if(!empty($user_playlist_switch)){
							$switch_value = 'true';
						}else{
							$switch_value = 'false';
						}
						?>					
						<span class="btn swith_{{playlist_switch}}">
							<input type="checkbox" name="playlist_switch" ng-model="playlist_switch" ng-init="playlist_switch=<?php echo $switch_value ?>">
							 použít
						</span>
						<span class="btn" ng-click="loadDefaultPlaylist()">
							nahrát do mého
						</span>
					</div>
				</div>
				<h5>Můj playlist</h5>
				<div class="playlist_col">
					<div class="playlist"><small>&nbsp;</small>

						<ul ui-sortable ui-options="{update: update, axis: 'y'}" ng-model="videos">
							<li ng-repeat="item in videos" fadey="500"> <!-- | orderBy:pos:reverse -->
								<a href="#myModal" ng-click="showModal(item.360p)" class="play" data-target="#myModal" >
									<i class="icon-play-circle" title="Ukázat video"></i>
								</a>
								<span class="item">
									<span class="muted">
										{{item.pos}}
									</span>
									<i class="icon-resize-vertical"></i> {{item.name}}
								</span> 
								<i class="rem icon-remove-sign" ng-click="doneFalse()"></i>
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
					<small class="alignright">Vysledné nastavení přehrávače <a href="http://manager.artycok.tv/?author=<?php echo $current_user->ID ?>" target="_blank">zde</a>.</small>
				<!-- 	
						<ul ui-sortable ui-options="{update: update, axis: 'y'}" ng-model="items">
							<li ng-repeat="item in items | filter:{done:true}">
								<span class="item">i{{$index}} {{ item.pos }} / {{ item.name }}</span> <i class="icon-eject" ng-click="doneFalse()"></i>
							</li>
						</ul> -->
					

					<!-- {{ items | filter:{done:true} }} -->
				</div>
			</div>


			<div class="span4 list">
				
				<!--Sidebar content-->
				<h4>Obsah <small>({{items.length}})</small></h4> 
				<div class="input-append">
					<input type="text" class="input-filter" ng-model="query" placeholder="filter" />
					 <button class="add-on clear-filter btn" ng-click="clearFilter()" type="button">Clear</button>
				</div>
				<ul class="items">
					<li ng-repeat="item in items | filter:{done:false} | filter:query" class="item">
						<a href="#myModal" ng-click="showModal(item.360p)" class="play" data-target="#myModal" >
							<i class="icon-play-circle" title="Ukázat video"></i>
						</a>
						<span ng-click="doneTrue()">{{item.name}}</span>
					</li>
				</ul>
			</div>
		</div>
		<!-- START modal container - player -->
		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div id="player_modal"></div>
			</div>
		</div>
		<!-- END modal container - player -->
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('.sh_default_playlist').click(function(){
					if($('.default_playlist ul').hasClass('hide') ){
						$('.default_playlist ul').slideDown().removeClass('hide');
					}else{
						$('.default_playlist ul').slideUp().addClass('hide');
					};
					$(this).text($(this).text() == 'zobrazit' ? 'skrýt' : 'zobrazit');
				});
			});
			
		</script>
	</div>

	
<?php 
} // end is logged in
else{
	dynamic_sidebar('001');
}
get_footer();