class LayoutViewer
{

  sharedData = {};

  constructor() {

  }

  async render() {


    const sharedDataContainer = document.querySelector('#sharedData');
    if(sharedDataContainer) {
      this.sharedData = JSON.parse(sharedDataContainer.value);
      console.log('%cLayoutViewer.js :: 12 =============================', 'color: #f00; font-size: 1rem');
    }

    const components = document.querySelectorAll('.componentContainer');

    components.forEach(async (componentContainer) => {
      const configuration = JSON.parse(
        componentContainer.querySelector('.componentConfiguration').value
      );

      if(configuration) {
        if(configuration.type === 'echart-line') {
          await this.renderEChartSimpleGraph(componentContainer, configuration, 'line');
        }
        else if(configuration.type === 'echart-bar') {
          await this.renderEChartSimpleGraph(componentContainer, configuration, 'bar')
        }
        else if(configuration.type === 'echart-pie') {
          await this.renderEChartPieGraph(componentContainer, configuration);
        }

        else if(configuration.type === 'echart-donut') {
          await this.renderEChartPieGraph(componentContainer, configuration, 'donut');
        }

        else if(configuration.type === 'echart-radar') {
          await this.renderEChartRadarGraph(componentContainer, configuration);
        }

        else if(configuration.type === 'datatable') {
          await this.renderDatatable(componentContainer, configuration);
        }
        else if(configuration.type === 'tinymce') {
          await this.renderHTML(componentContainer, configuration);
        }
      }
    })
  }

  async renderHTML(container, configuration) {
    let data = await this.prepareData(configuration.data, configuration);
    let html = configuration.html;

    if(data) {
      for(let key in data) {
        let value = data[key];
        html = html.replace(new RegExp('{{\s*' + key + '\s*}}', 'g'), value);
      }
    }


    const contentContainer = container.querySelector('.componentContent');
    contentContainer.innerHTML = html;
  }

  async renderDatatable(container, configuration) {
    const contentContainer = container.querySelector('.componentContent');

    let data = await this.prepareData(configuration.data, configuration);

    const table = document.createElement('table');
    const head = document.createElement('thead');
    table.appendChild(head);
    table.style.width = '100%';

    const headerRow = document.createElement('tr');
    head.appendChild(headerRow);
    for(let caption of data.headers) {
      const th = document.createElement('th');
      th.innerHTML = caption;
      headerRow.appendChild(th);
    }

    const tbody = document.createElement('tbody');
    table.appendChild(tbody);
    for(let values of data.values) {
      const tr = document.createElement('tr');
      tbody.appendChild(tr);
      for(let value of values) {
        const td = document.createElement('td');
        tr.appendChild(td);
        td.innerHTML = value;
      }
    }

    // const titleElement = document.createElement('div');
    // titleElement.innerHTML = manager.title;
    // contentElement.appendChild(titleElement);


    const tableContainer = document.createElement('div');
    tableContainer.style.height='100%';
    tableContainer.append(table);

    contentContainer.appendChild(tableContainer);

    let datatable = new DataTable(table);


  }

  async renderEChartRadarGraph(container, configuration) {
    let data = await this.prepareData(configuration.data, configuration);


    const values = [];
    const indicators = [];

    let max = 100;
    for(let key in data) {
        const value = data[key];
        if(value > max) {
            max = value;
        }
    }

    for(let key in data) {

        indicators.push({
            name: key,
            max: max
        });

        values.push(data[key]);
    }

    let options = {
        radar: {
            shape: 'circle',
            indicator: indicators,
            splitArea: {
                areaStyle: {
                    color: ['#77EADF', '#26C3BE', '#64AFE9', '#428BD4'],
                    shadowColor: 'rgba(0, 0, 0, 0.2)',
                    shadowBlur: 10
                }
            },
            axisLine: {
                lineStyle: {
                    color: 'rgba(211, 253, 250, 0.8)'
                }
            },
            splitLine: {
                lineStyle: {
                    color: 'rgba(211, 253, 250, 0.8)'
                }
            },
        },
        series: [
            {
                type: 'radar',
                data: [
                    {
                        value: values,
                        areaStyle: {
                            color: 'rgba(255, 228, 52, 0.6)'
                        }
                    },
                ]
            }
        ]
    };

    const contentContainer = container.querySelector('.componentContent');
    const chart = echarts.init(contentContainer);
    chart.setOption(options);
  }


  async renderEChartPieGraph(container, configuration, type = 'pie') {
    let data = await this.prepareData(configuration.data, configuration);

    const values = [];

    for(let key in data) {
        values.push({
            value: data[key],
            name: key
        });
    }

    let radius = '70%';
    if(type ===  'donut') {
      radius = ['40%', '70%'];
    }

    let options = {
      tooltip: {
          trigger: 'item'
      },
      legend: {
        orient: 'vertical',
        left: 'left',
        textStyle: {
            color: '#fff',
            fontSize: 14      // Taille de la police
        }
    },
      series: [
          {
            type: 'pie',
            radius: radius,
            data: values,
            emphasis: {
                itemStyle: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            },
            label: {
                show: true,
                textStyle: {
                    color: '#FFFFFF',         // Couleur du texte
                    textShadowBlur: 0,        // Pas de flou
                    textShadowColor: 'none',  // Pas de couleur d'ombre
                    textShadowOffsetX: 0,     // Pas de décalage horizontal
                    textShadowOffsetY: 0      // Pas de décalage vertical
                }
            },
            labelLine: {
                lineStyle: {
                    color: '#FFFFFF' // Couleur de la ligne reliant le label
                }
            }
          }
      ]
    };

    const contentContainer = container.querySelector('.componentContent');
    const chart = echarts.init(contentContainer);
    chart.setOption(options);
  }


  async renderEChartSimpleGraph(container, configuration, type) {
    let data = await this.prepareData(configuration.data, configuration);

    const xAxis = [];
    const values = [];


    for(let key in data) {
        xAxis.push(key);
        values.push(data[key]);
    }


    let options = {
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
          type: type,
          }
      ]
    };

    const contentContainer = container.querySelector('.componentContent');
    const chart = echarts.init(contentContainer);
    chart.setOption(options);
  }




  async prepareData(values, configuration) {
    let data = values;



    if(configuration.source) {

      let source = configuration.source;
      source = this.interpolateValues(source, data);

      const response = await fetch(source);
      const json = await response.json();
      data = json;
    }


    let adapter = configuration.adapter;

    if(adapter) {
      adapter = this.interpolateValues(adapter, data);
      let __VALUES = data;
      eval(adapter);
      data = __VALUES;
    }

    return data;
  }


  interpolateValues(content, data) {
    for (let key in data) {
      let value = data[key];
      content = content.replace(new RegExp('{{\s*' + key + '\s*}}', 'g'), value);
    }

    for (let key in this.sharedData) {
      let value = this.sharedData[key];
      content = content.replace(new RegExp('{{\s*' + key + '\s*}}', 'g'), value);
    }

    return content;
  }


}





document.addEventListener('DOMContentLoaded', () => {
  const layoutViwer = new LayoutViewer();
  layoutViwer.render();

});