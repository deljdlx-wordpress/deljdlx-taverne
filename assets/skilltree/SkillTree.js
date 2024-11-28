
class SkillEditor {
  currentSelectedNode = null;
  tree;

  formElement;
  skillNameInput;
  skillCodeInput;

  data = null;
  plugins = [
    // "checkbox",
    "contextmenu",
    "dnd",
    // "massload",
    // "search",
    // "sort",
    // "state",
    "types",
    // "unique",
    // "wholerow",
    // "changed",
    // "conditionalselect"
  ];

  types = {
    root: {
      icon: "fa-solid fa-diamond"
    },

    "category-attributes": {
      icon: "fa-solid fa-folder"
    },
    "category-perks": {
      icon: "fa-solid fa-folder"
    },
    "category-skills": {
      icon: "fa-solid fa-folder"
    },
    "category-characteristics": {
      icon: "fa-solid fa-cogs"
    },

    perk: {
      icon: "fa-solid fa-book-sparkles"
    },
    attribute: {
      icon: "fa-solid fa-sparkles"
    },
    characteristic: {
      icon: "fa-solid fa-sparkles"
    },
    cluster: {
      icon: "fa-solid fa-dice-d6"
    },
    skill: {
      icon: "fa-solid fa-wand-sparkles"
    },

    default: {
      icon: "fa-solid fa-folder"
    },
  };

  eventListeners = {
    'select_node.jstree': [],
    'rename_node.jstree': [],
    'move_node.jstree': [],
    'create_node.jstree': [],
    'delete_node.jstree': [],
  }


  constructor(data) {

    this.data = data;
  }

  addEventListener(name, callback) {
    this.eventListeners[name].push(callback);
  }

  setData(data) {
    this.data = data;
  }

  getData() {
    return this.data;
  }

  render() {
    this.tree = $('#skill-tree').jstree({
      'core': {
        'data': this.data.treeData,
        'multiple': false,
        "check_callback": (operation, node, parent, position, more) => {
          console.log('%cSkillEditor.js :: 64 =============================', 'color: #f00; font-size: 1rem');
          console.log(operation);


          if (operation === "move_node") {
            return this.checkMove(operation, node, parent, position, more);
          }

          if (node.id === "root") {

            if (operation === "delete_node") {
              return false;
            }
            if (operation === 'rename_node') {
              return false;
            }
          }


          return true; // Autorise toutes les autres opérations
        }
      },
      plugins: this.plugins,
      types: this.types,
      contextmenu: {
        items: (node) => {
          return this.getContextMenu(node);
        }
      },
    })
      .on('ready.jstree', (e, data) => {
        this.data.ready = true;
      })
      // handle new node creation
      .on('create_node.jstree', (e, data) => {
        this.handleCreate(e, data);
      })
      // handle drag and drop
      .on('move_node.jstree', (e, data) => {

      }).on('ready.jstree', function () {
        $(this).jstree('open_all');
      })
      // handle node selection, fill the form with node data
      .on('select_node.jstree', (e, data) => {
        this.data.previousSelectedNode = this.data.selectedNode;
        this.data.selectedNode = data.node;

        this.eventListeners['select_node.jstree'].forEach(callback => {
          callback(e, data);
        });
      })

      //show_contextmenu.jstree
      .on('before_open.jstree', function (e, data) {

        // var tree = $(this).jstree(true);
        // var node = tree.get_node(data.node);

        // if (node.id === 'root') { // Vérifiez si le nœud est le nœud racine
        //   e.stopImmediatePropagation(); // Empêche l'ouverture du menu contextuel
        // }
      })

      // does not work

      .on('contextmenu.jstree', function (e, data) {

        console.log('%cSkillEditor.js :: 131 =============================', 'color: #f00; font-size: 1rem');
        console.log("CONTEXT MENU");

        var tree = $(this).jstree(true);
        var node = $(e.target).closest("li"); // Trouver l'élément de nœud le plus proche

        // Vérifiez si un nœud a été trouvé et sélectionnez-le
        if (node && node.attr("id")) {

          console.log(node);

          tree.select_node(node.attr("id"));
        }
      })

      .on('rename_node.jstree', (e, data) => {
        // console.log(`Nœud nouvellement renommé : Ancien nom = "${data.old}", Nouveau nom = "${data.node.text}"`);
        this.selectNodeById('root');
        this.selectNode(data.node);
      })

      ;
  }

  getJson() {
    return this.tree.jstree(true).get_json();
  }

  getContextMenu(node) {
    // if (node.id === 'root') {
    //     return {};
    // }

    let items = $.jstree.defaults.contextmenu.items();


    delete items.rename;
    delete items.ccp;

    if (node.type === 'category-attributes' || node.type === 'category-skills' || node.type === 'category-perks') {
      delete items.remove;
      return items;
    }

    return items;

    if(node.type === 'cluster' || node.type === 'skill' || node.type === 'perk' || node.type === 'attribute') {
      return items;
    }

    return {}


  }

  checkMove(operation, node, parent, position, more) {
    let newParent = more.ref;
    if (!newParent) {
      newParent = parent;
    }

    if (node.type === "skill" && newParent.type !== "cluster") {
      return false;
    }

    if (node.type === "cluster" && newParent.type !== "category-skills") {
      return false;
    }

    if (node.type === "attribute" && newParent.type !== "category-attributes") {
      return false;
    }

    if (node.type === "perk" && newParent.type !== "category-perks") {
      return false;
    }

  }


  renameCurrentNode(text) {
    // get current selected node in jstree
    const node = this.tree.jstree('get_selected', true)[0];
    if(node){
      return;
    }


    console.log('%cSkillEditor.js :: 214 =============================', 'color: #f00; font-size: 1rem');
    console.log(node);

    this.tree.jstree('rename_node', node, text);
  }

  renameNode(node, text) {
    this.tree.jstree('rename_node', node, text);
  }


  updateNode(node) {
    console.log('%cupdateNode.js :: 59 =============================', 'color: #f00; font-size: 2rem');
    console.log(node.type);

    // if (node.type !== 'skill' && node.type !== 'perk' && node.type !== 'attribute' && node.type !== 'cluster'
    //   && node.type // type is null for new nodes
    // ) {
    //   console.log('%cRETURN PARENT ROOT :: 64 =============================', 'color: #f00; font-size: 1rem');
    //   return;
    // }


    // JDLX_TODO it works also on data attribute, but it seems buggy
    this.tree.jstree('rename_node', node, node.text);
    // this.data.treeData = data.instance.get_json();


    // select node
    // this.selectNodeById('root');
    // this.selectNode(node);

  }


  handleCreate(e, data) {

    console.log('%cSkillEditor.js :: 193 =============================', 'color: #f00; font-size: 1rem');
    console.log("CREATE");


    const parentNodeId = data.node.parent;
    const parentNode = data.instance.get_node(parentNodeId);
    const parentType = parentNode.type;

    console.log('%cNEW NODE =============================', 'color: #f00; font-size: 1rem');
    console.log(parentType);


    if (parentType === 'cluster') {
      data.instance.set_text(data.node, "Nouvelle compétence");
      data.instance.set_type(data.node, 'skill');
    }
    else if (parentType === 'category-attributes') {
      data.instance.set_text(data.node, "Nouvel attribut");
      data.instance.set_type(data.node, 'attribute');
    }
    else if (parentType === 'category-skills') {
      data.instance.set_text(data.node, "Nouveau cluster");
      data.instance.set_type(data.node, 'cluster');
    }
    else if (parentType === 'category-perks') {
      data.instance.set_text(data.node, "Nouvel avantage");
      data.instance.set_type(data.node, 'perk');
    }
    else if (parentType === 'category-characteristics') {
      data.instance.set_text(data.node, "Nouvelle caracteristique");
      data.instance.set_type(data.node, 'characteristic');
    }
    else {
      data.instance.delete_node(data.node);
    }

    data.node.data = {
      code: '',
    };

    this.data.treeData = data.instance.get_json();
    this.selectNode(data.node);
  }


  selectNode(node) {

    // unselect all selected nodes
    this.tree.jstree('deselect_all');

    this.tree.jstree('select_node', node);
    this.data.selectedNode = node;
  }

  selectNodeById(id) {
    const node = this.tree.jstree('get_node', id);
    console.log('%cSkillEditor.js :: 283 =============================', 'color: #f00; font-size: 1rem');
    console.log(node);

    this.selectNode(node);
  }

  getNodes() {
    return this.tree.jstree('get_json', 'root', {
      flat: true
    });
  }

  getNodeById(id) {
    return this.tree.jstree('get_node', id);
  }

  getNodeByCode(code) {
    // search in tree node with data.code === code
    const nodes = this.tree.jstree('get_json', 'root', {
      flat: true
    });

    return nodes.find(node => node.data.code === code);
  }
}
