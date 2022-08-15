<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-inner">
    <h4 class="page-title">Data Training</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-danger text-right" style="float: right;" data-toggle="modal" data-target="#hapusSemua">
                        Hapus semua data
                    </button>
                    <button type="button" class="btn btn-primary text-right mr-2" style="float: right;" data-toggle="modal" data-target="#importData">
                        Import data
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Suhu</th>
                                    <th>Kelembaban</th>
                                    <th>Produksi</th>
                                    <!-- <th>Aksi</th> -->
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Suhu</th>
                                    <th>Kelembaban</th>
                                    <th>Produksi</th>
                                    <!-- <th>Aksi</th> -->
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($train as $tr) :
                                    $id_awal = $tr['id_awal'];
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $tr['suhu']; ?></td>
                                        <td><?= $tr['kelembaban']; ?></td>
                                        <td><?= $tr['nama_kt']; ?></td>
                                        <!-- <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ubahtr<?= $id_awal ?>">
                                                Ubah
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapustr<?= $id_awal ?>">
                                                Hapus
                                            </button>
                                        </td> -->
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
<div class="modal fade" id="importData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import data training</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="training/import" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="filecsv" class="text-success">Upload file dengan ekstensi .csv/.xlsx/.xls</label>
                        <input type="file" id="filecsv" name="filecsv" class="form-control" placeholder="Import dengan ekstensi .csv" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
foreach ($train as $tr) :
    $id_awal = $tr['id_awal'];
    $suhu = $tr['suhu'];
    $kelembaban = $tr['kelembaban'];
    $produksi = $tr['produksi'];
?>

    <!-- Modal Ubah -->
    <div class="modal fade" id="ubahtr<?= $id_awal; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah data training</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="training/ubah" method="post">
                    <div class="modal-body">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="suhu">Suhu</label>
                            <input type="number" id="suhu" name="suhu" class="form-control" placeholder="Isikan hanya angka" autocomplete="off" required value="<?= $suhu; ?>">
                            <input type="hidden" id="id_awal" name="id_awal" value="<?= $id_awal ?>">
                        </div>
                        <div class="form-group">
                            <label for="kelembaban">Kelembaban</label>
                            <input type="number" id="kelembaban" name="kelembaban" class="form-control" placeholder="Isikan hanya angka" autocomplete="off" required value="<?= $kelembaban; ?>">
                        </div>
                        <div class="form-group">
                            <label for="produksi">Produksi</label>
                            <input type="number" id="produksi" name="produksi" class="form-control" placeholder="Isikan hanya angka" autocomplete="off" required value="<?= $produksi; ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal hapus -->
    <div class="modal fade" id="hapustr<?= $id_awal; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus data training</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="training/hapus" method="post">
                    <div class="modal-body">
                        <?= csrf_field(); ?>
                        <p>Apakah Anda yakin akan menghapus data ini?</p>
                        <input type="hidden" name="id_awal" value="<?= $id_awal; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal hapus semua -->
    <div class="modal fade" id="hapusSemua" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus semua data training</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="training/hapus_semua" method="post">
                    <div class="modal-body">
                        <?= csrf_field(); ?>
                        <p>Apakah Anda yakin akan menghapus semua data?</p>
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