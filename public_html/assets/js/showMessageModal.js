// showMessageModal.js
$(document).ready(function () {
    // Menampilkan modal jika ada pesan sukses
    if ($('#successModal').length > 0) {
        $('#successModal').modal('show');

        // Tambahkan animasi setelah modal ditampilkan
        $('.checkmark').addClass('animate__animated animate__rubberBand');
    }

    // Menghilangkan modal setelah beberapa detik
    setTimeout(function () {
        $('#successModal').modal('hide');
    }, 2000); // Ubah 2000 menjadi waktu yang Anda inginkan dalam milidetik
});
