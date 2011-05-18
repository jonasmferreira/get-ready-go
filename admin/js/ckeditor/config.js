/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.filebrowserBrowseUrl = '../admin/js/ckfinder/ckfinder.html',
	config.filebrowserImageBrowseUrl = '../admin/js/ckfinder/ckfinder.html?type=Images',
	config.filebrowserFlashBrowseUrl = '../admin/js/ckfinder/ckfinder.html?type=Flash',
	config.filebrowserUploadUrl = '../admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	config.filebrowserImageUploadUrl = '../admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	config.filebrowserFlashUploadUrl = '../admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
	
};
