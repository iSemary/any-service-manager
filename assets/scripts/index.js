function renderDiskSpaceChart(chartID, totalSpace, freeSpace) {
  var echarts = window.echarts;
  var chartDom = document.getElementById(chartID);
  var myChart = echarts.init(chartDom);
  var option;

  option = {
    title: {
      text: 'Disk Space',
      left: 'center',
    },
    tooltip: {
      trigger: 'item',
    },
    legend: {
      orient: 'vertical',
      left: 'left',
    },
    series: [
      {
        name: 'Usage',
        type: 'pie',
        radius: '50%',
        data: [
          { value: freeSpace, name: 'Free Space' },
          { value: totalSpace - freeSpace, name: 'Used Space' },
        ],
        emphasis: {
          itemStyle: {
            shadowBlur: 10,
            shadowOffsetX: 0,
            shadowColor: 'rgba(0, 0, 0, 0.5)',
          },
        },
      },
    ],
  };

  option && myChart.setOption(option);
}

$(function () {
  // Render disk space chart
  let totalDiskSpace = $('#diskSpaceChart').data('total-space');
  let freeDiskSpace = $('#diskSpaceChart').data('free-space');
  renderDiskSpaceChart('diskSpaceChart', totalDiskSpace, freeDiskSpace);

  // Check each package
  
});
