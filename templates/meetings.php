<?php $title = _('Réservation salle - laclef.cc'); ?>

<?php ob_start() ?>
<link href='templates/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='templates/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='templates/fullcalendar/lib/moment.min.js'></script>
<script src='templates/fullcalendar/lib/jquery.min.js'></script>
<script src='templates/fullcalendar/fullcalendar.min.js'></script>
<script src='templates/fullcalendar/lang/fr.js'></script>
<script>

$(document).ready(function() {

	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		lang: 'fr',
		editable: false,
		weekNumbers: true,
		defaultView: 'agendaWeek',
		eventLimit: true, // allow "more" link when too many events
		events: {
			url: 'http://mda.laclef.cc/meetings.json',
			error: function() {
				$('#script-warning').show();
			}
		}
	});

});

</script>
<style>
#script-warning {
	display: none;
}

#calendar {
	max-width: 900px;
	margin: 40px auto;
	padding: 0 10px;
}

</style>
<section>
	<div class="box">
		<div id='script-warning' class="ink-alert basic error">
			<button class="ink-dismiss">×</button>
			<p><?php echo _("Vous devez être connecté à Internet pour visualiser les réunions."); ?></p>
		</div>
		<?php if($message_active) echo '<div class="ink-alert basic success"><button class="ink-dismiss">×</button><p><b>' . _('OK') . ' </b> ' . _('La réservation de la salle de réunion a été acceptée !') . '</p></div>'; ?>
		<div id='calendar'></div>
	</div>
</section>
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>
