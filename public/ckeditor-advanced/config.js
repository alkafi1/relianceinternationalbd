/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.extraPlugins = 'lineheight, N1ED-editor';
    config.apiKey = "YzcfOJas";
    config.skin = "n1theme";
    config.removePlugins = "iframe, magicline";
	config.allowedContent= true;
	config.N1ED = { 
		bootstrapToolkit: true, 
		editingenableBootstrap: true, 
		componentsplugins: 'base',
		};
};
