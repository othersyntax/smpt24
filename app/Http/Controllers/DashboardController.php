<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tanah;
use DB;

class DashboardController extends Controller
{
    function index(){

        $milik = DB::select('SELECT
                            Count(tbltanah.tanah_id) AS BIL,
                            SUM(if(tbltanah.tanah_jenis_hakmilik=1,1,0)) AS PTP,
                            SUM(if(tbltanah.tanah_jenis_hakmilik=2,1,0)) AS RIZAB,
                            SUM(if(tbltanah.tanah_jenis_hakmilik=3,1,0)) AS FELDA,
                            SUM(if(tbltanah.tanah_jenis_hakmilik=4,1,0)) AS FELCRA,
                            SUM(if(tbltanah.tanah_jenis_hakmilik=5,1,0)) AS KESEDAR,
                            SUM(if(tbltanah.tanah_jenis_hakmilik=6,1,0)) AS LADA
                            FROM
                            tbltanah');

        $fasiliti = DB::select('SELECT
                            SUM(if(tbltanah.tanah_facilities=1,1,0)) AS adaFasiliti,
                            SUM(if(tbltanah.tanah_facilities=2,1,0)) AS xadaFasiliti
                            FROM
                            tbltanah');
        // dd($fasiliti);
        $bchart=DB::table('tbltanah')
                            ->select('ddsa_kod_negeri.neg_nama_negeri', DB::raw('COUNT(tbltanah.tanah_id) AS BIL'))
                            ->join('ddsa_kod_negeri','tbltanah.tanah_kod_negeri', '=', 'ddsa_kod_negeri.neg_kod_negeri')
                            ->where('ddsa_kod_negeri.neg_status', 1)
                            ->groupBy('ddsa_kod_negeri.neg_nama_negeri')
                            ->get();

        $bchart1=DB::table('tbltanah')
                            ->select('tblptj.ptj_nama', DB::raw('COUNT(tbltanah.tanah_id) AS BIL'))
                            ->join('tblptj','tbltanah.tanah_pk_id', '=', 'tblptj.ptj_id')
                            ->where('tblptj.ptj_status', 1)
                            ->groupBy('tblptj.ptj_nama')
                            ->get();


        $mapchart=DB::table('tbltanah')
                            ->select('ddsa_kod_negeri.neg_maps_code', 'ddsa_kod_negeri.neg_nama_negeri', DB::raw('COUNT(tbltanah.tanah_id) AS BIL'))
                            ->join('ddsa_kod_negeri','tbltanah.tanah_kod_negeri', '=', 'ddsa_kod_negeri.neg_kod_negeri')
                            ->groupBy('ddsa_kod_negeri.neg_maps_code', 'ddsa_kod_negeri.neg_nama_negeri')
                            ->get();

        foreach ($mapchart as $mc) {
           $mdata[] = "['".$mc->neg_maps_code."',".$mc->BIL."]";
        }
        // dd($mapchart);

        foreach($bchart1 as $d){
            $xdata[] = $d->ptj_nama;
            $ydata[] = $d->BIL;
        }

        $mapnegeri[] = ['Negeri', 'Jumlah Lot'];
        foreach($mapchart as $key=>$value){
            $mapnegeri[] = [array('v'=>$value->neg_maps_code, 'f'=>$value->neg_nama_negeri), $value->BIL];
        }

        // dd($xdata);

        $data['milik'] = $milik;
        $data['xdata'] = $xdata;
        $data['ydata'] = $ydata;
        $data['bchart'] = $bchart;
        $data['mapchart'] = $mdata;
        $data['mapnegeri'] = $mapnegeri;
        $data['fasiliti'] = $fasiliti;

        // dd($mapnegeri);

        return view('dashboard.index', $data);
    }
}
