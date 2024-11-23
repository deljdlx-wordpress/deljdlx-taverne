class EchartRadarManager extends EchartManager {

    areaColors = ['#77EADF', '#26C3BE', '#64AFE9', '#428BD4'];

    async prepareOptions() {

        let data = await this.prepareValues(this.data);

        const values = [];
        const indicators = [];

        let max = 100;
        for (let key in data) {
            const value = data[key];
            if (value > max) {
                max = value;
            }
        }

        for (let key in data) {
            indicators.push({
                name: key,
                max: max
            });
            values.push(data[key]);
        }


        let options = {
            color: this.colors,
            radar: {
                shape: 'circle',
                indicator: indicators,
                splitArea: {
                    areaStyle: {
                        color: this.areaColors,
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
        return options;
    }
}
