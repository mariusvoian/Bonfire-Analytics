	<!-- Analytics Editor -->
	<div id="content" style="padding:20px">
        <div class="selects">
            <?php echo form_dropdown('dashboard_profile_id',  array('' => 'loading'), '',' id="dashboard_profile_id"'); ?>
            <select name="months" id="months">
      	  <?php
	        foreach(range(1, 12) as $month){
	            echo '<option ' . ($month == date('n') ? 'selected="selected" ' : '') . 'value="' . $month . '">' . date('F', mktime(0, 0, 0, $month, 1, date('Y'))) . '</option>'; 
	        }
	        ?>
	        
		</select>
		
		<select name="year" id="year">
      	  <?php
	        foreach(range(date('Y')-2, date('Y')) as $year){
	            echo '<option ' . ($year == date('Y') ? 'selected="selected" ' : '') . 'value="' . $year . '">' . $year . '</option>'; 
	        }
	        ?>
	        
		</select>
        </div>
		<div id="linechart" ></div>
        <div id="dashboard"></div>	
	</div>	<!-- /content -->
<script type="text/javascript">
 head.ready(function(){   
    var so = new SWFObject("<?php echo base_url()?>bonfire/modules/analytics/assets/js/amcharts/amline.swf", "amline", "100%", "250", "8", "#FFFFFF");
    so.addVariable("data_file", encodeURIComponent("<?php echo base_url()?>bonfire/modules/analytics/assets/js/amcharts/amline_data.xml"));
    so.addVariable("chart_id", "amline");
    so.addParam("wmode", "opaque");
    so.addVariable('wmode', 'opaque');
    so.addVariable("settings_file", encodeURIComponent("<?php  echo base_url()?>bonfire/modules/analytics/assets/js/amcharts/amline_settings.xml"));
    so.addVariable("path", '<?php echo base_url()?>');
    so.write('linechart');
    });
    
    function amChartInited(chart_id)
    {
        dready();
    }
    function amError(chart_id,message)
    {
        alert(message);
    }
    
    function dready()
    {
           $.ajax({
                url: '<?php echo site_url('admin/reports/analytics/analytics_profiles')?>',
                cache: true,
                type:'POST',
                success: function(data) {
                    var profiles=data.split('|');
                    var i=0;
                    $.each(profiles,function(index,profile)
                        {
                            i++;
                            var row = profile.split(',');
    			    		var opt = document.createElement("option");
                            opt.text = row[1];
					        opt.value = row[0];
                            if (i==1)
                            {
                                opt.selected = true;
                            }else
                            {
                                opt.selected = false;
                            }
                            console.log(opt);
					        $("#dashboard_profile_id").append(opt);
                        }
                    )
                load_analytics($('#months').val(), $('#year').val(), $('#dashboard_profile_id').val());
                }
            });
            function load_analytics(month, year, profile)
			{
			     $.ajax({
			         url : '<?php echo site_url('admin/reports/analytics/xml_data')?>',
			         cache : true,
                     type : 'POST',
                     data: 'month=' + month + "&year="+year+"&profile=" + profile,
                     success: function(data){
                        
                        if(data)
    						{
    							//$('#linechart').set('style','display:block');
    							document.getElementById('amline').setData(data);
    						}
  						else
    						{
    							document.getElementById('amline').className = 'hiddenswf';
    						}
                        }
                        
			     })
                 $.ajax({
                     url : '<?php echo site_url('admin/reports/analytics/statistics')?>',
			         cache : true,
                     type : 'POST',
                     data: 'month=' + month + "&year="+year+"&profile=" + profile,
                     success: function(data){
                        
                        if(data)
    						{
    							//$('#linechart').set('style','display:block');
    							$('#dashboard').html(data);
    						}
  						else
    						{
    							document.getElementById('amline').className = 'hiddenswf';
    						}
                        }
                 })
		    }
    $('#months').change(function(){
        load_analytics($('#months').val(), $('#year').val(), $('#dashboard_profile_id').val());
    });
    $('#year').change(function(){
        load_analytics($('#months').val(), $('#year').val(), $('#dashboard_profile_id').val());
    });
    $('#dashboard_profile_id').change(function(){
        load_analytics($('#months').val(), $('#year').val(), $('#dashboard_profile_id').val());
    });
    }
    
</script>