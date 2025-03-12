package model;

public class Gejala {
    private int id_gejala;
    private String nama_gejala;
    private double nilai_cf;

    // Getter dan Setter
    public int getId_gejala() {
        return id_gejala;
    }

    public void setId_gejala(int id_gejala) {
        this.id_gejala = id_gejala;
    }

    public String getNama_gejala() {
        return nama_gejala;
    }

    public void setNama_gejala(String nama_gejala) {
        this.nama_gejala = nama_gejala;
    }

    public double getNilai_cf() {
        return nilai_cf;
    }

    public void setNilai_cf(double nilai_cf) {
        this.nilai_cf = nilai_cf;
    }

    @Override
    public String toString() {
        return "Gejala{id_gejala=" + id_gejala + ", nama_gejala='" + nama_gejala + "', nilai_cf=" + nilai_cf + "}";
    }
}

