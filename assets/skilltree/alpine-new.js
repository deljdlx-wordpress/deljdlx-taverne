initializeSkillTree = async function () {



  let skillEditor = null;

  const skillTreeStore = {
      ready: false,
      selectedNode: null,
      previousSelectedNode: null,

      defaultValues: {
          S: 5,
          P: 5,
          E: 5,
          C: 5,
          I: 5,
          A: 5,
          L: 5,
      },

      values: {
          S: 5,
          P: 5,
          E: 5,
          C: 5,
          I: 5,
          A: 5,
          L: 5,

          // PERK_SNIPER: false,
          // PERK_LUCKY: false,
          // PERK_DESTIN: true,
          // PERK_WIMPY: true,
          // PERK_NINJA: false,
          // SKILL_ENERGY_WEAPONS: 20,
      },

      defaultAvaiblePoints: {
          attributes: 10,
          perks: 2,
          skills: 100,
      },

      defaultAvailableAttributePoints: 10,

      availableAttributesPoints: 0,
      availableSkillsPoints: 0,
      availablePerksPoints: 0,

      computeAvailableAttributesPoints() {
          let available = this.defaultAvaiblePoints['attributes'];

          const children = this.getNodeById('category-attributes').children;

          console.log('%calpine.js :: 58 =============================', 'color: #f00; font-size: 1rem');
          console.log(children);


          for(index in children) {
              const childId = children[index];
              const node = this.getNodeById(childId);
              const code = node.data.code
              const value = this.values[code] ?? 0;

              const delta = (this.defaultValues[code] ?? 0) - value;
              available += delta;

              console.log(node);
              console.log(code + ':' + value);
              console.log(delta);

          }

          this.availableAttributesPoints = available;
          console.log('%calpine.js :: 75 =============================', 'color: #f00; font-size: 2rem');
          console.log(this.availablesAttributePoints);
      },

      computeAvailableSkillsPoints() {
          let available = this.defaultAvaiblePoints['skills'];

          const children = this.getNodeById('category-skills').children;

          console.log('%calpine.js :: 58 =============================', 'color: #f00; font-size: 1rem');
          console.log(children);
          console.log(available);


          // for(index in children) {
          //     const childId = children[index];
          //     const node = this.getNodeById(childId);
          //     const code = node.data.code
          //     const value = this.values[code] ?? 0;

          //     const delta = (this.defaultValues[code] ?? 0) - value;
          //     available += delta;

          //     console.log(node);
          //     console.log(code + ':' + value);
          //     console.log(delta);

          // }

          // this.availableAttributesPoints = available;
          // console.log('%calpine.js :: 75 =============================', 'color: #f00; font-size: 2rem');
          // console.log(this.availablesAttributePoints);
      },


      treeData: [{
          id: 'root',
          text: "Root node",
          type: "root",
          data: {
              code: 'ROOT',
          },
          "children": [
              {
                  text: "Attributes", type: "category-attributes", id: "category-attributes",
                  data: {
                      code: '',
                  },
                  children: []
              },
              {
                  text: "Caractéristiques", type: "category-characteristics", id: "category-characteristics",
                  data: {
                      code: '',
                  },
                  children: []
              },
              {
                  text: "Perks", type: "category-perks", id: "category-perks",
                  data: {
                      code: '',
                  },
                  children: []
              },
              {
                  text: "Skills", type: "category-skills", id: "category-skills",
                  data: {
                      code: '',
                  },
                  children: []
              },
          ]
      }],

      incrementValue(code, increment = 1, min = 0, max = 100) {
          if (typeof (this.values[code]) === 'undefined') {
              this.values[code] = 0;
          }

          if (increment > 0 && this.values[code] < max) {
              this.values[code] += increment;
              this.save();

              return true;
          }

          if (increment < 0 && this.values[code] > min) {
              this.values[code] += increment;
              this.save();

              return true;
          }


          return false;
      },

      computeValue(node) {
          let formula = node.data.value;
          let value = this.getValueByCode(node.data.code);

          const keys = [];


          if (formula) {

              formula = formula.replace('${__VALUE}', 'value');

              const matches = formula.match(/\${(.*?)}/g);
              if (matches) {
                  matches.forEach(match => {
                      const key = match.replace('${', '').replace('}', '');

                      keys.push(key);

                      const linkedNode = skillEditor.getNodeByCode(key)
                      formula = formula.replace(match, this.computeValue(linkedNode));
                  });
              }

              value = eval(formula);
          }


          const perks = this.getNodeById('category-perks').children;
          for (let perkId of perks) {

              const perk = this.getNodeById(perkId);

              if (!this.values[perk.data.code]) {
                  continue;
              }

              const modifiersString = perk.data.modifiers;

              if (modifiersString) {
                  const modifiers = modifiersString.split("\n");
                  for (let modifier of modifiers) {

                      const key = '${' + node.data.code + '}';
                      const hasKey = modifier.includes(key);

                      if (hasKey) {
                          let formula = modifier;
                          formula = formula.replace(key, 'value');
                          formula = formula.replace('${__VALUE}', 'value');
                          eval(formula)
                      }
                  }
              }
          }

          return parseInt(value);
      },

      getValueByCode(code) {
          if (typeof (this.values[code]) !== 'undefined') {

              const returnValue = parseInt(this.values[code]);
              if (isNaN(returnValue)) {
                  this.values[code] = 0;
                  return 0;
              }
              return returnValue;
          }

          return 0;
      },

      getNodeById(id) {
          const node = skillEditor.getNodeById(id);
          return node;
      },



      init() {

      }
  };



  // =========================== 


  reactiveData = Alpine.reactive(skillTreeStore);
  Alpine.data('application', () => (reactiveData))

  if (document.querySelector('#skillTreeId').value) {

      const permalink = document.querySelector('#skillTreePermalink').value;

      await fetch(permalink).then(response => response.json()).then(response => {
          console.log(response);
          if (response.data) {
              reactiveData.treeData = response.data;
          }

          skillEditor = new SkillEditor(reactiveData);
          skillEditor.render();
      });
  } else {
      skillEditor = new SkillEditor(reactiveData);
      skillEditor.render();
  }

  return skillEditor;
};
