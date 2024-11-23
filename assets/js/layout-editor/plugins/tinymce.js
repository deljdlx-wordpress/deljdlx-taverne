(() => {


  LayoutEditor.prototype.handleTinyMCE = (fieldset, input, value) => {
    tinymce.init({
      target: input,
      // selector: "#my-wysiwyg-editor", // Sélecteur de l'élément
      menubar: true, // Afficher la barre de menu
      // plugins: "lists link image code", // Plugins nécessaires
      //  toolbar: "undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code",
      toolbar: "customButton",
      content_css: "/wp-includes/css/editor.css", // Styles par défaut de l'éditeur WordPress
      setup: function (editor) {

        editor.on('change', function () {
          console.log("Le contenu de l'éditeur a changé :", editor.getContent());
          input.value = editor.getContent();
        });

        editor.addButton('customButton', {
          text: 'Ajouter Média',
          icon: false,
          onclick: function () {
            wp.media.editor.open();
            wp.media.editor.send.attachment = function (props, attachment) {
              editor.insertContent('<img src="' + attachment.url + '" alt="' + attachment.alt + '" />');
            };
          }
        });
      }
    });
  }


  LayoutEditor.plugins['tinymce'] = (layoutEditor) => {
    layoutEditor.registerComponent('tinymce', () => {
      const manager = new TinyMCEManager(layoutEditor, 'HTML content');
      return manager;
    });
  };


  return;

  // ==========================================================================
})();