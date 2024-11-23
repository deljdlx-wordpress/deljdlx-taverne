<?php
namespace Deljdlx\WPTaverne\Controllers;


class LayoutEditor extends Base
{

    public static $prependJs = [
        'https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js',
    ];

    public static $appendJs = [
        'vendor/ace-editor/src/ace.js',
        'plugin://deljdlx-taverne/assets/vendor/goldenlayout/goldenlayout.js',

        'plugin://deljdlx-taverne/assets/vendor/datatable/datatable.js',

        'plugin://deljdlx-taverne/assets/js/layout-editor/LayoutEditor.js',
        'plugin://deljdlx-taverne/assets/js/layout-editor/ComponentManagers/GenericManager.js',
        'plugin://deljdlx-taverne/assets/js/layout-editor/ComponentManagers/DatatableManager.js',
        'plugin://deljdlx-taverne/assets/js/layout-editor/ComponentManagers/TinyMCEManager.js',

        'plugin://deljdlx-taverne/assets/js/layout-editor/ComponentManagers/EchartManager.js',
        'plugin://deljdlx-taverne/assets/js/layout-editor/ComponentManagers/EchartPieManager.js',
        'plugin://deljdlx-taverne/assets/js/layout-editor/ComponentManagers/EchartRadarManager.js',



        'plugin://deljdlx-taverne/assets/js/layout-editor/plugins/echarts.js',
        'plugin://deljdlx-taverne/assets/js/layout-editor/plugins/datatable.js',
        'plugin://deljdlx-taverne/assets/js/layout-editor/plugins/tinymce.js',

        'plugin://deljdlx-taverne/assets/js/layout-editor/plugins/ace-editor.js',

        'plugin://deljdlx-taverne/assets/js/layout-editor/LayoutViewer.js',
    ];

    public static $appendCss = [
        'plugin://deljdlx-taverne/assets/vendor/goldenlayout/goldenlayout-base.css',
        'plugin://deljdlx-taverne/assets/vendor/goldenlayout/goldenlayout-dark-theme.css',

        'plugin://deljdlx-taverne/assets/vendor/datatable/datatable.css',

        'plugin://deljdlx-taverne/assets/js/layout-editor/layout-editor.css',
        'plugin://deljdlx-taverne/assets/js/layout-editor/layout-viewer.css',
    ];


    public function view() {
        $layout = json_decode(
            file_get_contents(__DIR__ . '/layout.json'),
            true,
        );

        $html = $this->renderPanel($layout['layout']['content']);

        $inputs = $this->getRequest()->input();

        foreach($inputs as $key => $value) {
            if(preg_match('`^shared-`', $key)) {
                $variableName = str_replace('shared-', '', $key);
                $layout['sharedData'][$variableName] = $value;
            }
        }


        $html .= '<textarea id="sharedData" style="display: none">' .
            json_encode($layout['sharedData'], JSON_PRETTY_PRINT) .
        '</textarea>';



        return $this->renderTemplate('layouts.layout-editor.view', [
            'html' => $html,
        ]);
    }


    public function edit()
    {
        // hide wp admin bar
        // add_filter('show_admin_bar', '__return_false');

        wp_enqueue_editor();
        wp_enqueue_media();

        return $this->renderTemplate('layouts.layout-editor.edit', []);
    }

    private function renderPanel(array $panels, string $parentType = null)
    {
        $html = '';
        foreach($panels as $panel) {

            $height = '100%';
            $width = '100%';


            $type = $panel['type'];


            if($parentType === 'row') {
                $width = isset($panel['width']) ? $panel['width'].'%' : '100%';
            }
            if($parentType === 'column') {
                $height = isset($panel['height']) ? $panel['height'].'%' : '100%';
            }

            if($type === 'row') {
                $height = isset($panel['height']) ? $panel['height'].'%' : '100%';
            }

            $class = '';
            if($type !== 'component') {
                $class = 'forge-layout-container forge-layout-container-'.$type;
            }

            $html .= '<div class="'.$class.'" style="height: '.$height.'; width: '.$width.';">';

            if(isset($panel['componentState']['text'])) {
                $html .= $panel['componentState']['text'];
            }
            if(isset($panel['content'])) {
                $html .= $this->renderPanel($panel['content'], $type);
            }

            if(isset($panel['componentState']['configuration'])) {

                $html .= $this->handleComponentConfiguration($panel['componentState']['configuration']);
                // $html .= '<pre>' .
                //     json_encode($panel['componentState']['configuration'], JSON_PRETTY_PRINT) .
                // '</pre>';
            }


            $html .= '</div>';
        }

        return $html;
    }

    public function handleComponentConfiguration(array $configuration) {

        static $idCounter;

        if($idCounter === null) {
            $idCounter = 0;
        }

        $html = '';

        $id = 'echart-container-'.$idCounter;
        $idCounter++;

        $html .= '<div class="componentContainer" id="' . $id . '">
            <h2 class="componentTitle">' . $configuration['title']  . '</h2>
            <div class="componentContent"></div>
            <textarea class="componentConfiguration">'.json_encode($configuration, JSON_PRETTY_PRINT).'</textarea>
        </div>';


        return $html;
    }
}

