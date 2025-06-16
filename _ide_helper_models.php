<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * Class Grading
 *
 * @package App
 * @property int $id
 * @property int $insiden_id
 * @property string $grading_risiko
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Insiden $insiden
 * @property-read \App\Models\User $oleh
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereGradingRisiko($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereInsidenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGrading {}
}

namespace App\Models{
/**
 * Class Insiden
 *
 * @package App
 * @property int $id
 * @property int|null $pasien_id
 * @property int $jenis_insiden_id
 * @property \Illuminate\Support\Carbon $tgl_pasien_masuk
 * @property \Illuminate\Support\Carbon $tanggal_insiden
 * @property string $waktu_insiden
 * @property string $insiden
 * @property string $kronologi
 * @property string $jenis_pelapor
 * @property string|null $jenis_pelapor_lainnya
 * @property string $korban_insiden
 * @property string|null $korban_insiden_lainnya
 * @property string $layanan_insiden
 * @property string|null $layanan_insiden_lainnya
 * @property array<array-key, mixed>|null $kasus_insiden
 * @property string|null $kasus_insiden_lainnya
 * @property string $tempat_kejadian
 * @property int $unit_id
 * @property string $dampak_insiden
 * @property int $pernah_terjadi
 * @property string $status_pelapor
 * @property int $created_by
 * @property string|null $created_sign
 * @property int|null $received_by
 * @property string|null $received_sign
 * @property \Illuminate\Support\Carbon|null $received_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Grading|null $grading
 * @property-read \App\Models\InvestigasiSederhana|null $investigasi_sederhana
 * @property-read \App\Models\JenisInsiden $jenis
 * @property-read \App\Models\JenisInsiden $jenisInsiden
 * @property-read \App\Models\User $oleh
 * @property-read \App\Models\Pasien|null $pasien
 * @property-read \App\Models\User|null $penerima
 * @property-read \App\Models\Tindakan|null $tindakan
 * @property-read \App\Models\Unit $unit
 * @method static \Database\Factories\InsidenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereCreatedSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereDampakInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereJenisInsidenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereJenisPelapor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereJenisPelaporLainnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereKasusInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereKasusInsidenLainnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereKorbanInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereKorbanInsidenLainnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereKronologi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereLayananInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereLayananInsidenLainnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden wherePasienId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden wherePernahTerjadi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereReceivedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereReceivedSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereStatusPelapor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereTanggalInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereTempatKejadian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereTglPasienMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereWaktuInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperInsiden {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $kepala_id
 * @property int $insiden_id
 * @property string $penyebab_insiden
 * @property string $penyebab_melatarbelakangi
 * @property string $rekomendasi
 * @property int $penanggung_jawab_rekomendasi
 * @property string $tanggal_rekomendasi
 * @property string $tindakan_rekomendasi
 * @property int $penanggung_jawab_tindakan
 * @property string $tanggal_tindakan
 * @property string $tanggal_mulai
 * @property string $tanggal_selesai
 * @property string $lengkap
 * @property string $investigasi_lanjut
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Insiden $insiden
 * @property-read \App\Models\User $kepala
 * @property-read \App\Models\User $pj_rekomendasi
 * @property-read \App\Models\User $pj_tindakan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereInsidenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereInvestigasiLanjut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereKepalaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana wherePenanggungJawabRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana wherePenanggungJawabTindakan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana wherePenyebabInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana wherePenyebabMelatarbelakangi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereTanggalRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereTanggalTindakan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereTindakanRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperInvestigasiSederhana {}
}

namespace App\Models{
/**
 * Class Jabatan
 *
 * @package App
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property string|null $deskripsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperJabatan {}
}

namespace App\Models{
/**
 * Class JenisInsiden
 *
 * @package App
 * @property int $id
 * @property string $alias
 * @property string $nama_jenis_insiden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Insiden> $insidens
 * @property-read int|null $insidens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereNamaJenisInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperJenisInsiden {}
}

namespace App\Models{
/**
 * Class Pasien
 *
 * @package App
 * @property int $id
 * @property string $nama
 * @property string|null $nik Nomor Induk Kependudukan
 * @property int|null $penanggung_biaya_id
 * @property string $no_rekam_medis
 * @property string $tempat_lahir
 * @property \Illuminate\Support\Carbon $tanggal_lahir
 * @property string $jenis_kelamin
 * @property string|null $no_telp
 * @property string|null $email
 * @property string|null $alamat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Insiden> $insidens
 * @property-read int|null $insidens_count
 * @property-read \App\Models\PenanggungBiaya|null $penanggungBiaya
 * @method static \Database\Factories\PasienFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereNoRekamMedis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereNoTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien wherePenanggungBiayaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPasien {}
}

namespace App\Models{
/**
 * Class PenanggungBiaya
 *
 * @package App
 * @property int $id
 * @property string $jenis_penanggung
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pasien> $pasiens
 * @property-read int|null $pasiens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya whereJenisPenanggung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPenanggungBiaya {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RootCauseAnalysis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RootCauseAnalysis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RootCauseAnalysis query()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRootCauseAnalysis {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settings whereValue($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSettings {}
}

namespace App\Models{
/**
 * Class Tindakan
 *
 * @package App
 * @property int $id
 * @property int $insiden_id
 * @property string $content
 * @property string $oleh
 * @property string|null $detail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Insiden $insiden
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereInsidenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTindakan {}
}

namespace App\Models{
/**
 * Class Unit
 *
 * @package App
 * @property int $id
 * @property string $nama_unit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Insiden> $insidens
 * @property-read int|null $insidens_count
 * @method static \Database\Factories\UnitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereNamaUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUnit {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\UserDetail|null $detail
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $user_id
 * @property int $unit_id
 * @property string $departemen
 * @property string|null $no_hp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $jabatan_id
 * @property-read \App\Models\Jabatan $jabatan
 * @property-read \App\Models\Unit $unit
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\UserDetailFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDepartemen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereJabatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUserDetail {}
}

