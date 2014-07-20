<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
	  google.setOnLoadCallback(drawChart2);
      function drawChart() {
		  
		  var dataTable = new google.visualization.DataTable();
		  
		  dataTable.addColumn('datetime', 'Date');
		  dataTable.addColumn('number', 'Number Of Votes');
		  
		  
		  dataTable.addRows([
			
	      <?php foreach($table_votes as $table_vote): ?>
		  
		  [new Date(<?php $calc_middleD = (strtotime($table_vote['start_date'])+strtotime($table_vote['end_date']))*1000/2; echo $calc_middleD; ?>), <?=$table_vote['num_votes']?> ],
		  
		  <?php endforeach; ?>			
			
		  ]);
	
		  var dataView = new google.visualization.DataView(dataTable);
		
	
		  var chart = new google.visualization.LineChart(document.getElementById('dateVSvotes'));
		  var options = {
			  'title':'Date / Number Of Votes',
			  titleTextStyle:{color: '#222222', fontSize:19, fontStyle:'normal'},
			  backgroundColor: 'none',
			  width: 800, height: 550,
			  vAxis:{title: 'Number Of Votes',titleTextStyle: {color: '#222222', fontSize:20, fontStyle:'normal'}, viewWindow: {min: 0},baselineColor:'#8c9cbf' },
			  hAxis:{title: 'Date & Time', titleTextStyle: {color: '#222222', fontSize:20}, baselineColor:'#8c9cbf'},
			  curveType:'function'
		  };
		  chart.draw(dataView, options);   
		  
	  }
	  
      function drawChart2() {
		  
		  var dataTable = new google.visualization.DataTable();
		  
		  dataTable.addColumn('datetime', 'Date');
		  dataTable.addColumn('number', 'Average Grade');
		  
		  
		  dataTable.addRows([
			
	      <?php foreach($table_votes as $table_vote): ?>
		  
		  [new Date(<?php $calc_middleD = (strtotime($table_vote['start_date'])+strtotime($table_vote['end_date']))*1000/2; echo $calc_middleD; ?>), <?=$table_vote['average_grade']?> ],
		  
		  <?php endforeach; ?>			
			
		  ]);
	
		  var dataView = new google.visualization.DataView(dataTable);
		
	
		  var chart = new google.visualization.LineChart(document.getElementById('dateVSvotes2'));
		  var options = {
			  'title':'Date / Average Grade',
			  titleTextStyle:{color: '#222222', fontSize:19, fontStyle:'normal'},
			  backgroundColor: 'none',
			  width: 800, height: 550,
			  vAxis:{title: 'Average Grade',titleTextStyle: {color: '#222222', fontSize:20, fontStyle:'normal'}, viewWindow: {min: 0},baselineColor:'#8c9cbf' },
			  hAxis:{title: 'Date & Time', titleTextStyle: {color: '#222222', fontSize:20}, baselineColor:'#8c9cbf'},
			  curveType:'function'
		  };
		  chart.draw(dataView, options);   
		  
	  }	  
	  
	  
/*	  function drawChart2() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Average Grade'],
          <?php foreach($table_votes as $table_vote): ?>
		  
		  ['<?=$table_vote['end_date']?>',  <?=$table_vote['average_grade']?>],
		  
		  <?php endforeach; ?>	
		  
        ]);

        var options = {
          title: ' Performance'
        };

        // Set chart options
        var options = {'title':'Date/Average Grade',
                       'width':700,
                       'height':500,
					   vAxis:{title: 'Average Grade',viewWindow: {min: 0}},
					   hAxis:{title: 'Date'}
					   
					   };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.LineChart(document.getElementById('dateVSvotes2'));
        chart.draw(data, options);
      }  
	  */
	  
    
</script> 

  
  <div id="main-content"> <!-- Main Content Section with everything --> 
    
    <!-- Page Head -->
    
    <h2><?=$event->title?></h2>
    <p id="page-intro">Average grade:</span> <?=$average_grade?><br/>
                        Number of votes:</span> <?=$num_votes?> votes
    </p>
    
    <div class="content-box"><!-- Start Content Box -->
      
      <div class="content-box-header">
        <h3>Content box</h3>
        <div class="clear"></div>
      </div>
      <!-- End .content-box-header -->
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
          
        <?php if(isset($successfully)):?>
	      <div class="notification success png_bg"> <a href="#" class="close"><img src="<?=base_url()?>assets/img/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div> Successfully deleted! </div>
          </div>
		<?php endif;?>
          
       <div class="excel">
         <a href="<?=base_url()?>admin/events/edit/poll/<?=$pollType?>/excel/<?=$event->id?>" class="button" >Export To Excel</a>
         <span class="chart">Date/Number Of Votes<img width="58px" height="86px" src="<?=base_url()?>assets/img/chart_logo.gif"/><span id="dateVSvotes" class="line_chart"></span></span>
         <span class="chart">Date/Average Grade<img width="58px" height="86px" src="<?=base_url()?>assets/img/chart_logo.gif"/><span id="dateVSvotes2" class="line_chart"></span></span>
       </div><br/><br/>
       
          <table>
            <thead>
              <tr>
                <th>Start Date</th>              
                <th>Number Of Votes</th>
                <th >Average Grade</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td colspan="8"><div class="bulk-actions align-left"></div>
                  <div class="pagination"></div>
                  <!-- End .pagination -->
                  
                  <div class="clear"></div></td>
              </tr>
            </tfoot>
            <tbody>

			<?php foreach($table_votes as $table_vote): ?>
                            <tr >
                                <td class="first"><?=$table_vote['start_date']?></td>
                                <td><?=$table_vote['num_votes']?></td>
                                <td class="tc last"><?=$table_vote['average_grade']?></td>
                            </tr>
            <?php endforeach; ?>	         
                
            </tbody>
          </table>
        </div>
        <!-- End #tab1 -->
        

        
      </div>
      <!-- End .content-box-content --> 
      
    </div>
    <!-- End .content-box -->
<script>
$(function(){
  $('.chart').click(function(e){
	  e.preventDefault();
	  $('.line_chart').hide();
      $(this).children('.line_chart').show(function(){});
     });
  $('.line_chart').on('click',function(e){
	  e.stopPropagation();
	  $(this).hide();
  });
  $(document).click(function(e) {
    if ( $(e.target).closest('.chart').length === 0 ) {
        $('.line_chart').hide();
    }
});
});
</script>