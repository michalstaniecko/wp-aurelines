( function ( blocks, element, blockEditor, components ) {
	var el          = element.createElement;
	var TextControl = components.TextControl;
	var SelectControl = components.SelectControl;
	var InspectorControls = blockEditor.InspectorControls;
	var PanelBody   = components.PanelBody;

	blocks.registerBlockType( 'aurelines/badge', {
		title: 'Badge',
		description: 'Etykieta sekcji Aurelines.',
		category: 'aurelines',
		icon: 'tag',
		supports: {
			html: false,
		},
		attributes: {
			text: {
				type: 'string',
				default: 'Badge',
			},
			variant: {
				type: 'string',
				default: 'section',
			},
		},

		edit: function ( props ) {
			var text    = props.attributes.text;
			var variant = props.attributes.variant;

			return el( element.Fragment, {},
				el( InspectorControls, {},
					el( PanelBody, { title: 'Ustawienia badge' },
						el( TextControl, {
							label: 'Tekst',
							value: text,
							onChange: function ( val ) {
								props.setAttributes( { text: val } );
							},
						} ),
						el( SelectControl, {
							label: 'Wariant',
							value: variant,
							options: [
								{ label: 'Sekcja', value: 'section' },
								{ label: 'Hero', value: 'hero' },
							],
							onChange: function ( val ) {
								props.setAttributes( { variant: val } );
							},
						} )
					)
				),
				el( 'div', {
					className: 'aurelines-badge aurelines-badge--' + variant,
				}, text )
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
