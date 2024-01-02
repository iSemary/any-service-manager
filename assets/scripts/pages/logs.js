// Get the log data from the API and pass it to renderLog() function to render it in the dom
function showLog(package) {
  let targetElement = package + 'Log';
  $.ajax({
    type: 'POST',
    url: '/api/package/log.php',
    data: {
      package: package,
    },
    dataType: 'json',
    beforeSend: function () {
      renderLog(targetElement, 'Loading...');
    },
    success: function (response) {
      renderLog(targetElement, response.data);
    },
  });
}

// Format and render the log content from the API 
function renderLog(targetElement, logData) {
  const formattedLog = logData.replace(/[\n\r]/g, '<br>');
  document.getElementById(targetElement).innerHTML = formattedLog;
}

// Get the default package log based on the "nav-log-active" class 
let defaultPackage = document.getElementsByClassName('nav-log-active')[0].getAttribute('data-package-name');
// Render the default package log
showLog(defaultPackage);
