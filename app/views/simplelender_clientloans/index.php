<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */  
if($objects=="show_login"){
	$url=mvc_public_url(array('controller' => "simplelender_clientloans" , 'action' => 'index'));
	
	echo simplelender_class('simplelender_account')->user_gate($url);
}
elseif($objects=='sl_client_account_not_created'){
	?>
	<div class="client_dash">
	<h3><center>Your account not a loan client account, please contact us and we will resolve this.</center></h3>
	</div>
	<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */  
}
else{
	if ( !simplelender_fs()->is_plan('growth') ) {?>
	<div class="client_dash">
	
	<div id="simplelender_dash_content">
		<div></div>
		<center>
			<span class="fwidthtd" style=""><br><br><b>This is your personal dashboard, followup on all your applications here</b></span>			
		</center>
	</div>

	</div>
</div>
	
<?php
	}
	else{
?>

<div class="client_dash">
	
	<div id="simplelender_dash_content">
			<?php do_action('simplelender_borrower_top_menu'); ?>
			<br><br>
			<div></div>
		<center>
			<span class="fwidthtd"><b></b></span>			
		</center>
		
		<table id="simplelender_loan_dash">
			
			<tr>
				<td class="simplelender_sub_title" ><center><b>Loan Application ID</b></center></td>
				<td class="simplelender_sub_title"><center><b>Loan Name</b></center></td>
				<td class="simplelender_sub_title"><center><b>Stage</b></center></td>
				<td class="simplelender_sub_title"></td>
			</tr>
			<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   foreach ($objects as $object): ?>

			<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   $this->render_view('_item_show', array('locals' => array('object' => $object))); ?>

			<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   endforeach; ?>
			
		</table>
		

	</div>

	</div>
</div>

	<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   }
	}
do_action("simplelender_build_by");
 ?>

 
