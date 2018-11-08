(function() {
    tinymce.PluginManager.add('listing_manager_shortcodes', function(editor) {        
        var shortcodeValues = [];

        jQuery.each(shortcodes_button, function(i) {
            shortcodeValues.push({text: shortcodes_button[i], value:i});
        });        
        
        editor.addButton('listing_manager_shortcodes', {
            type: 'listbox',
            text: 'Listing Manager',
            onselect: function(e) {
                tinyMCE.activeEditor.selection.setContent( '[' + e.control.settings.text + ']' );
            },
            values: shortcodeValues
        });
    });
})();