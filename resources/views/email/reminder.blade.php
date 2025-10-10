<!DOCTYPE html>
<html>
<body>
    <p>Kepada Yth.,</p>
    <p>Tim Administrasi Dokumen<br>
    RSUD Kesehatan Kerja Provinsi Jawa Barat</p>

    <p>Sehubungan dengan dokumen berikut:</p>
    <p>
        <strong>{{ $document->judul }}</strong><br>
        Tanggal Penetapan: {{ \Carbon\Carbon::parse($document->tanggal_penetapan)->locale('id')->isoFormat('D MMMM Y') }}
    </p>

    @if(str_contains($monthsText, 'expired'))
        <p>Dokumen tersebut <strong>{{ $monthsText }}</strong>. Mohon untuk dicatat dan ditindaklanjuti sesuai ketentuan yang berlaku.</p>
    @else
        <p>Dokumen tersebut <strong>{{ $monthsText }}</strong>. Kami mohon agar dapat segera ditinjau dan ditindaklanjuti sesuai ketentuan yang berlaku.</p>
    @endif

    <p>Terima kasih atas perhatian dan kerja samanya.</p>

    <p>Hormat kami,<br>
    JDIH RSKK</p>
</body>
</html>
