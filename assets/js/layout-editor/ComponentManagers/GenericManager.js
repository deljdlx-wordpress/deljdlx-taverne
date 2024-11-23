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

  async prepareValues(values, manager) {
    // let data = manager.values;
    let data = values;

    if (this.source) {
        const response = await fetch(this.source);
        data = await response.json();
        this.values = data;

        this._layout.refreshConfigurationPanel();
    }

    if (this.adapter) {
        const code = manager.adapter;
        let __VALUES = data;
        eval(code);
        data = __VALUES;
    }
    return data;
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

