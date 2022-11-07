<?php include_once('base.php'); ?>

<div style="width: 100%;">
	<table class="table table-bordered table-striped" >

		<thead>
			<tr>
				<th>Data</th>
				<th>Quant.</th>
				<th>Desc.</th>
			</tr>
		</thead>

		<tbody>
			<?php

			foreach ($lista as $key => $value) {

				echo "
				<tr>
				<td>".$value['data']."</td> 
				<td>".$value['quant_final']."</td>
				<td>".$value['descricao']."</td>
				</tr>
				";

			}

			?>
		</tbody>

	</table>
</div>