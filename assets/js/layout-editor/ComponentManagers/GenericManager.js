class GenericComponentManager
{
  _layout = null;
  _panel = null;

  fields = [
    {
        caption: 'Title',
        bind: 'title',
        type: 'text',
        group: 0,
    },
    {
        caption: 'Data source',
        bind: 'source',
        type: 'text',
        group: 1,
    },
    {
        caption: 'Data',
        bind: 'data',
        type: 'json',
        group: 1,
    },
    {
        caption: 'Data  adapter',
        description: 'Data are stored in a variable named __VALUES',
        bind: 'adapter',
        type: 'code',
        group: 1,
    },
  ];

  type = 'generic';
  title = 'Component';
  source = '';
  data = {};
  adapter = '';
  sharedData = {};


  constructor(layoutEditor, title) {
    this._layout = layoutEditor;
    this.title = title;
    this.sharedData = layoutEditor.sharedData;
  }

  setType(type) {
    this.type = type;
  }

  setPanel(panel) {
    this._panel = panel;
  }

  async prepareValues(values, afterSource = false, afterAdapter = false) {

    // let data = this._layout.sharedData;
    // data = Object.assign(data, values);

    let data = values;


    let source = this.source;
    source = this.interpolateValues(source, data);

    if (source) {
        const response = await fetch(source);
        const remoteData = await response.json();

        data = remoteData;

        if(afterSource) {
          afterSource(data);
        }
    }

    let adapter = this.adapter;
    adapter = this.interpolateValues(adapter, data);

    if (adapter) {
        const code = adapter;
        let __VALUES = data;
        eval(code);
        data = __VALUES;

        if(afterAdapter) {
          afterAdapter(data);
        }

    }

    return data;
  }


  interpolateValues(content, data) {

    if(typeof content !=='string') {
      return content;
    }

    for (let key in data) {
      let value = data[key];
      content = content.replace(new RegExp('{{\s*' + key + '\s*}}', 'g'), value);
    }

    for (let key in this._layout.sharedData) {
      let value = this._layout.sharedData[key];
      content = content.replace(new RegExp('{{\s*' + key + '\s*}}', 'g'), value);
    }

    return content;
  }


  async onCreate (contentElement) {
    contentElement.innerHTML =  '';

    const titleElement = document.createElement('div');
    titleElement.classList.add('panel-title');
    titleElement.innerHTML = this.title;
    contentElement.appendChild(titleElement);
  }


  onUpdate (contentElement, manager) {
      contentElement.innerHTML = '';
      this.onCreate(contentElement, manager);
  }
}

