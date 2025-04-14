<?php
/**
 * Plugin Name: Data Desa
 * Description: Plugin custom untuk website desa.
 * Version: 1.0
 * Author: Quarnyx
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

function datadesa()
{
    add_menu_page(
        'Anggaran Desa',             // Page title
        'Anggaran Desa',             // Menu title di sidebar
        'manage_options',            // Capability
        'anggaran-desa',             // Slug utama
        'anggaran_desa_dashboard',   // Callback function
        'dashicons-chart-pie',       // Icon
        25                           // Position
    );
    // Submenu: Pendapatan
    add_submenu_page(
        'anggaran-desa',
        'Anggaran Pendapatan',
        'Pendapatan',
        'manage_options',
        'anggaran-pendapatan',
        'anggaran_desa_pendapatan'
    );

    // Submenu: Belanja
    add_submenu_page(
        'anggaran-desa',
        'Anggaran Belanja',
        'Belanja',
        'manage_options',
        'anggaran-belanja',
        'anggaran_desa_belanja'
    );

    // Submenu: Pembangunan
    add_submenu_page(
        'anggaran-desa',
        'Anggaran Pembangunan',
        'Pembangunan',
        'manage_options',
        'anggaran-pembangunan',
        'anggaran_desa_pembangunan'
    );
}
add_action('admin_menu', 'datadesa');

function datadesa_styles($hook)
{
    if (strpos($hook, 'anggaran-desa') === false) {
        return;
    }

    // Load Bootstrap via CDN
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3'
    );

    // Optional: Bootstrap JS kalau kamu butuh fitur seperti modal/toast
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.3',
        true
    );
}
add_action('admin_enqueue_scripts', 'datadesa_styles');



function anggaran_desa_dashboard()
{
    global $wpdb;

    if (isset($_POST['submit'])) {
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);

        $table_name = $wpdb->prefix . 'custom_data';

        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'email' => $email
            ),
            array('%s', '%s')
        );

        echo '<div class="alert alert-success">Data berhasil disimpan!</div>';
    }
    ?>
    <div class="row">
        <h1 class="text-center">Data Desa</h1>
    </div>
    <div class="wrap">
        <div class="container mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title mb-4">Form Input Data</h2>
                    <form method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function anggaran_desa_pendapatan()
{
    global $wpdb;
    if (isset($_POST['submit'])) {
        $tahun_anggaran = sanitize_text_field($_POST['tahun_anggaran']);
        $jumlah_pendapatan = sanitize_text_field($_POST['jumlah_pendapatan']);
        $pendapatan_asli = sanitize_text_field($_POST['pendapatan_asli']);
        $pendapatan_transfer = sanitize_text_field($_POST['pendapatan_transfer']);
        $dana_desa = sanitize_text_field($_POST['dana_desa']);
        $alokasi_dana = sanitize_text_field($_POST['alokasi_dana']);
        $bagi_hasil = sanitize_text_field($_POST['bagi_hasil']);
        $bantuan_keuangan = sanitize_text_field($_POST['bantuan_keuangan']);

        $table_name = $wpdb->prefix . 'pendapatan_desa';

        $data = [
            'Pendapatan Asli Desa' => $pendapatan_asli,
            'Pendapatan Transfer Desa' => $pendapatan_transfer,
            'Dana Desa' => $dana_desa,
            'Alokasi Dana Desa' => $alokasi_dana,
            'Bagi Hasil Desa' => $bagi_hasil,
            'Bantuan Keuangan Desa' => $bantuan_keuangan,
            'Tahun Anggaran' => $tahun_anggaran,
            'Jumlah Pendapatan' => $jumlah_pendapatan
        ];

        foreach ($data as $jenis => $jumlah) {
            $wpdb->insert($table_name, [
                'jenis_pendapatan' => $jenis,
                'jumlah' => $jumlah,
                'tahun_anggaran' => $tahun_anggaran
            ]);
        }
        if (!$wpdb->insert_id) {
            echo '<div class="alert alert-danger">Data gagal disimpan!</div>';
            echo $wpdb->last_error;
            return;
        }

        echo '<div class="alert alert-success">Data berhasil disimpan!</div>';
    }
    ?>
    <div class="wrap">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: none; padding: 0%;">
                        <h5 class="card-header">Featured</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Anggaran Pendapatan Desa</h3>
                                    <p>Isi atau tampilkan data pendapatan desa di sini.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post">
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Tahun Anggaran</label>
                                                <input type="number" class="form-control" placeholder="Tahun Anggaran"
                                                    name="tahun_anggaran">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Jumlah Pendapatan Desa</label>
                                                <input type="text" class="form-control" placeholder="Jumlah Pendapatan Desa"
                                                    name="jumlah_pendapatan">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Pendapatan Asli Desa</label>
                                                <input type="number" class="form-control" placeholder="Tahun Anggaran"
                                                    name="pendapatan_asli">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Pendapatan Transfer</label>
                                                <input type="text" class="form-control" placeholder="Jumlah Pendapatan Desa"
                                                    name="pendapatan_transfer">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Dana Desa</label>
                                                <input type="number" class="form-control" placeholder="Dana Desa"
                                                    name="dana_desa">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Alokasi Dana Desa</label>
                                                <input type="text" class="form-control" placeholder="Alokasi Dana Desa"
                                                    name="alokasi_dana">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Bagi Hasil Pajak dna Retribusi</label>
                                                <input type="number" class="form-control"
                                                    placeholder="Bagi Hasil Pajak dna Retribusi" name="bagi_hasil">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Bantuan Keuangan Provinsi</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Bantuan Keuangan Provinsi" name="bantuan_keuangan">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card" style="padding: 0; max-width: none;">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tahun Anggaran</th>
                                        <th>Jenis Pendapatan</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $table_name = $wpdb->prefix . 'pendapatan_desa';
                                    $results = $wpdb->get_results("SELECT * FROM $table_name");
                                    foreach ($results as $result) {
                                        echo '<tr>';
                                        echo '<td>' . $result->tahun_anggaran . '</td>';
                                        echo '<td>' . $result->jenis_pendapatan . '</td>';
                                        echo '<td>' . "Rp. " . number_format($result->jumlah, 0, ',', '.') . '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

}

function anggaran_desa_belanja()
{
    echo '<div class="wrap"><h1>Anggaran Belanja</h1><p>Isi atau tampilkan data belanja desa di sini.</p></div>';
}

function anggaran_desa_pembangunan()
{
    echo '<div class="wrap"><h1>Anggaran Pembangunan</h1><p>Isi atau tampilkan data pembangunan desa di sini.</p></div>';
}


function create_custom_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_custom_table');
