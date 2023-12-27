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
          { value: totalSpace - freeSpace, name: 'Used Space' },
          { value: freeSpace, name: 'Free Space' },
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

function checkPackagesStatus() {
  $.ajax({
    type: 'POST',
    url: '/api/checker.php',
    dataType: 'json',
    success: function (response) {
      let packages = response.data;
      packages.forEach((package) => {
        let packageStatus = package.status;
        switch (packageStatus) {
          case PackageStatus.ACTIVE:
            setPackageActive(package.name);
            break;
          case PackageStatus.INACTIVE:
            setPackageInActive(package.name);
            break;
          case PackageStatus.UNINSTALLED:
            setPackageStopped(package.name);
            break;
          default:
            break;
        }
      });
    },
  });
}

function setPackageActive(name) {
  $('#' + name + ' .package-img').removeClass("img-muted");
  $('#' + name + ' .package-status').html('Active').addClass("text-success").removeClass("text-muted");
}

function setPackageInActive(name) {
  $('#' + name + ' .package-img').addClass("img-muted");
  $('#' + name + ' .package-status').html('In Active').addClass("text-primary").removeClass("text-muted");
}

function setPackageStopped(name) {
  $('#' + name + ' .package-img').addClass("img-muted");
  $('#' + name + ' .package-status').html('Stopped').addClass("text-danger").removeClass("text-muted");
}

$(function () {
  // Render disk space chart
  let totalDiskSpace = $('#diskSpaceChart').data('total-space');
  let freeDiskSpace = $('#diskSpaceChart').data('free-space');
  renderDiskSpaceChart('diskSpaceChart', totalDiskSpace, freeDiskSpace);

  // Check each package
  checkPackagesStatus();
});
