<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tugas Kripto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3">

        <ul class="nav nav-tabs mb-4" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="aestext-tab" data-bs-toggle="tab" data-bs-target="#aestext"
                    type="button" role="tab" aria-controls="aestext" aria-selected="true">AES Text</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="aesfile-tab" data-bs-toggle="tab" data-bs-target="#aesfile" type="button"
                    role="tab" aria-controls="aesfile" aria-selected="false">AES File</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="hybridtext-tab" data-bs-toggle="tab" data-bs-target="#hybridtext"
                    type="button" role="tab" aria-controls="hybridtext" aria-selected="false">HYBRID Text</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="hybridfile-tab" data-bs-toggle="tab" data-bs-target="#hybridfile"
                    type="button" role="tab" aria-controls="hybridfile" aria-selected="false">HYBRID File</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="hybridkey-tab" data-bs-toggle="tab" data-bs-target="#hybridkey"
                    type="button" role="tab" aria-controls="hybridkey" aria-selected="false">Key Generate</button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Ini Tab AES Text -->
            <div class="tab-pane fade active show" id="aestext" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                Encrypt Text
                            </div>
                            <div class="card-body">
                                <form action="process.php" method="POST" id="encryptTextForm">
                                    <input type="hidden" name="type" value="encrypt_text">

                                    <div class="mb-3">
                                        <label for="" class="form-label">Plaintext</label>
                                        <textarea name="plaintext" id="" class="form-control" rows="4" required
                                            placeholder="Masukkan Text Untuk di Enkripsi..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Method</label>
                                        <input type="text" name="key" class="form-control" required disabled default
                                            value="AES-256-GCM">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Key</label>
                                        <input type="text" name="key" class="form-control" required
                                            placeholder="Masukkan Secrect Key...">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Encrypt Text</button>
                                </form>
                                <div id="encryptTextResult" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                Decrypt Text
                            </div>
                            <div class="card-body">
                                <form action="process.php" method="POST" id="decryptTextForm">
                                    <input type="hidden" name="type" value="decrypt_text">

                                    <div class="mb-3">
                                        <label for="" class="form-label">Ciphertext</label>
                                        <textarea name="ciphertext" id="" class="form-control" rows="4" required
                                            placeholder="Masukkan Ciphertext Untuk di Dekripsi..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Method</label>
                                        <input type="text" name="key" class="form-control" required disabled default
                                            value="AES-256-GCM">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Key</label>
                                        <input type="text" name="key" class="form-control" required
                                            placeholder="Masukkan Secrect Key...">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Decrypt Text</button>
                                </form>
                                <div id="decryptTextResult" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ini Tab AES File -->
            <div class="tab-pane fade" id="aesfile" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                Encrypt File
                            </div>
                            <div class="card-body">
                                <form action="process.php" method="POST" enctype="multipart/form-data"
                                    id="encryptFileForm">
                                    <input type="hidden" name="type" value="encrypt_file">

                                    <div class="mb-3">
                                        <label for="" class="form-label">Choose File</label>
                                        <input type="file" class="form-control" name="file" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-control">Method:</label>
                                        <input type="text" default value="AES-256-GCM" disabled class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Key</label>
                                        <input type="text" name="key" class="form-control" required
                                            placeholder="Masukkan Secrect Key...">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Encrypt File</button>
                                </form>
                                <div id="encryptFileResult" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                Decrypt File
                            </div>
                            <div class="card-body">
                                <form action="process.php" method="POST" id="decryptFormFile">
                                    <input type="hidden" name="type" value="decrypt_file">

                                    <div class="mb-3">
                                        <label for="" class="form-label">
                                            Encrypted File
                                        </label>
                                        <input type="file" class="form-control" name="encrypted_file" accept=".enc"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">
                                            Method
                                        </label>
                                        <input type="text" default value="AES-256-GCM" disabled class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">
                                            Key
                                        </label>
                                        <input type="text" name="key" class="form-control" required
                                            placeholder="Masukkan Secret Key...">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Decrypt File</button>
                                </form>
                                <div id="decryptFileResult" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ini Tab HYBRID Text -->
            <div class="tab-pane fade" id="hybridtext" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                Encrypt Text
                            </div>
                            <div class="card-body">
                                <form id="encryptHybridTextForm">
                                    <input type="hidden" name="type" value="encrypt_hybrid_text">

                                    <div class="mb-3">
                                        <label for="" class="form-label">Plaintext</label>
                                        <textarea name="plaintext" class="form-control" rows="4" required
                                            placeholder="Masukkan Text Untuk di Enkripsi..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Public Key</label>
                                        <select name="public_key_select_text" id="public_key_select_text"
                                            class="form-select mb-2">
                                            <option value="">-- Pilih Key yang tersedia --</option>
                                        </select>
                                        <textarea name="public_key" class="form-control" rows="4" required
                                            placeholder="Masukkan RSA Public Key... atau pilih dari dropdown di atas"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Encrypt Text</button>
                                </form>
                                <div id="encryptHybridTextResult" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                Decrypt Text
                            </div>
                            <div class="card-body">
                                <form id="decryptHybridTextForm">
                                    <input type="hidden" name="type" value="decrypt_hybrid_text">

                                    <div class="mb-3">
                                        <label for="" class="form-label">Encrypted Data</label>
                                        <textarea name="encrypted_data" class="form-control" rows="4" required
                                            placeholder="Masukkan encrypted data (Ciphertext)..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Private Key</label>
                                        <select name="private_key_select_text" id="private_key_select_text"
                                            class="form-select mb-2">
                                            <option value="">-- Pilih Key yang tersedia --</option>
                                        </select>
                                        <textarea name="private_key" class="form-control" rows="4" required
                                            placeholder="Masukkan RSA Private Key... atau pilih dari dropdown di atas"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Encrypted Key</label>
                                        <textarea name="encrypted_key" class="form-control" rows="4" required
                                            placeholder="Masukkan encrypted AES key..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Decrypt Text</button>
                                </form>
                                <div id="decryptHybridTextResult" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ini Tab HYBRID File -->
            <div class="tab-pane fade" id="hybridfile" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                Encrypt File
                            </div>
                            <div class="card-body">
                                <form id="encryptHybridFileForm" enctype="multipart/form-data">
                                    <input type="hidden" name="type" value="encrypt_hybrid_file">

                                    <div class="mb-3">
                                        <label for="" class="form-label">Choose File</label>
                                        <input type="file" class="form-control" name="file" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Public Key</label>
                                        <select name="public_key_select_file" id="public_key_select_file"
                                            class="form-select mb-2">
                                            <option value="">-- Pilih Key yang tersedia --</option>
                                        </select>
                                        <textarea name="public_key" class="form-control" rows="4" required
                                            placeholder="Masukkan RSA Public Key... atau pilih dari dropdown di atas"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Encrypt File</button>
                                </form>
                                <div id="encryptHybridFileResult" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                Decrypt File
                            </div>
                            <div class="card-body">
                                <form id="decryptHybridFileForm" enctype="multipart/form-data">
                                    <input type="hidden" name="type" value="decrypt_hybrid_file">

                                    <div class="mb-3">
                                        <label for="" class="form-label">Encrypted File</label>
                                        <input type="file" class="form-control" name="encrypted_file" accept=".enc"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Private Key</label>
                                        <select name="private_key_select_file" id="private_key_select_file"
                                            class="form-select mb-2">
                                            <option value="">-- Pilih Key yang tersedia --</option>
                                        </select>
                                        <textarea name="private_key" class="form-control" rows="4" required
                                            placeholder="Masukkan RSA Private Key... atau pilih dari dropdown di atas"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Decrypt File</button>
                                </form>
                                <div id="decryptHybridFileResult" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ini Tab KEY GENERATE -->
            <div class="tab-pane fade" id="hybridkey" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                Generate RSA Key Pair
                            </div>
                            <div class="card-body">
                                <form id="generateKeyForm">
                                    <input type="hidden" name="type" value="generate_key_pair">

                                    <div class="mb-3">
                                        <label for="key_name" class="form-label">Nama Key (Opsional)</label>
                                        <input type="text" name="key_name" id="key_name" class="form-control"
                                            placeholder="Contoh: my_key_2024">
                                        <div class="form-text">Jika dikosongkan, akan generate nama otomatis</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="key_size" class="form-label">Pilih Key Size</label>
                                        <select name="key_size" id="key_size" class="form-select" required>
                                            <option value="1024">1024 bits</option>
                                            <option value="2048" selected>2048 bits</option>
                                            <option value="4096">4096 bits</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Generate Key Pair</button>
                                </form>
                                <div id="generateKeyResult" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <!-- List Available Keys -->
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                Available Keys
                            </div>
                            <div class="card-body">
                                <div id="availableKeysList"></div>
                                <button type="button" id="refreshKeysBtn" class="btn btn-sm btn-secondary mt-2">
                                    Refresh List
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Fungsi untuk menampilkan hasil
            function showResult(container, data) {
                if (data.status === "Error") {
                    container.html('<div class="alert alert-danger">' + data.message + '</div>');
                } else {
                    let html = '<div class="alert alert-success">';
                    html += '<h6>Hasil Berhasil!</h6>';

                    if (data.ciphertext) {
                        html += '<p><strong>Ciphertext:</strong><br><textarea class="form-control mt-2" rows="3" readonly>' + data.ciphertext + '</textarea></p>';
                    }
                    if (data.plaintext) {
                        html += '<p><strong>Plaintext:</strong><br><textarea class="form-control mt-2" rows="3" readonly>' + data.plaintext + '</textarea></p>';
                    }
                    if (data.method) {
                        html += '<p><strong>Method:</strong> ' + data.method + '</p>';
                    }
                    if (data.original_size) {
                        html += '<p><strong>Original Size:</strong> ' + data.original_size + '</p>';
                    }
                    if (data.chiper_size) {
                        html += '<p><strong>Cipher Size:</strong> ' + data.chiper_size + '</p>';
                    }
                    if (data.plaintext_size) {
                        html += '<p><strong>Plaintext Size:</strong> ' + data.plaintext_size + '</p>';
                    }
                    if (data.encrypted_size) {
                        html += '<p><strong>Encrypted Size:</strong> ' + data.encrypted_size + '</p>';
                    }
                    if (data.decrypted_size) {
                        html += '<p><strong>Decrypted Size:</strong> ' + data.decrypted_size + '</p>';
                    }
                    if (data.download_link) {
                        html += '<p><strong>Download:</strong> <a href="' + data.download_link + '" download class="btn btn-sm btn-success">Download File</a></p>';
                    }
                    if (data.durasi) {
                        html += '<p><strong>Durasi:</strong> ' + data.durasi + '</p>';
                    }

                    // Tambahkan tombol close manual
                    html += '<button type="button" class="btn-close float-end" aria-label="Close"></button>';
                    html += '</div>';
                    container.html(html);
                }
            }

            // Fungsi untuk menampilkan loading
            function showLoading(container) {
                container.html('<div class="alert alert-info">Memproses... Harap tunggu</div>');
            }

            // Encrypt Text Form
            $('#encryptTextForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const resultContainer = $('#encryptTextResult');

                showLoading(resultContainer);

                $.ajax({
                    url:'./process.php',
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        showResult(resultContainer, data);
                    },
                    error: function (xhr, status, error) {
                        resultContainer.html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
                    }
                });
            });

            // Decrypt Text Form
            $('#decryptTextForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const resultContainer = $('#decryptTextResult');

                showLoading(resultContainer);

                $.ajax({
                    url:'./process.php',
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        showResult(resultContainer, data);
                    },
                    error: function (xhr, status, error) {
                        resultContainer.html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
                    }
                });
            });

            // Encrypt File Form
            $('#encryptFileForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const resultContainer = $('#encryptFileResult');
                const formData = new FormData(this);

                // Validasi file terpilih
                const fileInput = form.find('input[name="file"]')[0];
                if (!fileInput.files.length) {
                    resultContainer.html('<div class="alert alert-danger">Pilih file terlebih dahulu</div>');
                    return;
                }

                showLoading(resultContainer);

                $.ajax({
                    url:'./process.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        showResult(resultContainer, data);
                    },
                    error: function (xhr, status, error) {
                        resultContainer.html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
                    }
                });
            });

            // Decrypt File Form
            $('#decryptFormFile').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const resultContainer = $('#decryptFileResult');
                const formData = new FormData(this);

                // Validasi file terpilih
                const fileInput = form.find('input[name="encrypted_file"]')[0];
                if (!fileInput.files.length) {
                    resultContainer.html('<div class="alert alert-danger">Pilih file terenkripsi terlebih dahulu</div>');
                    return;
                }

                showLoading(resultContainer);

                $.ajax({
                    url:'./process.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        showResult(resultContainer, data);
                    },
                    error: function (xhr, status, error) {
                        resultContainer.html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
                    }
                });
            });

            // Hapus event clear results ketika switching tabs
            // $('.nav-tabs button').on('click', function() {
            //     $('.tab-content .alert').remove();
            // });

            // Event untuk menutup alert manual dengan tombol close
            $(document).on('click', '.alert .btn-close', function () {
                $(this).closest('.alert').fadeOut(300, function () {
                    $(this).remove();
                });
            });

            // Optional: Auto-hide error messages setelah 15 detik (bukan success messages)
            setInterval(function () {
                $('.alert-danger').fadeOut(1000, function () {
                    $(this).remove();
                });
            }, 15000);

            // Event untuk menjaga hasil tetap ada ketika berpindah tab
            $('.nav-tabs button').on('click', function () {
                // Hanya sembunyikan alert loading, biarkan hasil tetap ada
                $('.alert-info').remove();
            });

            // Generate Key Pair Form
            $('#generateKeyForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const resultContainer = $('#generateKeyResult');

                showLoading(resultContainer);

                $.ajax({
                    url:'./process.php',
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === "Error") {
                            resultContainer.html('<div class="alert alert-danger">' + data.message + '</div>');
                        } else {
                            let html = '<div class="alert alert-success">';
                            html += '<h6>Key Pair Berhasil Digenerate!</h6>';
                            html += '<p><strong>Key Size:</strong> ' + data.key_size + '</p>';

                            html += '<p><strong>Public Key:</strong><br><textarea class="form-control mt-2" rows="6" readonly>' + data.public_key + '</textarea></p>';
                            html += '<p><strong>Private Key:</strong><br><textarea class="form-control mt-2" rows="8" readonly>' + data.private_key + '</textarea></p>';

                            html += '<div class="alert alert-warning mt-3">';
                            html += '<strong>Peringatan:</strong> Simpan private key dengan aman dan jangan bagikan kepada siapapun!';
                            html += '</div>';

                            html += '<button type="button" class="btn-close float-end" aria-label="Close"></button>';
                            html += '</div>';
                            resultContainer.html(html);
                        }
                    },
                    error: function (xhr, status, error) {
                        resultContainer.html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
                    }
                });
            });

            // Encrypt Hybrid Text Form
            $('#encryptHybridTextForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const resultContainer = $('#encryptHybridTextResult');

                showLoading(resultContainer);

                $.ajax({
                    url:'./process.php',
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        showHybridResult(resultContainer, data);
                    },
                    error: function (xhr, status, error) {
                        resultContainer.html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
                    }
                });
            });

            // Decrypt Hybrid Text Form
            $('#decryptHybridTextForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const resultContainer = $('#decryptHybridTextResult');

                showLoading(resultContainer);

                $.ajax({
                    url:'./process.php',
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        showHybridResult(resultContainer, data);
                    },
                    error: function (xhr, status, error) {
                        resultContainer.html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
                    }
                });
            });

            // Encrypt Hybrid File Form
            $('#encryptHybridFileForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const resultContainer = $('#encryptHybridFileResult');
                const formData = new FormData(this);

                const fileInput = form.find('input[name="file"]')[0];
                if (!fileInput.files.length) {
                    resultContainer.html('<div class="alert alert-danger">Pilih file terlebih dahulu</div>');
                    return;
                }

                showLoading(resultContainer);

                $.ajax({
                    url:'./process.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        showHybridResult(resultContainer, data);
                    },
                    error: function (xhr, status, error) {
                        resultContainer.html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
                    }
                });
            });

            // Decrypt Hybrid File Form
            $('#decryptHybridFileForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const resultContainer = $('#decryptHybridFileResult');
                const formData = new FormData(this);

                const fileInput = form.find('input[name="encrypted_file"]')[0];
                if (!fileInput.files.length) {
                    resultContainer.html('<div class="alert alert-danger">Pilih file terenkripsi terlebih dahulu</div>');
                    return;
                }

                showLoading(resultContainer);

                $.ajax({
                    url:'./process.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        showHybridResult(resultContainer, data);
                    },
                    error: function (xhr, status, error) {
                        resultContainer.html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
                    }
                });
            });

            // Function to load available keys
            function loadAvailableKeys() {
                $.ajax({
                    url:'./process.php',
                    type: 'POST',
                    data: { type: 'get_available_keys' },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === "Success") {
                            updateKeyDropdowns(data.keys);

                            // Update available keys list di tab generate key
                            let keysListHtml = '';
                            if (data.keys.length > 0) {
                                keysListHtml = '<div class="list-group">';
                                data.keys.forEach(function (key) {
                                    keysListHtml += '<div class="list-group-item">';
                                    keysListHtml += '<strong>' + key.name + '</strong> (' + key.size + ' bits)<br>';
                                    keysListHtml += '<small class="text-muted">Public: ' + key.public_key.substring(0, 50) + '...</small>';
                                    keysListHtml += '</div>';
                                });
                                keysListHtml += '</div>';
                            } else {
                                keysListHtml = '<p class="text-muted">Belum ada key yang digenerate.</p>';
                            }
                            $('#availableKeysList').html(keysListHtml);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error loading keys:', error);
                    }
                });
            }

            // Function to update key dropdowns
            function updateKeyDropdowns(keys) {
                // Semua dropdown public key
                const publicSelects = [
                    '#public_key_select_text',
                    '#public_key_select_file'
                ];

                // Semua dropdown private key
                const privateSelects = [
                    '#private_key_select_text',
                    '#private_key_select_file'
                ];

                // Update semua public key dropdowns
                publicSelects.forEach(function (selector) {
                    const select = $(selector);
                    select.find('option:not(:first)').remove();

                    keys.forEach(function (key) {
                        const optionText = key.name + ' (' + key.size + ' bits)';
                        select.append('<option value="' + key.public_key + '">' + optionText + ' - Public</option>');
                    });
                });

                // Update semua private key dropdowns
                privateSelects.forEach(function (selector) {
                    const select = $(selector);
                    select.find('option:not(:first)').remove();

                    keys.forEach(function (key) {
                        const optionText = key.name + ' (' + key.size + ' bits)';
                        select.append('<option value="' + key.private_key + '">' + optionText + ' - Private</option>');
                    });
                });
            }

            // Event handlers untuk semua dropdown public key
            $('#public_key_select_text, #public_key_select_file').on('change', function () {
                const selectedKey = $(this).val();
                if (selectedKey) {
                    // Update textarea di form yang sesuai
                    const form = $(this).closest('form');
                    form.find('textarea[name="public_key"]').val(selectedKey);
                }
            });

            // Event handlers untuk semua dropdown private key  
            $('#private_key_select_text, #private_key_select_file').on('change', function () {
                const selectedKey = $(this).val();
                if (selectedKey) {
                    // Update textarea di form yang sesuai
                    const form = $(this).closest('form');
                    form.find('textarea[name="private_key"]').val(selectedKey);
                }
            });

            // Load keys ketika tab hybrid di-click
            $('#hybridtext-tab, #hybridfile-tab').on('click', function () {
                loadAvailableKeys();
            });

            // Juga load keys ketika page pertama kali load
            $(document).ready(function () {
                loadAvailableKeys();
            });

            // Fungsi khusus untuk menampilkan hasil hybrid
            function showHybridResult(container, data) {
                if (data.status === "Error") {
                    container.html('<div class="alert alert-danger">' + data.message + '</div>');
                } else {
                    let html = '<div class="alert alert-success">';
                    html += '<h6>Hasil Berhasil!</h6>';

                    if (data.ciphertext) {
                        html += '<p><strong>Ciphertext:</strong><br><textarea class="form-control mt-2" rows="3" readonly>' + data.ciphertext + '</textarea></p>';
                    }
                    if (data.plaintext) {
                        html += '<p><strong>Plaintext:</strong><br><textarea class="form-control mt-2" rows="3" readonly>' + data.plaintext + '</textarea></p>';
                    }
                    if (data.method) {
                        html += '<p><strong>Method:</strong> ' + data.method + '</p>';
                    }
                    // Dalam function showHybridResult, update tampilan:
                    if (data.encrypted) {
                        html += '<p><strong>Encrypted Data:</strong><br><textarea class="form-control mt-2" rows="3" readonly>' + data.encrypted + '</textarea></p>';
                    }
                    if (data.encrypted_key) {
                        html += '<p><strong>Encrypted Key:</strong><br><textarea class="form-control mt-2" rows="3" readonly>' + data.encrypted_key + '</textarea></p>';
                    }
                    if (data.encrypted_key_size) {
                        html += '<p><strong>Encrypted Key Size:</strong> ' + data.encrypted_key_size + '</p>';
                    }
                    if (data.download_key_link) {
                        html += '<p><strong>Download Encrypted Key:</strong> <a href="' + data.download_key_link + '" download class="btn btn-sm btn-warning">Download Key File</a></p>';
                    }
                    if (data.encrypted_aes_key) {
                        html += '<p><strong>Encrypted AES Key:</strong><br><textarea class="form-control mt-2" rows="3" readonly>' + data.encrypted_aes_key + '</textarea></p>';
                        html += '<div class="alert alert-info mt-2">';
                        html += '<strong>Info:</strong> Simpan encrypted key ini bersama ciphertext untuk proses dekripsi.';
                        html += '</div>';
                    }
                    if (data.original_size) {
                        html += '<p><strong>Original Size:</strong> ' + data.original_size + '</p>';
                    }
                    if (data.chiper_size) {
                        html += '<p><strong>Cipher Size:</strong> ' + data.chiper_size + '</p>';
                    }
                    if (data.plaintext_size) {
                        html += '<p><strong>Plaintext Size:</strong> ' + data.plaintext_size + '</p>';
                    }
                    if (data.encrypted_size) {
                        html += '<p><strong>Encrypted Size:</strong> ' + data.encrypted_size + '</p>';
                    }
                    if (data.decrypted_size) {
                        html += '<p><strong>Decrypted Size:</strong> ' + data.decrypted_size + '</p>';
                    }
                    if (data.download_link) {
                        html += '<p><strong>Download:</strong> <a href="' + data.download_link + '" download class="btn btn-sm btn-success">Download File</a></p>';
                    }

                    // Durasi khusus hybrid
                    if (data.aes_durasi) {
                        html += '<p><strong>AES Duration:</strong> ' + data.aes_durasi + '</p>';
                    }
                    if (data.rsa_durasi) {
                        html += '<p><strong>RSA Duration:</strong> ' + data.rsa_durasi + '</p>';
                    }
                    if (data.total_durasi) {
                        html += '<p><strong>Total Duration:</strong> ' + data.total_durasi + '</p>';
                    } else if (data.durasi) {
                        html += '<p><strong>Duration:</strong> ' + data.durasi + '</p>';
                    }

                    html += '<button type="button" class="btn-close float-end" aria-label="Close"></button>';
                    html += '</div>';
                    container.html(html);
                }
            }
        });
    </script>
</body>

</html>