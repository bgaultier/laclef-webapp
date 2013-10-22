<?php $title = _('Kfet - laclef.cc'); ?>

<?php ob_start() ?>
  <header class="vertical-space">
    <h1 class="pull-left medium-100 small-100"><i class="icon-coffee"></i> Kfet <small style="font-family: 'Kreon', serif;">laclef.cc</small></h1>
    <nav class="ink-navigation pull-right medium-100 small-100">
      <ul class="menu horizontal grey rounded shadowed">
        <li><a href="login"><?php echo _('Administration'); ?></a></li>
        <li><a href="kfet"><?php echo _('Aide'); ?></a></li>
      </ul>
    </nav>
  </header>
  <div class="column-group gutters">
    <div class="large-25 medium-25 small-100">
      <nav class="ink-navigation vertical-space">
        <ul class="menu vertical rounded black">
          <?php
            usort($users, cmp);
            foreach ($users as $user): ?>
            <li><a href="#"><?php echo number_format($user['balance'], 2, ',', ' ') . '&euro; ' . $user['firstname'] . ' ' . $user['lastname']; ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
    </div>
    <div class="large-75 medium-75 small-100 content vertical-space">
      <div class="column-group gutters">
        <div class="large-50 medium-50 small-100">
          <h2 class="push-left"><?php echo _('Nombre de cafés'); ?></h2>
          <figure id="coffeechart"class="vspace"></figure>
        </div>
        <div class="large-50 medium-50 small-100">
          <h2 class="push-left"><?php echo _('Statistiques'); ?></h2>
          <div id="today"></div>
          <script type="text/javascript">
             Ink.requireModules(['Ink.Net.Ajax_1'],function(Ajax){
               Ajax.load( 'http://api.laclef.cc/coffees', function( response ){
                 console.log( response );
               });
             });
          </script>
        </div>
      </div>
    </div>
  </div><!--/.column-group -->
	<style>
	  .axis path,
    .axis line {
      fill: none;
      stroke: #000;
      shape-rendering: crispEdges;
    }

    .bar {
      fill: steelblue;
    }

    .x.axis path {
      display: none;
    }
  </style>
  <script src="http://d3js.org/d3.v3.min.js"></script>
  <script>
    var margin = {top: 40, right: 20, bottom: 30, left: 40},
        width = 400 - margin.left - margin.right,
        height = 300 - margin.top - margin.bottom;

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

    var svg = d3.select("#coffeechart").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    d3.tsv("data.tsv", type, function(error, data) {
      x.domain(data.map(function(d) { return d.month; }));
      y.domain([0, d3.max(data, function(d) { return d.coffees; })]);

      svg.append("g")
          .attr("class", "x axis")
          .attr("transform", "translate(0," + height + ")")
          .call(xAxis);

      svg.append("g")
          .attr("class", "y axis")
          .call(yAxis)
        .append("text")
          .attr("transform", "rotate(-90)")
          .attr("y", 6)
          .attr("dy", ".71em")
          .style("text-anchor", "end")
          .text("<?php echo _('Cafés'); ?>");

      svg.selectAll(".bar")
          .data(data)
        .enter().append("rect")
          .attr("class", "bar")
          .attr("x", function(d) { return x(d.month); })
          .attr("width", x.rangeBand())
          .style("fill", function(d) { return d3.rgb(187, 187, 187); })
          .attr("y", function(d) { return y(d.coffees); })
          .attr("height", function(d) { return height - y(d.coffees); });

    });

    function type(d) {
      d.coffees = +d.coffees;
      return d;
    }
  </script>
<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>  
