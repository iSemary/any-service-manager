function install(package) {
  let installBtn = package + 'InstallBtn';
  let uninstallBtn = package + 'UninstallBtn';
  let reinstallBtn = package + 'ReinstallBtn';

  $.ajax({
    type: 'POST',
    url: '/api/package/install.php',
    data: {
      package: package,
    },
    dataType: 'json',
    beforeSend: function () {
      document.getElementById(installBtn).setAttribute('disabled', true);
    },
    success: function (response) {
      document.getElementById(installBtn).setAttribute('disabled', true);
      document.getElementById(uninstallBtn).removeAttribute('disabled');
      document.getElementById(reinstallBtn).removeAttribute('disabled');
    },
  });
}

function uninstall(package) {
  let installBtn = package + 'InstallBtn';
  let uninstallBtn = package + 'UninstallBtn';
  let reinstallBtn = package + 'ReinstallBtn';

  $.ajax({
    type: 'POST',
    url: '/api/package/uninstall.php',
    data: {
      package: package,
    },
    dataType: 'json',
    beforeSend: function () {
      document.getElementById(uninstallBtn).setAttribute('disabled', true);
    },
    success: function (response) {
      document.getElementById(uninstallBtn).setAttribute('disabled', true);
      document.getElementById(reinstallBtn).setAttribute('disabled', true);
      document.getElementById(installBtn).removeAttribute('disabled');
    },
  });
}

function purge(package) {
  let purgeBtn = package + 'PurgeBtn';

  $.ajax({
    type: 'POST',
    url: '/api/package/purge.php',
    data: {
      package: package,
    },
    dataType: 'json',
    beforeSend: function () {
      document.getElementById(purgeBtn).setAttribute('disabled', true);
    },
    success: function (response) {
      document.getElementById(purgeBtn).removeAttribute('disabled');
    },
  });
}

function reinstall(package) {
  let installBtn = package + 'InstallBtn';
  let uninstallBtn = package + 'UninstallBtn';
  let reinstallBtn = package + 'ReinstallBtn';

  $.ajax({
    type: 'POST',
    url: '/api/package/uninstall.php',
    data: {
      package: package,
    },
    dataType: 'json',
    beforeSend: function () {
      document.getElementById(reinstallBtn).setAttribute('disabled', true);
    },
    success: function (response) {
      $.ajax({
        type: 'POST',
        url: '/api/package/install.php',
        data: {
          package: package,
        },
        dataType: 'json',
        success: function (response) {
          document.getElementById(uninstallBtn).removeAttribute('disabled');
          document.getElementById(reinstallBtn).removeAttribute('disabled');
          document.getElementById(installBtn).setAttribute('disabled', true);
        },
      });
    },
  });
}

function log(package) {
  alert(package);
}
