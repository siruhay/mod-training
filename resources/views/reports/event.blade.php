@include('training::reports.css')

<table class="report">
    <tbody>
        <tr class="without-border">
            <td><h3>{{ $title }}</h3></td>
        </tr>

        <tr class="without-border">
            <td><h5>PERIODE: {{ $periode }}</h5></td>
        </tr>

        @if($subdistrict)
        <tr class="without-border">
            <td><h5>KECAMATAN: {{ $subdistrict }}</h5></td>
        </tr>
        @endif
    </tbody>
</table>

<table class="report" style="margin-top: 4mm;">
    <tbody>
        <tr>
            <td><b><pre>NO</pre></b></td>
            <td><b><pre>NAMA KEGIATAN</pre></b></td>
            <td><b><pre>KECAMATAN</pre></b></td>
            <td><b><pre>DESA</pre></b></td>
            <td><b><pre>TGL AWAL</pre></b></td>
            <td><b><pre>TGL AKHIR</pre></b></td>
            <td><b><pre>STATUS</pre></b></td>
        </tr>

        @foreach($records as $key => $record)
        <tr>
            <td>{{ $key +1 }}</td>
            <td>{{ $record->name }}</td>
            <td>{{ optional($record->subdistrict)->name }}</td>
            <td>{{ optional($record->village)->name }}</td>
            <td>{{ optional($record->startdate)->format('Y-m-d') }}</td>
            <td>{{ optional($record->finishdate)->format('Y-m-d') }}</td>
            <td>{{ $record->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>