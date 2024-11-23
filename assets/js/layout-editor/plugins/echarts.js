(() => {

    // ==========================================================================

    LayoutEditor.plugins['echart-line'] = (layoutEditor) => {
        layoutEditor.registerComponent('echart-line', () => {
        const manager = new EchartManager(layoutEditor, 'Line chart', 'line');
        return manager;
        });
    };

    // ==========================================================================

    LayoutEditor.plugins['echart-bar'] = (layoutEditor) => {
        layoutEditor.registerComponent('echart-bar', () => {
            const manager = new EchartManager(layoutEditor, 'Bar chart', 'bar');
            return manager;
        });
    };

    // ==========================================================================

    LayoutEditor.plugins['echart-pie'] = (layoutEditor) => {
        layoutEditor.registerComponent('echart-pie', () => {
            const manager = new EchartPieManager(layoutEditor, 'Pie chart');
            return manager;
        });
    };

    // ==========================================================================

    LayoutEditor.plugins['echart-donut'] = (layoutEditor) => {
        layoutEditor.registerComponent('echart-donut', () => {
            const manager = new EchartPieManager(layoutEditor, 'Donut chart');
            manager.radius = ['40%', '70%'];
            return manager;
        });
    };

    // ==========================================================================

    LayoutEditor.plugins['echart-radar'] = (layoutEditor) => {
        layoutEditor.registerComponent('echart-radar', () => {
            const manager = new EchartRadarManager(layoutEditor, 'Radar chart');
            return manager;
        });
    };

    // ==========================================================================
})()
