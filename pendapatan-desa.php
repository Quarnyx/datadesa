<?php
function anggaran_desa_pendapatan()
{
    global $wpdb;
    if (isset($_POST['submit'])) {
        $tahun_anggaran = sanitize_text_field($_POST['tahun_anggaran']);
        $jumlah_pendapatan = sanitize_text_field(preg_replace("/[^0-9]/", "", $_POST['jumlah_pendapatan']));
        $pendapatan_asli = sanitize_text_field(preg_replace("/[^0-9]/", "", $_POST['pendapatan_asli']));
        $pendapatan_transfer = sanitize_text_field(preg_replace("/[^0-9]/", "", $_POST['pendapatan_transfer']));
        $dana_desa = sanitize_text_field(preg_replace("/[^0-9]/", "", $_POST['dana_desa']));
        $alokasi_dana = sanitize_text_field(preg_replace("/[^0-9]/", "", $_POST['alokasi_dana']));
        $bagi_hasil = sanitize_text_field(preg_replace("/[^0-9]/", "", $_POST['bagi_hasil']));
        $bantuan_keuangan = sanitize_text_field(preg_replace("/[^0-9]/", "", $_POST['bantuan_keuangan']));

        $table_name = $wpdb->prefix . 'pendapatan_desa';

        $data = [
            'Pendapatan Asli Desa' => $pendapatan_asli,
            'Pendapatan Transfer Desa' => $pendapatan_transfer,
            'Dana Desa' => $dana_desa,
            'Alokasi Dana Desa' => $alokasi_dana,
            'Bagi Hasil Desa' => $bagi_hasil,
            'Bantuan Keuangan Desa' => $bantuan_keuangan,
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
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card" style="padding: 0; max-width: none;">
                        <h5 class="card-header">Data Anggaran</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Anggaran Pendapatan Desa</h3>
                                    <p>Isi atau tampilkan data pendapatan desa di sini.</p>
                                </div>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Pendapatan</th>
                                        <th>Jumlah</th>
                                        <th>Tahun Anggaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $table_name = $wpdb->prefix . 'pendapatan_desa';
                                    $results = $wpdb->get_results("SELECT * FROM $table_name");
                                    $no = 1;
                                    foreach ($results as $result) {
                                        echo '<tr>';
                                        echo '<td style="width: 10%;">' . $no++ . '</td>';
                                        echo '<td>' . $result->jenis_pendapatan . '</td>';
                                        echo '<td>' . "Rp. " . number_format($result->jumlah, 0, ',', '.') . '</td>';
                                        echo '<td style="width: 15%;">' . $result->tahun_anggaran . '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card" style="max-width: none; padding: 0%;">
                        <h5 class="card-header">Tambah Anggaran</h5>
                        <div class="card-body">
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
                                                <input type="text" class="form-control currency"
                                                    placeholder="Jumlah Pendapatan Desa" name="jumlah_pendapatan">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Pendapatan Asli Desa</label>
                                                <input type="text" class="form-control currency"
                                                    placeholder="Tahun Anggaran" name="pendapatan_asli">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Pendapatan Transfer</label>
                                                <input type="text" class="form-control currency"
                                                    placeholder="Jumlah Pendapatan Desa" name="pendapatan_transfer">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Dana Desa</label>
                                                <input type="text" class="form-control currency" placeholder="Dana Desa"
                                                    name="dana_desa">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Alokasi Dana Desa</label>
                                                <input type="text" class="form-control currency"
                                                    placeholder="Alokasi Dana Desa" name="alokasi_dana">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Bagi Hasil Pajak dna Retribusi</label>
                                                <input type="text" class="form-control currency"
                                                    placeholder="Bagi Hasil Pajak dna Retribusi" name="bagi_hasil">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Bantuan Keuangan Provinsi</label>
                                                <input type="text" class="form-control currency"
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

        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Initialize DataTable on the specified table
            $('.table').DataTable();

            $(".currency").on("keyup", function () {
                var value = $(this).val().replace(/[^\d]/g, "");
                $(this).val("Rp. " + value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."));
            })
        });
    </script>
    <?php

}
