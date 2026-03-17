<?php
/**
 * Title: Kontakt
 * Slug: aurelines/contact
 * Categories: aurelines
 * Keywords: contact, kontakt, formularz
 */

$success = get_transient( 'aurelines_contact_success' );
$error   = get_transient( 'aurelines_contact_error' );
if ( $success ) {
	delete_transient( 'aurelines_contact_success' );
}
if ( $error ) {
	delete_transient( 'aurelines_contact_error' );
}
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-background-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--30)" id="kontakt">
	<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"},"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--50)">
		<!-- wp:html -->
		<div class="aurelines-badge aurelines-badge--section aurelines-reveal">Kontakt</div>
		<!-- /wp:html -->

		<!-- wp:heading {"textAlign":"center","className":"aurelines-reveal"} -->
		<h2 class="wp-block-heading has-text-align-center aurelines-reveal">Skontaktuj się z nami</h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}},"className":"aurelines-reveal"} -->
	<div class="wp-block-columns aurelines-reveal">
		<!-- wp:column {"verticalAlignment":"top"} -->
		<div class="wp-block-column is-vertically-aligned-top">
			<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
			<h3 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)">Dane kontaktowe</h3>
			<!-- /wp:heading -->

			<!-- wp:html -->
			<div class="aurelines-contact-row">
				<span class="aurelines-contact-icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
				</span>
				<span>+48 123 456 789</span>
			</div>
			<div class="aurelines-contact-row">
				<span class="aurelines-contact-icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
				</span>
				<span>kontakt@aurelines.pl</span>
			</div>
			<div class="aurelines-contact-row">
				<span class="aurelines-contact-icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
				</span>
				<span>ul. Akrobatyczna 12, 00-001 Warszawa</span>
			</div>
			<!-- /wp:html -->

			<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}},"typography":{"lineHeight":"2"}}} -->
			<p style="margin-top:var(--wp--preset--spacing--30);line-height:2"><strong>Godziny otwarcia:</strong><br>Poniedziałek – Piątek: 10:00 – 21:00<br>Sobota: 9:00 – 17:00<br>Niedziela: zamknięte</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"top"} -->
		<div class="wp-block-column is-vertically-aligned-top">
			<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
			<h3 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)">Napisz do nas</h3>
			<!-- /wp:heading -->

			<!-- wp:html -->
			<div class="aurelines-form-card">
				<?php if ( $success ) : ?>
					<div class="aurelines-form-message aurelines-form-success"><?php echo esc_html( $success ); ?></div>
				<?php endif; ?>
				<?php if ( $error ) : ?>
					<div class="aurelines-form-message aurelines-form-error"><?php echo esc_html( $error ); ?></div>
				<?php endif; ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="aurelines-contact-form">
					<input type="hidden" name="action" value="aurelines_contact">
					<?php wp_nonce_field( 'aurelines_contact', 'aurelines_contact_nonce' ); ?>
					<div class="aurelines-form-field">
						<label for="contact_name">Imię</label>
						<input type="text" id="contact_name" name="contact_name" required>
					</div>
					<div class="aurelines-form-field">
						<label for="contact_email">Email</label>
						<input type="email" id="contact_email" name="contact_email" required>
					</div>
					<div class="aurelines-form-field">
						<label for="contact_message">Wiadomość</label>
						<textarea id="contact_message" name="contact_message" rows="5" required></textarea>
					</div>
					<button type="submit" class="wp-element-button">Wyślij wiadomość</button>
				</form>
			</div>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
