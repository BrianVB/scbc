<div id="age-verification-modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">You must be 21 to experience this Space Craft</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-6" id="facebook-login">
						<p>Verify your age with Facbook</p>
						<div class="fb-login-button"></div>
					</div>
					<div class="col-sm-6">
						<p>Twll us your birthday</p>
						<form method="post" action="">
							<select name="dob[month]">
								<?php global $months; foreach($months as $num=>$name): ?>
								<option value="<?php echo sprintf("%02d", $num); ?>"><?php echo $name; ?></option>
								<?php endforeach; ?>
							</select>
							<select name="dob[day]">
								<?php for($d=01;$d<=31;$d++): ?>
								<option value="<?php echo sprintf("%02d", $d); ?>"><?php echo $d; ?></option>
								<?php endfor; ?>
							</select>
							<select name="dob[year]">
								<?php $year_range = range(date('Y'), date('Y')-100); ?>
								<?php foreach($year_range as $year): ?>
								<option><?php echo $year; ?></option>
								<?php endforeach; ?>
							</select>
							<input type="submit" value="Submit"/>
						</form>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#age-verification-modal').modal({backdrop: "static", keyboard: false});
});
</script>