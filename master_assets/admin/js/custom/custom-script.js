/*================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 5.0
	Author: PIXINVENT
	Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */
$(function () {
	$('.modal').modal();
	// $('#modal3').modal('open');
	// $('#modal3').modal('close');
});
$('.edit-it').click(function () {
	$(this).css('display', 'none');
	$(this).parents('span').siblings('span').children('button').css('display', 'inline-block')
	$(this).parents('.card-head').siblings('.card-content').find('.input-field').children('p').css('display', 'none')
	$(this).parents('.card-head').siblings('.card-content').find('.input-field').children('input').css('display', 'block')
	$(this).parents('.card-head').siblings('.card-content').find('.input-field').children('select').css('display', 'block')
})
$('.cancel-it').click(function () {
	$(this).css('display', 'none');
	$(this).parents('span').siblings('span').children('.edit-it').css('display', 'inline-block')
	$(this).parents('span').siblings('span').children('.save-it').css('display', 'none');
	$(this).parents('.card-head').siblings('.card-content').find('.input-field').children('p').css('display', 'block')
	$(this).parents('.card-head').siblings('.card-content').find('.input-field').children('input').css('display', 'none')
	$(this).parents('.card-head').siblings('.card-content').find('.input-field').children('select').css('display', 'none')

})
// tabs function
$('.listing-table-tab ul li').click(function () {
	var t = $(this).attr('id');
	$(this).siblings('li').removeClass('active-list');
	$(this).addClass('active-list')
	$(this).parents('.listing-table-tab').siblings('.listing-tab-content').children('.listing-tab-content-section').hide();
	$(this).parents('.listing-table-tab').siblings('.listing-tab-content').children('#' + t + 't').show();
	return false;
});
// tabs function

// universal tab function
$('.tablist ul li').click(function () {
	var t = $(this).attr('id');
	$(this).siblings('li').children('a').removeClass('active');
	$(this).children('a').addClass('active')
	$(this).parents('.tablist').siblings('.tab-container').children('.tab-child').hide();
	$(this).parents('.tablist').siblings('.tab-container').children('#' + t + 't').show();

});
//universal tab function

$('.hide-filter').click(function () {
	$(this).parents('p').siblings('div').css('display', 'none')
	$(this).css('display', 'none');
	$(this).siblings('.show-filter').css('display', 'block')
})
$('.show-filter').click(function () {
	$(this).parents('p').siblings('div').css('display', 'block')
	$(this).css('display', 'none');
	$(this).siblings('.hide-filter').css('display', 'block')
})
$('.show-advance').click(function () {
	$(this).css('display', 'none');
	$(this).siblings('.hide-advance').css('display', 'block')
	$(this).parents('p').siblings('.advance').css('display', 'block')
})
$('.hide-advance').click(function () {
	$(this).css('display', 'none');
	$(this).siblings('.show-advance').css('display', 'block')
	$(this).parents('p').siblings('.advance').css('display', 'none')
})

// Simple Data Table

$('#customer-table').DataTable({
	"responsive": true,
});
$('#customer-tablethree').DataTable({
	"responsive": true,
});
$('#customer-tabletwo').DataTable({
	"responsive": true,
});
$('#assets-table').DataTable({
	"responsive": true,
	"scrollX": true
});

$('.dat_table').DataTable({

})
$('.dataTable').wrap('<div class="dataTables_scroll2" />');



// $(function () {

// 	var current = window.location.href;
// 	console.log(current)

// 	$('.sidenav-dark.sidenav-main .sidenav li a').each(function () {
// 		var $this = $(this);
// 		var k = $(this).attr('href').indexOf(current);
// 		console.log(k)
// 		// if the current path is like this link, make it active
// 		if ($this.attr('href').indexOf(current) === -1) {
// 			$this.addClass('selected');
// 		}
// 	})
// })

var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
$('.sidenav-dark.sidenav-main .sidenav li a').each(function () {
	if (this.href === path) {
		$(this).addClass('selected');
	}
});


// top job trend Chart
var ctx = document.getElementById("topjob");
var myBarChart = new Chart(ctx, {
	type: "bar",
	data: {
		labels: ["Maintainance", "Dummy type1", "Dummy type2", "Dummy type 3", "Dummy type 4", "Dummy type 5"],
		datasets: [{
			label: "Job Count",
			backgroundColor: "#0061f263",
			hoverBackgroundColor: "rgba(0, 97, 242, 0.9)",
			borderColor: "#4e73df",
			data: [3, 4, 2, 5, 2, 4]
		}]
	},
	options: {
		maintainAspectRatio: false,
		layout: {
			padding: {
				left: 10,
				right: 25,
				top: 25,
				bottom: 0
			}
		},
		scales: {
			xAxes: [{
				time: {
					unit: "Job type"
				},
				gridLines: {
					display: false,
					drawBorder: false
				},
				ticks: {
					maxTicksLimit: 6
				},
				maxBarThickness: 35
			}],
			yAxes: [{
				ticks: {
					min: 0,
					max: 5,
					maxTicksLimit: 6,
					padding: 10,
					// Include a dollar sign in the ticks

				},
				gridLines: {
					color: "rgb(234, 236, 244)",
					zeroLineColor: "rgb(234, 236, 244)",
					drawBorder: false,
					borderDash: [2],
					zeroLineBorderDash: [2]
				}
			}]
		},
		legend: {
			display: false
		},
		tooltips: {
			titleMarginBottom: 10,
			titleFontColor: "#6e707e",
			titleFontSize: 14,
			backgroundColor: "rgb(255,255,255)",
			bodyFontColor: "#858796",
			borderColor: "#dddfeb",
			borderWidth: 1,
			xPadding: 15,
			yPadding: 15,
			displayColors: false,
			caretPadding: 10,

		}
	}
});
// top job chart end here


// customer chart start

var ctx2 = document.getElementById("topcustomers");
var myBarChart = new Chart(ctx2, {
	type: "bar",
	data: {
		labels: ["Sample customer1", "Sample customer 2", "Sample customer 3", "Sample customer 4", "Sample customer 5", "Sample customer 5"],
		datasets: [{
			label: "Customer type",
			backgroundColor: "#0061f263",
			hoverBackgroundColor: "rgba(0, 97, 242, 0.9)",
			borderColor: "#4e73df",
			data: [3, 4, 2, 5, 2, 4]
		}]
	},
	options: {
		maintainAspectRatio: false,
		layout: {
			padding: {
				left: 10,
				right: 25,
				top: 25,
				bottom: 0
			}
		},
		scales: {
			xAxes: [{
				time: {
					unit: "Value"
				},
				gridLines: {
					display: false,
					drawBorder: false
				},
				ticks: {
					maxTicksLimit: 6
				},
				maxBarThickness: 35
			}],
			yAxes: [{
				ticks: {
					min: 0,
					max: 5,
					maxTicksLimit: 6,
					padding: 10,
					// Include a dollar sign in the ticks

				},
				gridLines: {
					color: "rgb(234, 236, 244)",
					zeroLineColor: "rgb(234, 236, 244)",
					drawBorder: false,
					borderDash: [2],
					zeroLineBorderDash: [2]
				}
			}]
		},
		legend: {
			display: false
		},
		tooltips: {
			titleMarginBottom: 10,
			titleFontColor: "#6e707e",
			titleFontSize: 14,
			backgroundColor: "rgb(255,255,255)",
			bodyFontColor: "#858796",
			borderColor: "#dddfeb",
			borderWidth: 1,
			xPadding: 15,
			yPadding: 15,
			displayColors: false,
			caretPadding: 10,

		}
	}
});
//customer chart end here

// line chart

//Get the context of the Chart canvas element we want to select
var ctx3 = $("#job-trands");
// Chart Options
var chartOptions = {
	responsive: true,
	maintainAspectRatio: false,
	legend: {
		position: "bottom"
	},
	hover: {
		mode: "label"
	},
	scales: {
		xAxes: [
			{
				display: true,
				gridLines: {
					color: "#f3f3f3",
					drawTicks: false
				},
				scaleLabel: {
					display: true,
					labelString: "Jobtrends"
				}
			}
		],
		yAxes: [
			{
				display: true,
				gridLines: {
					color: "#f3f3f3",
					drawTicks: false
				},
				scaleLabel: {
					display: true,
					labelString: "Value"
				}
			}
		]
	},
	title: {
		display: false,
		text: "Job trends"
	}
};

// Chart Data
var chartData = {
	labels: ["label1", "label2", "label3", "label4", "label5", "label6", "label7"],
	datasets: [
		{
			label: "Complete",
			data: [65, 59, 80, 81, 56, 55, 40],
			fill: false,
			borderColor: "#e91e63",
			pointBorderColor: "#e91e63",
			pointBackgroundColor: "#FFF",
			pointBorderWidth: 2,
			pointHoverBorderWidth: 2,
			pointRadius: 4
		},
		{
			label: "Outstanding",
			data: [28, 48, 40, 19, 86, 27, 90],
			fill: false,
			borderColor: "#03a9f4",
			pointBorderColor: "#03a9f4",
			pointBackgroundColor: "#FFF",
			pointBorderWidth: 2,
			pointHoverBorderWidth: 2,
			pointRadius: 4
		},

	]
};

var config = {
	type: "line",

	// Chart Options
	options: chartOptions,

	data: chartData
};

// Create the chart
var lineChart = new Chart(ctx3, config);

//line chart end


// pie chart start here
var ctx4 = document.getElementById('camparechart')
var ctx5 = document.getElementById('comparechart2')
var ctx6 = document.getElementById('comparechart3')
console.log(ctx6)

var data1 = {
	labels: ["Outstanding Jobs", "Completed Jobs"],
	datasets: [
		{
			label: "Job camparison",
			data: [10, 90],
			backgroundColor: [
				"#ffcd56",
				"#ff6384",
			],
			borderColor: [
				"#ffcd56",
				"#ff6384",
			],
			borderWidth: [1, 1]
		}
	]
};

var data2 = {
	labels: ["Outstanding Jobs", "Completed Jobs"],
	datasets: [
		{
			label: "Job camparison",
			data: [40, 60],
			backgroundColor: [
				"##ffcd56",
				"#ff6384",
			],
			borderColor: [
				"#ffcd56",
				"#ff6384",
			],
			borderWidth: [1, 1]
		}
	]
};

var data3 = {
	labels: ["Outstanding Jobs", "Completed Jobs"],
	datasets: [
		{
			label: "Job camparison",
			data: [70, 30],
			backgroundColor: [
				"#54ea598c",
				"#ffcc00",
			],
			borderColor: [
				"#54ea598c",
				"#ffcc00",
			],
			borderWidth: [1, 1]
		}
	]
};

var options = {
	responsive: true,
	title: {
		display: false,
		position: "top",
		text: "Doughnut Chart",
		fontSize: 18,
		fontColor: "#111"
	},
	legend: {
		display: false,
		position: "bottom",
		labels: {
			fontColor: "#333",
			fontSize: 12
		}
	}
};

var piechart = new Chart(ctx4, {
	type: "doughnut",
	data: data1,
	options: options
});

var piechart2 = new Chart(ctx5, {
	type: "doughnut",
	data: data2,
	options: options
});

var piechart3 = new Chart(ctx6, {
	type: "doughnut",
	data: data3,
	options: options
});
// pie chart end here


