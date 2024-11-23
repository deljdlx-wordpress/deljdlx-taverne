class DatableManager extends GenericComponentManager {

  _datatable = null;

  data = {
    headers: ['Day', 'Values 1', 'Values 2'],
    values: [
      ['Mon',  Math.random() * 100, Math.random()],
      ['Tue',  Math.random() * 100, Math.random()],
      ['Wed',  Math.random() * 100, Math.random()],
      ['Thu',  Math.random() * 100, Math.random()],
      ['Fri',  Math.random() * 100, Math.random()],
      ['Sat',  Math.random() * 100, Math.random()],
      ['Sun',  Math.random() * 100, Math.random()],
    ]
  };



  async onCreate (contentElement) {
    super.onCreate(contentElement);


    let data = await this.prepareValues(this.data);

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

    const tableContainer = document.createElement('div');
    tableContainer.style.height='100%';
    tableContainer.append(table);

    contentElement.appendChild(tableContainer);

    this._datatable = new DataTable(table);

  }

}
