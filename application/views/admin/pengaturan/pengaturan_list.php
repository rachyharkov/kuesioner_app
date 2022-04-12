<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Pengaturan</h5>
                <p class="category">Kelola bagaimana aplikasi kuesioner dapat bekerja untuk anda sesuai keinginan</p>
            </div>
            <div class="card-body all-icons">
                <div class="row">
                    <?php
                    $arrsettinglist = [
                        0 => [
                            'nama_menu' => 'Import',
                            'url' => 'backup?action=import',
                            'icon' => 'now-ui-icons arrows-1_cloud-upload-94' 
                        ],
                        1 => [
                            'nama_menu' => 'Export',
                            'url' => 'backup?action=export',
                            'icon' => 'now-ui-icons arrows-1_cloud-download-93' 
                        ],
                        2 => [
                            'nama_menu' => 'Form Individual Template',
                            'url' => 'pengaturan/form_individu',
                            'icon' => 'now-ui-icons files_paper' 
                        ],
                        3 => [
                            'nama_menu' => 'Tema',
                            'url' => 'pengaturan/tema',
                            'icon' => 'now-ui-icons design_palette' 
                        ],
                        4 => [
                            'nama_menu' => 'Akun',
                            'url' => '#',
                            'icon' => 'now-ui-icons users_single-02' 
                        ],
                        5 => [
                            'nama_menu' => 'User Management',
                            'url' => '#',
                            'icon' => 'now-ui-icons users_single-02' 
                        ],
                        6 => [
                            'nama_menu' => 'Agenda',
                            'url' => '#',
                            'icon' => 'now-ui-icons education_agenda-bookmark'
                        ],
                        7 => [
                            'nama_menu' => 'Calendar Management',
                            'url' => '#',
                            'icon' => 'now-ui-icons ui-1_calendar-60'
                        ]
                    ];

                    foreach ($arrsettinglist as $key => $value) {
                        ?>
                        <div class="font-icon-list col-lg-2 col-md-3 col-sm-4 col-xs-6 col-xs-6">
                            <div class="font-icon-detail">
                                <i class="<?= $value['icon'] ?>"></i>
                                <p><a href="<?= $value['url'] ?>"><?= $value['nama_menu'] ?></a></p>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>