CKEDITOR.plugins.add( 'pjqfullscreen', {
    icons: 'pjqfullscreen',
    init: function( editor ) {
      editor.addCommand( 'pjqfullscreen', new CKEDITOR.dialogCommand( 'pjqfullscreenDialog' ) );
      editor.ui.addButton( 'pjqfullscreen', {
        label: 'Open in full screen',
        command: 'pjqfullscreen',
        toolbar: 'links,100'
      });
    }
});