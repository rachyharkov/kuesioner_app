<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Backup</h5>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Backup</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <!-- Tab panes -->
                <p style="text-align: center;">Silahkan pilih tindakan yang ingin anda lakukan terkait backup dibawah ini</p>
                <ul class="nav nav-tabs" role="tablist" style="justify-content: center;">
                    <li class="nav-item">
                        <a class="nav-link" href="#export" role="tab" data-toggle="tab"><span><i class="now-ui-icons arrows-1_cloud-download-93"></i></span> Export</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#import" role="tab" data-toggle="tab"><span><i class="now-ui-icons arrows-1_cloud-upload-94"></i></span> Import</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="export">
                        <table class="table table-borderless">
                            <thead>
                                <tr style="font-size: 12px;">
                                    <th>Apa yang ingin anda export?</th>
                                    <th>Jumlah Export</th>
                                    <th>Format</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php
                                $arrthingstoexport = [
                                    0 => [
                                        'nama' => 'Kuesioner'
                                    ],
                                    1 => [
                                        'nama' => 'Respon'
                                    ],
                                    2 => [
                                        'nama' => 'Tema'
                                    ],
                                    3 => [
                                        'nama' => 'Form Individu'
                                    ],
                                ]
                            ?>
                            <tbody>
                            <tr>
                                <td style="width: 20rem;">
                                    <select class="form-control">
                                        <option value="">- pilih -</option>
                                        <?php
                                            foreach ($arrthingstoexport as $key => $value) {
                                                ?>
                                                <option value="<?= $key ?>"><?= $value['nama'] ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control">
                                        <option value="">- pilih -</option>
                                        <option value="all">Semuanya</option>
                                        <option value="few">Beberapa</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control">
                                        <option value="">- pilih -</option>
                                        <option value="json">.json</option>
                                        <option value="excel">.xls</option>
                                        <option value="kap">.kap</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-primary">Export</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="import">
                        <table class="table table-borderless">
                            <thead>
                                <tr style="font-size: 12px;">
                                    <th>Upload</th>
                                    <th>Jumlah</th>
                                    <th>Jenis</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td style="width: 20rem;">
                                    <input type="file" class="form-control">
                                </td>
                                <td>
                                    <select class="form-control">
                                        <option value="">- pilih -</option>
                                        <option value="all">Semuanya</option>
                                        <option value="few">Beberapa</option>
                                    </select>
                                </td>
                                <td>
                                    <p>-</p>
                                </td>
                                <td>
                                    <button class="btn btn-primary">Import</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
</script>