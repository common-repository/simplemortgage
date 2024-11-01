<div class = "">

    <div class="mainstats_name">
        <div class="simplelender_flow_stats">
            <center>
                <div id="simplelender_application"><?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   echo mvc_model('simplelenderClientloan')->count(array('conditions'=>array('loan_stage'=>1))); ?> <br><br><span class="sl_stat_flow_description">Applications >></span></div>
                <div id="simplelender_processed"><?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   echo mvc_model('simplelenderClientloan')->count(array('conditions'=>array('loan_stage'=>array('2','4')))); ?> <br><br><span class="sl_stat_flow_description">Applications Being Processed >></span></div>
                <div id="simplelender_repayment"><?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   echo mvc_model('simplelenderClientloan')->count(array('conditions'=>array('loan_stage'=>3))); ?> <br><br><span class="sl_stat_flow_description">Repaying / Approved >></span></div>
                <div id="simplelender_close"><?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   echo mvc_model('simplelenderClientloan')->count(array('conditions'=>array('loan_stage'=>5))); ?> <br><br><span class="sl_stat_flow_description">Closed</span></div>
            </center>
        </div>       
    </div>
	
	<?php 
	if(count($objects) > 0){
	
	foreach($objects as $object){
		
		$status_var=[
			1=>"not viewed by the client yet",
			2=>"viewed by the client",
			3=>"Deleted"
		];
		
		echo '<div class="sl_activity_log">'.$object->message.' <br><span class="sl_note_description">Client <a href="'.mvc_admin_url(array('controller' => 'admin_simplelender_clientaccounts', 'action' => 'edit','id' => $object->user_id )).'">'.mvc_model('simplelenderClientaccount')->find_by_id($object->user_id)->firstname.' </a>, Created at '.$object->time_created.' ('.$status_var[$object->status].')</span></div>';
	}
	}
	else{
		echo '<div class="sl_activity_log">There is no activity yet.</div>';
	}
	?>
	<center><?php  echo paginate_links($pagination); ?></center>
    
</div>