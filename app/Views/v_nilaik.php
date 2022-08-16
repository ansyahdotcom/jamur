<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-inner">
    <h4 class="page-title">Konfigurasi Nilai K</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form action="nilaik/ubah" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="k">Nilai K</label>
                        <input type="hidden" name="idk" value="<?= $idk; ?>">
                        <input type="number" class="form-control" id="k" name="k" value="<?= $k; ?>" placeholder="Isikan hanya angka" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary text-right mb-3" style="float: right;">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>