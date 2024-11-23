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
        </div>


        <div id="component-configuration-container">
            <div class="component-configuration__toolbar">
                {{-- <button class="btn btn-primary w-full" id="update-configuration-trigger">Update</buttton> --}}

                {{-- save icon --}}
                <a class="save-trigger" id="update-configuration-trigger">
                    <i class="fas fa-save"></i>
                </a>

                {{-- maximize font awesome icon --}}
                <a class="maximize"><i class="fas fa-expand-arrows-alt"></i></a>
                {{-- minimuze icon --}}
                <a class="minimize"><i class="fas fa-compress-arrows-alt minimize"></i></a>
            </div>
            <div id="component-configuration"></div>
        </div>
    </div>

    <div id="layoutContainer"></div>
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

            layoutEditor.addPlugin('datatable');
            layoutEditor.addPlugin('tinymce');

            document.querySelector('.component-configuration__toolbar .maximize').addEventListener('click', () => {
                document.querySelector('#component-configuration-container').classList.add('fullscreen');
            });
            document.querySelector('.component-configuration__toolbar .minimize').addEventListener('click', () => {
                document.querySelector('#component-configuration-container').classList.remove('fullscreen');
            });
        });
    </script>
@endsection
