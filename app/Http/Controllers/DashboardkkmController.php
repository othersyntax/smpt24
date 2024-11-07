<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Utiliti;
use Carbon\Carbon;
use DB;

class DashboardkkmController extends Controller
{
    // CONST $nilai = 30000000;
    function index(Request $req){
        $where = '';
        $where1 = '';
        $year= '';
        if ($req->isMethod('post') || $req->has('negeri')){
            if($req->negeri != ''){
                $where .= ' AND neg_kod_negeri= '.$req->negeri;
                $where1 = ' WHERE neg_kod_negeri= '.$req->negeri;

                session(['negeri'=> $req->negeri]);
            }
            else{
                session()->forget(['negeri']); 
            }
            
            if($req->tahun != ''){
                $year=' AND tblutiliti.uti_tahun='.$req->tahun;
                session(['tahun'=> $req->tahun]);
            }
            else{
                session()->forget(['tahun']); 
            }
        }
        else{
            session()->forget(['negeri', 'tahun']);
        }

        $statedata=DB::select('select ddsa_kod_negeri.neg_kod_negeri, ddsa_kod_negeri.neg_nama_negeri,
                                SUM(if(tblutiliti.uti_type=1,tblutiliti.uti_amaun,0)) as eletrik,
                                SUM(if(tblutiliti.uti_type=2,tblutiliti.uti_amaun,0)) as air
                                FROM
                                tblutiliti
                                INNER JOIN tblhospital ON tblutiliti.uti_hospital_id = tblhospital.hosp_ptj_code
                                INNER JOIN ddsa_kod_negeri ON tblhospital.hosp_negeri_id = ddsa_kod_negeri.neg_kod_negeri
                                WHERE
                                1=1 '.$year.' GROUP BY neg_kod_negeri, neg_nama_negeri');
        
        $jumlah=DB::select('select ddsa_kod_negeri.neg_kod_negeri, SUM(if(tblutiliti.uti_type=1, tblutiliti.uti_amaun, 0)) AS eletrik, SUM(if(tblutiliti.uti_type=2, tblutiliti.uti_amaun, 0)) AS air
                            FROM
                            tblutiliti
                            INNER JOIN tblhospital ON tblutiliti.uti_hospital_id = tblhospital.hosp_ptj_code
                            INNER JOIN ddsa_kod_negeri ON tblhospital.hosp_negeri_id = ddsa_kod_negeri.neg_kod_negeri
                            WHERE
                            1=1 '.$year.' '.$where.'
                            GROUP BY ddsa_kod_negeri.neg_kod_negeri');

        $maps=DB::select('select ddsa_kod_negeri.neg_kod_negeri, ddsa_kod_negeri.neg_maps_code, ddsa_kod_negeri.neg_nama_negeri,
                            SUM(tblutiliti.uti_amaun) as amaun
                            FROM
                            tblutiliti
                            INNER JOIN tblhospital ON tblutiliti.uti_hospital_id = tblhospital.hosp_ptj_code
                            INNER JOIN ddsa_kod_negeri ON tblhospital.hosp_negeri_id = ddsa_kod_negeri.neg_kod_negeri
                            WHERE
                            1=1 '.$year.' '.$where.'
                            GROUP BY neg_kod_negeri, neg_nama_negeri, neg_maps_code');

        $tahunan=DB::select('select tblutiliti.uti_tahun as tahun, SUM(tblutiliti.uti_amaun) as amaun FROM
                            tblutiliti 
                            INNER JOIN tblhospital ON tblutiliti.uti_hospital_id = tblhospital.hosp_ptj_code
                            INNER JOIN ddsa_kod_negeri ON tblhospital.hosp_negeri_id = ddsa_kod_negeri.neg_kod_negeri
                            '.$where1 .'
                            GROUP BY tahun');
        //Jika ada state :  //  WHERE      ddsa_kod_negeri.neg_kod_negeri = 13  
        
        $hospital=DB::select('select tblhospital.hospital_id, tblhospital.hosp_name AS hospital,  SUM(tblutiliti.uti_amaun) AS amaun
                                FROM
                                tblutiliti
                                INNER JOIN tblhospital ON tblutiliti.uti_hospital_id = tblhospital.hosp_ptj_code
                                INNER JOIN ddsa_kod_negeri ON tblhospital.hosp_negeri_id = ddsa_kod_negeri.neg_kod_negeri
                                WHERE
                                1=1 '.$year.' ' .$where.'
                                GROUP BY hospital_id, hospital ORDER BY amaun DESC');

        //Barchart
       
        $barData=DB::select('select 
                                tblutiliti.uti_bulan AS Bulan, 
                                SUM(if(tblutiliti.uti_type=1, tblutiliti.uti_amaun, 0)) AS Elektrik, 
                                SUM(if(tblutiliti.uti_type=2, tblutiliti.uti_amaun, 0)) AS Air from `tblutiliti`
                                INNER JOIN tblhospital ON tblutiliti.uti_hospital_id = tblhospital.hosp_ptj_code
                                INNER JOIN ddsa_kod_negeri ON tblhospital.hosp_negeri_id = ddsa_kod_negeri.neg_kod_negeri
                                where 
                                1=1 '.$year.' ' .$where.'
                                group by Bulan 
                                order by CAST(Bulan AS UNSIGNED) asc');
                                // jika nak 6 bulan shj AND tblutiliti.uti_bulan >= MONTH(CURDATE() - interval 5 month)
        
        $result[] = ['Bulan','Elektrik','Air'];
        foreach ($barData as $key => $value) {
            $result[++$key] = [$this->tukarBulan($value->Bulan), (double)$value->Elektrik, (double)$value->Air];
        }
        // $barchart = json_encode($result);


        $mapnegeri[] = ['Negeri', 'Amaun (RM)'];
        foreach($maps as $key=>$value){
            $mapnegeri[] = [array('v'=>$value->neg_maps_code, 'f'=>$value->neg_nama_negeri), (double)$value->amaun];
        }

        // $total=0;
        // foreach($statedata as $d){
        //     $total += $d->amaun;
        // }

        $eletrik=0;
        $air=0;
        foreach($jumlah as $jum){
            $eletrik += $jum->eletrik;
            $air += $jum->air;
        }

        // $data['total'] = $total;
        $data['eletrik'] = $eletrik;
        $data['air'] = $air;
        $data['hospital'] = $hospital;
        // $data['bulanan'] = $bulanan;
        $data['tahunan'] = $tahunan;
        $data['negeri'] = $mapnegeri;
        $data['lsnegeri'] = $statedata;
        $data['barchart'] = $result;
        $data['statedata'] = $statedata;
        // dd($mapnegeri);
        return view('kkm-utiliti.dashboard', $data);
    }

    function tukarBulan($bln){
        if($bln==1)
            return 'Jan';
        else if($bln==2)
            return 'Feb';
        else if($bln==3)
            return 'Mac';
        else if($bln==4)
            return 'Apr';
        else if($bln==5)
            return 'Mei';
        else if($bln==6)
            return 'Jun';
        else if($bln==7)
            return 'Jul';
        else if($bln==8)
            return 'Ogo';
        else if($bln==9)
            return 'Sep';
        else if($bln==10)
            return 'Okt';
        else if($bln==11)
            return 'Nov';
        else
            return 'Dis';
    }

    function ajaxHospital(Request $req){
 	$where ='';
        $hospital_id = $req->hospital_id;
        $tahun = $req->tahun;
	if($tahun != '' || !empty($tahun)){
            $where = " AND tblutiliti.uti_tahun= ". $tahun;
        }

        $datahospital=DB::select('select 
                                    tblutiliti.uti_bulan AS Bulan, 
                                    SUM(if(tblutiliti.uti_type=1, tblutiliti.uti_amaun, 0)) AS Elektrik, 
                                    SUM(if(tblutiliti.uti_type=2, tblutiliti.uti_amaun, 0)) AS Air from `tblutiliti`
                                    INNER JOIN tblhospital ON tblutiliti.uti_hospital_id = tblhospital.hosp_ptj_code
                                    INNER JOIN ddsa_kod_negeri ON tblhospital.hosp_negeri_id = ddsa_kod_negeri.neg_kod_negeri
                                    where 
                                    hospital_id = '.$hospital_id.' '.$where.'
				    group by Bulan 
                                    order by CAST(Bulan AS UNSIGNED) asc');
         echo json_encode($datahospital);
    }
}
