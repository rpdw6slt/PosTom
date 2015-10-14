<h2>Event List</h2>
<ul id="eventlist">
<?php foreach($events as $event) : ?>
<li>
<a href="<?php echo '/postom/events/view/'.$event['Event']['id']; ?>">

<?php
// echo h($event['Event']['event_name']);
//echo $this->Html->link($event['Event']['event_name'], '/events/view/'.$event['Event']['id']);
?>
<span class="tit"><?php echo h($event['Event']['event_name']); ?></span>
<span>Location：<?php echo h($event['Event']['event_location']); ?></span>
<span>DateTime：<?php echo $event['Event']['event_begin_date']; ?> <?php echo $event['Event']['event_begin_time']; ?> - <?php echo $event['Event']['event_end_date']; ?> <?php echo $event['Event']['event_end_time']; ?></span>
</a>
</li>
<?php endforeach; ?>
</ul>

<?php echo $this->Html->link('Create Event', array('controller'=>'events', 'action'=>'add'), array('class'=>'btn btn-custom')); ?>