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
        'Data Desa',             // Page title
        'Data Desa',             // Menu title di sidebar
        'manage_options',            // Capability
        'data-desa',             // Slug utama
        'anggaran_desa_dashboard',   // Callback function
        'dashicons-chart-pie',       // Icon
        25                           // Position
    );
    // Submenu: Pendapatan
    add_submenu_page(
        'data-desa',
        'Anggaran Pendapatan',
        'Pendapatan',
        'manage_options',
        'anggaran-pendapatan',
        'anggaran_desa_pendapatan'
    );

    // Submenu: Belanja
    add_submenu_page(
        'data-desa',
        'Anggaran Belanja',
        'Belanja',
        'manage_options',
        'anggaran-belanja',
        'anggaran_desa_belanja'
    );

    // Submenu: Pembangunan
    add_submenu_page(
        'data-desa',
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
    if (strpos($hook, 'data-desa') === false) {
        return;
    }

    // Load Jquery via CDN
    wp_enqueue_script(
        'custom-jquery',
        'https://code.jquery.com/jquery-3.7.1.js',
        array('jquery'),
        '3.7.1'
    );

    // Load Bootstrap via CDN
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3'
    );

    // Load Bootstrap via CDN
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.3'
    );

    // Load Datatables via CDN
    wp_enqueue_script(
        'datatable-bootstrap-bundle-js',
        'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js',
        array(),
        '5.3.0'
    );

    wp_enqueue_script(
        'datatables-js',
        'https://cdn.datatables.net/2.2.2/js/dataTables.js',
        array(),
        '2.2.2'
    );
    wp_enqueue_script(
        'bootstrap-5-datatable-js',
        'https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js',
        array(),
        '2.2.2'
    );
    wp_enqueue_style(
        'datatables-css',
        'https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css',
        array(),
        '2.2.2'
    );
    wp_enqueue_style(
        'datatable-css-twitter-bootstrap',
        'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css',
        array(),
        '5.3.0'
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

include 'pendapatan-desa.php';
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
