/**
 * ========================================
 * MEASUREMENT HANDLER - FIXED VERSION
 * ========================================
 * 
 * Fixes:
 * - Live preview loading issue
 * - Image color correction
 * - Better error handling
 * - Connection timeout handling
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ===========================================
    // CONFIGURATION
    // ===========================================
     const API_BASE = 'http://192.168.1.19:5000';
    // Atau gunakan localhost jika test di Raspi:
    // const API_BASE = 'http://localhost:5000';
    
    // Connection timeout
    const STREAM_TIMEOUT = 10000; // 10 detik
    const API_TIMEOUT = 60000; // 60 detik
    
    // ===========================================
    // ELEMENTS
    // ===========================================
    const modal = document.getElementById('measurement-modal');
    const modalTitle = document.getElementById('modal-title');
    const btnMulai = document.getElementById('btn-mulai-pengukuran');
    const btnCloseModal = document.getElementById('btn-close-modal');
    
    // Step containers
    const stepPreview = document.getElementById('step-preview');
    const stepReview = document.getElementById('step-review');
    const stepAnalyzing = document.getElementById('step-analyzing');
    const stepResult = document.getElementById('step-result');
    
    // Preview elements
    const videoStream = document.getElementById('video-stream');
    const videoLoading = document.getElementById('video-loading');
    const btnCapture = document.getElementById('btn-capture');
    const btnCancelPreview = document.getElementById('btn-cancel-preview');
    
    // Review elements
    const capturedImage = document.getElementById('captured-image');
    const btnRetake = document.getElementById('btn-retake');
    const btnAnalyze = document.getElementById('btn-analyze');
    
    // Result elements
    const resultImage = document.getElementById('result-image');
    const resultStatus = document.getElementById('result-status');
    const resultConfidence = document.getElementById('result-confidence');
    const resultSpo2 = document.getElementById('result-spo2');
    const resultHr = document.getElementById('result-hr');
    const btnNewMeasurement = document.getElementById('btn-new-measurement');
    const btnSaveResult = document.getElementById('btn-save-result');
    
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Data storage
    let capturedImagePath = null;
    let measurementData = null;
    let streamTimeout = null;
    let cameraStarted = false;
    
    // ===========================================
    // HELPER FUNCTIONS
    // ===========================================
    function showStep(stepElement) {
        [stepPreview, stepReview, stepAnalyzing, stepResult].forEach(step => {
            if (step) step.classList.add('hidden');
        });
        if (stepElement) stepElement.classList.remove('hidden');
    }
    
    function showModal() {
        if (modal) modal.classList.remove('hidden');
    }
    
    function hideModal() {
        if (modal) modal.classList.add('hidden');
        stopCamera();
    }
    
    function updateTitle(text) {
        if (modalTitle) modalTitle.textContent = text;
    }
    
    function showLoading(text = 'Memuat...') {
        if (videoLoading) {
            videoLoading.classList.remove('hidden');
            videoLoading.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin text-4xl mb-2"></i>
                <br>
                <span class="text-gray-300">${text}</span>
            `;
        }
    }
    
    function showError(text) {
        if (videoLoading) {
            videoLoading.classList.remove('hidden');
            videoLoading.innerHTML = `
                <i class="fa-solid fa-exclamation-triangle text-4xl text-red-400 mb-2"></i>
                <br>
                <span class="text-red-400">${text}</span>
            `;
        }
    }
    
    // ===========================================
    // CAMERA FUNCTIONS
    // ===========================================
    async function startCamera() {
        console.log('Starting camera...');
        
        showLoading('Menghidupkan kamera...');
        
        try {
            // 1. Start camera via API
            const response = await fetch(`${API_BASE}/api/camera/start`, { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            
            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message || 'Gagal start kamera');
            }
            
            console.log('✓ Camera API started');
            cameraStarted = true;
            
            // 2. Load video stream
            showLoading('Memuat stream video...');
            
            // 🔥 FIX: Set stream source dengan timestamp untuk prevent caching
            const streamUrl = `${API_BASE}/api/video_feed?t=${Date.now()}`;
            
            // Setup timeout jika stream tidak load
            streamTimeout = setTimeout(() => {
                console.error('✗ Stream timeout');
                showError('Stream timeout. Coba lagi.');
                videoStream.src = '';
            }, STREAM_TIMEOUT);
            
            // Event listeners untuk stream
            videoStream.onload = () => {
                clearTimeout(streamTimeout);
                if (videoLoading) videoLoading.classList.add('hidden');
                console.log('✓ Stream loaded successfully');
            };
            
            videoStream.onerror = (e) => {
                clearTimeout(streamTimeout);
                console.error('✗ Stream error:', e);
                showError('Gagal memuat stream. Periksa koneksi.');
            };
            
            // 🔥 FIX: Set src SETELAH event listeners terpasang
            videoStream.src = streamUrl;
            
            // Enable capture button setelah beberapa detik
            setTimeout(() => {
                if (btnCapture) btnCapture.disabled = false;
            }, 2000);
            
        } catch (err) {
            console.error('Camera start error:', err);
            clearTimeout(streamTimeout);
            showError(`Error: ${err.message}`);
            
            await Swal.fire({
                icon: 'error',
                title: 'Kamera Error',
                text: `Gagal menghidupkan kamera: ${err.message}`,
                footer: 'Pastikan Flask API berjalan di Raspberry Pi',
                confirmButtonColor: '#CD5656'
            });
        }
    }
    
    function stopCamera() {
        console.log('📹 Stopping camera...');
        
        clearTimeout(streamTimeout);
        cameraStarted = false;
        
        // Clear video source
        if (videoStream) {
            videoStream.src = '';
            videoStream.onload = null;
            videoStream.onerror = null;
        }
        
        // Stop camera via API (non-blocking)
        fetch(`${API_BASE}/api/camera/stop`, { method: 'POST' })
            .then(() => console.log('✓ Camera stopped'))
            .catch(err => console.log('Camera stop warning:', err));
    }
    
    // ===========================================
    // CAPTURE FUNCTION - FIXED
    // ===========================================
    async function capturePhoto() {
        console.log('Capturing...');
        
        if (btnCapture) {
            btnCapture.disabled = true;
            btnCapture.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Capturing...';
        }
        
        try {
            const response = await fetch(`${API_BASE}/api/capture`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            
            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message || 'Capture failed');
            }
            
            capturedImagePath = data.data.filepath;
            
            //Load captured image dengan cache buster
            if (capturedImage) {
                const imageUrl = `${API_BASE}${data.data.image_url}?t=${Date.now()}`;
                capturedImage.src = imageUrl;
                
                // Preload image
                await new Promise((resolve, reject) => {
                    capturedImage.onload = resolve;
                    capturedImage.onerror = reject;
                });
            }
            
            console.log('Captured:', data.data.filename);
            
            // Stop camera saat review
            stopCamera();
            
            // Go to review step
            updateTitle('Review Foto');
            showStep(stepReview);
            
        } catch (err) {
            console.error('Capture error:', err);
            
            await Swal.fire({
                icon: 'error',
                title: 'Gagal Capture',
                text: err.message,
                confirmButtonColor: '#CD5656'
            });
            
        } finally {
            // Re-enable capture button
            if (btnCapture) {
                btnCapture.disabled = false;
                btnCapture.innerHTML = '<i class="fa-solid fa-camera mr-2"></i> Capture';
            }
        }
    }
    
    // ===========================================
    // ANALYZE FUNCTION
    // ===========================================
    async function analyzePhoto() {
        console.log(' Analyzing...');
        
        updateTitle('Menganalisis...');
        showStep(stepAnalyzing);
        
        try {
            const response = await fetch(`${API_BASE}/api/analyze`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    image_path: capturedImagePath
                }),
                signal: AbortSignal.timeout(API_TIMEOUT)
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            
            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message || 'Analysis failed');
            }
            
            measurementData = data.data;
            
            console.log('✓ Analysis complete:', measurementData);
            
            // Display results
            displayResults(measurementData);
            
            updateTitle('Hasil Pengukuran');
            showStep(stepResult);
            
        } catch (err) {
            console.error('Analysis error:', err);
            
            await Swal.fire({
                icon: 'error',
                title: 'Gagal Analisis',
                text: err.message,
                confirmButtonColor: '#CD5656'
            });
            
            // Go back to preview
            updateTitle('Live Preview');
            showStep(stepPreview);
            startCamera();
        }
    }
    
    // ===========================================
    // DISPLAY RESULTS
    // ===========================================
    function displayResults(data) {
        // Image
        if (resultImage && data.image_path) {
            resultImage.src = `${API_BASE}${data.image_path}?t=${Date.now()}`;
        }
        
        // Status
        const status = (data.status_anemia || 'unknown').toLowerCase();
        if (resultStatus) {
            resultStatus.textContent = status === 'anemia' ? 'Anemia' : 'Normal';
            resultStatus.className = status === 'anemia' 
                ? 'inline-block px-4 py-2 rounded-full text-base font-semibold bg-red-100 text-red-700'
                : 'inline-block px-4 py-2 rounded-full text-base font-semibold bg-green-100 text-green-700';
        }
        
        // Confidence
        if (resultConfidence) {
            resultConfidence.textContent = `${data.confidence || 0}%`;
        }
        
        // SpO2
        if (resultSpo2) {
            resultSpo2.textContent = `${data.spo2 || 0}%`;
        }
        
        // Heart Rate
        if (resultHr) {
            resultHr.textContent = `${data.heart_rate || 0} bpm`;
        }
    }
    
    // ===========================================
    // SAVE TO DATABASE
    // ===========================================
    async function saveToDatabase() {
        if (!measurementData) {
            await Swal.fire({
                icon: 'warning',
                title: 'Tidak Ada Data',
                text: 'Tidak ada data untuk disimpan!'
            });
            return;
        }
        
        const saveUrl = btnMulai?.getAttribute('data-save-url');
        
        if (!saveUrl) {
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'URL penyimpanan tidak ditemukan!'
            });
            return;
        }
        
        // Disable button
        if (btnSaveResult) {
            btnSaveResult.disabled = true;
            btnSaveResult.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Menyimpan...';
        }
        
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
            
            if (!data.success) {
                throw new Error(data.message || 'Gagal menyimpan');
            }
            
            console.log('✓ Saved to database');
            
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
                hideModal();
                location.reload();
            }
            
        } catch (err) {
            console.error('Save error:', err);
            
            await Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan',
                text: err.message,
                confirmButtonColor: '#CD5656'
            });
            
            // Re-enable button
            if (btnSaveResult) {
                btnSaveResult.disabled = false;
                btnSaveResult.innerHTML = '<i class="fa-solid fa-save mr-2"></i> Simpan Hasil';
            }
        }
    }
    
    // ===========================================
    // EVENT LISTENERS
    // ===========================================
    
    // Mulai Pengukuran
    if (btnMulai) {
        btnMulai.addEventListener('click', () => {
            console.log('Starting measurement...');
            
            // Reset state
            capturedImagePath = null;
            measurementData = null;
            
            // Show modal with preview step
            updateTitle('Live Preview');
            showStep(stepPreview);
            showModal();
            
            // Disable capture button initially
            if (btnCapture) btnCapture.disabled = true;
            
            // Start camera
            startCamera();
        });
    }
    
    // Close Modal
    if (btnCloseModal) {
        btnCloseModal.addEventListener('click', hideModal);
    }
    
    // Cancel Preview
    if (btnCancelPreview) {
        btnCancelPreview.addEventListener('click', hideModal);
    }
    
    // Capture
    if (btnCapture) {
        btnCapture.addEventListener('click', capturePhoto);
    }
    
    // Retake
    if (btnRetake) {
        btnRetake.addEventListener('click', () => {
            updateTitle('Live Preview');
            showStep(stepPreview);
            if (btnCapture) btnCapture.disabled = true;
            startCamera();
        });
    }
    
    // Analyze
    if (btnAnalyze) {
        btnAnalyze.addEventListener('click', analyzePhoto);
    }
    
    // New Measurement
    if (btnNewMeasurement) {
        btnNewMeasurement.addEventListener('click', () => {
            capturedImagePath = null;
            measurementData = null;
            updateTitle('Live Preview');
            showStep(stepPreview);
            if (btnCapture) btnCapture.disabled = true;
            startCamera();
        });
    }
    
    // Save Result
    if (btnSaveResult) {
        btnSaveResult.addEventListener('click', saveToDatabase);
    }
    
    // Close on outside click
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                hideModal();
            }
        });
    }
    
    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            hideModal();
        }
    });
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        if (cameraStarted) {
            stopCamera();
        }
    });
    
    console.log(' Measurement handler initialized');
    
});