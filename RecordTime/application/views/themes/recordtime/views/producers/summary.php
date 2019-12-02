<?php
$expense_name = explode( ",", $production_rates[ 0 ][ 'expensename' ] );
$expense_value = explode( ",", $production_rates[ 0 ][ 'expensevalue' ] );
$combine = array_combine( $expense_name, $expense_value );
?>


<div class="middle-container">
	<div class="banner-image">
		<div class="banner-content">
			<img src="<?= site_url().template_assets_path(); ?>/images/Big Logo-White.png">
		</div>
	</div>
	<div class="page-title box-shadow">
		<div class="container-fluid">
			<div id="title-1">
				<h1>Production Rates Summary</h1>
			</div>
		</div>
	</div>
	<br>
	<div class="page-title box-shadow">
		<div class="container-fluid">
			<div>
				<h3>Your base rate per Song will be visible to artists and will indicate your rates per song without additional studio professionals.</h3>
			</div>
		</div>
	</div>
</div>

<div class="FormErrors">
	<?php echo validation_errors(); ?>
</div>

<div id="project-overview">
	<div class="container new-project-container-padding" id="step-2">
		<div class="row project-inner-section">
			<div class="col-md-3">
				<div class="arrow left-arrow box-shadow">
					<a href="<?php echo site_url('producers/editproductionrates')?>"><i class="fa fa-arrow-left " aria-hidden="true"></i><b style="color: #fff; font-size: 25px; padding: 18px; border: none;">Return to calculator</b></a>
				</div>
			</div>
			<div class="col-md-6">
				<div class="base-rate-container profile-card box-shadow">
					<div class="rate-table-container">
						<table>
							<tr>
								<td>
									<h4>Base Production Rate</h4>
								</td>
								<td>
									<h4>$<?php echo $production_rates[0]['base_rate']; ?></h4>
								</td>
							</tr>
							<tr>
								<td>
									<h4>Base Production Expenses</h4>
								</td>
								<td>
									<h4>$<?php echo $production_rates[0]['project_expenses']; ?></h4>
								</td>
							</tr>
							<tr>
								<table class="small-text-table">
									<?php foreach ($combine as $key=>$value) { ?>
									<tr>
										<td>
											<h5>
												<?php echo $key; ?>
											</h5>
										</td>
										<td>
											<h5>$<?php echo $value; ?></h5>
										</td>
									</tr>
									<?php } ?>
								</table>
							</tr>
							<tr>
								<td colspan="2">
									<div class="table-double-line"></div>
								</td>
							</tr>
						</table>

						<?php $base_rate = $production_rates[0]['base_rate'] + $production_rates[0]['project_expenses']; ?>

						<table class="base-rate-total-table">
							<tr>
								<td>
									<h4><b>Base Rate Per Song</b></h4>
								</td>
								<td>
									<p><span>$<?php echo $base_rate; ?></span>
									</p>
								</td>
							</tr>
							<tr>
								<td>
									<h4><b>Recordtime service fee</b></h4>
								</td>
								<td>
									<p><span>($70)</span>
									</p>
								</td>
							</tr>
						</table>

						<div class="table-single-line"></div>

						<table class="base-rate-total-table">
							<tr>
								<td>
									<h4><b>Your base budget</b></h4>
								</td>
								<td>
									<p><span>$<?php echo $base_rate+ 70; ?></span>
									</p>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="project-details-container">
					<div class="arrow right-arrow box-shadow">
						<a href="<?php echo site_url('producers/profile')?>"><b style="color: #fff; font-size: 25px; padding: 18px; border: none;">Finish</b><i class="fa fa-arrow-right" aria-hidden="true" style="float: right; margin-top: 10px;"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>