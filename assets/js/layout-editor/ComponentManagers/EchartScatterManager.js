class EchartScatterManager extends EchartManager
{

  chartType = 'scatter';
  axisColor = '#fff';
  axisWidth = 3;

  xMinCaption = 'Minimum x';
  xMaxCaption = 'Maximum x';
  yMinCaption = 'Minimum y';
  yMaxCaption = 'Maximum y';

  axisCaptionFontSize = 16;





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
            name: labels[i % labels.length], // Réutiliser les libellés si plus de 30 points
            description: `Point ${labels[i % labels.length]} avec une position (${x}, ${y})`
        });
    }
    return points;
}


  async prepareOptions()  {

    let data = await this.prepareValues(this.data);

    // const values = [];

    // for (let key in data) {
    //     values.push({
    //         value: data[key],
    //         name: key,
    //     });
    // }


    let scatterData  = data;

    // console.log('%cEchartScatterManager.js :: 51 =============================', 'color: #f00; font-size: 1rem');
    // console.log(JSON.stringify(scatterData, null, 4));


    let options = {

        // grid: {
        //     top: 50,        // Espace depuis le haut
        //     bottom: 50,     // Espace depuis le bas
        //     left: 50,       // Espace depuis la gauche
        //     right: 50,      // Espace depuis la droite
        //     containLabel: true // Gère les étiquettes sans déborder
        // },


        // label: {
        //     // Options: 'left', 'right', 'top', 'bottom', 'inside', 'insideTop', 'insideLeft', 'insideRight', 'insideBottom', 'insideTopLeft', 'insideTopRight', 'insideBottomLeft', 'insideBottomRight'
        //     position: 'top',
        //     distance: 10,
        //     show: true,

        // },

        color: this.colors,
        tooltip: {
            trigger: 'item',
            formatter: function (params) {
                // Extraire les données spécifiques du point
                const point = scatterData[params.dataIndex];
                return `
                    <strong>${point.name}</strong><br/>
                    <span>Coordonnées : (${point.value[0]}, ${point.value[1]})</span><br/>
                    <span>Description : ${point.description}</span>
                `;
            }
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            textStyle: {
                color: this.legendTextColor,
                fontSize: 14
            }
        },

        xAxis: {
            axisLine: {
                show: true,
                scale: true,
                lineStyle: {
                    color: this.axisColor,
                    width: this.axisWidth,
                    type: 'solid',
                }
            },
            max: 13,
            min: -13,
            axisLabel: {
                show: false,
            },
        },
        yAxis: {
            axisLine: {
                scale: true,
                show: false,
                lineStyle: {
                    color: this.axisColor,
                    width: this.axisWidth,
                    type: 'solid',
                }
            },
            max: 13,
            min: -13,
            axisLabel: {
                show: false,
            },
        },
        series: [
          {
            symbolSize: 20,
            data: scatterData.map(item => item.value),
            type: 'scatter',
            itemStyle: {
                color: function (params) {
                    // Récupérer la valeur Y
                    const y = params.value[1];

                    // Assigner une couleur selon la valeur Y
                    if (y > 6) {
                        return '#ff5722'; // Rouge pour les valeurs Y > 6
                    } else if (y > 0) {
                        return '#4caf50'; // Vert pour les valeurs Y entre 1 et 6
                    } else {
                        return '#2196f3'; // Bleu pour les valeurs Y <= 0
                    }
                }
            },
          }
        ],


        // graphic: [
        //     {
        //         type: 'text',
        //         left: '1%',
        //         top: '49%',
        //         style: {
        //             text: this.xMinCaption,
        //             fontSize: this.axisCaptionFontSize,
        //             fill: '#ff5722'
        //         }
        //     },
        //     {
        //         type: 'text',
        //         left: '92%',
        //         top: '49%',
        //         style: {
        //             text: this.xMaxCaption,
        //             fontSize: this.axisCaptionFontSize,
        //             fill: '#4caf50'
        //         }
        //     },
        //     {
        //         type: 'text',
        //         left: (50 - this.yMaxCaption.length / 2) + '%',
        //         top: '5%',
        //         style: {
        //             text: this.yMaxCaption,
        //             fontSize: this.axisCaptionFontSize,
        //             fill: '#2196f3'
        //         }
        //     },
        //     {
        //         type: 'text',
        //         left: (50 - this.yMaxCaption.length / 2) + '%',
        //         top: '92%',
        //         style: {
        //             text: this.yMinCaption,
        //             fontSize: this.axisCaptionFontSize,
        //             fill: '#ff5722'
        //         }
        //     }
        // ],

    };

    return options;
  }

  async onCreate(contentElement) {

    const container = document.createElement('div');
    contentElement.appendChild(container);

    container.innerHTML =  'HELLO WORLD';


    const width = contentElement.clientWidth;
    const height = contentElement.clientHeight;
    const size = Math.min(width, height);

    container.style.width = size +'px';
    container.style.height = size +'px';
    container.style.position = 'relative';
    container.style.border = 'solid 1px #f0f';

    const xMaxLabel = document.createElement('div');
    container.appendChild(xMaxLabel);

    xMaxLabel.style.position = 'absolute';
    xMaxLabel.innerHTML = "maximum x";
    xMaxLabel.style.width = height + 'px';
    xMaxLabel.style.backgroundColor = '#f0f';




    /*
    await super.onCreate(contentElement);

    const container = this._chart.getDom();

    const width = container.clientWidth;
    const height = container.clientHeight;
    const size = Math.min(width, height);

    const sideSize = size - 100;






    this._chart.setOption({


        grid: {
            top: (height - sideSize) / 2,
            bottom: (height - sideSize) / 2,
            left: (width - sideSize) / 2,
            right: (width - sideSize) / 2,
            containLabel: true // Gère les étiquettes sans déborder
        },


        // grid: {
        //     width: sideSize,
        //     height: sideSize
        // },


        // graphic: [
        //     {
        //         type: 'text',
        //         left: this.axisCaptionFontSize + 4 +'px',
        //         top: sideSize / 2 + 50 - (this.axisCaptionFontSize * this.xMinCaption.length / 4.2) + 'px',
        //         rotation: Math.PI / 2,
        //         // origin : [0.5, 0.5],

        //         style: {
        //             text: this.xMinCaption,
        //             fontSize: this.axisCaptionFontSize,
        //             fill: '#ff5722'
        //         }
        //     },
        //     {
        //         type: 'text',
        //         left: sideSize + 50 + this.axisCaptionFontSize +'px',
        //         top: sideSize / 2 + 50 - (this.axisCaptionFontSize * this.xMaxCaption.length / 4.2) + 'px',
        //         rotation: Math.PI / 2,
        //         // origin :  [0.5, 0.5],
        //         style: {
        //             text: this.xMaxCaption,
        //             fontSize: this.axisCaptionFontSize,
        //             fill: '#4caf50'
        //         }
        //     },
        //     {
        //         type: 'text',
        //         left: width / 2 + 'px',
        //         top: height - sideSize - 100 - this.axisCaptionFontSize * 3,
        //         style: {
        //             text: this.yMaxCaption,
        //             fontSize: this.axisCaptionFontSize,
        //             fill: '#2196f3'
        //         }
        //     },
        //     {
        //         type: 'text',
        //         left: width / 2 + 'px',
        //         top: height - 100 + 'px',
        //         style: {
        //             text: this.yMinCaption,
        //             fontSize: this.axisCaptionFontSize,
        //             fill: '#ff5722'
        //         }
        //     }
        // ],


    });
    */

  }
}