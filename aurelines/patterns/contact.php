<?php
/**
 * Title: Kontakt
 * Slug: aurelines/contact
 * Categories: aurelines
 * Keywords: contact, kontakt
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-background-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--30)" id="kontakt">
	<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"},"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--50)">
		<!-- wp:aurelines/badge {"text":"Kontakt","variant":"section"} /-->

		<!-- wp:heading {"textAlign":"center","className":"aurelines-reveal"} -->
		<h2 class="wp-block-heading has-text-align-center aurelines-reveal">Skontaktuj się z nami</h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"className":"aurelines-reveal"} -->
	<div class="wp-block-columns aurelines-reveal">
		<!-- wp:column {"verticalAlignment":"top"} -->
		<div class="wp-block-column is-vertically-aligned-top">
			<!-- wp:image {"sizeSlug":"large","style":{"border":{"radius":"12px"}}} -->
			<figure class="wp-block-image size-large has-custom-border"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/akrobatka-kontakt.png' ) ); ?>" alt="Akrobatka" style="border-radius:12px"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"top"} -->
		<div class="wp-block-column is-vertically-aligned-top">
			<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
			<h3 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)">Dane kontaktowe</h3>
			<!-- /wp:heading -->

			<!-- wp:aurelines/contact-info {"items":[{"icon":"phone","text":"+48 123 456 789"},{"icon":"email","text":"kontakt@aurelines.pl"},{"icon":"location","text":"ul. Akrobatyczna 12, 00-001 Warszawa"}]} /-->

			<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"typography":{"lineHeight":"2"}}} -->
			<p style="margin-top:var(--wp--preset--spacing--30);line-height:2"><strong>Godziny otwarcia:</strong><br>Poniedziałek – Piątek: 10:00 – 21:00<br>Sobota: 9:00 – 17:00<br>Niedziela: zamknięte</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
