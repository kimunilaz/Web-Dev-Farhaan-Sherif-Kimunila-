(function () {
    const forms = document.querySelectorAll('form[data-validate]');

    forms.forEach(function (form) {
        form.noValidate = true;

        form.querySelectorAll('input, textarea, select').forEach(function (field) {
            field.addEventListener('input', function () {
                field.setCustomValidity('');
            });
        });

        form.addEventListener('submit', function (event) {
            let firstInvalid = null;
            const fields = form.querySelectorAll('input, textarea, select');

            fields.forEach(function (field) {
                field.setCustomValidity('');
                const value = field.value.trim();

                if (field.required && value === '') {
                    field.setCustomValidity('Please complete this required field.');
                } else if (field.maxLength > 0 && value.length > field.maxLength) {
                    field.setCustomValidity('Please use no more than ' + field.maxLength + ' characters.');
                }

                if (!firstInvalid && field.validity.customError) {
                    firstInvalid = field;
                }
            });

            const confirmation = form.querySelector('[name="password_confirmation"]');
            if (confirmation) {
                const username = form.querySelector('[name="username"]');
                const password = form.querySelector('[name="password"]');

                if (username.value.length < 3) {
                    username.setCustomValidity('Username must contain at least 3 characters.');
                    firstInvalid = firstInvalid || username;
                } else if (!/^[A-Za-z0-9_.-]+$/.test(username.value)) {
                    username.setCustomValidity('Use letters, numbers, dots, underscores, or hyphens only.');
                    firstInvalid = firstInvalid || username;
                }

                if (password.value.length < 8) {
                    password.setCustomValidity('Password must contain at least 8 characters.');
                    firstInvalid = firstInvalid || password;
                }

                if (confirmation.value !== password.value) {
                    confirmation.setCustomValidity('Passwords do not match.');
                    firstInvalid = firstInvalid || confirmation;
                }
            }

            if (firstInvalid) {
                event.preventDefault();
                firstInvalid.focus();
                firstInvalid.reportValidity();
            }
        });
    });
})();
