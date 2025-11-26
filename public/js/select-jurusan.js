const JurusanAndProdiList = [{
    "jurusan": "Akuntansi",
    "prodi": [
        "Keuangan dan Perbankan Syariah",
        "Akuntansi Keuangan",
        "Keuangan dan Perbankan",
        "Manajemen Keuangan"
    ]
}, {
    "jurusan": "Administrasi Niaga",
    "prodi": [
        "Usaha Jasa Konvensi, Perjalanan Insentif dan Pameran / MICE",
        "Administrasi Bisnis Terapan",
    ]
}, {
    "jurusan": "Teknik Grafika & Penerbitan",
    "prodi": [
        "Teknologi Industri Cetak dan Kemasan",
        "Desain Grafis"
    ]
}, {
    "jurusan": "Teknik Sipil",
    "prodi": [
        "Teknik Perancangan Jalan dan Jembatan",
        "Teknik Perancangan Jalan dan Jembatan - Konsentrasi Jalan Tol",
        "Teknik Konstruksi Gedung"
    ]
}, {
    "jurusan": "Teknik Mesin",
    "prodi": [
        "Manufaktur",
        "Pembangkit Tenaga Listrik",
        "Manufaktur - PSDKU Pekalongan"
    ]
}, {
    "jurusan": "Teknik Elektro",
    "prodi": [
        "Instrumentasi dan Kontrol Industri",
        "Broadband Multimedia",
        "Teknik Otomasi Listrik Industri"
    ]
}, {
    "jurusan": "Teknik Informatika dan Komputer",
    "prodi": [
        "Teknik Informatika",
        "Teknik Multimedia dan Jaringan",
        "Teknik Multimedia Digital"
    ]
}];

const jurusanSelect = document.getElementById('jurusan');
const prodiSelect = document.getElementById('prodi');
prodiSelect.disabled = true;

// Inisialisasi Select Box
jurusanSelect.innerHTML = '<option value="">Pilih Jurusan</option>';
prodiSelect.innerHTML = '<option value="">Pilih jurusan terlebih dahulu!</option>';

// Fungsi untuk mengisi opsi Program Studi
function setProdi(selectedJurusan) {
    const selectedJurusanData = JurusanAndProdiList.find(item => item.jurusan === selectedJurusan);
    prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';

    if (selectedJurusanData && selectedJurusanData.prodi) {
        prodiSelect.disabled = false;
        selectedJurusanData.prodi.forEach(prodi => {
            const option = document.createElement('option');
            option.value = prodi;
            option.textContent = prodi;
            prodiSelect.appendChild(option);
        });
    } else {
        prodiSelect.disabled = true;
        prodiSelect.innerHTML = '<option value="">Pilih jurusan terlebih dahulu!</option>';
    }
}

// Fungsi untuk set Jurusan awal (dari PHP) dan mengisi Prodi
function setInitialJurusan(jurusanValue) {
    if (jurusanValue) {
        jurusanSelect.value = jurusanValue;
        setProdi(jurusanValue);
    }
}

// Fungsi untuk set nilai Prodi akhir (dari PHP)
function setProdiValue(prodiValue) {
    if (prodiValue) {
        prodiSelect.value = prodiValue;
    }
}

// Isi Opsi Jurusan saat load
JurusanAndProdiList.forEach(data => {
    const option = document.createElement('option');
    option.value = data.jurusan;
    option.textContent = data.jurusan;
    jurusanSelect.appendChild(option);
});

// Event Listener untuk Jurusan
jurusanSelect.addEventListener('change', function() {
    const selectedJurusan = this.value;
    if (selectedJurusan) {
        setProdi(selectedJurusan);
    } else {
        prodiSelect.disabled = true;
        prodiSelect.innerHTML = '<option value="">Pilih jurusan terlebih dahulu!</option>';
    }
});

