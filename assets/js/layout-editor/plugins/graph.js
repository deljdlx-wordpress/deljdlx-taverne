(() => {

  // ==========================================================================

  LayoutEditor.plugins['graph-scatter'] = (layoutEditor) => {
      layoutEditor.registerComponent('graph-scatter', () => {
      const manager = new ScatterGraphManager(layoutEditor, 'Scatter graph');
      return manager;
      });
  };
})();