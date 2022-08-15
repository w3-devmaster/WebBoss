<?php
if ( !function_exists( 'getSeqments' ) )
{
    function getSeqments( $seqment )
    {
        $seqments = [
            'admin'          => 'หน้าแรก',
            'changepassword' => 'เปลี่ยนรหัสผ่าน',
            'setting'        => 'ตั้งค่าระบบ',
            // ''               => '',
        ];

        return $seqments[$seqment] ?? '...';
    }
}
?>