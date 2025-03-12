package model;

import java.util.Map;

public class HistoryItem {
    private String id_konsultasi;
    private String nama_pengguna;
    private String nama_penyakit;
    private String gejala_kategori;
    private String hasil_diagnosa;
    private String tanggal_diagnosa;
    private Map<String, String> gejala; // Menyimpan gejala dan tingkat kepastian

    // Constructor, getters, and setters
    public HistoryItem(String id_konsultasi, String nama_pengguna, String nama_penyakit,
                       String gejala_kategori, String hasil_diagnosa, String tanggal_diagnosa,
                       Map<String, String> gejala) {
        this.id_konsultasi = id_konsultasi;
        this.nama_pengguna = nama_pengguna;
        this.nama_penyakit = nama_penyakit;
        this.gejala_kategori = gejala_kategori;
        this.hasil_diagnosa = hasil_diagnosa;
        this.tanggal_diagnosa = tanggal_diagnosa;
        this.gejala = gejala;
    }

    // Getter dan setter untuk gejala
    public Map<String, String> getGejala() {
        return gejala;
    }

    public void setGejala(Map<String, String> gejala) {
        this.gejala = gejala;
    }

    // Getter dan setter untuk properti lainnya
    public String getIdKonsultasi() {
        return id_konsultasi;
    }

    public String getNamaPengguna() {
        return nama_pengguna;
    }

    public String getPenyakit() {
        return nama_penyakit;
    }

    public String getGejalaKategori() {
        return gejala_kategori;
    }

    public String getHasilDiagnosa() {
        return hasil_diagnosa;
    }

    public String getTanggal() {
        return tanggal_diagnosa;
    }
}
