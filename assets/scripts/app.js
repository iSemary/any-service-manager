function confirmAction(title, confirmButtonText, actionCallback) {
  Swal.fire({
    title: title,
    showCancelButton: true,
    confirmButtonText: confirmButtonText,
    denyButtonText: `Cancel`,
  }).then((result) => {
    if (result.isConfirmed) {
      actionCallback();
    }
  });
}

function powerOff() {
  confirmAction(
    'Are you sure you want to power off this machine?',
    'Power Off',
    function () {
      $.ajax({
        type: 'POST',
        url: '/api/system/powerOff.php',
        dataType: 'json',
        success: function (response) {
          Swal.fire('The machine has been powered down', '', 'success');
        },
      });
    }
  );
}

function restart() {
  confirmAction(
    'Are you sure you want to restart this machine?',
    'Restart',
    function () {
      $.ajax({
        type: 'POST',
        url: '/api/system/restart.php',
        dataType: 'json',
        success: function (response) {
          Swal.fire('The machine has been restarted', '', 'success');
        },
      });
    }
  );
}
