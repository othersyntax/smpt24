<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak</title>
    <link rel="stylesheet" href="{{ asset('/template/css/cetak-tanah.css') }}">
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="crossorigin=""></script>
    <style>
        #map {
                height: 500px;
            }
    </style> --}}
</head>
<body>
<div class="sheet-outer A4">
    <section class="sheet padding-5mm">
        <div class="text-center">
            <img src="{{ asset('/template/dist/img/jata_negara.png')}}" class="pdf-logo" />
            <p>Bahagian Pembangunan, KKM</p>
        </div><br><br>
        <div id="map"></div>       
        <h3 class="text-center ">{{ Str::upper($tanah->tanah_desc) }}</h3>
        <div class="text-center">
            {{-- <table style="margin-top: 20px; margin-left: 2%; border: 1px solid; align:center; width:190mm">
                <tr>
                    <td>
                        
                    </td>
                </tr>
            </table> --}}
            <table style="margin-top: 20px; margin-left: 2%; border: 1px solid; align:center; width:190mm">
                <tr>
                    <td colspan="4" class="text-center" height="40px" valign="top"><b>MAKLUMAT LOKASI</b></td>
                </tr>
                <tr>
                    <td width="15%">PTJ</td>
                    <td width="35%">: {{ Str::upper($tanah->ptj_nama) }}</td>
                    <td width="15%">NEGERI</td>
                    <td width="35%">: {{ Str::upper($tanah->neg_nama_negeri) }}</td>
                </tr>
                <tr>
                    <td width="15%">DAERAH</td>
                    <td width="35%">: {{ Str::upper($tanah->dae_nama_daerah) }}</td>
                    <td width="15%">MUKIM</td>
                    <td width="35%">: {{ Str::upper($tanah->ban_nama_bandar)}}</td>
                </tr>
                <tr>
                    <td width="15%">NO LOT</td>
                    <td width="35%">: {{ Str::upper($tanah->tanah_no_lot) }}</td>
                    <td width="15%">HAK MILIK</td>
                    <td width="35%">: {{ Str::upper($tanah->tanah_no_hakmilik)}}</td>
                </tr>
                <tr>
                    <td width="15%">NO. JKPTG</td>
                    <td width="35%">: {{ Str::upper($tanah->tanah_no_jkptg) }}</td>
                    <td width="15%">KELUASAN</td>
                    <td width="35%">: {{ $tanah->tanah_luas }} {{ Str::upper($tanah->tanah_luas_unit)}}</td>
                </tr>
            </table>
        </div>
    </section>
    <section class="sheet padding-5mm">
        
    </section>
</div>
</body>
{{-- <script>

    var map = L.map('map').setView([{{ $tanah->tanah_latitud }}, {{$tanah->tanah_longitud}}], 13);
    
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

</script> --}}
</html>