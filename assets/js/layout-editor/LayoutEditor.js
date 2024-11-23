class LayoutEditor {
  static plugins = {};

  layout = null;

  registeredComponentTypes = {};
  currentComponent = null;

  sharedData = {};

  configurationContainer = document.querySelector('#component-configuration-container');

  constructor() {
    const config = {
      settings: {
        selectionEnabled: false,
        showPopoutIcon: false,
        showMaximiseIcon: false,
        showCloseIcon: true,
      },
      content: [
        // {
        //     type: 'row',
        //     content: [{
        //             title: 'Container',
        //             type: 'component',
        //             componentName: 'container',
        //             componentState: {
        //                 text: ''
        //             },
        //             isClosable: false,
        //         },
        //     ]
        // }
      ]
    };


    this.layout = new window.GoldenLayout(config, $('#layoutContainer'));

    this.layout.registerComponent('container', function (container, state) {
      container.getElement().html('<div class="forge-container">' + state.text + '</div>');
    });

    this.layout.init();

    this.handleInteractions();

    this.createFirstPanel();

    this.addMenuItem('container', 'Add container', '');
  }

  createFirstPanel() {
    const panelConfiguration =  {
      title: 'Container',
      type: 'component',
      componentName: 'container',
      componentState: {
        text: ''
      },
    }
    const panel = this.layout.root.addChild( panelConfiguration );
  }

  handleInteractions() {

    document.querySelector('#update-configuration-trigger').addEventListener('click', (event) => {
      this.updateConfiguration();
    });

    this.layout.on("componentCreated", (component) => {
      this.handleNewPanel(component);
    });

    $(".draggable").draggable({
      helper: "clone",
    });

    this.layout.on('stateChanged', () => {
      this.refreshAll();
      // var state = JSON.stringify(this.layout.toConfig());
      // localStorage.setItem( 'savedState', state );
      // console.log('%csandbox.blade.php :: 106 =============================', 'color: #f00; font-size: 1rem');
      // console.log(state);
    });
  }

  getJson() {
    const json = {};
    json.sharedData = this.sharedData;
    json.layout = this.layout.toConfig();
    return json;
  }


  addPlugin(pluginName) {

    if(LayoutEditor.plugins[pluginName]) {
      LayoutEditor.plugins[pluginName](this);
      return;
    }

    console.error('Plugin not found: ' + pluginName);
  }

  refreshConfigurationPanel() {
    if(this.currentComponent.manager) {
      const inputs = document.querySelectorAll('#component-configuration *[data-bind]');
      inputs.forEach((input) => {
        const bind = input.dataset.bind;
        let value = '';
        if(input.dataset.type === 'json') {
          value = JSON.stringify(this.currentComponent.manager[bind] ?? '', null, 4);
        }
        else {
          value = this.currentComponent.manager[bind] ?? '';
        }

        input.value = value;


        console.log('%cLayoutEditor.js :: 123 =============================', 'color: #f00; font-size: 1rem');
        console.log(value);

        if(input.dataset.type === 'json' || input.dataset.type === 'code') {
          input.ace.session.setValue(value);
        }
      });
    }
  }

  updateConfiguration() {
    if(this.currentComponent.manager) {

      const inputs = document.querySelectorAll('*[data-bind]');

      inputs.forEach((input) => {
        const bind = input.dataset.bind;
        const value = input.value;

        if(input.dataset.type === 'json') {
          this.currentComponent.manager[bind] = JSON.parse(value);
        }
        else if(input.dataset.type === 'code' && 0) {
          // this.currentComponent.manager[bind]
        }
        else {
          this.currentComponent.manager[bind] = value;
        }
      });


      this.currentComponent.manager.onUpdate(
        this.currentComponent.querySelector('.component-content'),
        this.currentComponent.manager
      );

      this.saveManagerConfiguration(this.currentComponent.manager);

      // var state = JSON.stringify(this.layout.toConfig(), null, 4);
      // console.log('%csandbox.blade.php :: 106 =============================', 'color: #f00; font-size: 1rem');
      // console.log(state);
    }
  }

  clearConfigurationPanel() {
    for(let i = 0 ; i < 10; i++) {
      // component-configuration-0
      const tab = document.querySelector('#component-configuration-' + i);

      if(tab) {

        console.log('%cLayoutEditor.js :: 177 =============================', 'color: #f00; font-size: 1rem');
        console.log(tab);

        tab.innerHTML = '';
      }
    }
  }


  setConfigurationPanelContent() {

    this.configurationContainer.classList.add('active');
    this.clearConfigurationPanel();

    let fields = this.currentComponent.manager.fields;

    for(let field of fields) {
      const fieldset = document.createElement('fieldset');
      const legend = document.createElement('legend');
      legend.innerHTML = field.caption;
      fieldset.appendChild(legend);

      if(field.description) {
        const description = document.createElement('p');
        description.innerHTML = field.description;
        fieldset.appendChild(description);
      }

      const bind = field.bind;
      let input;
      let value;


      if(field.type === 'json') {
        input = document.createElement('textarea');
        value = JSON.stringify(this.currentComponent.manager[bind] ?? '', null, 4);
      }

      else if(field.type === 'html') {
        input = document.createElement('textarea');
        value = this.currentComponent.manager[bind] ?? '';
      }

      else if(field.type === 'code') {
        input = document.createElement('textarea');
        value = this.currentComponent.manager[bind] ?? '';
      }
      else {
        input = document.createElement('input');
        value = this.currentComponent.manager[bind] ?? '';
      }

      input.dataset.bind = bind;
      input.dataset.type = field.type;
      input.value = value;
      fieldset.appendChild(input);


      document.querySelector('#component-configuration-' + field.group).appendChild(fieldset);


      if(field.type === 'html') {
          this.handleTinyMCE(fieldset, input, value);
      }

      else if(field.type === 'code' || field.type === 'json') {
        this.handleAceEditor(fieldset, input, value);
      }
    }
  }

  addMenuItem(componentName, title, content) {
    var element = $('<div>' + title + '</div>');
    $('#menuContainer').append(element);

    var newItemConfig = {
      title: title,
      type: 'component',
      componentName: componentName,
      componentState: {
        text: content
      },
    };

    this.layout.createDragSource(element, newItemConfig);
  }


  handleNewPanel(component) {
    const droppableArea = component.container.getElement().find(".forge-container");
    droppableArea.droppable({
      // accept: "#draggable-item",
      drop: (event, ui) => {
        this.handleDrop(event, ui);
      },
    });
  }

  handleDrop(event, ui) {
    const container = event.target;
    this.createComponent(container, ui.draggable.get(0));

    // this.refreshPanelByElement(container);

    // var state = JSON.stringify(
    //   this.layout.toConfig(),
    //   null,
    //   4
    // );

    // localStorage.setItem( 'savedState', state );
    // console.log('%csandbox.blade.php :: 106 =============================', 'color: #f00; font-size: 1rem');
    // console.log(state);
  }




  getPanelByElement(element) {
    const parent = element.closest('.lm_item'); // Trouve le parent GoldenLayout
    const panel = this.layout.root.getItemsByFilter(item => item.element[0] === parent)[0];

    return panel
  }


  getCurrentManager() {
    return this.currentComponent.manager;
  }

  setSharedData(data) {
    this.sharedData = data;
  }

  createComponent(container, draggable) {
    const componentType = draggable.dataset.component;

    if(!this.registeredComponentTypes[componentType]) {
      console.error(componentType + ' component typeis not registered');
      console.log(this.registeredComponentTypes);
      return;
    }

    const panel = this.getPanelByElement(container);


    const componentManager = this.registeredComponentTypes[componentType]();

    componentManager.setPanel(panel);
    componentManager.setType(componentType);

    componentManager.sharedData = this.sharedData;

    panel.manager = componentManager;

    const element = document.createElement('div');
    element.classList.add('component');
    element.dataset.component = componentType;
    element.manager = componentManager;

    // JDX_TODO does not work
    // document.body.addEventListener('click', (event) => {
    //   this.currentComponent = null;
    //   this.configurationContainer.classList.remove('active');
    // });



    element.addEventListener('click', (event) => {
      this.currentComponent = event.currentTarget.closest('.component');

      // remove class active on all ".component" elements
      document.querySelectorAll('.component').forEach((component) => {
        component.classList.remove('active');
      });

      this.currentComponent.classList.add('active');

      this.setConfigurationPanelContent(element.manager.configuration);
    });

    // trigger click on element
    element.click();


    const toolbar = document.createElement('div');
    toolbar.classList.add('component-toolbar');

    const deleteButton = document.createElement('span');
    deleteButton.innerHTML = '<i class="fa fa-trash"></i>';
    toolbar.appendChild(deleteButton);


    deleteButton.addEventListener('click', (event) => {

      // stop propagation
      event.stopPropagation();

      const container = event.currentTarget.closest('.component');
      container.remove();
      this.currentComponent = null;

      console.log('%cLayoutEditor.js :: 377 =============================', 'color: #f00; font-size: 1rem');
      console.log("CLEAR CONFIGURATION PANEL");
      this.clearConfigurationPanel();
    });

    element.appendChild(toolbar);


    const content = document.createElement('div');
    content.classList.add('component-content');
    content.style.height = '100%';

    element.appendChild(content);
    container.appendChild(element);

    this.currentComponent = element;
    componentManager.onCreate(content, element.manager);
    this.saveManagerConfiguration(element.manager)
  }

  saveManagerConfiguration(manager) {
    const panel = manager._panel;
    panel.config.content[0].componentState.configuration = {};

    for(let attribute in manager) {
      const value = manager[attribute];
      if(typeof value !== 'function' && !attribute.match(/^_/)) {
        panel.config.content[0].componentState.configuration[attribute] = value;
      }
    }
  }

  refreshAll() {
    const panels = this.layout.root.getItemsByType("stack");

    for(let panel of panels) {
      if(panel.manager) {
        if(panel.manager.onUpdate) {
          panel.manager.onUpdate(
            panel.element.get(0).querySelector('.component-content'),
            panel.manager,
          );
        }
      }
    }
  }

  registerComponent(componentName, manager) {
    this.registeredComponentTypes[componentName] = manager;
 }
}
