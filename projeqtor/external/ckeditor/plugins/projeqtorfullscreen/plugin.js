CKEDITOR.plugins.add( 'projeqtorfullscreen', {
  icons: 'projeqtorfullscreen',
  init: function( editor ) {
    editor.addCommand( 'projeqtorOpenFullScreen', {
      exec: function( editor ) {
        displayFullScreenCK(editor.name);
      }
    });
    editor.ui.addButton( 'ProjeqtorFullscreen', {
      label: 'Maximise',
      command: 'projeqtorOpenFullScreen',
      toolbar: 'links,50'
    });
    CKEDITOR.addCss(
        '.cke_contents_ltr blockquote { padding-left: 10px; padding-right: 8px; border-left-width: 4px;  border-left-color: #f8d4ba;}'
      + 'blockquote {border-color: #f8d4ba; font-family: courier new, courier, serif; font-style:normal;}'
    );
  }
});