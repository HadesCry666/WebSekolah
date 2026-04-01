document.addEventListener('DOMContentLoaded', function() {
    const toast = document.getElementById('toastNotif');
    if (toast) {
        // Munculkan toast
        setTimeout(() => {
            toast.classList.add('toast-show');
        }, 100);

        // Hilangkan setelah 4 detik
        setTimeout(() => {
            toast.classList.remove('toast-show');

            // Hapus elemen setelah animasi
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    }
});

document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-delete')) {

        let button = e.target.closest('.btn-delete');
        let id = button.getAttribute('data-id');

        Swal.fire({
            title: "Hapus Data?",
            text: "Data ini akan dihapus secara permanen.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });

    }
});

