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

  --button-radius:{{get_theme_mod('button-radius', '4px')}}px;



  --primary-color: {{rgbaToOklch(get_theme_mod('primary-color', '#f0f'))}};
  --secondary-color: {{rgbaToOklch(get_theme_mod('secondary-color', '#f0f'))}};
  --accent-color: {{rgbaToOklch(get_theme_mod('accent-color', '#f0f'))}};
  --neutral-color: {{rgbaToOklch(get_theme_mod('neutral-color', '#f0f'))}};

  --info-color: {{rgbaToOklch(get_theme_mod('info-color', '#f0f'))}};
  --success-color: {{rgbaToOklch(get_theme_mod('success-color', '#f0f'))}};
  --error-color: {{rgbaToOklch(get_theme_mod('error-color', '#f0f'))}};



  /*H1===================================================================================*/
  @php
  $h1 = get_theme_mod('h1-typography');
  if(is_array($h1)) {
    if(isset($h1['font-family'])) {
      $h1FontFamily = $h1['font-family'];
    }
    if(isset($h1['font-size'])) {
      $h1FontSize = $h1['font-size'];
    }
    if(isset($h1['font-weight'])) {
      $h1FontWeight = $h1['font-weight'];
    }
    if(isset($h1['color'])) {
      $h1FontColor = $h1['color'];
    }
  }
  $h1MarginBottom = get_theme_mod('h1-margin-bottom', '1rem');
  @endphp

  --h1-font-family: {!!$h1FontFamily ?? 'verdana'!!};
  --h1-font-size: {!!$h1FontSize ?? '24px'!!};
  --h1-font-color: {!!$h1FontColor ?? '#000'!!};
  --h1-font-weight: {!!$h1FontWeight ?? '700'!!};
  --h1-margin-bottom: {!!$h1MarginBottom ?? '1rem'!!};
  /*H2===================================================================================*/
  @php
  $h2 = get_theme_mod('h2-typography');
  if(is_array($h2)) {
    if(isset($h2['font-family'])) {
      $h2FontFamily = $h2['font-family'];
    }
    if(isset($h2['font-size'])) {
      $h2FontSize = $h2['font-size'];
    }
    if(isset($h2['font-weight'])) {
      $h2FontWeight = $h2['font-weight'];
    }
    if(isset($h2['color'])) {
      $h2FontColor = $h2['color'];
    }
  }
  $h2MarginBottom = get_theme_mod('h2-margin-bottom', '1rem');
  @endphp

  --h2-font-family: {!!$h2FontFamily ?? 'verdana'!!};
  --h2-font-size: {!!$h2FontSize ?? '24px'!!};
  --h2-font-color: {!!$h2FontColor ?? '#000'!!};
  --h2-font-weight: {!!$h2FontWeight ?? '700'!!};
  --h2-margin-bottom: {!!$h1MarginBottom ?? '1rem'!!};
  /*H3===================================================================================*/
  @php
  $h3 = get_theme_mod('h3-typography');
  if(is_array($h3)) {
    if(isset($h3['font-family'])) {
      $h3FontFamily = $h3['font-family'];
    }
    if(isset($h3['font-size'])) {
      $h3FontSize = $h3['font-size'];
    }
    if(isset($h3['font-weight'])) {
      $h3FontWeight = $h3['font-weight'];
    }
    if(isset($h3['color'])) {
      $h3FontColor = $h3['color'];
    }
  }
  $h3MarginBottom = get_theme_mod('h3-margin-bottom', '1rem');
  @endphp

  --h3-font-family: {!!$h3FontFamily ?? 'verdana'!!};
  --h3-font-size: {!!$h3FontSize ?? '24px'!!};
  --h3-font-color: {!!$h3FontColor ?? '#000'!!};
  --h3-font-weight: {!!$h3FontWeight ?? '700'!!};
  --h3-margin-bottom: {!!$h1MarginBottom ?? '1rem'!!};
  /*H4===================================================================================*/
  @php
  $h4 = get_theme_mod('h4-typography');
  if(is_array($h4)) {
    if(isset($h4['font-family'])) {
      $h4FontFamily = $h4['font-family'];
    }
    if(isset($h4['font-size'])) {
      $h4FontSize = $h4['font-size'];
    }
    if(isset($h4['font-weight'])) {
      $h4FontWeight = $h4['font-weight'];
    }
    if(isset($h4['color'])) {
      $h4FontColor = $h4['color'];
    }
  }
  $h4MarginBottom = get_theme_mod('h4-margin-bottom', '1rem');
  @endphp

  --h4-font-family: {!!$h4FontFamily ?? 'verdana'!!};
  --h4-font-size: {!!$h4FontSize ?? '24px'!!};
  --h4-font-color: {!!$h4FontColor ?? '#000'!!};
  --h4-font-weight: {!!$h4FontWeight ?? '700'!!};
  --h4-margin-bottom: {!!$h1MarginBottom ?? '1rem'!!};
  /*===================================================================================*/

}


