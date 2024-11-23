(() => {


  LayoutEditor.prototype.handleAceEditor = (fieldset, input, value) => {
    const aceContainer = document.createElement('div');
    aceContainer.classList.add('ace-container');
    fieldset.appendChild(aceContainer);
    const editor = ace.edit(aceContainer);
    editor.setOptions({
        theme: "ace/theme/dracula",
        mode: "ace/mode/javascript",
        // maxLines: 30,
        minLines: 5,
        autoScrollEditorIntoView: true,
        enableBasicAutocompletion: true,
        enableSnippets: true,
        enableLiveAutocompletion: true, // Si tu veux la complétion en temps réel
    });
    input.style.display = 'none';
    editor.session.setValue(value);
    editor.session.on('change', function(delta) {
      input.value = editor.getValue();
    });
  }

})();