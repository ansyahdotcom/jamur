<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-inner">
    <h4 class="page-title">Data Testing</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form action="test_jarak" method="post">
                    <div class="form-group">
                        <label for="suhu">Suhu</label>
                        <input type="number" class="form-control" id="suhu" name="suhu" placeholder="Isikan hanya angka" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="kelembaban">Kelembaban</label>
                        <input type="number" class="form-control" id="kelembaban" name="kelembaban" placeholder="Isikan hanya angka" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="k">K</label>
                        <input type="number" class="form-control" id="k" name="k" placeholder="Isikan hanya angka" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary text-right mb-3" style="float: right;">Test</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">

    </div>
</div>
<?= $this->endSection(); ?>