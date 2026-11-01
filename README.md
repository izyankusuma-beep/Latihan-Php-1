# Latihan Individu - PHP Array Multidimensi & IPS

Program PHP untuk menampilkan tabel mata kuliah, nilai huruf, status kelulusan, IPS, dan batas SKS semester depan.

## Fitur
1. Array multidimensi `$matkul` (nama, sks, nilai 0-100)
2. Fungsi helper `hitungBobot($nilai)` -> huruf & bobot
3. Tabel: matkul, SKS, nilai angka, nilai huruf, status (LULUS / MENGULANG)
4. Baris MENGULANG berwarna merah
5. Ringkasan IPS di bawah tabel
6. Batas SKS semester depan: IPS >= 3.00 -> 24 SKS, selain itu 20 SKS

## Konversi Nilai
| Nilai   | Huruf | Bobot |
|---------|-------|-------|
| 85-100  | A     | 4.0   |
| 70-84   | B     | 3.0   |
| 55-69   | C     | 2.0   |
| 40-54   | D     | 1.0   |
| 0-39    | E     | 0.0   |

