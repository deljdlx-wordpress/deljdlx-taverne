<?php
// header('Content-Type: text/html');
header('Content-Type: text/css');


$mainFontFamily = '"Noticia Text", serif';
$mainFontSize = '14px';
$mainFontColor = '#000';
$mainFontWeight = '400';

$mainFont = get_theme_mod('main-font');
if(is_array($mainFont)) {
  if(isset($mainFont['font-family'])) {
    $mainFontFamily = $mainFont['font-family'];
  }
  if(isset($mainFont['font-size'])) {
    $mainFontSize = $mainFont['font-size'];
  }
  if(isset($mainFont['color'])) {
    $mainFontColor = $mainFont['color'];
  }
  if(isset($mainFont['font-weight'])) {
    $mainFontWeight = $mainFont['font-weight'];
  }
}






?>

/* custom css */

/*
{{get_theme_mod('primary-color')}}
*/


:root {
  --background-color: {!!get_theme_mod('background-color', '#fff')!!};
  --background-image: url({!!get_theme_mod('background-image', 'none')!!});
  --text-color: {!!get_theme_mod('text-color', '#000')!!};
  --link-color: {!!get_theme_mod('link-color', '#0073aa')!!};

  --main-font-family: {!!$mainFontFamily ?? 'verdana'!!};
  --main-font-size: {!!$mainFontSize ?? '14px'!!};
  --main-font-color: {!!$mainFontColor ?? '#000'!!};
  --main-font-weight: {!!get_theme_mod('main-font-weight', '400')!!};
}


.taverne {

  --button-radius:{{get_theme_mod('button-radius', '4')}}px;

  --card-border-radius:{{get_theme_mod('card-border-radius', '4')}}px;
  --card-border-width:{{get_theme_mod('card-border-width', '1')}}px;
  --card-border-color:{{get_theme_mod('card-border-color', 'var(--text-color)')}};
  --card-title-font-size: {{get_theme_mod('card-title-font-size', 'var(--main-font-size)')}};
  --card-background-color:{{get_theme_mod('card-background-color', 'transparent')}};

  --primary-color: {{rgbaToOklch(get_theme_mod('primary-color', '#f0f'))}};
  --secondary-color: {{rgbaToOklch(get_theme_mod('secondary-color', '#f0f'))}};
  --accent-color: {{rgbaToOklch(get_theme_mod('accent-color', '#f0f'))}};
  --neutral-color: {{rgbaToOklch(get_theme_mod('neutral-color', '#f0f'))}};

  --info-color: {{rgbaToOklch(get_theme_mod('info-color', '#f0f'))}};
  --success-color: {{rgbaToOklch(get_theme_mod('success-color', '#f0f'))}};
  --error-color: {{rgbaToOklch(get_theme_mod('error-color', '#f0f'))}};


  /*site title===================================================================================*/
  @php
  $siteTitle = get_theme_mod('site-title-typography');
  if(is_array($siteTitle)) {
    if(isset($siteTitle['font-family'])) {
      $siteTitleFontFamily = $siteTitle['font-family'];
    }
    if(isset($siteTitle['font-size'])) {
      $siteTitleFontSize = $siteTitle['font-size'];
    }
    if(isset($siteTitle['font-weight'])) {
      $siteTitleFontWeight = $siteTitle['font-weight'];
    }
    if(isset($siteTitle['color'])) {
      $siteTitleFontColor = $siteTitle['color'];
    }
  }
  @endphp
  --site-title-font-family: {!!$siteTitleFontFamily ?? 'verdana'!!};
  --site-title-font-size: {!!$siteTitleFontSize ?? '24px'!!};
  --site-title-font-color: {!!$siteTitleFontColor ?? 'var(--text-color)'!!};
  --site-title-font-weight: {!!$siteTitleFontWeight ?? '700'!!};



  @php

  for($i = 1 ; $i <= 6 ; $i++) {

    echo '/*H'.$i . ' variables =================================================================================*/'."\n";

    $titleLevel = 'h'.$i;
    $titleOptions = get_theme_mod($titleLevel.'-typography');
    if($titleOptions) {
      if(is_array($titleOptions)) {
        if(isset($titleOptions['font-family'])) {
          $titleFontFamily = $titleOptions['font-family'];
        }
        if(isset($titleOptions['font-size'])) {
          $titleFontSize = $titleOptions['font-size'];
        }
        if(isset($titleOptions['font-weight'])) {
          $titleFontWeight = $titleOptions['font-weight'];
        }
        if(isset($titleOptions['color'])) {
          $titleFontColor = $titleOptions['color'];
        }
        if(isset($titleOptions['text-align'])) {
          $titleTextAlign = $titleOptions['text-align'];
        }
      }
      $titleMarginBottom = get_theme_mod($titleLevel.'-margin-bottom', '1rem');
      $titleMarginTop = get_theme_mod($titleLevel.'-margin-top', '1rem');
      @endphp
      --{{$titleLevel}}-font-family: {!!$titleFontFamily ?? 'verdana'!!};
      --{{$titleLevel}}-font-size: {!!$titleFontSize ?? '24px'!!};
      --{{$titleLevel}}-text-align: {!!$titleTextAlign ?? 'left'!!};
      --{{$titleLevel}}-font-color: {!!$titleFontColor ?? 'var(--text-color)'!!};
      --{{$titleLevel}}-font-weight: {!!$titleFontWeight ?? '700'!!};
      --{{$titleLevel}}-margin-bottom: {!!$titleMarginBottom ?? '16'!!}px;
      --{{$titleLevel}}-margin-top: {!!$titleMarginTop ?? '16'!!}px;
      @php
    }
  }
  @endphp
}


/*====================================================================*/
/*TYPOGRAPHY==========================================================*/
/*====================================================================*/


@for($i = 1 ; $i <= 6 ; $i++)
  /*H{{$i}}=================================================================================*/
  body.taverne h{{$i}} {
    font-family: var(--h{{$i}}-font-family);
    font-size: var(--h{{$i}}-font-size);
    color: var(--h{{$i}}-font-color);
    font-weight: var(--h{{$i}}-font-weight);
    text-align: var(--h{{$i}}-text-align);
    margin-bottom: var(--h{{$i}}-margin-bottom);
    margin-top: var(--h{{$i}}-margin-top);
  }
@endfor


