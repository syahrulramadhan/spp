<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th class="text-center col-small">NO</th>
        <th>KL/Pemda</th>
        <?php if($result_jenis_advokasi){ foreach($result_jenis_advokasi as $rows): ?>
        <th class="text-center"><?= $rows['nama_jenis_advokasi'] ?></th>
        <?php endforeach; } ?>
    </tr>
    </thead>
    <tbody>
    <?php
        if($result){
            $i = 1;

            foreach($result as $rows):
                $field1 = ($rows['field1']) ? $rows['field1'] : 0;
                $field2 = ($rows['field2']) ? $rows['field2'] : 0;
                $field3 = ($rows['field3']) ? $rows['field3'] : 0;
                $field4 = ($rows['field4']) ? $rows['field4'] : 0;
                $field5 = ($rows['field5']) ? $rows['field5'] : 0;
                $field6 = ($rows['field6']) ? $rows['field6'] : 0;
                $field7 = ($rows['field7']) ? $rows['field7'] : 0;
                $field8 = ($rows['field8']) ? $rows['field8'] : 0;
                $field9 = ($rows['field9']) ? $rows['field9'] : 0;
            ?>
            <tr>
                <th scope="row" class="text-center"><?= $i++; ?></th>
                <td><?= $rows['nama_klpd']; ?></td>
                <td class="text-center"><?= $field1; ?></td>
                <td class="text-center"><?= $field2; ?></td>
                <td class="text-center"><?= $field3; ?></td>
                <td class="text-center"><?= $field4; ?></td>
                <td class="text-center"><?= $field5; ?></td>
                <td class="text-center"><?= $field6; ?></td>
                <td class="text-center"><?= $field7; ?></td>
                <td class="text-center"><?= $field8; ?></td>
                <td class="text-center"><?= $field9; ?></td>
            </tr>
            <?php endforeach; 
        }else{
            echo '<tr class="text-center"><td colspan="7">Data tidak ditemukan</td></tr>';
        }
        ?>
    </tbody>
</table>