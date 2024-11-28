class SkilltreeEditor
{

    skillTtree = null;

    constructor(skillTtree) {
        this.skillTtree = skillTtree;



        this.skillTtree.getData().updateSelectedNode = async (event) => {
            return await this.handleNodeUpdate(event);

        };

        // KEPT FOR EXEMPLE
        // this.skillTtree.getData().handleNodeSelection = () => {
        //     console.log('%ceditor.js :: 17 =============================', 'color: #f00; font-size: 2rem');
        //     console.log("handleNodeSelection");

        //     const codeContainers = document.querySelectorAll('.code');
        //     codeContainers.forEach((container) => {
        //         console.log('%ceditor.js :: 87 =============================', 'color: #f0f; font-size: 1rem');
        //         console.log(container.value)
        //         console.log(container.innerHTML)
        //     });
        // }


        this.skillTtree.addEventListener('select_node.jstree', async (event, data) => {
            setTimeout(() => {
                this.handleNodeSelection(event, data);
            }, 100);
        });


        const saveTrigger = document.querySelector('#save-trigger');
        saveTrigger.addEventListener('click', async (e) => {
            this.save(e);
        });

        this.handleIllustrationPaste();
    }

    async handleNodeSelection(event, data) {

        const selectedNode = this.skillTtree.getData().selectedNode;


        // ===========================
        const imageUploader = document.querySelector('#imageUploader');
        const imagePreview = document.querySelector('#imagePreview');

        imageUploader.value = '';
        imagePreview.innerHTML = '';

        if(!imageUploader.dataset.initialized) {
            imageUploader.dataset.initialized = 'true'
            imageUploader.addEventListener('change', async (e) => {
                const file = e.target.files[0];
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100%';
                    img.style.height = 'auto';
                    imagePreview.appendChild(img);
                }
                reader.readAsDataURL(file);

                let json = await this.uploadImage(file);
                console.log('%ceditor.js :: 50 =============================', 'color: #f00; font-size: 1rem');
                console.log(json);
                this.skillTtree.getData().selectedNode.data.illustration = json['image_url'];
            });
        }


        // ===========================

        // JDLX_TODO does not work
        // const containers = document.querySelectorAll('.quill');
        // containers.forEach((container) => {
        //     if(!container.dataset.initialized) {
        //         container.dataset.initialized = 'true';
        //         const quill = new Quill(container, {
        //             theme: "snow"
        //         });
        //     }
        // });

        // ===========================

        this.handleAceEditor();


    }

    handleAceEditor() {


        const codeContainers = document.querySelectorAll('.code');

        codeContainers.forEach(async (container) => {


            const selectedNode = this.skillTtree.getData().selectedNode;

            // destroy previous ace editor
            if (container.querySelector('.ace_editor')) {
                container.querySelector('.ace_editor').remove();
            }


            const langTools = ace.require("ace/ext/language_tools");

            const editor = ace.edit();

            editor.setOptions({
                theme: "ace/theme/dracula",
                mode: "ace/mode/taverne",
                maxLines: 30,
                minLines: container.dataset.lines,
                autoScrollEditorIntoView: true,
                enableBasicAutocompletion: true,
                enableSnippets: true,
                enableLiveAutocompletion: true, // Si tu veux la complétion en temps réel
            });


            var taverneCompleter = {
                getCompletions: (editor, session, pos, prefix, callback) => {
                    if (prefix.length === 0) { callback(null, []); return }


                    const autocompletions = [];
                    const nodes = this.skillTtree.getNodes();
                    nodes.forEach((node) => {
                        if(node.data.code) {
                            autocompletions.push({
                                name: node.text,
                                value: '${' + node.data.code + '}',
                                score: 1,
                                meta: node.data.code
                            });
                        }
                    });

                    callback(null, autocompletions);

                    // harcoded autocompletions, kept for exemple
                    // callback(null, [
                    //     {name: "test", value: "test", score: 1, meta: "test"},
                    //     {name: "foo", value: "foo", score: 1, meta: "test"},
                    // ]);

                }
            }
            langTools.addCompleter(taverneCompleter);
            editor.session.setValue(selectedNode.data[container.dataset.fieldName] ??  '');

            // listen changes in editor
            editor.on('change', (e) => {
                selectedNode.data[container.dataset.fieldName] = editor.getValue();
            });

            // JDLX_TODO tooltips
            // editor.on("mousemove", function (e) {
            //     const renderer = editor.renderer;
            //     const session = editor.getSession();
            //     const docPos = renderer.screenToTextCoordinates(e.clientX, e.clientY);
            //     const token = session.getTokenAt(docPos.row, docPos.column);

            //     console.log(token);

            //     if (token && token.type === "variable.language") {
            //         tooltip.textContent = `Information sur : ${token.value}`; // Ton contenu d'aide
            //         tooltip.style.left = e.clientX + 10 + "px";
            //         tooltip.style.top = e.clientY + 10 + "px";
            //         tooltip.style.display = "block";
            //     } else {
            //         tooltip.style.display = "none";
            //     }
            // });


            container.appendChild(editor.container);

        });
    }

    async handleNodeUpdate(event) {
        const selectedNode = this.skillTtree.getData().selectedNode;
        this.skillTtree.updateNode(selectedNode);
    }

    async save(e) {

        console.log('%ceditor.js :: 17 =============================', 'color: #f00; font-size: 1rem');
        console.log("SAVE");

        e.preventDefault();
        const data = {
            id: document.querySelector('#skillTreeId').value,
            tree: this.skillTtree.getJson(),
            name: document.querySelector('#skill-tree-name').value,
        }

        // send post data with fetch
        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        }

        const response = await fetch('?', options);
        const json = await response.json();
        const skillTreeId = json.id;
        if(!document.querySelector('#skillTreeId').value) {
            document.location = '?id=' + skillTreeId;
        }
        // document.querySelector('#skillTreeId').value = skillTreeId;
    }

    async handleIllustrationPaste() {
        document.addEventListener('paste', async (e) => {
            const items = e.clipboardData.items;
            if (items.length === 0) {
                return;
            }

            const file = items[0].getAsFile();
            if (!file) {
                return;
            }

            const previewElement = document.querySelector('#imagePreview');
            if(previewElement) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewElement.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100%';
                    img.style.height = 'auto';
                    previewElement.appendChild(img);
                }
                reader.readAsDataURL(file);


                let json = await this.uploadImage(file);
                this.skillTtree.getData().selectedNode.data.illustration = json['image_url'];
            }
        });
    }

    async handleIllustrationUpload() {

    }

    async uploadImage(file) {
        const formData = new FormData();
        formData.append('file', file);
        const options = {
            method: 'POST',
            body: formData
        }
        const response = await fetch('/wp-json/jdlx-force/v1/image', options);
        const json = await response.json();
        return json;
    }
}

document.addEventListener('alpine:init', async () => {


    let skillEditor = await initializeSkillTree();
    let editor = new SkilltreeEditor(skillEditor);

    // ===========================


});
