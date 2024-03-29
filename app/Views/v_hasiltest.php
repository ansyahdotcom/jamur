<?= $this->extend('layout/template_test'); ?>
<?= $this->section('content'); ?>
<div class="page-inner">
    <h4 class="page-title">Hasil Perhitungan</h4>
    <div class="row">
        <div class="col-md-6">
            <?php foreach ($data_baru as $dt_br) : ?>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="suhu">Suhu</label>
                            <input type="text" value="<?= $dt_br['suhu_br']; ?>" class="form-control" id="suhu" name="suhu" placeholder="Suhu" autocomplete="off" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kelembaban">Kelembaban</label>
                            <input type="text" value="<?= $dt_br['kelembaban_br']; ?>" class="form-control" id="kelembaban" name="kelembaban" placeholder="Kelembaban" autocomplete="off" readonly>
                        </div>
                    </div>
                </div>
                <h2><strong>Kesimpulan</strong></h2>
                <h3>Perkiraan hasil produksi :
                    <strong>
                        <?php if ($dt_br['id_kt'] == 1) {
                            echo "Rendah";
                        } else if ($dt_br['id_kt'] == 2) {
                            echo "Sedang";
                        } else if ($dt_br['id_kt'] == 3) {
                            echo "Tinggi";
                        } else {
                            echo "Tidak ada";
                        } ?>
                    </strong>
                </h3>
            <?php endforeach; ?>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jarak</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_jarak as $dt_jr) :
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $dt_jr['jarak']; ?></td>
                                        <td><?= $dt_jr['nama_kt']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>