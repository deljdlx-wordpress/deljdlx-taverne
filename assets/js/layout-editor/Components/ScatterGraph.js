class ScatterGraph {

  topMargin = 30;
  bottomMargin = 30;
  leftMargin = 30;
  rightMargin = 30;

  axisColor = '#fff';
  axisWidth = 3;

  legendOffset = 10;
  legendColor = '#fff';

  xMinCaption = 'x min';
  xMaxCaption = 'x max';
  yMinCaption = 'y min';
  yMaxCaption = 'y max';

  axisCaptionFontSize = '16px';

  dotSize = 20;


  drawAxis(container) {
    const xAxis = document.createElement('div');
    xAxis.classList.add('axis', 'x-axis');
    xAxis.style.width = this.axisWidth + 'px';
    xAxis.style.left = 'calc(50% - ' + (this.axisWidth / 2) + 'px)';
    xAxis.style.backgroundColor = this.axisColor;
    container.appendChild(xAxis);

    const yAxis = document.createElement('div');
    yAxis.classList.add('axis', 'y-axis');
    yAxis.style.height = this.axisWidth + 'px';
    yAxis.style.top = 'calc(50% - ' + (this.axisWidth / 2) + 'px)';
    yAxis.style.backgroundColor = this.axisColor;
    container.appendChild(yAxis);
  }


  drawAxisLabels(container) {

    const xMaxLabelElement = document.createElement('div');
    container.appendChild(xMaxLabelElement);
    xMaxLabelElement.classList.add('axis-label');
    xMaxLabelElement.innerHTML = this.xMaxCaption;
    xMaxLabelElement.style.right = this.legendOffset + 'px';
    xMaxLabelElement.style.height = '100%';
    xMaxLabelElement.style.writingMode = ' vertical-rl';
    xMaxLabelElement.style.color = this.legendColor;
    xMaxLabelElement.style.fontSize = this.axisCaptionFontSize;

    const xMinLabelElement = document.createElement('div');
    container.appendChild(xMinLabelElement);
    xMinLabelElement.classList.add('axis-label');
    xMinLabelElement.innerHTML = this.xMinCaption;
    xMinLabelElement.style.left = this.legendOffset + 'px';
    xMinLabelElement.style.height = '100%';
    xMinLabelElement.style.writingMode = ' vertical-rl';
    xMinLabelElement.style.color = this.legendColor;
    xMinLabelElement.style.fontSize = this.axisCaptionFontSize;

    const yMinLabelElement = document.createElement('div');
    container.appendChild(yMinLabelElement);
    yMinLabelElement.classList.add('axis-label');
    yMinLabelElement.innerHTML = this.yMinCaption;
    yMinLabelElement.style.bottom = this.legendOffset + 'px';
    yMinLabelElement.style.width = '100%';
    yMinLabelElement.style.color = this.legendColor;
    yMinLabelElement.style.fontSize = this.axisCaptionFontSize;

    const yMaxLabelElement = document.createElement('div');
    container.appendChild(yMaxLabelElement);
    yMaxLabelElement.classList.add('axis-label');
    yMaxLabelElement.innerHTML = this.yMaxCaption;
    yMaxLabelElement.style.top = this.legendOffset + 'px';
    yMaxLabelElement.style.width = '100%';
    yMaxLabelElement.style.color = this.legendColor;
    yMaxLabelElement.style.fontSize = this.axisCaptionFontSize;
  }

  renderPoint(container, x, y, xMin, xMax, yMin, yMax) {

    const point = document.createElement('div');
    point.classList.add('scatter-point');

    point.style.width = this.dotSize + 'px';
    point.style.height = this.dotSize + 'px';

    point.style.left = 'calc(' + (x - xMin) / (xMax - xMin) * 100 + '%' + ' - ' + this.dotSize / 2 + 'px)';
    point.style.bottom = 'calc(' + (y - yMin) / (yMax - yMin) * 100 + '%' + ' - ' + this.dotSize / 2 + 'px)';

    container.appendChild(point);

    return point;
  }



  render(contentElement, data) {
    function drawGrid(container, size, margin, gridSize) {
      const gridContainer = document.createElement('div');
      container.appendChild(gridContainer);
      gridContainer.classList.add('scatter-graph-container');
      gridContainer.style.width = (size - margin * 2) + 'px';
      gridContainer.style.height = (size - margin * 2) + 'px';
      gridContainer.style.top = margin + 'px';
      gridContainer.style.left = margin + 'px';

      // generate grid
      gridContainer.style.backgroundSize = gridSize + 'px ' + gridSize + 'px';
      gridContainer.style.backgroundImage = 'linear-gradient(to right, #0003 1px, transparent 1px), linear-gradient(to bottom, grey 1px, transparent 1px)';

      return gridContainer;
    }



    const width = contentElement.clientWidth - this.leftMargin - this.rightMargin;
    const height = contentElement.clientHeight - this.topMargin - this.bottomMargin;
    const size = Math.min(width, height);


    const xMin = -15;
    const xMax = 15;
    const yMin = -15;
    const yMax = 15;

    const margin = 50;
    const dividers = 15;


    const gridSize = (size - margin * 2) / (dividers % 2 ? dividers + 1 : dividers);

    const wrapper = document.createElement('div');
    wrapper.classList.add('scatter-wrapper');
    contentElement.appendChild(wrapper);

    const container = document.createElement('div');
    container.classList.add('scatter-container');

    wrapper.appendChild(container);

    container.style.width = size + 'px';
    container.style.height = size + 'px';

    this.drawAxisLabels(
      container,
      'minimum x',
      'maximum x',
      'minimum y',
      'maximum y',
    )


    const gridContainer = drawGrid(container, size, margin, gridSize);


    this.drawAxis(gridContainer);

    for (let item of data) {
      const x = item.value[0];
      const y = item.value[1];


      const point = this.renderPoint(gridContainer, x, y, xMin, xMax, yMin, yMax);

      gridContainer.appendChild(point);

      const tooltip = document.createElement('div');
      tooltip.classList.add('tooltip');

      tooltip.innerHTML = item.caption;

      point.appendChild(tooltip);
    }

  }
}
