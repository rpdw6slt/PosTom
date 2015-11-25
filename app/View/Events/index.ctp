
<h2>Event List</h2>
<ul id="eventlist">
<?php foreach($events as $event) : ?>
<li>
<a href="<?php echo $this->Html->url(array('controller' => 'Events', 'action' => 'view')).'/'.$event['Event']['unique_str']; ?>">

<span class="tit"><?php echo h($event['Event']['event_name']); ?></span>
<span>Location：<?php echo h($event['Event']['event_location']); ?></span>
<span>DateTime：<?php echo $event['Event']['event_begin_date']; ?> <?php echo $this->Time->format($event['Event']['event_begin_time'], '%H:%M'); ?> - <?php echo $event['Event']['event_end_date']; ?> <?php echo $this->Time->format($event['Event']['event_end_time'], '%H:%M');?></span>
</a>
</li>
<?php endforeach; ?>
</ul>

<?php echo $this->Html->link('Create Event', array('controller'=>'events', 'action'=>'add'), array('class'=>'btn btn-custom')); ?>
