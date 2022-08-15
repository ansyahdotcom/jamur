<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-inner">
    <h4 class="page-title">Riwayat Testing Data</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Suhu</th>
                                    <th>Kelembaban</th>
                                    <th>Nilai K</th>
                                    <th>Perkiraan Produksi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Suhu</th>
                                    <th>Kelembaban</th>
                                    <th>Nilai K</th>
                                    <th>Perkiraan Produksi</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data_baru as $baru) :
                                    $id_br = $baru['id_br'];
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $baru['suhu_br']; ?></td>
                                        <td><?= $baru['kelembaban_br']; ?></td>
                                        <td><?= $baru['k']; ?></td>
                                        <td>
                                            <?php if ($baru['id_kt'] == 1) {
                                                echo 'Rendah';
                                            } else if ($baru['id_kt'] == 2) {
                                                echo 'Sedang';
                                            } else if ($baru['id_kt'] == 3) {
                                                echo 'Tinggi';
                                            } ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapustr<?= $id_br ?>">
                                                Hapus
                                            </button>
                                        </td>
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

<!-- Modal -->
<?php
foreach ($data_baru as $baru) :
    $id_br = $baru['id_br'];
?>
    <!-- Modal hapus -->
    <div class="modal fade" id="hapustr<?= $id_br; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus data yang dipilih</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="history/hapus" method="post">
                    <div class="modal-body">
                        <?= csrf_field(); ?>
                        <p>Apakah Anda yakin akan menghapus data perhitungan ini?</p>
                        <input type="hidden" name="id_br" value="<?= $id_br; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?= $this->endSection(); ?>