<?php

namespace App\Support;

// NFR-03: pesan validasi berbahasa Indonesia yang jelas.
class Msg
{
    public static function all(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'max.string' => ':attribute maksimal :max karakter.',
            'max.file' => 'Ukuran :attribute maksimal :max KB.',
            'mimes' => ':attribute harus berformat :values.',
            'image' => ':attribute harus berupa gambar.',
            'integer' => ':attribute harus berupa angka.',
            'date' => ':attribute bukan tanggal yang valid.',
            'email' => ':attribute bukan alamat surel yang valid.',
            'in' => 'Pilihan :attribute tidak valid.',
            'min' => ':attribute minimal :min.',
            'between' => ':attribute harus antara :min dan :max.',
            'file' => ':attribute harus berupa berkas.',
            'uploaded' => ':attribute gagal diunggah (periksa batas ukuran server).',
        ];
    }
}
