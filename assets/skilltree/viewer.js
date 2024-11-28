

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
        const response = await fetch('/my-dektop/character/sheet/get-data?characterId=' + characterId + '&skilltreeId=' + skilltreeId);
        const json = await response.json();

        console.log('%cviewer.js :: 14 =============================', 'color: #f00; font-size: 1rem');
        console.log(json);

        if(json) {
            reactiveData.values = json.values;
            reactiveData.availableAttributePoints = json.availableAttributePoints;
            reactiveData.availableSkillPoints = json.availableSkillsPoints;
            reactiveData.availablePerks = json.availablePerksPoints;
        }

        loaded();

    }


    reactiveData.save = async () => {

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

            const response = await fetch('/my-dektop/character/sheet/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const json = await response.json();

            console.log('%cviewer.js :: 33 =============================', 'color: #f00; font-size: 1rem');
            console.log(json);
        }, 100);


    };


    reactiveData.loadValues();


});

