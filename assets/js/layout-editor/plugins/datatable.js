(() => {

  // ==========================================================================

  LayoutEditor.plugins['datatable'] = (layoutEditor) => {
    layoutEditor.registerComponent('datatable', () => {
      const manager = new DatableManager(layoutEditor, 'Data table');
      return manager;
    });
  };

  // ==========================================================================

})()