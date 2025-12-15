/**
 * ========================================
 * MEASUREMENT HANDLER
 * ========================================
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ===========================================
    // ELEMENTS
    // ===========================================
    const btnMulai = document.getElementById('btn-mulai-pengukuran');
    const loadingModal = document.getElementById('loading-modal');
    const resultModal = document.getElementById('result-modal');
    const btnCloseModal = document.getElementById('btn-close-modal');
    const btnUlangi = document.getElementById('btn-ulangi');
    const btnSimpan = document.getElementById('btn-simpan-hasil');
    
    // Result elements
    const resultImage = document.getElementById('result-image');
    const resultStatus = document.getElementById('result-status');
    const resultConfidence = document.getElementById('result-confidence');
    const resultSpo2 = document.getElementById('result-spo2');
    const resultHr = document.getElementById('result-hr');
    
    // Data storage
    let measurementData = null;
    
    // ===========================================
    // CSRF TOKEN
    // ===========================================
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    if (!csrfToken) {
        console.error('CSRF token not found!');
    }
    
    // ===========================================
    // SHOW/HIDE MODAL HELPERS
    // ===========================================
    function showLoadingModal() {
        if (loadingModal) loadingModal.classList.remove('hidden');
    }
    
    function hideLoadingModal() {
        if (loadingModal) loadingModal.classList.add('hidden');
    }
    
    function showResultModal() {
        if (resultModal) resultModal.classList.remove('hidden');
    }
    
    function hideResultModal() {
        if (resultModal) resultModal.classList.add('hidden');
    }
    
    // ===========================================
    // EVENT: MULAI PENGUKURAN
    // ===========================================
    if (btnMulai) {
        btnMulai.addEventListener('click', async function() {
            console.log('🚀 Mulai pengukuran...');
            
            const startUrl = this.getAttribute('data-url');
            
            if (!startUrl) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'URL pengukuran tidak ditemukan!'
                });
                return;
            }
            
            showLoadingModal();
            
            try {
                const response = await fetch(startUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                hideLoadingModal();
                
                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Gagal melakukan pengukuran');
                }
                
                // Store data
                measurementData = data.data;
                
                // Tampilkan hasil di modal
                displayResult(measurementData);
                showResultModal();
                
                console.log('✅ Pengukuran berhasil:', measurementData);
                
            } catch (error) {
                hideLoadingModal();
                console.error('❌ Error:', error);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Melakukan Pengukuran',
                    text: error.message,
                    confirmButtonColor: '#CD5656'
                });
            }
        });
    }
    
    // ===========================================
    // DISPLAY RESULT IN MODAL
    // ===========================================
    function displayResult(data) {
        // Status Anemia
        const status = data.status_anemia.toLowerCase();
        if (resultStatus) {
            resultStatus.textContent = status === 'anemia' ? 'Anemia' : 'Normal';
            resultStatus.className = status === 'anemia' 
                ? 'inline-block px-4 py-2 rounded-full text-base font-semibold bg-red-100 text-red-700'
                : 'inline-block px-4 py-2 rounded-full text-base font-semibold bg-green-100 text-green-700';
        }
        
        // Confidence
        if (resultConfidence) {
            resultConfidence.textContent = `${data.confidence}%`;
        }
        
        // SpO2
        if (resultSpo2) {
            resultSpo2.textContent = `${data.spo2}%`;
        }
        
        // Heart Rate
        if (resultHr) {
            resultHr.textContent = `${data.heart_rate} bpm`;
        }
        
        // Image
        if (resultImage && data.image_path) {
            // Sesuaikan path gambar dengan Laravel storage
            const imageName = data.image_path.split('/').pop();
            resultImage.src = `/storage/patient_images/${imageName}`;
            resultImage.onerror = function() {
                this.src = '/images/placeholder.jpg';
            };
        }
        
        // 🔥 Update data-url untuk button Simpan Hasil
        if (btnSimpan && data.anamnesis_id) {
            // Ambil pasien slug dari URL saat ini
            const urlParts = window.location.pathname.split('/');
            const pasienSlug = urlParts[urlParts.indexOf('home') + 1];
            
            const saveUrl = `/home/${pasienSlug}/${data.anamnesis_id}/save`;
            btnSimpan.setAttribute('data-url', saveUrl);
            console.log('✓ Save URL set to:', saveUrl);
        }
    }
    
    // ===========================================
    // EVENT: CLOSE MODAL
    // ===========================================
    if (btnCloseModal) {
        btnCloseModal.addEventListener('click', function() {
            hideResultModal();
        });
    }
    
    // ===========================================
    // EVENT: ULANGI PENGUKURAN
    // ===========================================
    if (btnUlangi) {
        btnUlangi.addEventListener('click', function() {
            hideResultModal();
            measurementData = null;
            
            if (btnMulai) {
                btnMulai.click();
            }
        });
    }
    
    // ===========================================
    // EVENT: SIMPAN HASIL
    // ===========================================
    if (btnSimpan) {
        btnSimpan.addEventListener('click', async function() {
            if (!measurementData) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak Ada Data',
                    text: 'Tidak ada data untuk disimpan!',
                    confirmButtonColor: '#CD5656'
                });
                return;
            }
            
            const saveUrl = this.getAttribute('data-url');
            
            if (!saveUrl || saveUrl === '#') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'URL penyimpanan tidak ditemukan!',
                    confirmButtonColor: '#CD5656'
                });
                return;
            }
            
            // Disable button
            this.disabled = true;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Menyimpan...</span>';
            
            try {
                const response = await fetch(saveUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(measurementData)
                });
                
                const data = await response.json();
                
                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Gagal menyimpan data');
                }
                
                console.log('✅ Data tersimpan:', data);
                
                // Show success
                await Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Hasil pengukuran berhasil disimpan!',
                    confirmButtonColor: '#CD5656'
                });
                
                // Redirect
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    hideResultModal();
                    location.reload();
                }
                
            } catch (error) {
                console.error('Error saving:', error);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: error.message,
                    confirmButtonColor: '#CD5656'
                });
                
                // Re-enable button
                this.disabled = false;
                this.innerHTML = '<i class="fa-solid fa-save"></i> <span class="text-sm font-semibold">Simpan Hasil</span>';
            }
        });
    }
    
    // ===========================================
    // CLOSE MODAL ON OUTSIDE CLICK
    // ===========================================
    if (resultModal) {
        resultModal.addEventListener('click', function(e) {
            if (e.target === resultModal) {
                hideResultModal();
            }
        });
    }
    
});