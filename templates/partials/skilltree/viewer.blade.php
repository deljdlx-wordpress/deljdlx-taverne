<div class="skill-tree-viewer">
    <div>
        @if(isset($character))
            <h1>{{ $character->getField('name') }}</h1>
        @endif

        <template x-if="ready">
            <div class="grid grid-cols-12 gap-2">

                <div class="col-span-4 p-2 container attributes-container">
                    <div class="available-points-container">
                        <h2>Attributs</h2>
                        <span class="available-points" x-text="availableAttributePoints"></span>
                    </div>

                    <div>
                        <template x-for="childId in getNodeById('category-attributes').children">
                            <div class="attribute-container" x-data="{node: getNodeById(childId)}">
                                <div class="with-tooltip">
                                    <span x-text="node.text"></span>
                                    <template x-if="node.data.description">
                                        <div class="tooltip" :data-tip="node.data.description">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                    </template>
                                </div>
                                <div class="value-container">
                                    <span  class="value" x-text="computeValue(node)"></span>
                                    <button x-on:click="
                                        if(availableAttributePoints > 0) {
                                            if(incrementValue(node.data.code, 1, 0, 10)) {
                                                availableAttributePoints--;
                                            }
                                        }" class="btn btn-xs btn-primary value-modifier">
                                        <i class="fas fa-plus" style="font-size: 10px;"></i>
                                    </button>
                                    <button x-on:click="
                                        if(incrementValue(node.data.code, -1, 0, 10)) {
                                            availableAttributePoints++;
                                        }
                                    " class="btn btn-xs btn-primary value-modifier">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="col-span-4 p-2 container perks-container">
                    <div class="available-points-container">
                        <h2>Perks</h2>
                        <span class="available-points" x-text="availablePerks"></span>
                    </div>
                    <template x-for="childId in getNodeById('category-perks').children">
                        <div class="perk-container" x-data="{node: getNodeById(childId)}">


                            <div class="with-tooltip">
                                <span x-text="node.text"></span>
                                <template x-if="node.data.description">
                                    <div class="tooltip" :data-tip="node.data.description">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                </template>
                            </div>





                            <input @click="
                            if(!values[node.data.code]) {
                                if(!availablePerks) {
                                    values[node.data.code] = false;
                                }
                                else {
                                    availablePerks--;
                                }
                            } else {
                                availablePerks++;
                            }" type="checkbox" x-model="values[node.data.code]" :checked="values[node.data.code]" :disabled="!values[node.data.code] && !availablePerks" class="checkbox checkbox-primary"/>
                        </div>
                    </template>
                </div>

                <div class="col-span-4 p-2 container characteristics-container">
                    <h2>Caractéristiques</h2>
                    <template x-for="childId in getNodeById('category-characteristics').children">
                        <div class="characteristic-container" x-data="{node: getNodeById(childId)}">
                            <div class="with-tooltip">
                                <span x-text="node.text"></span>
                                <template x-if="node.data.description">
                                    <div class="tooltip" :data-tip="node.data.description">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                </template>
                            </div>
                            <span x-text="computeValue(node)"></span>
                        </div>
                    </template>
                </div>


            </div>
        </template>
    </div>


    <template x-if="ready">

        <div>
            <div class="available-points-container">
                <h2>Compétences</h2>
                <span class="available-points" x-text="availableSkillPoints"></span>
            </div>


            <div class="grid grid-cols-12 gap-2 skills-container">
                <template x-for="clusterId in getNodeById('category-skills').children">
                    <div class="col-span-4 cluster-container container"  x-data="{cluster: getNodeById(clusterId)}">
                        <h2 x-text="cluster.text"></h2>
                        <template x-for="skillId in cluster.children">

                                <div x-data="{skill: getNodeById(skillId)}" class="skill-container">
                                    <div class="with-tooltip">
                                        <span x-text="skill.text"></span>
                                        <template x-if="skill.data.description">
                                            <div class="tooltip" :data-tip="skill.data.description">
                                                <i class="fas fa-question-circle"></i>
                                            </div>
                                        </template>
                                    </div>


                                    <div class="value-container">
                                        <span class="value" x-text="computeValue(skill)"></span>
                                        <button x-on:click="
                                            if(availableSkillPoints > 0) {
                                                if(incrementValue(skill.data.code)) {
                                                    availableSkillPoints--;
                                                }
                                            }" class="btn btn-xs btn-primary value-modifier">
                                            <i class="fas fa-plus" style="font-size: 10px;"></i>
                                        </button>

                                        <button x-on:click="
                                            if(incrementValue(skill.data.code, -1)) {
                                                availableSkillPoints++;
                                            }"class="btn btn-xs btn-primary value-modifier">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </template>
</div>
