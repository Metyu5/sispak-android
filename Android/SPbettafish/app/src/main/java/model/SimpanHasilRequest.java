package model;

import com.google.gson.annotations.SerializedName;
import java.util.Map;

public class SimpanHasilRequest {

    @SerializedName("nama_pengguna")
    private String namaPengguna;  // Properti untuk nama pengguna

    @SerializedName("nama_penyakit")
    private String namaPenyakit;

    // Menggunakan Map untuk menyimpan gejala dengan key-value
    @SerializedName("gejala_kategori")
    private Map<String, String> gejalaKategori;

    @SerializedName("hasil_diagnosa")
    private String hasilDiagnosa;

    @SerializedName("tanggal_diagnosa")
    private String tanggalDiagnosa;

    // Getter dan Setter untuk nama_pengguna
    public String getNamaPengguna() {
        return namaPengguna;
    }

    public void setNamaPengguna(String namaPengguna) {
        this.namaPengguna = namaPengguna;
    }

    // Getter dan Setter untuk nama_penyakit
    public String getNamaPenyakit() {
        return namaPenyakit;
    }

    public void setNamaPenyakit(String namaPenyakit) {
        this.namaPenyakit = namaPenyakit;
    }

    // Getter dan Setter untuk gejala_kategori
    public Map<String, String> getGejalaKategori() {
        return gejalaKategori;
    }

    public void setGejalaKategori(Map<String, String> gejalaKategori) {
        this.gejalaKategori = gejalaKategori;
    }

    // Getter dan Setter untuk hasil_diagnosa
    public String getHasilDiagnosa() {
        return hasilDiagnosa;
    }

    public void setHasilDiagnosa(String hasilDiagnosa) {
        this.hasilDiagnosa = hasilDiagnosa;
    }

    // Getter dan Setter untuk tanggal_diagnosa
    public String getTanggalDiagnosa() {
        return tanggalDiagnosa;
    }

    public void setTanggalDiagnosa(String tanggalDiagnosa) {
        this.tanggalDiagnosa = tanggalDiagnosa;
    }
}
