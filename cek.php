<?php
echo "<h1>Cek Isi Folder web_7</h1>";
echo "<h2>Lokasi: " . __DIR__ . "</h2>";

echo "<h3>Isi Folder Utama:</h3>";
echo "<pre>";
print_r(scandir(__DIR__));
echo "</pre>";

echo "<h3>Apakah folder 'includes' ada?</h3>";
if (is_dir(__DIR__ . '/includes')) {
    echo "<p style='color:green'>✅ Folder 'includes' ADA</p>";
    echo "<h3>Isi Folder 'includes':</h3>";
    echo "<pre>";
    print_r(scandir(__DIR__ . '/includes'));
    echo "</pre>";
} else {
    echo "<p style='color:red'>❌ Folder 'includes' TIDAK ADA</p>";
}

echo "<h3>Apakah file 'includes/functions.php' ada?</h3>";
$path = __DIR__ . '/includes/functions.php';
if (file_exists($path)) {
    echo "<p style='color:green'>✅ File ADA</p>";
    echo "<p>Ukuran: " . filesize($path) . " bytes</p>";
} else {
    echo "<p style='color:red'>❌ File TIDAK ADA di: $path</p>";
}