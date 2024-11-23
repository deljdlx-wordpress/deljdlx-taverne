class EchartPieManager extends EchartManager
{

  chartType = 'pie';
  radius = '70%';

  async prepareOptions()  {

    let data = await this.prepareValues(this.data);

    const values = [];

    for (let key in data) {
        values.push({
            value: data[key],
            name: key,
        });
    }


    let options = {
        color: this.colors,
        tooltip: {
            trigger: 'item',
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            textStyle: {
                color: this.legendTextColor,
                fontSize: 14
            }
        },

        series: [
            {
                type: this.chartType,
                radius: this.radius,
                data: values,

                label: {
                    show: true,
                    textStyle: {
                        color: '#FFFFFF',
                        textShadowBlur: 0,
                        textShadowColor: 'none',
                        textShadowOffsetX: 0,
                        textShadowOffsetY: 0,
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

    return options;
  }
}