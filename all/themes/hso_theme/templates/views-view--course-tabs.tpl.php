<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
if (empty($rows)) {
  //
  // views-view-unformatted--course-tabs.tpl.php not performed due to no available rows
  // add 'startdaten' tab here
  drupal_add_library('system', 'ui.tabs');
  $course = node_load($view->args[0]);
  $segment_id = $course->field_segment[LANGUAGE_NONE][0]['tid'];
  $nid = -1; // no form displayed

  // special form needs
  if (in_array($course->nid, array('7176','7177','7178'))) {
    // Webform SVIT Lehrgänge: id = 7176 - 7179
    // Lehrgang 7179 has no form
    $nid = '7215';

  } else if (in_array($segment_id, array('91', '92'))) {
    // Webform Lerncoaching = 91, Sprachen = 92
    $nid = '6820';

  }
  if ($nid > 0) {
    $form_anmeldung = drupal_render(node_view(node_load($nid)));
  } else if ($nid == -1) {
    // don't display course tabs at all
    return;
  }
}
?>
<div class="<?php print $classes; ?>">

	<div class="view-content">
		<?php if ($rows): ?>

			<?php print $rows; ?>

		<?php else: ?>

			<ul>
        <?php if ($nid > 0): ?>
          <li><a href="#startdaten">Anmeldung</a></li>
        <?php else: ?>
          <li><a href="#startdaten">Startdaten</a></li>
        <?php endif; ?>
			</ul>

      <?php if ($nid > 0): ?>
        <div class="views-row views-row-startdaten" id="startdaten">
          <?php print $form_anmeldung; ?>
        </div>
      <?php else: ?>
        <div class="views-row views-row-startdaten" id="startdaten">
          <?php print views_embed_view('course_times'); ?>
        </div>
      <?php endif; ?>

		<?php endif; ?>
	</div>

</div>
