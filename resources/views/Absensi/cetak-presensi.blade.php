<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Cetak Presensi {{ $kelas->nama_kelas }}</title>
 <style>
  body { 
   font-family: 'Arial', sans-serif; 
   margin: 0; 
   padding: 20px; 
   background-color: #013C58; /* Warna latar belakang untuk tampilan layar */
   color: #fff; /* Warna teks untuk tampilan layar */
  }
  .header { 
   text-align: center; 
   margin-bottom: 20px; 
  }
  .info { 
   margin-bottom: 20px; 
   color: #A8E8F9; /* Warna info untuk tampilan layar */
   text-align: center;
  }
  .table-container { 
   overflow-x: auto; 
  }
  table { 
   width: 100%; 
   border-collapse: collapse; 
   font-size: 11px; /* Dikecilkan sedikit untuk muat lebih banyak kolom */
  }
  th, td { 
   border: 1px solid #A8E8F9; /* Border untuk tampilan layar */
   padding: 4px; /* Padding dikurangi */
   text-align: center; 
   border-radius: 0; /* Menghilangkan border-radius untuk cetak formal */
  }
  th { 
   background-color: #00537A; /* Warna header untuk tampilan layar */
   color: #FFD35B;
  }
  td.nama-siswa { 
   text-align: left; 
   width: 150px; /* Dikecilkan sedikit */
   min-width: 150px;
  }
  /* Status colors for display */
  .status-H { color: #00FF00; font-weight: bold; } /* Hadir */
  .status-I { color: #FFBA42; font-weight: bold; } /* Izin */
  .status-S { color: #FFD35B; font-weight: bold; } /* Sakit */
  .status-A { color: #FF5A5A; font-weight: bold; } /* Alpha */
  .status-N { color: #A8E8F9; font-weight: bold; } /* Belum Ada Data */

  /* ================================================= */
  /* Style untuk Cetak (Print Styles) */
  /* ================================================= */
  @media print {
   /* Mengatur Kertas menjadi A4 Landscape */
   @page { 
    size: A4 landscape; 
    margin: 1cm; /* Margin lebih kecil untuk memaksimalkan ruang */
   }

   body { 
    font-size: 10pt; /* Font size standar untuk cetak */
    color: #000; /* Warna teks hitam saat dicetak */
    background-color: #fff; /* Latar belakang putih */
    padding: 0; 
   }

   .header { margin-bottom: 10px; }
   .header h1 { font-size: 16pt; color: #000; }
   .info { 
    color: #333; /* Warna info menjadi hitam/abu-abu gelap */
    font-size: 10pt;
    margin-bottom: 10px;
   }

   table { 
    font-size: 8pt; /* Font size lebih kecil untuk tabel */
    table-layout: fixed; /* Penting agar lebar kolom merata */
   }
   th, td { 
    border: 1px solid #000; /* Border hitam untuk cetak */
    padding: 2px; 
   }

   th { 
    background-color: #eee !important; /* Latar belakang abu-abu terang */
    color: #000 !important;
   }
   
   /* Menggunakan warna yang aman untuk cetak atau menonaktifkan pewarnaan yang terlalu mencolok */
   .status-H { color: green !important; } 
   .status-I { color: orange !important; } 
   .status-S { color: gold !important; } 
   .status-A { color: red !important; } 
   .status-N { color: #666 !important; } 
   
   /* Pastikan semua warna latar belakang dan teks dicetak */
   * { 
    print-color-adjust: exact !important; 
    -webkit-print-color-adjust: exact !important; 
   }

   .no-print { display: none; }
  }
 </style>
</head>
<body onload="window.print()">

 <div class="header">
    <h1>REKAP PRESENSI BULANAN</h1>
  <div class="info">
   <p><strong>Kelas:</strong> {{ $kelas->nama_kelas ?? 'N/A' }} | <strong>Mata Pelajaran:</strong> {{ $mata_pelajaran->nama_mapel ?? 'N/A' }} | <strong>Periode:</strong> {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</p>
  </div>
 </div>

 <div class="table-container">
  <table>
   <thead>
    <tr>
     <th class="nama-siswa">Nama Siswa</th>
     @foreach ($datesInMonth as $day)
      <th>{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}</th>
     @endforeach
    </tr>
   </thead>
   <tbody>
    @foreach ($siswa as $sw)
     <tr>
      <td class="nama-siswa">{{ $sw->user->name }}</td>
      @foreach ($datesInMonth as $day)
       @php
        $status = $attendanceData[$sw->id][$day] ?? 'N';
        $statusText = substr($status, 0, 1);
        $statusClass = "status-$statusText";
       @endphp
       <td class="{{ $statusClass }}">{{ $statusText }}</td>
      @endforeach
     </tr>
    @endforeach
   </tbody>
  </table>
 </div>

 <div class="info" style="margin-top: 15px; text-align: left; color: #333;">
  <strong>Keterangan:</strong> 
  <span class="status-H">H = Hadir</span>, 
  <span class="status-I">I = Izin</span>, 
  <span class="status-S">S = Sakit</span>, 
  <span class="status-A">A = Alpha</span>, 
  <span class="status-N">N = Belum Ada Data</span>
 </div>
</body>
</html>