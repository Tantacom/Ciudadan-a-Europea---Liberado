<?php
?><!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7"<?php print $html_attributes; ?>><![endif]-->
<!--[if lte IE 6]><html class="lt-ie9 lt-ie8 lt-ie7"<?php print $html_attributes; ?>><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="lt-ie9 lt-ie8"<?php print $html_attributes; ?>><![endif]-->
<!--[if IE 8]><html class="lt-ie9"<?php print $html_attributes; ?>><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><!--><html<?php print $html_attributes . $rdf_namespaces; ?>><!--<![endif]-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="cleartype" content="on">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" href="sites/all/themes/slxthememobile/img/Icon.png" />
<link rel="apple-touch-icon" sizes="72x72" href="sites/all/themes/slxthememobile/img/Icon-72.png" />
<link rel="apple-touch-icon" sizes="114x114" href="sites/all/themes/slxthememobile/img/Icon@2x.png" />
<?php print $head; ?>
<title><?php print $head_title; ?></title>
<?php print $styles; ?>
<script type="text/javascript">
var addToHomeConfig = {
	animationIn: 'bubble',
	animationOut: 'drop',
	lifespan:10000,
	expire:2,
	touchIcon:true,
	message:'Pulsa aquí si deseas añadir esta aplicación a tu página de inicio'
};
</script>
<script type="application/javascript" src="sites/all/themes/slxthememobile/scripts/add2home.js"></script>
<?php print $scripts; ?>

</head>
<body class="<?php print $classes; ?>"<?php print $attributes; ?>>
<?php print $page; ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-38652448-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
