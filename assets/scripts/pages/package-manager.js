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
      changePackageStatus(
        package,
        'Please wait, Installing your package...',
        'loading'
      );
    },
    success: function (response) {
      changePackageStatus(
        package,
        package + ' has been installed successfully!',
        'success'
      );
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
      changePackageStatus(
        package,
        'Please wait, Uninstalling your package...',
        'loading'
      );
    },
    success: function (response) {
      changePackageStatus(
        package,
        package + ' has been uninstalled successfully!',
        'success'
      );
      document.getElementById(uninstallBtn).setAttribute('disabled', true);
      document.getElementById(reinstallBtn).setAttribute('disabled', true);
      document.getElementById(installBtn).removeAttribute('disabled');
      document
        .querySelector('#' + package)
        .querySelector('.package-version').textContent = '';
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
      changePackageStatus(
        package,
        'Please wait, Purging your package...',
        'loading'
      );
      document.getElementById(purgeBtn).setAttribute('disabled', true);
    },
    success: function (response) {
      changePackageStatus(
        package,
        package + ' has been purged successfully!',
        'success'
      );
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
      changePackageStatus(
        package,
        'Please wait, Reinstalling your package...',
        'loading'
      );
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
        beforeSend: function () {
          changePackageStatus(
            package,
            'Please wait, Reinstalling your package...',
            'loading'
          );
        },
        success: function (response) {
          changePackageStatus(
            package,
            package + ' has been reinstalled successfully!',
            'success'
          );
          document.getElementById(uninstallBtn).removeAttribute('disabled');
          document.getElementById(reinstallBtn).removeAttribute('disabled');
          document.getElementById(installBtn).setAttribute('disabled', true);
        },
      });
    },
  });
}

function log(package) {
  let logBtn = package + 'LogBtn';
  $.ajax({
    type: 'POST',
    url: '/api/package/log.php',
    data: {
      package: package,
    },
    dataType: 'json',
    beforeSend: function (response) {
      changePackageStatus(
        package,
        'Please wait, Getting package logs...',
        'loading'
      );
      document.getElementById(logBtn).setAttribute('disabled', true);
    },
    success: function (response) {
      if (response.data) {
        let logData = response.data.replace(/[\n\r]/g, '<br>');
        changePackageStatus(package, '');
        document.getElementById(logBtn).removeAttribute('disabled');
        document
          .querySelector('#' + package)
          .querySelector('.package-log').innerHTML = logData;
      }
    },
  });
}

function changePackageStatus(packageName, statusText, statusType) {
  let packageStatusElement = document.querySelector(
    '.package-status.' + packageName
  );

  if (packageStatusElement) {
    // Update the status text
    packageStatusElement.querySelector('.status-text').textContent = statusText;
    let statusIconElement = packageStatusElement.querySelector('.status-icon');
    if (statusIconElement) {
      // Remove existing classes
      statusIconElement.className = 'status-icon';
      if (statusType === 'success') {
        statusIconElement.classList.add('fas', 'fa-check-circle');
      } else if (statusType === 'loading') {
        statusIconElement.classList.add('fas', 'fa-spinner', 'fa-spin');
      } else if (statusType === 'error') {
        statusIconElement.classList.add('fas', 'fa-exclamation-triangle');
      }
    }
  } else {
    console.error(
      'Package status element not found for package: ' + packageName
    );
  }
}
