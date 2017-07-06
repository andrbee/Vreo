<?php
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'title': {
            echo '<script>
                                   swal({
                                      title: \'Save!\',
                                      text: \'New compaign title.\',
                                      type:  \'success\',
                                      timer: 1000
                                    }).then(
                                      function () {},
                                      // handling the promise rejection
                                      function (dismiss) {
                                        if (dismiss === \'timer\') {
                                          console.log(\'I was closed by the timer\')
                                        }
                                      }
                                    )</script>';

            break;
        }
        case 'title-error': {
            echo '<script>
                                   swal({
                                      title: \'Error!\',
                                      text: \'New compaign title.\',
                                      type:  \'warning\',
                                      timer: 1000
                                    }).then(
                                      function () {},
                                      // handling the promise rejection
                                      function (dismiss) {
                                        if (dismiss === \'timer\') {
                                          console.log(\'I was closed by the timer\')
                                        }
                                      }
                                    )</script>';

            break;
        }
        case 'campaign-bg': {
            echo '<script>
                                   swal({
                                      title: \'Save!\',
                                      text: \'New compaign bg.\',
                                      type:  \'success\',
                                      timer: 1000
                                    }).then(
                                      function () {},
                                      // handling the promise rejection
                                      function (dismiss) {
                                        if (dismiss === \'timer\') {
                                          console.log(\'I was closed by the timer\')
                                        }
                                      }
                                    )</script>';

            break;
        }
        case 'campaign-bg-error': {
            echo '<script>
                                   swal({
                                      title: \'Error!\',
                                      text: \'New compaign bg.\',
                                      type:  \'warning\',
                                      timer: 1000
                                    }).then(
                                      function () {},
                                      // handling the promise rejection
                                      function (dismiss) {
                                        if (dismiss === \'timer\') {
                                          console.log(\'I was closed by the timer\')
                                        }
                                      }
                                    )</script>';

            break;
        }
        case 'exist': {
            echo '<div class="error">The user with the specified email already exists.</div>';
            break;
        }
        case 'short': {
            echo '<div class="error">The password is too short.</div>';
            break;
        }
        case 'mismatch': {
            echo '<div class="error">Passwords do not match.</div>';
            break;
        }
        case 'wrong': {
            echo '<div class="error">The old password is incorrect.</div>';
            break;
        }
        case 'required': {
            echo '<div class="error">Please fill in all required fields.</div>';
            break;
        }
    }
}