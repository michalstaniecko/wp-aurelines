<?php
/**
 * Title: O nas
 * Slug: aurelines/about
 * Categories: aurelines
 * Keywords: about, o nas
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-background-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--30)" id="o-nas">
	<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"},"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--50)">
		<!-- wp:html -->
		<div class="aurelines-badge aurelines-badge--section aurelines-reveal">O nas</div>
		<!-- /wp:html -->

		<!-- wp:heading {"textAlign":"center","className":"aurelines-reveal"} -->
		<h2 class="wp-block-heading has-text-align-center aurelines-reveal">Pasja do ruchu w powietrzu</h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}},"className":"aurelines-reveal"} -->
	<div class="wp-block-columns aurelines-reveal">
		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.0625rem","lineHeight":"1.8"}}} -->
			<p style="font-size:1.0625rem;line-height:1.8">Aurelines to szkoła akrobatyki powietrznej, w&nbsp;której łączymy pasję do ruchu z&nbsp;artystycznym wyrażaniem siebie. Od lat pomagamy naszym kursantkom odkrywać własne możliwości i&nbsp;przełamywać granice.</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.0625rem","lineHeight":"1.8"}}} -->
			<p style="font-size:1.0625rem;line-height:1.8">Nasze zajęcia prowadzą doświadczeni instruktorzy z&nbsp;wieloletnim stażem w&nbsp;akrobatyce powietrznej, cyrku współczesnym i&nbsp;tańcu. Zapewniamy bezpieczne warunki treningowe i&nbsp;indywidualne podejście do każdego ucznia — niezależnie od poziomu zaawansowania.</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.0625rem","lineHeight":"1.8"}}} -->
			<p style="font-size:1.0625rem;line-height:1.8">Dołącz do naszej społeczności i&nbsp;odkryj, jak wiele radości może przynieść akrobatyka powietrzna!</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:image {"sizeSlug":"large","style":{"border":{"radius":"20px"}},"className":"aurelines-about-image"} -->
			<figure class="wp-block-image size-large has-custom-border aurelines-about-image"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-placeholder.jpg' ); ?>" alt="Aurelines — zdjęcie ze szkoły" style="border-radius:20px"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
