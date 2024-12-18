<!-- untuk mengubah Status dengan function -->
<?php
function changeStatus($status)
{
    switch ($status) {
        case '1':
            $badge = "<span class='badge bg-success'> Selesai Dipesan</span>";
            break;
        default:
            $badge = "<span class='badge bg-warning'> Pesanan Baru</span>";
            break;
    }
    return $badge;
}
