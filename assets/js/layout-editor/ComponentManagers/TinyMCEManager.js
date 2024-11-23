class TinyMCEManager extends GenericComponentManager {
  data = {
    title: 'HTML exemple',
  };

  html = `
    <h1>{{title}}</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec pur us. Donec euismod, nunc nec vehicula<p>
    <p>Nullam nec pur us. Donec euismod, nunc nec vehicula</p>
  `;

  constructor(layoutEditor, title) {
    super(layoutEditor, title);
    this.fields.push(
      {
        caption: 'HTML',
        description: 'Use {{VARIABLE_NAME}} to replace with data',
        bind: 'html',
        type: 'html',
        group: 0,
      },
    );
  }



  async onCreate (contentElement) {

    super.onCreate(contentElement);

    let html = this.html;

    let data = await this.prepareValues(this.data, (data) => {
      this.data = data;
      this._layout.setConfigurationPanelContent();
    });

    this.data = data;



    html = this.interpolateValues(html, data);

    const htmlContainer = document.createElement('div');
    htmlContainer.innerHTML = html;

    contentElement.appendChild(htmlContainer);
  }

}
