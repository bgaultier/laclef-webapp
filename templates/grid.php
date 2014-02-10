<?php $title = _('Kfet - laclef.cc'); ?>

<?php ob_start() ?>
	<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="templates/gridster/jquery.gridster.css">
	<link rel="stylesheet" type="text/css" href="templates/gridster/grid.css">
	<script src="templates/gridster/jquery.gridster.js"></script>
	<script src="templates/d3/d3.v3.min.js"></script>
	<script>
		$(function(){
			$(".gridster ul").gridster({
				widget_margins: [10, 10],
				widget_base_dimensions: [256, 256]
			});
			
			gridTimer = setInterval(updateWidgets, 10000);
			updateWidgets();
		});
		
		function updateWidgets() {
			var currentTime = new Date();
			var hours = currentTime.getHours();
			var minutes = currentTime.getMinutes();
			if (minutes < 10)
				minutes = "0" + minutes;
			$( "#time" ).html(hours + ":" + minutes);
			$.get( "grid.json", function(data) {
				$( "#coffees" ).html(data.coffees);
				$( "#money" ).html(Math.round(data.money) + '&euro;');
				$( "#bus" ).html(data.bus + "'");
				$( "#bikes" ).html(data.bikes);
				$( "#temperature" ).html(data.temperature + "&deg;C");
				$( "#people" ).html(data.people);
				$( "#message" ).html(data.message.message + " - " +data.message.firstname);
				$( "#published" ).html(data.message.published);
				$( "#icon" ).removeClass("icon-spin");
				$( "#icon" ).removeClass("icon-spinner");
				if(data.icon == 0) {
					$( "#icon" ).removeClass("icon-cloud");
					$( "#icon" ).addClass("icon-sun");
				}
				else {
					$( "#icon" ).removeClass("icon-sun");
					$( "#icon" ).addClass("icon-cloud");
				}
					
			});
		}
	</script>
	<script>
		$(function(){
		  var n = 243,
		  duration = 750,
		  now = new Date(Date.now() - duration),
		  //count = 0,
		  data = d3.range(n).map(function() { return 0; });

			var margin = {top: 6, right: 0, bottom: 20, left: 40},
					width = 390 - margin.right,
					height = 236 - margin.top - margin.bottom;

			var x = d3.time.scale()
					.domain([now - (n - 2) * duration, now - duration])
					.range([0, width]);

			var y = d3.scale.linear()
					.range([height, 0]);

			var line = d3.svg.line()
					.interpolate("basis")
					.x(function(d, i) { return x(now - (n - 1 - i) * duration); })
					.y(function(d, i) { return y(d); });

			var svg = d3.select("#powerWidget")
					.append("svg")
						.attr("width", width + margin.left + margin.right)
						.attr("height", height + margin.top + margin.bottom)
						.style("margin-left", -margin.left + "px")
					.append("g")
						.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

			var axis = svg.append("g")
					.attr("class", "x axis")
					.attr("transform", "translate(0," + height + ")")
					.call(x.axis = d3.svg.axis().scale(x).orient("bottom"));

			var path = svg.append("g")
					.attr("clip-path", "url(#clip)")
				.append("path")
					.data([data])
					.attr("class", "line");

			tick();

			function tick() {
				// update the domains
				now = new Date();
				x.domain([now - (n - 2) * duration, now - duration]);
				y.domain([0, d3.max(data)]);
				
				$.get( "energy.json?power=7&energy=8", function(feeds) {
					$( "#power" ).html(Math.round(feeds.power) + "W");
					data.push(Math.min(2000, feeds.power));
				});

				// redraw the line
				svg.select(".line")
						.attr("d", line)
						.attr("transform", null);

				// slide the x-axis left
				axis.transition()
						.duration(duration)
						.ease("linear")
						.call(x.axis);

				// slide the line left
				path.transition()
						.duration(duration)
						.ease("linear")
						.attr("transform", "translate(" + x(now - (n - 1) * duration) + ")")
						.each("end", tick);

				// pop the old data point off the front
				data.shift();
			 }
		});
		
		$(function(){
			var margin = {top: 40, right: 20, bottom: 30, left: 40},
		      width = 808 - margin.left - margin.right,
		      height = 236 - margin.top - margin.bottom;

		  var x = d3.scale.ordinal()
		      .rangeRoundBands([0, width], .1);

		  var y = d3.scale.linear()
		      .range([height, 0]);

		  var xAxis = d3.svg.axis()
		      .scale(x)
		      .orient("bottom")
		      .tickFormat(function(d) { return d + "/13"; });

		  var yAxis = d3.svg.axis()
		      .scale(y)
		      .orient("left")
		      .ticks(5);

		  var svg = d3.select("#coffeeChartWidget").append("svg")
		      .attr("width", width + margin.left + margin.right)
		      .attr("height", height + margin.top + margin.bottom)
		    .append("g")
		      .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

		  d3.tsv("coffees.tsv?months=8", type, function(error, data) {
		    x.domain(data.map(function(d) { return d.month; }));
		    y.domain([0, d3.max(data, function(d) { return d.coffees; })]);

		    svg.append("g")
		        .attr("class", "x axis")
		        .attr("transform", "translate(0," + height + ")")
		        .call(xAxis);

		    svg.append("g")
		        .attr("class", "y axis")
		        .call(yAxis);

		    svg.selectAll(".bar")
		        .data(data)
		      .enter().append("rect")
		        .attr("class", "bar")
		        .attr("x", function(d) { return x(d.month); })
		        .attr("width", x.rangeBand())
		        .attr("y", function(d) { return y(d.coffees); })
		        .attr("height", function(d) { return height - y(d.coffees); });
		  });

		  function type(d) {
		    d.coffees = +d.coffees;
		    return d;
		  }
		});
  </script>
	<div class="column-group gutters">
		<div class="large-100 medium-100 small-100">
			<div class="gridster">
				<ul>
					<li id ="timeWidget" data-row="1" data-col="1" data-sizex="1" data-sizey="1"><div class="widget"><i class="icon-time icon-background"></i><h1><?php echo (strftime("%A %d %B")); ?></h1><h2 id="time"><i class="icon-spin icon-spinner"></i></h2></div></li>
					<li id ="moneySpentWidget" data-row="2" data-col="1" data-sizex="1" data-sizey="1"><div class="widget"><i class="icon-money icon-background"></i><h1><?php echo _('Dépensés'); ?></h1><h2 id="money"><i class="icon-spin icon-spinner"></i></h2></div></li>
					<li id ="LabFabWidget" data-row="3" data-col="1" data-sizex="1" data-sizey="1"><div class="widget"><i class="icon-building icon-background"></i><h1><?php echo _('LabFab'); ?></h1><h2><?php echo _('Fermé'); ?></h2></div></li>
					<!-- <li id ="cameraWidget" data-row="4" data-col="1" data-sizex="1" data-sizey="1"><div class="widget" style="vertical-align: top;"><img class="icon-background" src="templates/images/starbucks.jpg" style="width: 256px; height: 256px; opacity: 0.7; z-index:-1;" height="100%"><h2><?php echo _('Fermé'); ?></h2></div></li>-->
					 
					<li id ="powerWidget" data-row="1" data-col="2" data-sizex="2" data-sizey="1"><div class="widget"><h1><?php echo _('Puissance'); ?></h1><h2 id="power"><i class="icon-spin icon-spinner"></i></h2></div><i class="icon-lightbulb icon-background"></i></li>
					<li id ="coffeeChartWidget" data-row="2" data-col="2" data-sizex="3" data-sizey="1"><i class="icon-coffee icon-background"></i></li>
					
					<li id ="coffeesWidget" data-row="3" data-col="3" data-sizex="1" data-sizey="1"><div class="widget"><i class="icon-coffee icon-background"></i><h1><?php echo _('Cafés'); ?></h1><h2 id="coffees"><i class="icon-spin icon-spinner"></i></h2></div></li>
					 
					<li id ="busWidget" data-row="1" data-col="4" data-sizex="1" data-sizey="1"><div class="widget"><img class="icon-background" src="templates/images/bus.svg" style="width: 190px; height: 190px; margin-top: 30px;" height="100%"></i><h1><?php echo _('Bus 4'); ?></h1><h2 id="bus"><i class="icon-spin icon-spinner"></i></h2></div></li>
					<li id ="weatherWidget" data-row="3" data-col="2" data-sizex="1" data-sizey="1"><div class="widget"><i id="icon" class="icon-spin icon-spinner icon-background"></i><h1><?php echo _('Météo'); ?></h1><h2 id="temperature"><i class="icon-spin icon-spinner"></i></h2></div></li>
					<li id ="messageWidget" data-row="3" data-col="3" data-sizex="2" data-sizey="1"><div class="widget"><i class="icon-comment icon-background"></i><h1 id="published"><i class="icon-spin icon-spinner"></i></h1><div id="message"><i class="icon-spin icon-spinner"></i></div></div></li>
					
					<li id ="peopleWidget" data-row="1" data-col="5" data-sizex="1" data-sizey="1"><div class="widget"><i class="icon-group icon-background"></i><h1><?php echo _('Personnes'); ?></h1><h2 id="people"><i class="icon-spin icon-spinner"></i></h2></div></li>
					<li id ="bikesWidget" data-row="2" data-col="5" data-sizex="1" data-sizey="1"><div class="widget"><img class="icon-background" src="templates/images/bike.svg" style="width: 190px; height: 170px; margin-top: 30px;"></i><h1><?php echo _('Vélos'); ?></h1><h2 id="bikes"><i class="icon-spin icon-spinner"></i></h2></div></li>
					
				</ul>
			</div>
		</div>
	</div>
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>  
