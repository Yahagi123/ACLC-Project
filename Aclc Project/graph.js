<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Spending of Money Based on Household Composition"
	},
	theme: "light2",
	animationEnabled: true,
	toolTip:{
		shared: true,
		reversed: true
	},
	axisY: {
		suffix: "%"
	},
	data: [
		{
			type: "stackedColumn100",
			name: "Housing",
			showInLegend: true,
			yValueFormatString: "$#,##0 K",
			dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
		},{
			type: "stackedColumn100",
			name: "Transportation",
			showInLegend: true,
			yValueFormatString: "$#,##0 K",
			dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
		},{
			type: "stackedColumn100",
			name: "Food",
			showInLegend: true,
			yValueFormatString: "$#,##0 K",
			dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
		},{
			type: "stackedColumn100",
			name: "Insurance and Pastion",
			showInLegend: true,
			yValueFormatString: "$#,##0 K",
			dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
		},{
			type: "stackedColumn100",
			name: "Healthcare",
			showInLegend: true,
			yValueFormatString: "$#,##0 K",
			dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
		},{
			type: "stackedColumn100",
			name: "Entertainment",
			showInLegend: true,
			yValueFormatString: "$#,##0 K",
			dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
		},{
			type: "stackedColumn100",
			name: "Other",
			showInLegend: true,
			yValueFormatString: "$#,##0 K",
			dataPoints: <?php echo json_encode($dataPoints7, JSON_NUMERIC_CHECK); ?>
		}
	]
});
 
chart.render();
 
}
</script>