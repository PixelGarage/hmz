<?php
  // prepare view elements
  drupal_add_library('system', 'ui.tabs');
  $slugs = array();
  $course = node_load($view->args[0]);
  $segment_id = $course->field_segment[LANGUAGE_NONE][0]['tid'];
  $nid = null;
  if (in_array($course->nid, array('7176','7177','7178','7179'))) {
    // Webform SVIT Lehrgänge: id = 7176 - 7179
    $nid = '7215';

  } else if (in_array($segment_id, array('91', '92'))) {
    // Webform Lerncoaching = 91, Sprachen = 92
    $nid = '6820';

  }
  if ($nid) {
    $form_anmeldung = drupal_render(node_view(node_load($nid)));
  }
?>
<ul>
	<?php foreach ($view->result as $id => $data): ?>
		<?php
			$node = node_load($data->nid);
			$title = empty($node->field_tab_title) ? $node->title : $node->field_tab_title[LANGUAGE_NONE][0]['safe_value'];
 			$slug = str_replace('.', '_', transliteration_clean_filename(trim($title)));
			$slugs[$id] = $slug;
		?>
		<li><a href="#<?php print $slug; ?>"><?php print $title; ?></a></li>
	<?php endforeach; ?>

  <?php if (in_array($segment_id, array('91', '92'))): ?>
	  <li><a href="#startdaten">Anmeldung</a></li>
  <?php else: ?>
    <li><a href="#startdaten">Startdaten</a></li>
  <?php endif; ?>
</ul>

<?php foreach ($rows as $id => $row): ?>
  <div <?php if ($classes_array[$id]) { print 'class="' . $classes_array[$id] .'"';  } ?> id="<?php print $slugs[$id] ?>">
    <?php print $row; ?>
  </div>
<?php endforeach; ?>

<?php if ($nid): ?>
  <div class="views-row views-row-startdaten" id="startdaten">
    <?php print $form_anmeldung; ?>
  </div>
<?php else: ?>
  <div class="views-row views-row-startdaten" id="startdaten">
    <?php print views_embed_view('course_times'); ?>
  </div>
<?php endif; ?>
