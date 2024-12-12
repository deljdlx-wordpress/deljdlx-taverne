

document.addEventListener('alpine:init', async () => {

    if(!document.querySelector('#skilltree-id')) {
        return;
    }

    loading();


    const skillEditor = await initializeSkillTree();
    const reactiveData = skillEditor.getData();

    reactiveData.loadValues = async() => {
        const characterId = document.querySelector('#character-id').value;
        const skilltreeId = document.querySelector('#skilltree-id').value;
        try {
            const response = await fetch('/my-desktop/character/sheet/get-data?characterId=' + characterId + '&skilltreeId=' + skilltreeId);
            const json = await response.json();

            console.log('%cviewer.js :: 14 =============================', 'color: #f00; font-size: 1rem');
            console.log(json);

            if(json) {
                reactiveData.values = json.values;
                reactiveData.availableAttributePoints = json.availableAttributePoints;
                reactiveData.availableSkillPoints = json.availableSkillsPoints;
                reactiveData.availablePerks = json.availablePerksPoints;
            }
        } catch(e) {
        }

        loaded();



    }

    let saving = false;
    let pending = 0;
    const loadingIndicator = document.querySelector('#loading-indicator');

    reactiveData.save = async () => {

        if(saving) {
            pending++;
            return;
        }

        loadingIndicator.classList.add('active');
        saving = true;

        setTimeout(async () => {
            const values = reactiveData.values;
            const availableAttributePoints = reactiveData.availableAttributePoints;
            const availableSkillsPoints = reactiveData.availableSkillPoints;
            const availablePerksPoints = reactiveData.availablePerks;

            const data = {
                data: {
                    values: values,
                    availableAttributePoints: availableAttributePoints,
                    availableSkillsPoints: availableSkillsPoints,
                    availablePerksPoints: availablePerksPoints,
                },
                characterId: document.querySelector('#character-id').value,
                skilltreeId: document.querySelector('#skilltree-id').value,
            };

            console.log('%calpine.js :: 75 =============================', 'color: #f00; font-size: 1rem');
            console.log(data);

            const response = await fetch('/my-desktop/character/sheet/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            saving = false;
            loadingIndicator.classList.remove('active');

            if(pending > 0) {
                pending = 0;
                reactiveData.save();
            }

            const json = await response.json();

            console.log('%cviewer.js :: 33 =============================', 'color: #f00; font-size: 1rem');
            console.log(json);
        }, 100);


    };


    reactiveData.loadValues();


});

