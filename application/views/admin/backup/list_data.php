<div class="alert alert-success">
    <?= $messageny ?>
</div>


<table class="table">
    <thead>
        <tr>
            <th>
                No
            </th>
            <th>
                <?= $jenisData ?>
            </th>
            <th>

            </th>
        </tr>
    </thead>
    <tbody id="listDatany">
        <?php

            foreach ($dataList as $key => $value) {
                echo '<tr>';
                echo '<td>' . ($key + 1) . '</td>';
                echo '<td>' . $value->judul_kuesioner . '</td>';
                echo '<td>';
                echo '<a class="btn btn-danger btn-sm" href="'.base_url().'backup/export/'.$jenisDatalowercase.'/'.$value->id_kuesioner.'">Export</button>';
                echo '</td>';
                echo '</tr>';
            }

        ?>
    </tbody>
    
</table>