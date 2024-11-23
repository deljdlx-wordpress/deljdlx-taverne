<div  style="width: 900px; height: 789px; position: relative; border: 1px solid rgb(255, 0, 255);" id="layoutContainer">


</div>

<script>



const contentElement = document.getElementById('layoutContainer');


function drawAxis(container) {
    // draw centered axis
    const axisWidth = 3
    const xAxis = document.createElement('div');
    xAxis.classList.add('axis', 'x-axis');
    xAxis.style.width = axisWidth + 'px';
    xAxis.style.left = 'calc(50% - ' + axisWidth + 'px)';
    container.appendChild(xAxis);

    const yAxis = document.createElement('div');
    yAxis.classList.add('axis', 'y-axis');
    yAxis.style.height = axisWidth + 'px';
    yAxis.style.backgroundColor = 'black';
    yAxis.style.top = 'calc(50% - '+ axisWidth + 'px)';
    container.appendChild(yAxis);
}

function drawAxisLabels(container, xMinLabel, xMaxLabel, yMinLabel, yMaxLabel) {

    const xMaxLabelElement = document.createElement('div');
    container.appendChild(xMaxLabelElement);
    xMaxLabelElement.classList.add('axis-label');
    xMaxLabelElement.innerHTML = xMaxLabel;
    xMaxLabelElement.style.right = '0';
    xMaxLabelElement.style.height = height + 'px';
    xMaxLabelElement.style.writingMode =' vertical-rl';


    const xMinLabelElement = document.createElement('div');
    container.appendChild(xMinLabelElement);
    xMinLabelElement.classList.add('axis-label');
    xMinLabelElement.innerHTML = xMinLabel;
    xMinLabelElement.style.left = '0';
    xMinLabelElement.style.height = size + 'px';
    xMinLabelElement.style.writingMode =' vertical-rl';


    const yMinLabelElement = document.createElement('div');
    container.appendChild(yMinLabelElement);
    yMinLabelElement.classList.add('axis-label');
    yMinLabelElement.innerHTML = yMinLabel;
    yMinLabelElement.style.bottom = '0';
    yMinLabelElement.style.width = size + 'px';


    //xMaxLabel
    const yMaxLabelElement = document.createElement('div');
    container.appendChild(yMaxLabelElement);
    yMaxLabelElement.classList.add('axis-label');
    yMaxLabelElement.innerHTML = yMaxLabel;
    yMaxLabelElement.style.top = '0';
    yMaxLabelElement.style.width = size + 'px';
}



const container = document.createElement('div');
contentElement.appendChild(container);




const xMin = -15;
const xMax = 15;
const yMin = -15;
const yMax = 15;

const margin = 50;
const dividers = 15;


const width = contentElement.clientWidth;
const height = contentElement.clientHeight;
const size = Math.min(width, height);

container.style.width = size +'px';
container.style.height = size +'px';
container.style.position = 'relative';
container.style.border = 'solid 1px #f0f';
container.style.backgroundColor = '#f0f5';

drawAxisLabels(
    container,
    'minimum x',
    'maximum x',
    'minimum y',
    'maximum y',
)


const gridContainer = document.createElement('div');
container.appendChild(gridContainer);
gridContainer.classList.add('scatter-container');
gridContainer.style.width = (size - margin * 2) + 'px';
gridContainer.style.height = (size - margin * 2 ) + 'px';
gridContainer.style.top = margin + 'px';
gridContainer.style.left = margin + 'px';



const gridSize = (size - margin * 2) / (dividers % 2 ? dividers + 1 : dividers);


gridContainer.style.backgroundSize = gridSize + 'px ' + gridSize + 'px';
gridContainer.style.backgroundImage = 'linear-gradient(to right, grey 1px, transparent 1px), linear-gradient(to bottom, grey 1px, transparent 1px)';
gridContainer.style.backgroundColor = '#ff05';


drawAxis(gridContainer);



const dotSize = 30;

fetch('https://taverne-dev.jlb.ninja/generators/scatter.json.php')
    .then(response => response.json())
    .then(data => {

        for(let item of data) {
            const x = item.value[0];
            const y = item.value[1];

            const point = document.createElement('div');
            point.classList.add('scatter-point');

            point.style.width = dotSize + 'px';
            point.style.height = dotSize + 'px';
            point.style.backgroundColor = '#f009';
            point.style.borderRadius = '50%';
            point.style.left = 'calc(' + (x - xMin) / (xMax - xMin) * 100 + '%' + ' - ' + dotSize / 2 + 'px)';
            point.style.bottom = 'calc(' + (y - yMin) / (yMax - yMin) * 100 + '%' + ' - ' + dotSize / 2 + 'px)';


            gridContainer.appendChild(point);

            const tooltip = document.createElement('div');
            tooltip.classList.add('tooltip');

            tooltip.innerHTML = item.firstname + '<br/>' + item.lastname + '<br/>(' + x + ', ' + y + ')';

            point.appendChild(tooltip);
        }
    });
</script>

<style>
.scatter-container {
    background-color: #f0f5;
    position: absolute;
    border: solid 1px #f00;
}

.axis {
    position: absolute;
    background-color: black;
}
.axis.x-axis {
    height: 100%;
}

.axis.y-axis {
    width: 100%;
}

.axis-label {
    position: absolute;
    text-align: center;
    background-color: #ff08;
}

.scatter-point {
    position: absolute;
}

.scatter-point .tooltip {
    display: none;
    position: absolute;
    left: 100%;
    bottom: 100%;
    padding: 10px;

    width: 200px;
    height: auto;

    border: solid 1px #f00;
    border-radius: 5px;

    background-Color: #f0f5;
}

.scatter-point:hover .tooltip {
    display: block;
}
</style>

