"use strict";

const primary = '#6993FF';
const success = '#1BC5BD';
const info = '#8950FC';
const warning = '#FFA800';
const danger = '#F64E60';
const d = new Date();
let year = d.getFullYear();

var KTApexChartsDemo = function () {
	var _demo5 = function () {
		const apexChart = "#chart_5";
		var options = {
            series: [],
            chart: {
                height: 350,
                type: 'bar',
            },
            dataLabels: {
                enabled: false
            },
            title: {
                text: 'Penjualan Per Bulan Tahun ' + year,
                align: 'left',
                offsetX: 110
            },
            noData: {
                text: 'Loading...'
            },
            xaxis: {
                type: 'category',
                tickPlacement: 'on',
                labels: {
                rotate: -45,
                rotateAlways: true
                }
            }
        };
  
        var chart = new ApexCharts(document.querySelector(apexChart), options);
        chart.render();
        
        $.ajax({
			url: HOST_URL + 'home/get_penjualan_perbulan',
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				chart.updateSeries([{
                  name: 'Penjualan',
                  data: data
                }])
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error show data');
			}
		});
	}

	var _demo12 = function () {
		const apexChart = "#chart_12";
		var options = {
			series: [44, 55, 13, 43, 22],
			chart: {
				width: 380,
				type: 'pie',
			},
			labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 150
					},
					legend: {
						position: 'bottom'
					}
				}
			}],
			colors: [primary, success, warning, danger, info]
		};

		var chart = new ApexCharts(document.querySelector(apexChart), options);
		chart.render();
	}

	return {
		init: function () {
			_demo5();
			_demo12();
		}
	};
}();

jQuery(document).ready(function () {
	KTApexChartsDemo.init();
});
