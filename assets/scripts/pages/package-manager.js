function install(package) {
  $.ajax({
    type: 'POST',
    url: '/api/package/install.php',
    data: {
      package: package,
    },
    dataType: 'json',
    success: function (response) {
      console.log(response);
    },
  });
}

function uninstall(package) {
  $.ajax({
    type: 'POST',
    url: '/api/package/uninstall.php',
    data: {
      package: package,
    },
    dataType: 'json',
    success: function (response) {
      console.log(response);
    },
  });
}

function purge(package) {
  $.ajax({
    type: 'POST',
    url: '/api/package/purge.php',
    data: {
      package: package,
    },
    dataType: 'json',
    success: function (response) {
      console.log(response);
    },
  });
}


function reinstall(package) {
  $.ajax({
    type: 'POST',
    url: '/api/package/uninstall.php',
    data: {
      package: package,
    },
    dataType: 'json',
    success: function (response) {
      $.ajax({
        type: 'POST',
        url: '/api/package/install.php',
        data: {
          package: package,
        },
        dataType: 'json',
        success: function (response) {},
      });
    },
  });
}

function log(package) {
  alert(package);
}
