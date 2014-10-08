<?php
//Paginación
global $pager_limits;
global $pager_page_array;
global $pager_total_items;

$min = (($pager_page_array[0]  + 1) * $pager_limits[0]) - 1;
$max = ($pager_page_array[0]  + 1) * $pager_limits[0];
?>
<h2 class="news">Actualidad</h2>
<?php if ($pager): ?>
<div class="pagination cl">
        <span class="flt">Estas viendo del <?php print $min; ?> al <?php print $max; ?> de <?php print $pager_total_items[0]; ?> registros</span>
        <span class="frt"><?php print $pager; ?></span>

</div>
<?php endif; ?>

<?php print $rows; ?>

<?php if ($pager): ?>
<div class="pagination cl">
        <span class="flt">Estas viendo del <?php print $min; ?> al <?php print $max; ?> de <?php print $pager_total_items[0]; ?> registros</span>
        <span class="frt"><?php print $pager; ?></span>

</div>
<?php endif; ?>
<?php
//RSS
/*$viewname = 'noticias_rss';
$display_id = 'page'; 
$view_rss = views_get_view($viewname);
$view_rss->set_display($display_id);
$view_rss->execute();

$rows_rss = '';
$renderer = $view_rss->style_plugin->row_plugin;

foreach ($view_rss->result as $index=>$row) {
  $rows_rss .= '<article class="news summary cl"> '.$renderer->render($row).'</article>';
  $view_rss->row_index = $index;
}
?>
<h2 class="news">Otras noticias</h2>
<?php print $rows_rss; ?>
*/