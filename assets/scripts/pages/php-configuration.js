$('#iniSelector').on('change', function (e) {
  let selectedFile = $(this).val();

  $.ajax({
    type: 'POST',
    url: '/api/configuration/getFile.php',
    data: {
      file: selectedFile,
    },
    dataType: 'json',
    beforeSend: function () {
      document.querySelector('.form-inputs').innerHTML = '';
    },
    success: function (response) {
      let options = response.data;
      options.forEach((option) => {
        let optionElement = `
            <div class="form-group col-3">
                <label for="${option.key}">${option.key}</label>
                <input type="text" class="form-control" name="${option.key}" id="${option.key}" value="${option.value}"/>
            </div>
        `;
        $('.form-inputs').append(optionElement);
      });
    },
  });
});

$('#iniFileEditorForm').on('submit', function (e) {
  e.preventDefault();
  let formBtn = this.querySelector('button[type="submit"]');
  let formStatus = this.querySelector('.form-status');
  let formInputs = document.querySelectorAll('.form-inputs input');

  let selectedFile = $('#iniSelector').val();
  let updatedOptions = [];

  formInputs.forEach((input) => {
    updatedOptions.push({
      name: input.name,
      value: input.value,
    });
  });

  $.ajax({
    type: 'POST',
    url: '/api/configuration/updateFile.php',
    data: {
      file: selectedFile,
      options: updatedOptions,
    },
    dataType: 'json',
    beforeSend: function () {
      // disable submit button
      formBtn.disabled = true;
      // disable all form inputs
      formInputs.forEach((input) => {
        input.disabled = true;
      });

      formStatus.innerHTML = "Updating ini file..."
    },
    success: function (response) {
      // enable submit button
      formBtn.disabled = false;
      // enable all form inputs
      formInputs.forEach((input) => {
        input.disabled = false;
      });

      formStatus.innerHTML = "File updated successfully!"
    },
    error: function ({response}) {
      // enable submit button
      formBtn.disabled = false;
      // enable all form inputs
      formInputs.forEach((input) => {
        input.disabled = false;
      });

      formStatus.innerHTML = response.message
    },
  });
});
