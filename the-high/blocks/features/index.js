/***
	* Added to the theme using 
	* Using wp-cli https://developer.wordpress.org/cli/commands/scaffold/block/  (depreciated)
	* Just to see
***/


( function( wp ) { 

	/**
	 * Registers a new block provided a unique name and an object defining its behavior.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/#registering-a-block
	 */
	var registerBlockType = wp.blocks.registerBlockType;
	/**
	 * Returns a new element of given type. Element is an abstraction layer atop React.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/packages/packages-element/
	 */
	var el = wp.element.createElement;
	/**
	 * Retrieves the translation of text.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/packages/packages-i18n/
	 */
	var __ = wp.i18n.__;
	
	wp.hooks.addFilter('blocks.registerBlockType', 'custom/filter', function(blockOptions) {
		if(blockOptions.hasOwnProperty('attributes')) blockOptions.attributes.background_image = {
			type: 'string',
			default: ''
		};
		return blockOptions;
	});
	
	
	
	/**
	 * Every block starts by registering a new block type definition.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/#registering-a-block
	 */
	registerBlockType( 'the-high/features', {
		/**
		 * This is the display title for your block, which can be translated with `i18n` functions.
		 * The block inserter will show this name.
		 */
		title: __( 'Features', 'the-high' ),

		/**
		 * Blocks are grouped into categories to help users browse and discover them.
		 * The categories provided by core are `common`, `embed`, `formatting`, `layout` and `widgets`.
		 */
		category: 'design',

		/**
		 * Optional block extended support features.
		 */
		supports: {
			// Removes support for an HTML mode.
			html: true,
		},	
		
		attributes: {
			content: {
				type: 'string',
				source: 'text',
				selector: 'p',
				default: 'Editable block content...',
			},
			title: {
				type: 'array',
				source: 'children',
				selector: 'h3',
			},
			mediaID: {
				type: 'number',
			},
			mediaURL: {
				type: 'string',
				selector: 'img',
				attribute: 'src',
			},
			mediaURL: {
				type: 'array',
				source: 'children',
				selector: '.high-card-description',
			},
			highBackground: {
				type: 'string',
				default: '#f6f6f6' // is optional
			},
			
			fontColor: {
				type: 'string',
				default: '#1e6b6d' // is optional
			},
			textAlignment: {
				type: 'object',
			}
		},
			
		edit: function( props ) {
				var content = props.attributes.content,
					title = props.attributes.title,
					mediaID = props.attributes.mediaID,
					mediaURL = props.attributes.mediaURL;
					
				var focus = props.focus;

				var RichText = wp.editor.RichText,
					MediaUpload = wp.editor.MediaUpload,
					AlignmentToolbar = wp.editor.AlignmentToolbar,
					BlockControls = wp.editor.BlockControls,
					InspectorControls = wp.editor.InspectorControls,
					PanelColorSettings = wp.editor.PanelColorSettings; // For creating editable elements.
				
				var Toolbar = wp.components.Toolbar,
					Button = wp.components.Button,
					Tooltip = wp.components.Tooltip,
					CheckboxControl = wp.components.CheckboxControl,
					SelectControl = wp.components.SelectControl,
					PanelBody = wp.components.PanelBody,
					PanelRow = wp.components.PanelRow,
					TextControl = wp.components.Text;

	
 

				function onChangeContent( updatedContent ) {
					props.setAttributes( { content: updatedContent } );
				}
				
				function onChangeTitle( updatedTitle ) {
					props.setAttributes( { title: updatedTitle} );
				}
				
				
				function onChangeDescription( updatedDescription ) {
					props.setAttributes( { description: updatedDescription} );
				}
				 
				

				return el(
					RichText,
					{
						tagName: 'h2',
						className: props.className,
						value: title,
						onChange: onChangeTitle,
						focus: focus,
						onFocus: props.setFocus
					},
					RichText,
					{
						tagName: 'p',
						value: content,
						onChange: onChangeContent,
						focus: focus,
						onFocus: props.setFocus
					},
				);
			},

			// Defines the saved block.
			save: function( props ) {
				var content = props.attributes.content,
					title = props.attributes.title,
					mediaID = props.attributes.mediaID,
					mediaURL = props.attributes.mediaURL;
					 
		
				var focus = props.focus;

				var RichText = wp.editor.RichText,
					MediaUpload = wp.editor.MediaUpload,
					AlignmentToolbar = wp.editor.AlignmentToolbar,
					BlockControls = wp.editor.BlockControls,
					InspectorControls = wp.editor.InspectorControls,
					PanelColorSettings = wp.editor.PanelColorSettings; // For creating editable elements.
				
				var Toolbar = wp.components.Toolbar,
					Button = wp.components.Button,
					Tooltip = wp.components.Tooltip,
					CheckboxControl = wp.components.CheckboxControl,
					SelectControl = wp.components.SelectControl,
					PanelBody = wp.components.PanelBody,
					PanelRow = wp.components.PanelRow,
					TextControl = wp.components.Text;

	
 


				return el( 
				RichText.Content,
					{
						'tagName': 'h3',
						'value': title
					}
				);
			},
		
	}); // end reigsgter block

})(wp);
