// File: resources/js/app.js

import './bootstrap'; // Memanggil file di atas untuk menyalakan "mesin"
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// ================================================================
// LOGIKA UTAMA NOTIFIKASI REAL-TIME
// ================================================================

// Pastikan seluruh halaman sudah siap sebelum kita mencari elemen
document.addEventListener("DOMContentLoaded", () => {
    
    // Cari elemen-elemen notifikasi di halaman
    const notificationList = document.getElementById('notification-list');
    const notificationCounter = document.getElementById('notification-counter');
    const noNotificationMessage = document.querySelector('#notification-list .text-center');

    // Hanya jalankan listener jika semua elemen yang dibutuhkan ada
    if (notificationList && notificationCounter) {
        
        console.log('✅ Elemen notifikasi ditemukan. Siap mendengarkan channel "private-admin-channel".');
        let notificationCount = parseInt(notificationCounter.innerText) || 0;

        // Langsung dengarkan channel
        window.Echo.private('admin-channel')
            .listen('.new-order', (e) => {
                
                // Ini adalah bukti bahwa sinyal sudah sampai ke browser
                console.log('🔥 NOTIFIKASI BARU DITERIMA:', e);

                // Hapus pesan "Tidak ada notifikasi" jika ada
                if (noNotificationMessage) {
                    noNotificationMessage.remove();
                }

                // Buat elemen HTML untuk notifikasi baru
                const newNotificationHTML = `
                    <a href="${e.url}" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
                        <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
                            <span class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                <iconify-icon icon="solar:cart-large-2-bold" class="icon text-xxl"></iconify-icon>
                            </span>
                            <div>
                                <h6 class="text-md fw-semibold mb-4">Pesanan Baru Diterima</h6>
                                <p class="mb-0 text-sm text-secondary-light text-w-200-px">Pesanan dari ${e.customer_name} sedang menunggu konfirmasi Anda.</p>
                            </div>
                        </div>
                    </a>
                `;

                // Tambahkan notifikasi baru di paling atas daftar
                notificationList.insertAdjacentHTML('afterbegin', newNotificationHTML);

                // Update counter notifikasi
                notificationCount++;
                notificationCounter.innerText = notificationCount;
                notificationCounter.style.display = 'block';
            });

    } else {
        console.warn('⚠️ Elemen notifikasi (#notification-list atau #notification-counter) tidak ditemukan di halaman ini.');
    }
});