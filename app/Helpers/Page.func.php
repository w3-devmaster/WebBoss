<?php
if ( !function_exists( 'getSeqments' ) )
{
    function getSeqments( $seqment )
    {
        $seqments = [
            'admin'          => 'หน้าแรก',
            'dashboard'      => 'สรุปบัญชี',
            'changepassword' => 'เปลี่ยนรหัสผ่าน',
            'setting'        => 'ตั้งค่าระบบ',
            'bank'           => 'บัญชีธนาคาร',
            'how-to-buy'     => 'วิธีการสั่งซื้อ',
            'how-to-payment' => 'วิธีแจ้งชำระเงิน',
            'about'          => 'เกี่ยวกับเรา',
            'contact'        => 'ติดต่อเรา',
            'privacy-policy' => 'นโยบายความเป็นส่วนตัว',
            'refund-policy'  => 'นโยบายการคืนเงิน',
            'product-policy' => 'นโยบายการคืนสินค้า',
        ];

        return $seqments[$seqment] ?? '...';
    }
}

?>