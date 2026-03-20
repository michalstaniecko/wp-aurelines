( function ( blocks, element, blockEditor, components ) {
	var el              = element.createElement;
	var SelectControl   = components.SelectControl;
	var InspectorControls = blockEditor.InspectorControls;
	var PanelBody       = components.PanelBody;

	var svgs = {
		fire: el( 'svg', {
			xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'none',
			stroke: 'currentColor', strokeWidth: '2', strokeLinecap: 'round', strokeLinejoin: 'round',
		}, el( 'path', { d: 'M12 12c2-2.96 0-7-1-8 0 3.038-1.773 4.741-3 6-1.226 1.26-2 3.24-2 5a6 6 0 1 0 12 0c0-1.532-1.056-3.94-2-5-1.786 3-2.791 3-4 2z' } ) ),
		shield: el( 'svg', {
			xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'none',
			stroke: 'currentColor', strokeWidth: '2', strokeLinecap: 'round', strokeLinejoin: 'round',
		}, el( 'path', { d: 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z' } ) ),
		growth: el( 'svg', {
			xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'none',
			stroke: 'currentColor', strokeWidth: '2', strokeLinecap: 'round', strokeLinejoin: 'round',
		},
			el( 'path', { d: 'M12 20V10' } ),
			el( 'path', { d: 'M18 20V4' } ),
			el( 'path', { d: 'M6 20v-4' } )
		),
	};

	blocks.registerBlockType( 'aurelines/icon-circle', {
		title: 'Icon Circle',
		description: 'Ikona w kolorowym okręgu.',
		category: 'aurelines',
		icon: 'marker',
		supports: {
			html: false,
		},
		attributes: {
			icon: {
				type: 'string',
				default: 'fire',
			},
		},

		edit: function ( props ) {
			var icon = props.attributes.icon;

			return el( element.Fragment, {},
				el( InspectorControls, {},
					el( PanelBody, { title: 'Ustawienia ikony' },
						el( SelectControl, {
							label: 'Ikona',
							value: icon,
							options: [
								{ label: 'Pasja (fire)', value: 'fire' },
								{ label: 'Bezpieczeństwo (shield)', value: 'shield' },
								{ label: 'Rozwój (growth)', value: 'growth' },
							],
							onChange: function ( val ) {
								props.setAttributes( { icon: val } );
							},
						} )
					)
				),
				el( 'div', { style: { textAlign: 'center' } },
					el( 'div', {
						className: 'aurelines-icon-circle aurelines-icon-circle--' + icon,
					}, svgs[ icon ] )
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
