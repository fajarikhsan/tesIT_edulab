$(document).ready(function () {
	var url = window.base_url;
	$("#students").DataTable({
		searchPanes: {
			viewTotal: true,
			columns: [10, 11],
		},
		dom: "Plfrtip",
		columnDefs: [
			{
				searchPanes: {
					options: [
						{
							label: "< 50%",
							value: function (rowData, rowIdx) {
								var percentage = Number(rowData[11].replace(/[^0-9\.]+/g, ""));
								return parseInt(percentage) < 50;
							},
						},
						{
							label: "> 50%",
							value: function (rowData, rowIdx) {
								var percentage = Number(rowData[11].replace(/[^0-9\.]+/g, ""));
								return parseInt(percentage) >= 50;
							},
						},
					],
				},
				targets: [11],
			},
			{
				targets: [2, 3, 4, 5, 6, 7, 8, 9],
				render: $.fn.dataTable.render.number(",", ".", 0, ""),
			},
		],
		order: [[0, "asc"]],
	});

	// Jumlah USER per Cabang Belajar
	$.ajax({
		url: url + "statistics/userCountByBranch",
		method: "post",
		dataType: "json",
		success: function (data) {
			var options = {
				animationEnabled: true,
				title: {
					text: "JUMLAH USER SETIAP CABANG",
				},
				axisY: {
					title: "BANYAK USER",
				},
				axisX: {
					title: "Cabang Belajar",
				},
				data: [
					{
						type: "column",
						yValueFormatString: "####",
						dataPoints: data,
					},
				],
			};
			$("#userCount").CanvasJSChart(options);
		},
	});

	// Jumlah user yang sudah lunas per cabang
	$.ajax({
		url: url + "statistics/paidUserByBranch",
		method: "post",
		dataType: "json",
		success: function (data) {
			var options = {
				animationEnabled: true,
				title: {
					text: "JUMLAH USER SUDAH LUNAS SETIAP CABANG",
				},
				axisY: {
					title: "BANYAK USER",
				},
				axisX: {
					title: "Cabang Belajar",
				},
				data: [
					{
						type: "column",
						yValueFormatString: "####",
						dataPoints: data,
					},
				],
			};
			$("#paidUser").CanvasJSChart(options);
		},
	});

	// Jumlah user yang belum lunas per cabang
	$.ajax({
		url: url + "statistics/unpaidUserByBranch",
		method: "post",
		dataType: "json",
		success: function (data) {
			var options = {
				animationEnabled: true,
				title: {
					text: "JUMLAH USER BELUM LUNAS SETIAP CABANG",
				},
				axisY: {
					title: "BANYAK USER",
				},
				axisX: {
					title: "Cabang Belajar",
				},
				data: [
					{
						type: "column",
						yValueFormatString: "####",
						dataPoints: data,
					},
				],
			};
			$("#unpaidUser").CanvasJSChart(options);
		},
	});

	// Total Biaya yang harus dibayar setelah Potongan per Cabang
	$.ajax({
		url: url + "statistics/totalAfterDiscount",
		method: "post",
		dataType: "json",
		success: function (data) {
			var options = {
				animationEnabled: true,
				title: {
					text: "TOTAL BIAYA - POTONGAN SETIAP CABANG",
					fontColor: "Peru",
				},
				axisY: {
					tickThickness: 0,
					lineThickness: 0,
					valueFormatString: " ",
					includeZero: true,
					gridThickness: 0,
				},
				axisX: {
					tickThickness: 0,
					lineThickness: 0,
					labelFontSize: 18,
					labelFontColor: "Peru",
				},
				data: [
					{
						indexLabelFontSize: 26,
						toolTipContent:
							'<span style="color:#62C9C3">{indexLabel}:</span> <span style="color:#CD853F"><strong>{y}</strong></span>',
						indexLabelPlacement: "inside",
						indexLabelFontColor: "white",
						indexLabelFontWeight: 600,
						indexLabelFontFamily: "Verdana",
						color: "#62C9C3",
						type: "bar",
						dataPoints: data,
					},
				],
			};
			$("#totalWithDiscount").CanvasJSChart(options);
		},
	});

	// Total Biaya yang sudah dibayar per cabang
	$.ajax({
		url: url + "statistics/totalPaid",
		method: "post",
		dataType: "json",
		success: function (data) {
			var options = {
				animationEnabled: true,
				title: {
					text: "TOTAL BIAYA YANG SUDAH DIBAYAR SETIAP CABANG",
					fontColor: "Peru",
				},
				axisY: {
					tickThickness: 0,
					lineThickness: 0,
					valueFormatString: " ",
					includeZero: true,
					gridThickness: 0,
				},
				axisX: {
					tickThickness: 0,
					lineThickness: 0,
					labelFontSize: 18,
					labelFontColor: "Peru",
				},
				data: [
					{
						indexLabelFontSize: 26,
						toolTipContent:
							'<span style="color:#62C9C3">{indexLabel}:</span> <span style="color:#CD853F"><strong>{y}</strong></span>',
						indexLabelPlacement: "inside",
						indexLabelFontColor: "white",
						indexLabelFontWeight: 600,
						indexLabelFontFamily: "Verdana",
						color: "#4f81bc",
						type: "bar",
						dataPoints: data,
					},
				],
			};
			$("#totalPaid").CanvasJSChart(options);
		},
	});

	// Total Biaya yang belum dibayar per cabang
	$.ajax({
		url: url + "statistics/totalUnpaid",
		method: "post",
		dataType: "json",
		success: function (data) {
			var options = {
				animationEnabled: true,
				title: {
					text: "TOTAL BIAYA YANG BELUM DIBAYAR SETIAP CABANG",
					fontColor: "Peru",
				},
				axisY: {
					tickThickness: 0,
					lineThickness: 0,
					valueFormatString: " ",
					includeZero: true,
					gridThickness: 0,
				},
				axisX: {
					tickThickness: 0,
					lineThickness: 0,
					labelFontSize: 18,
					labelFontColor: "Peru",
				},
				data: [
					{
						indexLabelFontSize: 26,
						toolTipContent:
							'<span style="color:#62C9C3">{indexLabel}:</span> <span style="color:#CD853F"><strong>{y}</strong></span>',
						indexLabelPlacement: "inside",
						indexLabelFontColor: "white",
						indexLabelFontWeight: 600,
						indexLabelFontFamily: "Verdana",
						color: "#9bbb58",
						type: "bar",
						dataPoints: data,
					},
				],
			};
			$("#totalUnpaid").CanvasJSChart(options);
		},
	});

	// Total User sudah bayar 50% dan yang belum bayar 50%
	$.ajax({
		url: url + "statistics/paidPercentage",
		method: "post",
		dataType: "json",
		success: function (data) {
			var options = {
				animationEnabled: true,
				title: {
					text: "TOTAL USER YANG SUDAH BAYAR",
				},
				axisY: {
					title: "BANYAK USER",
				},
				axisX: {
					title: "PERSENTASE",
				},
				data: [
					{
						type: "column",
						yValueFormatString: "####",
						dataPoints: data,
					},
				],
			};
			$("#paidPercentage").CanvasJSChart(options);
		},
	});
});
