<?php
// header('Content-Type: text/html');
header('Content-Type: text/css');


$themeTypography = get_theme_mod('theme-typography');

if(is_array($themeTypography)) {
  if(isset($themeTypography['font-family'])) {
    $mainFontFamily = $themeTypography['font-family'];
  }
  if(isset($mainFont['font-size'])) {
    $mainFontSize = $themeTypography['font-size'];
  }
  if(isset($themeTypography['color'])) {
    $mainFontColor = $themeTypography['color'];
  }
  if(isset($themeTypography['font-weight'])) {
    $mainFontWeight = $themeTypography['font-weight'];
  }
}

// ===========================================================


$linksTypography = get_theme_mod('theme-links-typography');
if(is_array($linksTypography)) {
  if(isset($linksTypography['font-family'])) {
    $linksFontFamily = $linksTypography['font-family'];
  }
  if(isset($linksTypography['font-size'])) {
    $linksFontSize = $linksTypography['font-size'];
  }
  if(isset($linksTypography['color'])) {
    $linksFontColor = $linksTypography['color'];
  }
  if(isset($linksTypography['font-weight'])) {
    $linksFontWeight = $linksTypography['font-weight'];
  }
}

// ===========================================================

$formComponentsTypography = get_theme_mod('form-components-typography');
if(is_array($formComponentsTypography)) {
  if(isset($formComponentsTypography['font-family'])) {
    $formComponentsFontFamily = $formComponentsTypography['font-family'];
  }
  if(isset($formComponentsTypography['font-size'])) {
    $formComponentsFontSize = $formComponentsTypography['font-size'];
  }
  if(isset($formComponentsTypography['color'])) {
    $formComponentsFontColor = $formComponentsTypography['color'];
  }
  if(isset($formComponentsTypography['font-weight'])) {
    $formComponentsFontWeight = $formComponentsTypography['font-weight'];
  }
}

// ===========================================================

$formComponentsLabelTypography = get_theme_mod('form-components-label-typography');
if(is_array($formComponentsLabelTypography)) {
  if(isset($formComponentsLabelTypography['font-family'])) {
    $formComponentsLabelFontFamily = $formComponentsLabelTypography['font-family'];
  }
  if(isset($formComponentsLabelTypography['font-size'])) {
    $formComponentsLabelFontSize = $formComponentsLabelTypography['font-size'];
  }
  if(isset($formComponentsLabelTypography['color'])) {
    $formComponentsLabelFontColor = $formComponentsLabelTypography['color'];
  }
  if(isset($formComponentsLabelTypography['font-weight'])) {
    $formComponentsLabelFontWeight = $formComponentsLabelTypography['font-weight'];
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

  --background-repeat: {!!get_theme_mod('background-repeat') ? 'repeat' : 'no-repeat'!!};
  --background-size: {!!get_theme_mod('background-repeat') ? 'auto' : 'cover'!!};


  --main-container-background-color: {!!get_theme_mod('main-container-background-color', 'transparent')!!};


  --theme-typography-font-color: {!!$mainFontColor ?? '#000000' !!};
  --theme-typography-font-family: {!!$mainFontFamily ?? 'verdana'!!};
  --theme-typography-font-size: {!!$mainFontSize ?? '14px'!!};
  --theme-typography-font-color: {!!$mainFontColor ?? '#000'!!};
  --theme-typography-font-weight: {!!get_theme_mod('main-font-weight', '400')!!};

  --links-typography-font-family: {!!$linksFontFamily ?? 'var(--theme-typography-font-family)'!!};
  --links-typography-font-size: {!!$linksFontSize ?? 'var(--theme-typography-font-size)'!!};
  --links-typography-font-color: {!!$linksFontColor ?? 'var(--theme-typography-font-color)'!!};
  --links-typography-font-weight: {!!$linksFontWeight ?? 'var(--theme-typography-font-weight)'!!};
}


.taverne {

  --button-radius:{{get_theme_mod('button-radius', '4')}}px;

  --card-border-radius:{{get_theme_mod('card-border-radius', '4')}}px;
  --card-border-width:{{get_theme_mod('card-border-width', '1')}}px;
  --card-border-color:{{get_theme_mod('card-border-color', 'var(--theme-typography-font-color)')}};
  --card-title-font-size: {{get_theme_mod('card-title-font-size', 'var(--theme-typography-font-size)')}};
  --card-background-color:{{get_theme_mod('card-background-color', 'transparent')}};
  --card-text-color:{{get_theme_mod('card-text-color', 'var(--theme-typography-font-color)')}};

  --form-components-background-color:{{get_theme_mod('form-components-background-color', 'transparent')}};
  --form-components-border-color:{{get_theme_mod('form-components-border-color', 'var(--theme-typography-font-color)')}};
  --form-components-text-color:{{get_theme_mod('form-components-border-color', 'var(--theme-typography-font-color)')}};
  --form-components-border-width:{{get_theme_mod('form-components-border-width', '1')}};

  --form-components-font-family: {!!$formComponentsFontFamily ?? 'var(--main-font-family)'!!};
  --form-components-font-size: {!!$formComponentsFontSize ?? '14px'!!};
  --form-components-font-color: {!!$formComponentsFontColor ?? 'var(--theme-typography-font-color)'!!};
  --form-components-font-weight: {!!$formComponentsFontWeight ?? '400'!!};

  --form-components-label-font-family: {!!$formComponentsLabelFontFamily ?? 'var(--theme-typography-font-family)'!!};
  --form-components-label-font-size: {!!$formComponentsLabelFontSize ?? '14px'!!};
  --form-components-label-font-color: {!!$formComponentsLabelFontColor ?? 'var(--theme-typography-font-color)'!!};
  --form-components-label-font-weight: {!!$formComponentsLabelFontWeight ?? '400'!!};

  --form-components-border-color: {{ get_theme_mod('form-components-border-color', 'var(--theme-typography-font-color)')}};
  --form-components-border-width: {{ get_theme_mod('fform-components-border-width', 1)}}px;


  {{-- RIGHT MENU ============================================== --}}
  --right-menu-background-color: {{get_theme_mod('right-menu-background-color', 'transparent')}};
  --right-menu-border-radius: {{get_theme_mod('right-menu-border-radius', '0')}}px;
  --right-menu-border-width: {{get_theme_mod('right-menu-border-width', '0')}}px;
  --right-menu-border-color: {{get_theme_mod('right-menu-border-color')}};
  --right-menu-padding: {{get_theme_mod('right-menu-padding')}}px;

  --right-menu-block-background-color: {{get_theme_mod('right-menu-block-background-color', 'transparent')}};
  --right-menu-block-border-radius: {{get_theme_mod('right-menu-block-border-radius', '0')}}px;
  --right-menu-block-border-width: {{get_theme_mod('right-menu-block-border-width', '0')}}px;
  --right-menu-block-border-color: {{get_theme_mod('right-menu-block-border-color')}};
  --right-menu-block-padding: {{get_theme_mod('right-menu-block-padding')}}px;

  {{-- ============================================== --}}

  --base-100-color: {{rgbaToOklch(get_theme_mod('base-100-color', '#000'))}};

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
    if(isset($siteTitle['text-align'])) {
      $siteTitleTextAlign = $siteTitle['text-align'];
    }
  }
  $siteTitleMarginBottom = get_theme_mod('site-title-margin-bottom');
  $siteTitleMarginTop = get_theme_mod('site-title-margin-top');
  @endphp

  --site-title-font-family: {!!$siteTitleFontFamily ?? 'var(--theme-typography-font-family)'!!};
  --site-title-font-size: {!!$siteTitleFontSize ?? 'var(--theme-typography-font-size)'!!};
  --site-title-font-color: {!!$siteTitleFontColor ?? 'var(--theme-typography-font-color)'!!};

  --site-title-font-weight: {!!$siteTitleFontWeight ?? '700'!!};
  --site-title-text-align: {!!$siteTitleTextAlign ?? 'left'!!};

  --site-title-margin-bottom: {!!$siteTitleMarginBottom ?? '16'!!}px;
  --site-title-margin-top: {!!$siteTitleMarginTop ?? '16'!!}px;


  /*site main title===================================================================================*/
  @php
  $siteTitle = get_theme_mod('site-main-title-typography');
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
    if(isset($siteTitle['text-align'])) {
      $siteTitleTextAlign = $siteTitle['text-align'];
    }
  }
  $siteTitleMarginBottom = get_theme_mod('site-main-title-margin-bottom');
  $siteTitleMarginTop = get_theme_mod('site-main-title-margin-top');
  @endphp



  --site-main-title-typography-font-family: {!!$siteTitleFontFamily ?? 'var(--theme-typography-font-family)'!!};
  --site-main-title-typography-font-size: {!!$siteTitleFontSize ?? 'var(--theme-typography-font-size)'!!};
  --site-main-title-typography-font-color: {!!$siteTitleFontColor ?? 'var(--theme-typography-font-color)'!!};
  --site-main-title-typography-font-weight: {!!$siteTitleFontWeight ?? '700'!!};
  --site-main-title-typography-text-align: {!!$siteTitleTextAlign ?? 'left'!!};
  --site-main-title-margin-bottom: {!!$siteTitleMarginBottom ?? '16'!!}px;
  --site-main-title-margin-top: {!!$siteTitleMarginTop ?? '16'!!}px;


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
      $titleMarginBottom = get_theme_mod($titleLevel.'-margin-bottom', '16');
      $titleMarginTop = get_theme_mod($titleLevel.'-margin-top', '16');
    }
    @endphp
      --{{$titleLevel}}-font-family: {!!$titleFontFamily ?? 'var(--site-title-font-family)'!!};
      --{{$titleLevel}}-font-size: {!!$titleFontSize ?? 'var(site-title-font-size)'!!};
      --{{$titleLevel}}-text-align: {!!$titleTextAlign ?? 'left'!!};
      --{{$titleLevel}}-font-color: {!!$titleFontColor ?? 'var(--site-title-font-color)'!!};
      --{{$titleLevel}}-font-weight: {!!$titleFontWeight ?? 'var(--site-title-font-weight)'!!};
      --{{$titleLevel}}-margin-bottom: {!!$titleMarginBottom ?? 'var(--site-title-margin-bottom)'!!};
      --{{$titleLevel}}-margin-top: {!!$titleMarginTop ?? 'var(--site-title-margin-top)'!!};
      @php
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


