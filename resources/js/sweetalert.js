/**
 * SweetAlert2 Flash Message Handler
 * This script handles flash messages (success/error) and displays them using SweetAlert2
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check for flash messages in the DOM
    const successMessage = document.querySelector('[data-flash-success]');
    const errorMessage = document.querySelector('[data-flash-error]');
    const profileIncomplete = document.querySelector('[data-profile-incomplete]');

    // Show success message
    if (successMessage && successMessage.dataset.flashSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: successMessage.dataset.flashSuccess,
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-3xl',
                title: 'text-xl font-semibold',
                html: 'text-sm'
            }
        });
    }

    // Show error message
    if (errorMessage && errorMessage.dataset.flashError) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: errorMessage.dataset.flashError,
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: true,
            customClass: {
                popup: 'rounded-3xl',
                title: 'text-xl font-semibold',
                html: 'text-sm',
                confirmButton: 'rounded-full bg-slate-900 px-6 py-2 text-sm font-semibold text-white'
            }
        });
    }

    // Show profile incomplete warning
    if (profileIncomplete && profileIncomplete.dataset.profileIncomplete) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian!',
            text: profileIncomplete.dataset.profileIncomplete,
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: true,
            customClass: {
                popup: 'rounded-3xl',
                title: 'text-xl font-semibold',
                html: 'text-sm',
                confirmButton: 'rounded-full bg-amber-500 px-6 py-2 text-sm font-semibold text-white'
            }
        });
    }

    // Handle validation errors from Laravel
    // Check if there are field errors displayed
    const fieldErrors = document.querySelectorAll('.field-error');
    if (fieldErrors.length > 0) {
        // Collect all error messages
        let errorMessages = [];
        fieldErrors.forEach(function(error) {
            errorMessages.push(error.textContent.trim());
        });

        // Remove duplicates
        errorMessages = [...new Set(errorMessages)];

        // Join all errors with line breaks
        const errorText = errorMessages.join('\n');

        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            text: errorText,
            timer: 0,
            showConfirmButton: true,
            confirmButtonText: 'Tutup',
            customClass: {
                popup: 'rounded-3xl max-w-lg',
                title: 'text-xl font-semibold text-red-600',
                html: 'text-sm text-left',
                confirmButton: 'rounded-full bg-red-500 px-6 py-2 text-sm font-semibold text-white hover:bg-red-600'
            }
        });
    }
});

// Function to show custom SweetAlert from anywhere
function showSweetAlert(icon, title, text, timer = 3000) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            timer: timer,
            timerProgressBar: true,
            showConfirmButton: timer === 0,
            customClass: {
                popup: 'rounded-3xl',
                title: 'text-xl font-semibold',
                html: 'text-sm',
                confirmButton: 'rounded-full bg-slate-900 px-6 py-2 text-sm font-semibold text-white'
            }
        });
    }
}

// Function to show success alert
function showSuccess(title = 'Berhasil!', text = 'Operasi berhasil dilakukan.') {
    showSweetAlert('success', title, text);
}

// Function to show error alert
function showError(title = 'Gagal!', text = 'Terjadi kesalahan. Silakan coba lagi.') {
    showSweetAlert('error', title, text);
}

// Function to show warning alert
function showWarning(title = 'Peringatan!', text = 'Harap periksa kembali data Anda.') {
    showSweetAlert('warning', title, text);
}

// Function to show info alert
function showInfo(title = 'Informasi', text = '') {
    showSweetAlert('info', title, text);
}

