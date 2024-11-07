<?php

namespace App\Http\Controllers\Premis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Premis\Penyewaan;
use App\Models\Premis\Bayaran;
use App\Models\Tanah;
use DB;
use Carbon\Carbon;

class PenyewaanController extends Controller
{
    function dashboard(){
        return view('premis.dashboard');
    }
    function senarai(Request $req){
        $sewa = DB::table('pre_tblsewa')
                ->select('tbltanah.tanah_id', 'ddsa_kod_negeri.neg_nama_negeri', 'ddsa_kod_bandar.ban_nama_bandar', 'tbltanah.tanah_desc' ,
                        DB::raw('COUNT(pre_tblsewa.penyewaan_id) AS bilangan'))
                ->leftJoin('tblfasiliti', 'pre_tblsewa.peny_fasilti_id','=', 'tblfasiliti.fasiliti_id')
                ->join('tbltanah', 'tblfasiliti.fas_tanah_id','=', 'tbltanah.tanah_id')
                ->join('ddsa_kod_bandar', 'tbltanah.tanah_kod_bandar','=', 'ddsa_kod_bandar.ban_kod_bandar')
                ->join('ddsa_kod_negeri', 'ddsa_kod_bandar.ban_kod_negeri','=', 'ddsa_kod_negeri.neg_kod_negeri')
                ->groupBy('tbltanah.tanah_id', 'ban_nama_bandar', 'neg_nama_negeri', 'tbltanah.tanah_desc')->paginate(20);

        // DB::select(" SELECT
        //                     FROM pre_tblsewa
        //                     INNER JOIN tblfasiliti ON pre_tblsewa.peny_fasilti_id = tblfasiliti.fasiliti_id
        //                     INNER JOIN tbltanah ON tblfasiliti.fas_tanah_id = tbltanah.tanah_id
        //                     INNER JOIN ddsa_kod_bandar ON tbltanah.tanah_kod_bandar = ddsa_kod_bandar.ban_kod_bandar
        //                     INNER JOIN ddsa_kod_negeri ON ddsa_kod_bandar.ban_kod_negeri = ddsa_kod_negeri.neg_kod_negeri
        //                     GROUP BY tbltanah.tanah_id,ban_nama_bandar, neg_nama_negeri");
        // $sewa = $query->paginate(20);
        $data['sewa'] = $sewa;
        return view('premis.senarai', $data);
    }

    function papar(Request $req){
        $tanah_id = $req->tanah;
        $tanah = Tanah::find( $tanah_id);
        $sewaan = DB::select('SELECT pre_tblsewa.*, pre_tblsyarikat.sya_desc, tblfasiliti.fas_desc  FROM pre_tblsewa
        INNER JOIN tblfasiliti ON pre_tblsewa.peny_fasilti_id = tblfasiliti.fasiliti_id
        INNER JOIN pre_tblsyarikat ON pre_tblsewa.peny_syarikat_id = pre_tblsyarikat.syarikat_id
        WHERE tblfasiliti.fas_tanah_id='.$tanah_id);
        $data['sewaan']=$sewaan;
        $data['tanah']=$tanah;
        // dd($sewaan);
        return view('premis.view', $data);
    }

    function sewa(Request $req){
        $penyewaan_id = $req->sewaan;
        $sewaan = Penyewaan::find($penyewaan_id);
        $bayaran = Bayaran::where('byr_penyewaan_id',$penyewaan_id)->get();
        // dd($bayaran);
        $data['sewaan'] =  $sewaan;
        $data['bayaran'] = $bayaran;
        return view('premis.sewa', $data);
    }

    // KONTARK
    public function addKontrak(){
        return view('premis.tambah-kontrak');
    }

    public function simpanSewa(Request $req){
        $sewa = new Penyewaan();
        $sewa->peny_tujuan = $req->peny_tujuan;
        $sewa->peny_syarikat_id = $req->peny_syarikat_id;
        $sewa->peny_no_perjanjian = $req->peny_no_perjanjian;
        $sewa->peny_mula = Carbon::createFromFormat('d/m/Y', $req->peny_mula)->format('Y-m-d');
        $sewa->peny_tamat = Carbon::createFromFormat('d/m/Y', $req->peny_tamat)->format('Y-m-d');
        $sewa->peny_pgw_incharge = $req->peny_pgw_incharge;
        $sewa->peny_cagaran = $req->peny_cagaran;
        $sewa->peny_kadar_sewa = $req->peny_kadar_sewa;
        $sewa->peny_ketua_ptj = $req->peny_ketua_ptj;
        $sewa->peny_fasilti_id = $req->peny_fasilti_id;

        $sewa->save();

        return redirect('/premis/senarai');
    }

    public function simpanBayar(Request $req){
        $bayar = new Bayaran();
        $bayar->byr_penyewaan_id = $req->byr_penyewaan_id;
        $bayar->byr_no_resit = $req->byr_no_resit;
        $bayar->byr_amaun = $req->byr_amaun;
        $bayar->byr_tarikh = Carbon::createFromFormat('d/m/Y', $req->byr_tarikh)->format('Y-m-d');

        // CEK BULAN DAH BAYAR
        $sewa = Penyewaan::where('penyewaan_id',$req->byr_penyewaan_id)->first();
        $dahbayar = Bayaran::where('byr_penyewaan_id',$req->byr_penyewaan_id)->latest('byr_created_at')->first();


        if($dahbayar){
            $bayar->byr_bulan = $dahbayar->byr_bulan + 1;
            if($dahbayar->byr_bulan<=12){
                $bayar->byr_tahun = (int)$dahbayar->byr_tahun;
            }
            else{
                $bayar->byr_tahun = (int)$dahbayar->byr_tahun + 1;
            }

        }
        else{
            $bayar->byr_bulan = (int)date('m', strtotime($sewa->peny_mula));
            $bayar->byr_tahun = (int)date('Y', strtotime($sewa->peny_mula));
        }
        // dd($bayar);

        $bayar->save();

        return redirect('/premis/sewa/'.$req->byr_penyewaan_id);
    }
}
