class ScatterGraphManager extends GenericComponentManager {
    xMinCaption = 'Minimum x';
    xMaxCaption = 'Maximum x';
    yMinCaption = 'Minimum y';
    yMaxCaption = 'Maximum y';


    constructor(layoutEditor, title) {
        super(layoutEditor, title);
        this.data = this.getFakeData();
    }

    getFakeData() {
        const points = [];
        const labels = [
            "Alpha", "Beta", "Gamma", "Delta", "Epsilon", "Zeta", "Eta", "Theta", "Iota", "Kappa",
            "Lambda", "Mu", "Nu", "Xi", "Omicron", "Pi", "Rho", "Sigma", "Tau", "Upsilon",
            "Phi", "Chi", "Psi", "Omega", "Vega", "Nova", "Stellar", "Luna", "Solar", "Nebula"
        ];

        for (let i = 0; i < 30; i++) {
            const x = (Math.random() * 24 - 12).toFixed(2); // Générer un nombre entre -12 et +12 pour X
            const y = (Math.random() * 24 - 12).toFixed(2); // Générer un nombre entre -12 et +12 pour Y

            points.push({
                value: [parseFloat(x), parseFloat(y)],
                caption: labels[i % labels.length] + `<div>Values:  (${x}, ${y})</div>`,
            });
        }
        return points;
    }

    async onCreate(contentElement) {
        super.onCreate(contentElement);

        let data = await this.prepareValues(this.data);
        const graph = new ScatterGraph();

        graph.xMinCaption = this.xMinCaption;
        graph.xMaxCaption = this.xMaxCaption;
        graph.yMinCaption = this.yMinCaption;
        graph.yMaxCaption = this.yMaxCaption;

        graph.render(contentElement, data);
    }
}