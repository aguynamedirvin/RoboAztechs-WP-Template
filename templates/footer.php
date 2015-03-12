	</div><!-- /Main -->
	
	<div class="strip"></div>
	
	<!-- Footer -->
	<footer class="footer" role="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

		<?php if ( is_active_sidebar( 'footer_widgets' ) ) : ?>
			<div class="footer-widgets">
				<?php dynamic_sidebar('footer_widgets'); ?>
			</div>
		<?php endif; ?>


		<!-- Website Info -->
		<div class="footer-note">
			<div class="wrap">
				<div class="siteinfo">
					&#169; <?php echo '2014 - ', date('Y'), ' ', bloginfo( $name ); ?>. All Rights Reserved.
				</div>

				<?php if ( has_nav_menu( 'footer-navigation' ) ) : ?>
					<div class="footer-navigation">
						<?php
							wp_nav_menu (
							array (
								'theme_location'	=> 'footer-nav',
								'container'			=> false,
								'fallback_cb'		=> false,
								'depth'				=> -1
								)
							);
						?>
					</div>
				<?php endif; ?>
				
			</div>
		</div><!-- /Website Info -->

	</footer><!-- /Footer-->

	<!-- JavaScript -->
	<script>
		jQuery(document).ready(function($) {
			function displaySearch() {
				var searchCont 	= $('.search-cont');
				var searchBox 	= $('.search-box');
				var searchClose	= $('.close-search_btn');

				$('.show-search_btn').on('click', function() {
					if (searchCont.hasClass('search-opened')) {
						searchCont.fadeOut().removeClass('search-opened');
					} else {
						searchCont.fadeIn().addClass('search-opened');
						searchBox.focus();
					}
				});

				searchBox.blur(function () {
					searchCont.fadeOut().removeClass('search-opened');
				});

				searchClose.click(function () {
					searchCont.fadeOut().removeClass('search-opened');
				});
			}
			displaySearch();
		});
	</script>
	<!-- /JavaScript -->


<?php wp_footer(); ?>
</body>
</html>