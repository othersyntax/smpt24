<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use App\Models\Tanah;
use App\Models\Daerah;
use App\Models\Bandar;
use App\Models\Penilaian;
use App\Models\Dokumen;
use App\Models\Fasiliti;
use App\Models\Isu;
use App\Models\Bayaran;

class CetakTanahController extends Controller
{
    public function generatePDF(string $tanah_id){

        // $tanah = Tanah::find(decrypt($tanah_id));
        $tanah = \DB::table('tbltanah')
                ->leftJoin('ddsa_kod_bandar','tbltanah.tanah_kod_bandar','ddsa_kod_bandar.ban_kod_bandar')
                ->leftJoin('ddsa_kod_daerah', 'tbltanah.tanah_kod_daerah', 'ddsa_kod_daerah.dae_kod_daerah')
                ->leftJoin('ddsa_kod_negeri', 'tbltanah.tanah_kod_negeri', 'ddsa_kod_negeri.neg_kod_negeri')
                ->leftJoin('tblptj', 'tbltanah.tanah_pk_id', 'tblptj.ptj_id')
                ->where('tanah_id', decrypt($tanah_id))
                ->select('tbltanah.*',  'ddsa_kod_negeri.neg_nama_negeri', 'ddsa_kod_daerah.dae_nama_daerah', 'ddsa_kod_bandar.ban_nama_bandar', 'tblptj.ptj_nama')->first();

        $nilai = Penilaian::where('pen_tanah_id',decrypt($tanah_id))->get();
        $dokumen = Dokumen::where('doc_tanah_id',decrypt($tanah_id))->get();
        $fasiliti = Fasiliti::where('fas_tanah_id',decrypt($tanah_id))->get();
        $isu = Isu::where('isue_tanah_id',decrypt($tanah_id))->get();
        $bayaran = Bayaran::where('bayar_tanah_id', decrypt($tanah_id))->get();

        $nearest = Tanah::where('tanah_kod_daerah', $tanah->tanah_kod_daerah)->get();

        foreach($nearest as $event){
            if($event->tanah_longitud!='' && $event->tanah_latitud!=''){
                $coordinates[] = [$event->tanah_latitud,  $event->tanah_longitud, $event->tanah_desc];  
            }
            
        }

        $data['title'] = "Maklumat Tanah";
        $data['date'] = date('d-m-Y');
        $data['tanah'] = $tanah;
        $data['nilai'] = $nilai;
        $data['dokumen'] = $dokumen;
        $data['fasiliti'] = $fasiliti;
        $data['isu'] = $isu;
        $data['bayaran'] = $bayaran;
        $data['coordinates'] = $coordinates;
        // dd( $coordinates);

        $pdf = PDF::loadView('tanah.cetak', $data);
        return $pdf->stream('tanah.cetak', array("Attachment" => false, $data,));
        // return view('tanah.cetak', $data);
    }
}
