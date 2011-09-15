<div class="box create rounded">

	<a class="button good" href="<?php echo site_url(SITE_AREA . settings .'/'. analytics .'/create'); ?>">
		<?php echo lang('analytics_create_new_button'); ?>
	</a>

	<h3><?php echo lang('analytics_create_new'); ?></h3>

	<p><?php echo lang('analytics_edit_text'); ?></p>

</div>

<br />

<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
	<h2>Analytics</h2>
	<table>
		<thead>
		
			
		
			<th><?php echo lang('analytics_actions'); ?></th>
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('analytics_true') : lang('analytics_false')) : $value; ?></td>
				<?php endif; ?>
				
			<?php endforeach; ?>

				<td>
					<?php echo anchor(SITE_AREA .'/settings/analytics/edit/'. $record[$primary_key_field], lang('analytics_edit'), '') ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>