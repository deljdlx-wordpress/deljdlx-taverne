class EchartManager extends GenericComponentManager {


  _chart;

  defaultColors = [
    '#FF6B6B',
    '#FFA351',
    '#FFD93D',
    '#1DD1A1',
    '#4D96FF',
    '#9B59B6',
    '#2BC4CC',
    '#B3B3B3',
  ];

  legendDefaultColor = '#fff';

  colors = [];
  chartType = 'line';



  constructor(layoutEditor, title, chartType) {
    super(layoutEditor, title);
    this.data = this.getFakeData();
    this.colors =  this.defaultColors;
    if(chartType) {
      this.chartType = chartType;
    }
  }


  async renderEchartPanel(contentElement) {
    let options = await this.prepareOptions();

    const echartContainer = document.createElement('div');
    echartContainer.style.height = '100%';

    contentElement.appendChild(echartContainer);
    contentElement.chart = echarts.init(echartContainer);
    contentElement.chart.setOption(options);


    this._chart = contentElement.chart;
  }

  async prepareOptions () {
    let data = await this.prepareValues(this.data);

    const xAxis = [];
    const values = [];

    for (let key in data) {
        xAxis.push(key);
        values.push(data[key]);
    }

    let options = {
        color: this.colors,
        xAxis: {
            type: 'category',
            data: xAxis,
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: values,
                type: this.chartType,
            }
        ]
    };
    return options;
  }

  getFakeData() {
    return {
        'Mon': Math.random() * 100,
        'Tue': Math.random() * 100,
        'Wed': Math.random() * 100,
        'Thu': Math.random() * 100,
        'Fri': Math.random() * 100,
        'Sat': Math.random() * 100,
        'Sun': Math.random() * 100,
    };
  }

  getDefaultColors() {
    return defaultColors;
  }


  async onCreate (contentElement, manager) {
    super.onCreate(contentElement, manager);
    await this.renderEchartPanel(contentElement);
  }

}
