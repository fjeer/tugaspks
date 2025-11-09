<?php

function encryptText($plaintext, $key)
{
    if (empty($plaintext)) {
        return [
            "status" => "Error",
            "message" => "Plaintext tidak boleh kosong"
        ];
    }

    if (empty($key)) {
        return [
            "status" => "Error",
            "message" => "Key harus diisi untuk enkripsi"
        ];
    }

    $method = 'aes-256-gcm';
    if (!in_array($method, openssl_get_cipher_methods())) {
        return [
            "status" => "Error",
            "message" => "Method Enkripsi $method tidak didukung di server ini"
        ];
    }

    $ivlen = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $key_hashed = hash('sha256', $key, true);
    $tag = '';
    $option = 0;

    $start = microtime(true);
    $ciphertext = openssl_encrypt($plaintext, $method, $key_hashed, $option, $iv, $tag);
    $end = microtime(true);

    $orisize = strlen($plaintext);
    $ciphersize = strlen(base64_encode($iv . $tag .$ciphertext));
    $time = $end - $start;

    return [
        "status" => "Success",
        "method" => $method,
        "ciphertext" => base64_encode($iv . $tag . $ciphertext),
        "original_size" => $orisize . " bytes",
        "chiper_size" => $ciphersize . " bytes",
        "durasi" => number_format($time, 6) . " detik"
    ];
}

function decryptText($ciphertext, $key)
{
    if (empty($ciphertext)) {
        return [
            "status" => "Error",
            "message" => "Ciphertext tidak boleh kosong"
        ];
    }

    if (empty($key)) {
        return [
            "status" => "Error",
            "message" => "Key harus diisi untuk dekripsi"
        ];
    }

    $method = 'aes-256-gcm';
    if (!in_array($method, openssl_get_cipher_methods())) {
        return [
            "status" => "Error",
            "message" => "Method Enkripsi $method tidak didukung di server ini"
        ];
    }

    try {
        $data = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($method);
        $iv = substr($data, 0, $ivlen);
        $tag = substr($data, $ivlen, 16);
        $ciphertext_raw = substr($data, $ivlen + 16);

        $key_hashed = hash('sha256', $key, true);
        $option = 0;

        $start = microtime(true);
        $plaintext = openssl_decrypt($ciphertext_raw, $method, $key_hashed, $option, $iv, $tag);
        $end = microtime(true);

        if ($plaintext === false) {
            return [
                "status" => "Error",
                "message" => "Dekripsi gagal. Pastikan ciphertext dan key benar."
            ];
        }

        $orisize = strlen($ciphertext);
        $plaintextsize = strlen($plaintext);
        $time = $end - $start;

        return [
            "status" => "Success",
            "method" => $method,
            "plaintext" => $plaintext,
            "original_size" => $orisize . " bytes",
            "plaintext_size" => $plaintextsize . " bytes",
            "durasi" => number_format($time, 6) . " detik"
        ];
    } catch (Exception $e) {
        return [
            "status" => "Error",
            "message" => "Terjadi kesalahan: " . $e->getMessage()
        ];
    }
}

function encryptFile($file, $key)
{
    if (empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return [
            "status" => "Error",
            "message" => "File tidak valid atau gagal diupload"
        ];
    }

    if (empty($key)) {
        return [
            "status" => "Error",
            "message" => "Key harus diisi untuk enkripsi file"
        ];
    }

    $method = 'aes-256-gcm';
    if (!in_array($method, openssl_get_cipher_methods())) {
        return [
            "status" => "Error",
            "message" => "Method Enkripsi $method tidak didukung di server ini"
        ];
    }

    $ivlen = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $key_hashed = hash('sha256', $key, true);
    $tag = '';
    $option = 0;

    $fileContent = file_get_contents($file['tmp_name']);

    $start = microtime(true);
    $encryptedContent = openssl_encrypt($fileContent, $method, $key_hashed, $option, $iv, $tag);
    $end = microtime(true);

    if ($encryptedContent === false) {
        return [
            "status" => "Error",
            "message" => "Gagal mengenkripsi file"
        ];
    }

    // Gabungkan IV, tag, dan encrypted content
    $finalContent = $iv . $tag . $encryptedContent;

    $originalSize = $file['size'] / 1024;
    $encryptedSize = strlen($finalContent) / 1024;
    $time = $end - $start;

    // Simpan file terenkripsi
    $encryptedFilename = $file['name'] . '.enc';
    file_put_contents($encryptedFilename, $finalContent);

    return [
        "status" => "Success",
        "method" => $method,
        "original_filename" => $file['name'],
        "encrypted_filename" => $encryptedFilename,
        "original_size" => number_format($originalSize, 2) . " kb",
        "encrypted_size" => number_format($encryptedSize, 2) . " kb",
        "download_link" => $encryptedFilename,
        "durasi" => number_format($time, 6) . " detik"
    ];
}

function decryptFile($encryptedFile, $key)
{
    if (empty($encryptedFile) || $encryptedFile['error'] !== UPLOAD_ERR_OK) {
        return [
            "status" => "Error",
            "message" => "File terenkripsi tidak valid atau gagal diupload"
        ];
    }

    if (empty($key)) {
        return [
            "status" => "Error",
            "message" => "Key harus diisi untuk dekripsi file"
        ];
    }

    $method = 'aes-256-gcm';
    if (!in_array($method, openssl_get_cipher_methods())) {
        return [
            "status" => "Error",
            "message" => "Method Enkripsi $method tidak didukung di server ini"
        ];
    }

    try {
        $encryptedContent = file_get_contents($encryptedFile['tmp_name']);

        $ivlen = openssl_cipher_iv_length($method);
        $iv = substr($encryptedContent, 0, $ivlen);
        $tag = substr($encryptedContent, $ivlen, 16);
        $ciphertext = substr($encryptedContent, $ivlen + 16);

        $key_hashed = hash('sha256', $key, true);
        $option = 0;

        $start = microtime(true);
        $decryptedContent = openssl_decrypt($ciphertext, $method, $key_hashed, $option, $iv, $tag);
        $end = microtime(true);

        if ($decryptedContent === false) {
            return [
                "status" => "Error",
                "message" => "Dekripsi file gagal. Pastikan file dan key benar."
            ];
        }

        $encryptedSize = $encryptedFile['size'] / 1024;
        $decryptedSize = strlen($decryptedContent) / 1024;
        $time = $end - $start;

        // Ekstrak nama file asli (hapus .enc)
        $originalFilename = str_replace('.enc', '', $encryptedFile['name']);
        $decryptedFilename = 'decrypted_' . $originalFilename;

        // Simpan file terdekripsi
        file_put_contents($decryptedFilename, $decryptedContent);

        return [
            "status" => "Success",
            "method" => $method,
            "original_filename" => $originalFilename,
            "decrypted_filename" => $decryptedFilename,
            "encrypted_size" => number_format($encryptedSize, 2) . " kb",
            "decrypted_size" => number_format($decryptedSize, 2) . " kb",
            "download_link" => $decryptedFilename,
            "durasi" => number_format($time, 6) . " detik"
        ];
    } catch (Exception $e) {
        return [
            "status" => "Error",
            "message" => "Terjadi kesalahan: " . $e->getMessage()
        ];
    }
}

// Fungsi untuk generate key pair RSA
function generateRSAKeyPair($key_size, $key_name)
{
    // Validasi key size
    $valid_sizes = [1024, 2048, 4096];
    if (!in_array($key_size, $valid_sizes)) {
        return [
            "status" => "Error",
            "message" => "Key size tidak valid. Pilih 1024, 2048, atau 4096 bits."
        ];
    }

    // Generate key name jika tidak provided
    if (empty($key_name)) {
        $key_name = 'key_' . date('Ymd_His') . '_' . $key_size . 'bits';
    }

    $temp_dir = sys_get_temp_dir();
    $private_key_file = $temp_dir . '/private_' . uniqid() . '.pem';
    $public_key_file = $temp_dir . '/public_' . uniqid() . '.pem';

    // Generate private key
    $command = "openssl genrsa -out " . escapeshellarg($private_key_file) . " " . (int) $key_size . " 2>&1";
    exec($command, $output, $return_var);

    if ($return_var !== 0) {
        return [
            "status" => "Error",
            "message" => "Gagal generate private key: " . implode("\n", $output)
        ];
    }

    // Generate public key
    $command = "openssl rsa -pubout -in " . escapeshellarg($private_key_file) . " -out " . escapeshellarg($public_key_file) . " 2>&1";
    exec($command, $output, $return_var);

    if ($return_var !== 0) {
        unlink($private_key_file);
        return [
            "status" => "Error",
            "message" => "Gagal generate public key: " . implode("\n", $output)
        ];
    }

    // Read keys
    $private_key = file_get_contents($private_key_file);
    $public_key = file_get_contents($public_key_file);

    // Clean up temp files
    unlink($private_key_file);
    unlink($public_key_file);

    if ($private_key === false || $public_key === false) {
        return [
            "status" => "Error",
            "message" => "Gagal membaca generated keys"
        ];
    }

    // Save keys to files
    $keys_dir = 'keys/';
    if (!is_dir($keys_dir)) {
        mkdir($keys_dir, 0755, true);
    }

    $private_key_filename = $keys_dir . $key_name . '_private.pem';
    $public_key_filename = $keys_dir . $key_name . '_public.pem';

    file_put_contents($private_key_filename, $private_key);
    file_put_contents($public_key_filename, $public_key);

    return [
        "status" => "Success",
        "private_key" => $private_key,
        "public_key" => $public_key,
        "key_name" => $key_name,
        "key_size" => $key_size . " bits",
        "private_key_file" => $private_key_filename,
        "public_key_file" => $public_key_filename
    ];
}

// Fungsi untuk mendapatkan list keys yang tersedia
function getAvailableKeys()
{
    $keys_dir = 'keys/';
    if (!is_dir($keys_dir)) {
        return [];
    }

    $keys = [];
    $files = scandir($keys_dir);

    foreach ($files as $file) {
        if (preg_match('/(.+)_public\.pem$/', $file, $matches)) {
            $key_name = $matches[1];
            $public_key = file_get_contents($keys_dir . $file);
            $private_file = $keys_dir . $key_name . '_private.pem';

            if (file_exists($private_file)) {
                $private_key = file_get_contents($private_file);
                $key_info = openssl_pkey_get_details(openssl_pkey_get_private($private_key));
                $key_size = $key_info['bits'] ?? 'Unknown';

                $keys[] = [
                    'name' => $key_name,
                    'public_key' => $public_key,
                    'private_key' => $private_key,
                    'size' => $key_size
                ];
            }
        }
    }

    return $keys;
}

// Fungsi untuk encrypt hybrid (RSA + AES)
function encryptHybridText($plaintext, $public_key)
{
    if (empty($plaintext)) {
        return [
            "status" => "Error",
            "message" => "Plaintext tidak boleh kosong"
        ];
    }

    if (empty($public_key)) {
        return [
            "status" => "Error",
            "message" => "Public key harus diisi"
        ];
    }

    $start_total = microtime(true);

    // Generate random AES key
    $aes_key = openssl_random_pseudo_bytes(32); // 256 bit
    $method = 'aes-256-gcm';
    $ivlen = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $tag = '';

    // Encrypt data dengan AES
    $start_aes = microtime(true);
    $ciphertext = openssl_encrypt($plaintext, $method, $aes_key, OPENSSL_RAW_DATA, $iv, $tag);
    $end_aes = microtime(true);

    if ($ciphertext === false) {
        return [
            "status" => "Error",
            "message" => "Gagal mengenkripsi data dengan AES"
        ];
    }

    // Encrypt AES key dengan RSA public key
    $start_rsa = microtime(true);
    $encrypted_key = '';
    if (!openssl_public_encrypt($aes_key, $encrypted_key, $public_key)) {
        return [
            "status" => "Error",
            "message" => "Gagal mengenkripsi AES key dengan RSA"
        ];
    }
    $end_rsa = microtime(true);

    $end_total = microtime(true);

    // Gabungkan IV, tag, dan ciphertext untuk AES result
    $aes_final_data = base64_encode($iv) . ':' . base64_encode($tag) . ':' . base64_encode($ciphertext);

    $orisize = strlen($plaintext);
    $ciphersize = strlen($aes_final_data);
    $encrypted_key_size = strlen(base64_encode($encrypted_key));

    $aes_time = $end_aes - $start_aes;
    $rsa_time = $end_rsa - $start_rsa;
    $total_time = $end_total - $start_total;

    return [
        "status" => "Success",
        "method" => "RSA + AES-256-GCM",
        "encrypted" => $aes_final_data, // Hasil encrypt AES (IV:Tag:Ciphertext)
        "encrypted_key" => base64_encode($encrypted_key), // Hasil encrypt RSA (AES key yang diencrypt)
        "original_size" => $orisize . " bytes",
        "encrypted_size" => $ciphersize . " bytes",
        "encrypted_key_size" => $encrypted_key_size . " bytes",
        "aes_durasi" => number_format($aes_time, 6) . " detik",
        "rsa_durasi" => number_format($rsa_time, 6) . " detik",
        "total_durasi" => number_format($total_time, 6) . " detik"
    ];
}

// Fungsi untuk decrypt hybrid (RSA + AES)
function decryptHybridText($encrypted_data, $encrypted_key, $private_key)
{
    if (empty($encrypted_data)) {
        return [
            "status" => "Error",
            "message" => "Encrypted data tidak boleh kosong"
        ];
    }

    if (empty($encrypted_key)) {
        return [
            "status" => "Error",
            "message" => "Encrypted key tidak boleh kosong"
        ];
    }

    if (empty($private_key)) {
        return [
            "status" => "Error",
            "message" => "Private key harus diisi"
        ];
    }

    $start_total = microtime(true);

    try {
        // Pisahkan data AES (IV:Tag:Ciphertext)
        $parts = explode(':', $encrypted_data);
        if (count($parts) !== 3) {
            return [
                "status" => "Error",
                "message" => "Format encrypted data tidak valid. Harus: IV:Tag:Ciphertext"
            ];
        }

        list($iv_b64, $tag_b64, $ciphertext_b64) = $parts;

        $iv = base64_decode($iv_b64);
        $tag = base64_decode($tag_b64);
        $ciphertext_raw = base64_decode($ciphertext_b64);
        $encrypted_key_raw = base64_decode($encrypted_key);

        // Decrypt AES key dengan RSA private key
        $start_rsa = microtime(true);
        $aes_key = '';
        if (!openssl_private_decrypt($encrypted_key_raw, $aes_key, $private_key)) {
            return [
                "status" => "Error",
                "message" => "Gagal mendekripsi AES key dengan RSA. Pastikan private key benar."
            ];
        }
        $end_rsa = microtime(true);

        // Decrypt data dengan AES
        $start_aes = microtime(true);
        $method = 'aes-256-gcm';
        $plaintext = openssl_decrypt($ciphertext_raw, $method, $aes_key, OPENSSL_RAW_DATA, $iv, $tag);
        $end_aes = microtime(true);

        if ($plaintext === false) {
            return [
                "status" => "Error",
                "message" => "Gagal mendekripsi data dengan AES"
            ];
        }

        $end_total = microtime(true);

        $encrypted_size = strlen($encrypted_data);
        $plaintextsize = strlen($plaintext);

        $aes_time = $end_aes - $start_aes;
        $rsa_time = $end_rsa - $start_rsa;
        $total_time = $end_total - $start_total;

        return [
            "status" => "Success",
            "method" => "RSA + AES-256-GCM",
            "plaintext" => $plaintext,
            "encrypted_size" => $encrypted_size . " bytes",
            "plaintext_size" => $plaintextsize . " bytes",
            "aes_durasi" => number_format($aes_time, 6) . " detik",
            "rsa_durasi" => number_format($rsa_time, 6) . " detik",
            "total_durasi" => number_format($total_time, 6) . " detik"
        ];
    } catch (Exception $e) {
        return [
            "status" => "Error",
            "message" => "Terjadi kesalahan: " . $e->getMessage()
        ];
    }
}

// Fungsi untuk encrypt file hybrid
function encryptHybridFile($file, $public_key)
{
    if (empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return [
            "status" => "Error",
            "message" => "File tidak valid atau gagal diupload"
        ];
    }

    if (empty($public_key)) {
        return [
            "status" => "Error",
            "message" => "Public key harus diisi"
        ];
    }

    $start_total = microtime(true);

    // Generate random AES key
    $aes_key = openssl_random_pseudo_bytes(32);
    $method = 'aes-256-gcm';
    $ivlen = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $tag = '';

    $fileContent = file_get_contents($file['tmp_name']);

    // Encrypt file dengan AES
    $start_aes = microtime(true);
    $encryptedContent = openssl_encrypt($fileContent, $method, $aes_key, OPENSSL_RAW_DATA, $iv, $tag);
    $end_aes = microtime(true);

    if ($encryptedContent === false) {
        return [
            "status" => "Error",
            "message" => "Gagal mengenkripsi file dengan AES"
        ];
    }

    // Encrypt AES key dengan RSA
    $start_rsa = microtime(true);
    $encrypted_key = '';
    if (!openssl_public_encrypt($aes_key, $encrypted_key, $public_key)) {
        return [
            "status" => "Error",
            "message" => "Gagal mengenkripsi AES key dengan RSA"
        ];
    }
    $end_rsa = microtime(true);

    $end_total = microtime(true);

    // Gabungkan semua: encrypted_key + iv + tag + encrypted_content
    $finalContent = $encrypted_key . $iv . $tag . $encryptedContent;

    $originalSize = $file['size'] / 1024;
    $encryptedSize = strlen($finalContent) / 1024;
    $encryptedKeySize = strlen($encrypted_key) / 1024;

    $aes_time = $end_aes - $start_aes;
    $rsa_time = $end_rsa - $start_rsa;
    $total_time = $end_total - $start_total;

    // Simpan file terenkripsi
    $encryptedFilename = $file['name'] . '.enc';
    file_put_contents($encryptedFilename, $finalContent);

    return [
        "status" => "Success",
        "method" => "RSA + AES-256-GCM",
        "original_filename" => $file['name'],
        "encrypted_filename" => $encryptedFilename,
        "original_size" => number_format($originalSize, 2) . " kb",
        "encrypted_size" => number_format($encryptedSize, 2) . " kb",
        "encrypted_key_size" => number_format($encryptedKeySize, 2) . " kb",
        "download_link" => $encryptedFilename,
        "aes_durasi" => number_format($aes_time, 6) . " detik",
        "rsa_durasi" => number_format($rsa_time, 6) . " detik",
        "total_durasi" => number_format($total_time, 6) . " detik"
    ];
}

// Fungsi untuk decrypt file hybrid
function decryptHybridFile($encryptedFile, $private_key)
{
    if (empty($encryptedFile) || $encryptedFile['error'] !== UPLOAD_ERR_OK) {
        return [
            "status" => "Error",
            "message" => "File terenkripsi tidak valid atau gagal diupload"
        ];
    }

    if (empty($private_key)) {
        return [
            "status" => "Error",
            "message" => "Private key harus diisi"
        ];
    }

    $start_total = microtime(true);

    try {
        $encryptedContent = file_get_contents($encryptedFile['tmp_name']);

        if ($encryptedContent === false) {
            return [
                "status" => "Error",
                "message" => "Gagal membaca file terenkripsi"
            ];
        }

        // Tentukan key size berdasarkan private key
        $key_resource = openssl_pkey_get_private($private_key);
        if ($key_resource === false) {
            return [
                "status" => "Error",
                "message" => "Private key tidak valid"
            ];
        }

        $key_details = openssl_pkey_get_details($key_resource);
        $key_size_bits = $key_details['bits'];
        $key_size_bytes = $key_size_bits / 8; // RSA key size in bytes

        $method = 'aes-256-gcm';
        $ivlen = openssl_cipher_iv_length($method);
        $tag_length = 16;

        // Pisahkan data: encrypted_key + iv + tag + encrypted_content
        $encrypted_key = substr($encryptedContent, 0, $key_size_bytes);
        $iv = substr($encryptedContent, $key_size_bytes, $ivlen);
        $tag = substr($encryptedContent, $key_size_bytes + $ivlen, $tag_length);
        $ciphertext = substr($encryptedContent, $key_size_bytes + $ivlen + $tag_length);

        // Validasi panjang data
        if (strlen($encrypted_key) !== $key_size_bytes || strlen($iv) !== $ivlen || strlen($tag) !== $tag_length) {
            return [
                "status" => "Error",
                "message" => "Format file tidak valid. Pastikan file dienkripsi dengan sistem yang sama."
            ];
        }

        // Decrypt AES key dengan RSA
        $start_rsa = microtime(true);
        $aes_key = '';
        if (!openssl_private_decrypt($encrypted_key, $aes_key, $private_key)) {
            $error = openssl_error_string();
            return [
                "status" => "Error",
                "message" => "Gagal mendekripsi AES key dengan RSA. Pastikan private key benar. Error: " . $error
            ];
        }
        $end_rsa = microtime(true);

        // Decrypt file dengan AES
        $start_aes = microtime(true);
        $decryptedContent = openssl_decrypt($ciphertext, $method, $aes_key, OPENSSL_RAW_DATA, $iv, $tag);
        $end_aes = microtime(true);

        if ($decryptedContent === false) {
            return [
                "status" => "Error",
                "message" => "Gagal mendekripsi file dengan AES. Pastikan file tidak korup."
            ];
        }

        $end_total = microtime(true);

        $encryptedSize = $encryptedFile['size'] / 1024;
        $decryptedSize = strlen($decryptedContent) / 1024;

        $aes_time = $end_aes - $start_aes;
        $rsa_time = $end_rsa - $start_rsa;
        $total_time = $end_total - $start_total;

        // Ekstrak nama file asli (hapus .enc)
        $originalFilename = preg_replace('/\.enc$/', '', $encryptedFile['name']);
        $decryptedFilename = 'decrypted_' . $originalFilename;

        // Simpan file terdekripsi
        if (file_put_contents($decryptedFilename, $decryptedContent) === false) {
            return [
                "status" => "Error",
                "message" => "Gagal menyimpan file terdekripsi"
            ];
        }

        return [
            "status" => "Success",
            "method" => "RSA + AES-256-GCM",
            "original_filename" => $originalFilename,
            "decrypted_filename" => $decryptedFilename,
            "encrypted_size" => number_format($encryptedSize, 2) . " kb",
            "decrypted_size" => number_format($decryptedSize, 2) . " kb",
            "download_link" => $decryptedFilename,
            "aes_durasi" => number_format($aes_time, 6) . " detik",
            "rsa_durasi" => number_format($rsa_time, 6) . " detik",
            "total_durasi" => number_format($total_time, 6) . " detik"
        ];

    } catch (Exception $e) {
        return [
            "status" => "Error",
            "message" => "Terjadi kesalahan: " . $e->getMessage()
        ];
    }
}

// Main request handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $type = $_POST['type'] ?? '';
    $response = [];

    try {
        switch ($type) {
            case 'encrypt_text':
                $plaintext = $_POST['plaintext'] ?? '';
                $key = $_POST['key'] ?? '';
                $response = encryptText($plaintext, $key);
                break;

            case 'decrypt_text':
                $ciphertext = $_POST['ciphertext'] ?? '';
                $key = $_POST['key'] ?? '';
                $response = decryptText($ciphertext, $key);
                break;

            case 'encrypt_file':
                $key = $_POST['key'] ?? '';
                if (isset($_FILES['file'])) {
                    $response = encryptFile($_FILES['file'], $key);
                } else {
                    $response = [
                        "status" => "Error",
                        "message" => "File tidak ditemukan"
                    ];
                }
                break;

            case 'decrypt_file':
                $key = $_POST['key'] ?? '';
                if (isset($_FILES['encrypted_file'])) {
                    $response = decryptFile($_FILES['encrypted_file'], $key);
                } else {
                    $response = [
                        "status" => "Error",
                        "message" => "File terenkripsi tidak ditemukan"
                    ];
                }
                break;
            case 'get_available_keys':
                $keys = getAvailableKeys();
                $response = [
                    "status" => "Success",
                    "keys" => $keys
                ];
                break;

            case 'generate_key_pair':
                $key_size = $_POST['key_size'] ?? '';
                $key_name = $_POST['key_name'] ?? '';
                $response = generateRSAKeyPair($key_size, $key_name);
                break;

            case 'encrypt_hybrid_text':
                $plaintext = $_POST['plaintext'] ?? '';
                $public_key = $_POST['public_key'] ?? '';
                $response = encryptHybridText($plaintext, $public_key);
                break;

            case 'decrypt_hybrid_text':
                $encrypted_data = $_POST['encrypted_data'] ?? '';
                $encrypted_key = $_POST['encrypted_key'] ?? '';
                $private_key = $_POST['private_key'] ?? '';
                $response = decryptHybridText($encrypted_data, $encrypted_key, $private_key);
                break;

            case 'encrypt_hybrid_file':
                $public_key = $_POST['public_key'] ?? '';
                if (isset($_FILES['file'])) {
                    $response = encryptHybridFile($_FILES['file'], $public_key);
                } else {
                    $response = [
                        "status" => "Error",
                        "message" => "File tidak ditemukan"
                    ];
                }
                break;

            case 'decrypt_hybrid_file':
                $private_key = $_POST['private_key'] ?? '';
                if (isset($_FILES['encrypted_file'])) {
                    $response = decryptHybridFile($_FILES['encrypted_file'], $private_key);
                } else {
                    $response = [
                        "status" => "Error",
                        "message" => "File terenkripsi tidak ditemukan"
                    ];
                }
                break;

            default:
                $response = [
                    "status" => "Error",
                    "message" => "Tipe aksi tidak valid"
                ];
                break;
        }
    } catch (Exception $e) {
        $response = [
            "status" => "Error",
            "message" => "Terjadi kesalahan: " . $e->getMessage()
        ];
    }

    echo json_encode($response);
    exit;
}