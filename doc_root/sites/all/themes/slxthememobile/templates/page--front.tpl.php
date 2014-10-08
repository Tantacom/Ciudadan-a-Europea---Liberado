<?php

?>
<div id="wrapperContent">
  <div class="centerContent">
    <div id="page" class="container <?php print $classes; ?>">
    
      <!-- region: Leaderboard -->
      <?php print render($page['leaderboard']); ?>
    
      <header<?php print $header_attributes; ?>>
        <div class="desktopLink">
            <a title="versión escritorio" href="/node?mobile_switch=standard">Ir a la Versión de escritorio</a>
        </div>
        <ul class="breadcrumb">
          <li><a title="Inicio" href="/">Inicio</a></li>
          <li><a title="Contacto" href="/contacto">Contacto</a></li>
	</ul>
        <h1 class="logo"><span>Ciudadanía<strong>Europea</strong></span></h1>
        <?php if ($primary_navigation): print $primary_navigation; endif; ?>
        <!-- region: Header -->
        <?php print render($page['header']); ?>
    
      </header>
    
      <!-- Navigation elements -->
      <?php print render($page['menu_bar']); ?>
      <?php //if ($secondary_navigation): print $secondary_navigation; endif; ?>
     
    
      <!-- Breadcrumbs -->
      <?php if ($breadcrumb): print $breadcrumb; endif; ?>
    
      <!-- Messages and Help -->
      <?php print $messages; ?>
      <?php print render($page['help']); ?>
    
      <!-- region: Secondary Content -->
      <?php print render($page['secondary_content']); ?>
    
      <div id="columns" class="columns clearfix">
        <div id="content-column" class="content-column" role="main">
          <div class="content-inner">
    
            <!-- region: Highlighted -->
            <?php print render($page['highlighted']); ?>
    
            <<?php print $tag; ?> id="main-content">
    
              <?php print render($title_prefix); // Does nothing by default in D7 core ?>
    
              <?php if ($title || $primary_local_tasks || $secondary_local_tasks || $action_links = render($action_links)): ?>
                <header<?php print $content_header_attributes; ?>>
    
                  <?php /*if ($title): ?>
                    <h1 id="page-title">
                      <?php print $title; ?>
                    </h1>
                  <?php endif;*/ ?>
    
                  <?php if ($primary_local_tasks || $secondary_local_tasks || $action_links): ?>
                    <div id="tasks">
    
                      <?php if ($primary_local_tasks): ?>
                        <ul class="tabs primary clearfix"><?php print render($primary_local_tasks); ?></ul>
                      <?php endif; ?>
    
                      <?php if ($secondary_local_tasks): ?>
                        <ul class="tabs secondary clearfix"><?php print render($secondary_local_tasks); ?></ul>
                      <?php endif; ?>
    
                      <?php if ($action_links = render($action_links)): ?>
                        <ul class="action-links clearfix"><?php print $action_links; ?></ul>
                      <?php endif; ?>
    
                    </div>
                  <?php endif; ?>
    
                </header>
              <?php endif; ?>

              <div id="content" class="region dest cl">
                <?php
                  $block = module_invoke('mapa', 'block_view', 'bigmap');
                  print render($block['content']);
                ?>
                <div class="sep"><hr></div>
                <section class="main">
                <?php
                  $bloque_banners = block_load('views', 'banners_portada-block');
                  $output_banners = drupal_render(_block_get_renderable_array(_block_render_blocks(array($bloque_banners))));
                  print $output_banners;
                ?>
                </section>
                <?php unset($page['content']['system_main']); ?>
            </div>
              
            </<?php print $tag; ?>><!-- /end #main-content -->
    
          </div><!-- /end .content-inner -->
        </div><!-- /end #content-column -->
    
        <!-- regions: Sidebar first and Sidebar second -->
        <?php //$sidebar_first = render($page['sidebar_first']); print $sidebar_first; ?>
        <?php //$sidebar_second = render($page['sidebar_second']); print $sidebar_second; ?>
    
      </div><!-- /end #columns -->
    
      <!-- region: Tertiary Content -->
      <?php //print render($page['tertiary_content']); ?>
    
    </div><!-- page -->
  </div>
</div>
<div id="wrapperFooter">
  <div class="centerContent">
    <footer>
      <?php print render($page['footer']); ?>
    </footer>
  </div>
</div>
