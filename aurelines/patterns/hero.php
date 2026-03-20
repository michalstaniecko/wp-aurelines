<?php
/**
 * Title: Hero
 * Slug: aurelines/hero
 * Categories: aurelines
 * Keywords: hero, home
 */
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_template_directory_uri() . '/assets/images/akrobatka.png' ); ?>","dimRatio":80,"customOverlayColor":"#1F3FAE","minHeight":100,"minHeightUnit":"vh","isDark":true,"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|60","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}}} -->
<div class="wp-block-cover alignfull is-dark" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--30);min-height:100vh" id="home">
	<span aria-hidden="true" class="wp-block-cover__background has-background-dim-80 has-background-dim" style="background-color:#1F3FAE"></span>
	<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/akrobatka.png' ); ?>" data-object-fit="cover" />
	<div class="wp-block-cover__inner-container">
		<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
		<div class="wp-block-group">
			<!-- wp:aurelines/badge {"text":"Szkoła akrobatyki powietrznej","variant":"hero"} /-->

			<!-- wp:heading {"textAlign":"center","level":1,"textColor":"text-light","style":{"typography":{"fontWeight":"300","fontSize":"4.5rem","letterSpacing":"-0.03em"},"spacing":{"margin":{"top":"var:preset|spacing|30"}}},"className":"aurelines-reveal aurelines-reveal-delay-1"} -->
			<h1 class="wp-block-heading has-text-align-center has-text-light-color has-text-color aurelines-reveal aurelines-reveal-delay-1" style="margin-top:var(--wp--preset--spacing--30);font-weight:300;font-size:4.5rem;letter-spacing:-0.03em">Odkryj piękno ruchu w powietrzu</h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"align":"center","textColor":"text-light","style":{"typography":{"fontSize":"1.25rem","fontWeight":"300"},"spacing":{"margin":{"top":"var:preset|spacing|20"}}},"className":"aurelines-hero-subtitle aurelines-reveal aurelines-reveal-delay-2"} -->
			<p class="has-text-align-center has-text-light-color has-text-color aurelines-hero-subtitle aurelines-reveal aurelines-reveal-delay-2" style="margin-top:var(--wp--preset--spacing--20);font-size:1.25rem;font-weight:300">Szkoła akrobatyki powietrznej, w której łączymy pasję do ruchu z&nbsp;artystycznym wyrażaniem siebie</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}},"className":"aurelines-reveal aurelines-reveal-delay-3"} -->
			<div class="wp-block-buttons aurelines-reveal aurelines-reveal-delay-3" style="margin-top:var(--wp--preset--spacing--40)">
				<!-- wp:button {"style":{"typography":{"fontSize":"0.875rem","letterSpacing":"0.1em","textTransform":"uppercase"},"spacing":{"padding":{"top":"0.875rem","bottom":"0.875rem","left":"2.25rem","right":"2.25rem"}},"border":{"radius":"50px"}}} -->
				<div class="wp-block-button" style="font-size:0.875rem"><a class="wp-block-button__link wp-element-button" href="#kontakt" style="border-radius:50px;padding-top:0.875rem;padding-right:2.25rem;padding-bottom:0.875rem;padding-left:2.25rem;letter-spacing:0.1em;text-transform:uppercase">Zapisz się</a></div>
				<!-- /wp:button -->

				<!-- wp:button {"className":"aurelines-ghost-btn","style":{"typography":{"fontSize":"0.875rem","letterSpacing":"0.1em","textTransform":"uppercase"},"spacing":{"padding":{"top":"0.875rem","bottom":"0.875rem","left":"2.25rem","right":"2.25rem"}},"border":{"radius":"50px"}}} -->
				<div class="wp-block-button aurelines-ghost-btn" style="font-size:0.875rem"><a class="wp-block-button__link wp-element-button" href="#o-nas" style="border-radius:50px;padding-top:0.875rem;padding-right:2.25rem;padding-bottom:0.875rem;padding-left:2.25rem;letter-spacing:0.1em;text-transform:uppercase">Poznaj nas</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
	</div>
</div>
<!-- /wp:cover -->
