( function ( blocks, element, blockEditor, components ) {
	var el                = element.createElement;
	var TextControl       = components.TextControl;
	var SelectControl     = components.SelectControl;
	var Button            = components.Button;
	var InspectorControls = blockEditor.InspectorControls;
	var PanelBody         = components.PanelBody;

	var iconSVGs = {
		phone: el( 'svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', strokeWidth: '2', strokeLinecap: 'round', strokeLinejoin: 'round' },
			el( 'path', { d: 'M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z' } )
		),
		email: el( 'svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', strokeWidth: '2', strokeLinecap: 'round', strokeLinejoin: 'round' },
			el( 'path', { d: 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z' } ),
			el( 'polyline', { points: '22,6 12,13 2,6' } )
		),
		location: el( 'svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', strokeWidth: '2', strokeLinecap: 'round', strokeLinejoin: 'round' },
			el( 'path', { d: 'M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z' } ),
			el( 'circle', { cx: '12', cy: '10', r: '3' } )
		),
	};

	var iconLabels = {
		phone: 'Telefon',
		email: 'Email',
		location: 'Lokalizacja',
	};

	blocks.registerBlockType( 'aurelines/contact-info', {
		title: 'Contact Info',
		description: 'Lista danych kontaktowych z ikonami.',
		category: 'aurelines',
		icon: 'phone',
		supports: {
			html: false,
		},
		attributes: {
			items: {
				type: 'array',
				default: [
					{ icon: 'phone', text: '+48 123 456 789' },
					{ icon: 'email', text: 'kontakt@aurelines.pl' },
					{ icon: 'location', text: 'ul. Akrobatyczna 12, 00-001 Warszawa' },
				],
			},
		},

		edit: function ( props ) {
			var items = props.attributes.items;

			function updateItem( index, key, value ) {
				var updated = items.map( function ( item, i ) {
					if ( i === index ) {
						var copy = {};
						for ( var k in item ) { copy[ k ] = item[ k ]; }
						copy[ key ] = value;
						return copy;
					}
					return item;
				} );
				props.setAttributes( { items: updated } );
			}

			function removeItem( index ) {
				props.setAttributes( {
					items: items.filter( function ( _, i ) { return i !== index; } ),
				} );
			}

			function addItem() {
				props.setAttributes( {
					items: items.concat( [ { icon: 'phone', text: '' } ] ),
				} );
			}

			return el( element.Fragment, {},
				el( InspectorControls, {},
					el( PanelBody, { title: 'Dane kontaktowe' },
						items.map( function ( item, index ) {
							return el( 'div', { key: index, style: { marginBottom: '16px', paddingBottom: '16px', borderBottom: '1px solid #ddd' } },
								el( SelectControl, {
									label: 'Ikona',
									value: item.icon,
									options: [
										{ label: 'Telefon', value: 'phone' },
										{ label: 'Email', value: 'email' },
										{ label: 'Lokalizacja', value: 'location' },
									],
									onChange: function ( val ) { updateItem( index, 'icon', val ); },
								} ),
								el( TextControl, {
									label: 'Tekst',
									value: item.text,
									onChange: function ( val ) { updateItem( index, 'text', val ); },
								} ),
								el( Button, {
									isDestructive: true,
									isSmall: true,
									onClick: function () { removeItem( index ); },
								}, 'Usuń' )
							);
						} ),
						el( Button, {
							isPrimary: true,
							isSmall: true,
							onClick: addItem,
						}, 'Dodaj pozycję' )
					)
				),
				el( 'div', { className: 'aurelines-contact-info' },
					items.map( function ( item, index ) {
						return el( 'div', { className: 'aurelines-contact-row', key: index },
							el( 'span', { className: 'aurelines-contact-icon' }, iconSVGs[ item.icon ] || iconSVGs.phone ),
							el( 'span', {}, item.text )
						);
					} )
				)
			);
		},

		save: function () {
			return null;
		},
	} );
} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.blockEditor,
	window.wp.components
);
