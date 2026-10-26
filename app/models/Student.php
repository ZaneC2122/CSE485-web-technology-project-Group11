<?php
class Student
{
    public $ma_sv;
    public $ho_ten;
    public $ngay_sinh;
    public $gioi_tinh;
    public $ten_lop;
    public $nganh;
    public $khoa;
    public $trang_thai;

    public function __construct($ma_sv, $ho_ten, $ngay_sinh, $gioi_tinh, $ten_lop, $nganh, $khoa, $trang_thai)
    {
        $this->ma_sv = $ma_sv;
        $this->ho_ten = $ho_ten;
        $this->ngay_sinh = $ngay_sinh;
        $this->gioi_tinh = $gioi_tinh;
        $this->ten_lop = $ten_lop;
        $this->nganh = $nganh;
        $this->khoa = $khoa;
        $this->trang_thai = $trang_thai;
    }

    // Duong dang '2005-03-14' trong DB thanh '14/03/2005' de hien thi
    public static function formatDate($date)
    {
        if ($date == null) {
            return '';
        }
        return date_format(date_create($date), 'd/m/Y');
    }
}
