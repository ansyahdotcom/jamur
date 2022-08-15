<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-inner">
    <h4 class="page-title">Testing Data</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form action="test_jarak" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="suhu">Suhu</label>
                        <input type="text" class="form-control" id="suhu" name="suhu" placeholder="Isikan hanya angka, gunakan tanda titik (.) untuk bilangan desimal" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="kelembaban">Kelembaban</label>
                        <input type="text" class="form-control" id="kelembaban" name="kelembaban" placeholder="Isikan hanya angka, gunakan tanda titik (.) untuk bilangan desimal" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="k">Nilai K</label>
                        <input type="number" class="form-control" id="k" name="k" placeholder="Isikan hanya angka" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary text-right mb-3" style="float: right;">Test</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>