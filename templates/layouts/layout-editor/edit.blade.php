@php
    use Deljdlx\WPTaverne\Models\Place;
    use Deljdlx\WPTaverne\Models\Character;
@endphp

@extends('layouts/common/empty')

<style>


</style>



<div id="top-toolbar">

</div>
<div id="wrapper">
    <div id="leftContainer">

        <div id="menuContainer"></div>

        <div>

            <div class="draggable" data-component="tinymce">
                <div>
                    HTML
                </div>
            </div>


            <div class="draggable" data-component="datatable">
                <div>
                    Data table
                </div>
            </div>


            <div class="draggable" data-component="echart-line">
                <div>
                    Line chart
                </div>
            </div>

            <div class="draggable" data-component="echart-bar">
                <div>
                    Bar chart
                </div>
            </div>

            <div class="draggable" data-component="echart-pie">
                <div>
                    Pie chart
                </div>
            </div>

            <div class="draggable" data-component="echart-donut">
                <div>
                    Donut chart
                </div>
            </div>

            <div class="draggable" data-component="echart-radar">
                <div>
                    Radar chart
                </div>
            </div>

            <div class="draggable" data-component="graph-scatter">
                <div>
                    Scatter chart
                </div>
            </div>
        </div>

        <div>
            <h2>Global variables</h2>
            <div id="global-variables-editor" style="height: 100px"></div>
        </div>


    </div>

    <div id="layoutContainer"></div>

    <div id="rightContainer">

        <div id="component-configuration-container">

            <div class="component-configuration__toolbar">
                <a class="save-trigger" id="update-configuration-trigger"><i class="fas fa-save"></i></a>
                <a class="maximize"><i class="fas fa-expand-arrows-alt"></i></a>
                <a class="minimize"><i class="fas fa-compress-arrows-alt minimize"></i></a>
            </div>


            <div role="tablist" class="tabs tabs-bordered">

                {{-- ====================================================================================== --}}
                <input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Settings" checked="checked"/>
                <div role="tabpanel" class="tab-content">
                    <div id="component-configuration-0"></div>
                </div>

                {{-- ====================================================================================== --}}


                <input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Data" />
                <div role="tabpanel" class="tab-content">
                    <div id="component-configuration-1"></div>
                </div>

                {{-- ====================================================================================== --}}

                <input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Misc" />
                <div role="tabpanel" class="tab-content">
                    <div id="component-configuration-2"></div>
                </div>
            </div>
        </div>


    </div>

</div>

@section('body-content')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ===========================
            const layoutEditor = new LayoutEditor();

            layoutEditor.addPlugin('echart-bar');
            layoutEditor.addPlugin('echart-line');
            layoutEditor.addPlugin('echart-pie');
            layoutEditor.addPlugin('echart-donut');
            layoutEditor.addPlugin('echart-radar');

            layoutEditor.addPlugin('graph-scatter');
            layoutEditor.addPlugin('datatable');
            layoutEditor.addPlugin('tinymce');

            const componentConfigurationPanel = document.querySelector('#component-configuration-container');
            const rightContainer = document.querySelector('#rightContainer');
            document.querySelector('.component-configuration__toolbar .maximize').addEventListener('click', () => {
                componentConfigurationPanel.classList.add('fullscreen');
                document.body.appendChild(componentConfigurationPanel);
            });
            document.querySelector('.component-configuration__toolbar .minimize').addEventListener('click', () => {
                componentConfigurationPanel.classList.remove('fullscreen');
                rightContainer.appendChild(componentConfigurationPanel);
            });

            const saveTrigger = document.querySelector('#update-configuration-trigger');
            saveTrigger.addEventListener('click', (event) => {
                const data = layoutEditor.getJson();
                console.log('%cedit.blade.php :: 151 =============================', 'color: #f00; font-size: 1rem');
                console.log(data);


                const json = JSON.stringify(data, (key, value) => {
                    if(key.match(/^_/)) {
                        return;
                    }
                    return value;
                }, 4);

                console.log(json);
            });



            // window.globalVariables = {};

            const aceContainer = document.querySelector('#global-variables-editor');

            const editor = ace.edit(aceContainer);
            editor.setOptions({
                theme: "ace/theme/dracula",
                mode: "ace/mode/javascript",
                // maxLines: 30,
                minLines: 30,
                autoScrollEditorIntoView: true,
                enableBasicAutocompletion: true,
                enableSnippets: true,
                enableLiveAutocompletion: true, // Si tu veux la complétion en temps réel
            });

            // editor.session.setValue(value);
            editor.session.on('change', function(delta) {
                const code = editor.getValue();
                try {
                    const json = JSON.parse(code);
                    console.log('%cedit.blade.php :: 142 =============================',
                        'color: #f00; font-size: 1rem');
                    console.log(json);
                    // window.globalVariables = json;

                    layoutEditor.setSharedData(json);

                } catch (error) {
                    console.error('Invalid json : ' + code);
                }
            });

        });
    </script>
@endsection
