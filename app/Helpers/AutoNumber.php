<?php 
/**
* 
*/
namespace App\Helpers;
use DB;
class AutoNumber 
{
	public static function autoNumber($table,$primary,$prefix){
        $q=DB::table($table)->select(DB::raw('MAX(RIGHT('.$primary.',3)) as kd_max'));
        $prx=$prefix;
        if($q->count()>0)
        {
            foreach($q->get() as $k)
            {
                $tmp = ((int)$k->kd_max)+1;
                $kd = $prx.date('Ym').sprintf("%04s", $tmp);
            }
        }
        else
        {
            $kd = $prx.date('Ym')."0001";
        }

        return $kd;
    }
}
?>