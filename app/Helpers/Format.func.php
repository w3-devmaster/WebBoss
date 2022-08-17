<?php

if ( !function_exists( 'thai_date_short' ) )
{
    function thai_date_short( $time )
    {
        if ( $time == null )
        {
            return false;
        }

        $thai_month_arr = [
            "0"  => "",
            "1"  => "มกราคม",
            "2"  => "กุมภาพันธ์",
            "3"  => "มีนาคม",
            "4"  => "เมษายน",
            "5"  => "พฤษภาคม",
            "6"  => "มิถุนายน",
            "7"  => "กรกฎาคม",
            "8"  => "สิงหาคม",
            "9"  => "กันยายน",
            "10" => "ตุลาคม",
            "11" => "พฤศจิกายน",
            "12" => "ธันวาคม",
        ];
        $thai_date_return = " " . date( "j", $time );
        $thai_date_return .= " " . $thai_month_arr[date( "n", $time )];
        $thai_date_return .= " " . ( date( "Y", $time ) + 543 );

        return $thai_date_return;
    }
}

if ( !function_exists( 'thai_date' ) )
{
    function thai_date( $time )
    {
        if ( $time == null )
        {
            return false;
        }

        $thai_day_arr   = ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์"];
        $thai_month_arr = [
            "0"  => "",
            "1"  => "มกราคม",
            "2"  => "กุมภาพันธ์",
            "3"  => "มีนาคม",
            "4"  => "เมษายน",
            "5"  => "พฤษภาคม",
            "6"  => "มิถุนายน",
            "7"  => "กรกฎาคม",
            "8"  => "สิงหาคม",
            "9"  => "กันยายน",
            "10" => "ตุลาคม",
            "11" => "พฤศจิกายน",
            "12" => "ธันวาคม",
        ];

        $thai_date_return = $thai_day_arr[date( "w", $time )];
        $thai_date_return .= " ที่ " . date( "j", $time );
        $thai_date_return .= " " . $thai_month_arr[date( "n", $time )];
        $thai_date_return .= " พ.ศ. " . ( date( "Y", $time ) + 543 );

        return $thai_date_return;
    }
}

if ( !function_exists( 'thai_month' ) )
{
    function thai_month( $time )
    {
        if ( $time == null )
        {
            return false;
        }

        $thai_month_arr = [
            "0"  => "",
            "1"  => "มกราคม",
            "2"  => "กุมภาพันธ์",
            "3"  => "มีนาคม",
            "4"  => "เมษายน",
            "5"  => "พฤษภาคม",
            "6"  => "มิถุนายน",
            "7"  => "กรกฎาคม",
            "8"  => "สิงหาคม",
            "9"  => "กันยายน",
            "10" => "ตุลาคม",
            "11" => "พฤศจิกายน",
            "12" => "ธันวาคม",
        ];

        $thai_date_return = $thai_month_arr[date( "n", $time )];
        $thai_date_return .= " " . ( date( "Y", $time ) + 543 );

        return $thai_date_return;
    }
}

if ( !function_exists( 'thai_month_only' ) )
{
    function thai_month_only( $time )
    {
        if ( $time == null )
        {
            return false;
        }

        $thai_month_arr = [
            "0"  => "",
            "1"  => "มกราคม",
            "2"  => "กุมภาพันธ์",
            "3"  => "มีนาคม",
            "4"  => "เมษายน",
            "5"  => "พฤษภาคม",
            "6"  => "มิถุนายน",
            "7"  => "กรกฎาคม",
            "8"  => "สิงหาคม",
            "9"  => "กันยายน",
            "10" => "ตุลาคม",
            "11" => "พฤศจิกายน",
            "12" => "ธันวาคม",
        ];

        $thai_date_return = $thai_month_arr[date( "n", $time )];

        return $thai_date_return;
    }
}

if ( !function_exists( 'thai_date_time' ) )
{
    function thai_date_time( $time )
    {
        if ( $time == null )
        {
            return false;
        }

        $thai_day_arr   = ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์"];
        $thai_month_arr = [
            "0"  => "",
            "1"  => "มกราคม",
            "2"  => "กุมภาพันธ์",
            "3"  => "มีนาคม",
            "4"  => "เมษายน",
            "5"  => "พฤษภาคม",
            "6"  => "มิถุนายน",
            "7"  => "กรกฎาคม",
            "8"  => "สิงหาคม",
            "9"  => "กันยายน",
            "10" => "ตุลาคม",
            "11" => "พฤศจิกายน",
            "12" => "ธันวาคม",
        ];

        $thai_date_return = $thai_day_arr[date( "w", $time )];
        $thai_date_return .= " ที่ " . date( "j", $time );
        $thai_date_return .= " " . $thai_month_arr[date( "n", $time )];
        $thai_date_return .= " พ.ศ. " . ( date( "Y", $time ) + 543 );
        $thai_date_return .= " เวลา " . ( date( "H", $time ) ) . ":";
        $thai_date_return .= date( "i", $time ) . " น.";

        return $thai_date_return;
    }
}

if ( !function_exists( 'thai_date_time_short' ) )
{
    function thai_date_time_short( $time )
    {
        if ( $time == null )
        {
            return false;
        }

        $thai_day_arr   = ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์"];
        $thai_month_arr = [
            "0"  => "",
            "1"  => "มกราคม",
            "2"  => "กุมภาพันธ์",
            "3"  => "มีนาคม",
            "4"  => "เมษายน",
            "5"  => "พฤษภาคม",
            "6"  => "มิถุนายน",
            "7"  => "กรกฎาคม",
            "8"  => "สิงหาคม",
            "9"  => "กันยายน",
            "10" => "ตุลาคม",
            "11" => "พฤศจิกายน",
            "12" => "ธันวาคม",
        ];

        $thai_date_return = date( "j", $time );
        $thai_date_return .= " " . $thai_month_arr[date( "n", $time )];
        $thai_date_return .= " " . ( date( "Y", $time ) + 543 );
        $thai_date_return .= " " . ( date( "H", $time ) ) . ":";
        $thai_date_return .= date( "i", $time );

        return $thai_date_return;
    }
}

if ( !function_exists( 'month_name' ) )
{
    function month_name( $month = NULL )
    {
        $thai_month_arr = [
            "1"  => "มกราคม",
            "2"  => "กุมภาพันธ์",
            "3"  => "มีนาคม",
            "4"  => "เมษายน",
            "5"  => "พฤษภาคม",
            "6"  => "มิถุนายน",
            "7"  => "กรกฎาคม",
            "8"  => "สิงหาคม",
            "9"  => "กันยายน",
            "10" => "ตุลาคม",
            "11" => "พฤศจิกายน",
            "12" => "ธันวาคม",
        ];
        if ( $month != NULL )
        {
            return $thai_month_arr[$month];
        }

        return $thai_month_arr;
    }
}

if ( !function_exists( 'm2t' ) )
{
    function m2t( $number )
    {
        $number  = number_format( $number, 2, '.', '' );
        $numberx = $number;
        $txtnum1 = ['ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ'];
        $txtnum2 = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];
        $number  = str_replace( ",", "", $number );
        $number  = str_replace( " ", "", $number );
        $number  = str_replace( "บาท", "", $number );
        $number  = explode( ".", $number );
        if ( sizeof( $number ) > 2 )
        {
            return 'ทศนิยมหลายตัวนะจ๊ะ';
            exit;
        }
        $strlen  = strlen( $number[0] );
        $convert = '';
        for ( $i = 0; $i < $strlen; $i++ )
        {
            $n = substr( $number[0], $i, 1 );
            if ( $n != 0 )
            {
                if ( $i == ( $strlen - 1 ) AND $n == 1 )
                {
                    $convert .= 'เอ็ด';}
                elseif ( $i == ( $strlen - 2 ) AND $n == 2 )
                {
                    $convert .= 'ยี่';}
                elseif ( $i == ( $strlen - 2 ) AND $n == 1 )
                {
                    $convert .= '';}
                else
                {
                    $convert .= $txtnum1[$n];}
                $convert .= $txtnum2[$strlen - $i - 1];
            }
        }

        $convert .= 'บาท';
        if ( $number[1] == '0' OR $number[1] == '00' OR
            $number[1] == '' )
        {
            $convert .= 'ถ้วน';
        }
        else
        {
            $strlen = strlen( $number[1] );
            for ( $i = 0; $i < $strlen; $i++ )
            {
                $n = substr( $number[1], $i, 1 );
                if ( $n != 0 )
                {
                    if ( $i == ( $strlen - 1 ) AND $n == 1 )
                    {
                        $convert
                        .= 'เอ็ด';}
                    elseif ( $i == ( $strlen - 2 ) AND
                        $n == 2 )
                    {
                        $convert .= 'ยี่';}
                    elseif ( $i == ( $strlen - 2 ) AND
                        $n == 1 )
                    {
                        $convert .= '';}
                    else
                    {
                        $convert .= $txtnum1[$n];}
                    $convert .= $txtnum2[$strlen - $i - 1];
                }
            }
            $convert .= 'สตางค์';
        }
        //แก้ต่ำกว่า 1 บาท ให้แสดงคำว่าศูนย์ แก้ ศูนย์บาท
        if ( $numberx < 1 )
        {
            $convert = "ศูนย์" . $convert;
        }

        //แก้เอ็ดสตางค์
        $len     = strlen( $numberx );
        $lendot1 = $len - 2;
        $lendot2 = $len - 1;
        if (  ( $numberx[$lendot1] == 0 ) && ( $numberx[$lendot2] == 1 ) )
        {
            $convert = substr( $convert, 0, -10 );
            $convert = $convert . "หนึ่งสตางค์";
        }

        //แก้เอ็ดบาท สำหรับค่า 1-1.99
        if ( $numberx >= 1 )
        {
            if ( $numberx < 2 )
            {
                $convert = substr( $convert, 4 );
                $convert = "หนึ่ง" . $convert;
            }
        }

        return $convert;
    }
}

?>