package model;
public class Penyakit {

    private int id;
    private String nama;

    // Constructor
    public Penyakit(int id, String nama) {
        this.id = id;
        this.nama = nama;
    }

    // Getter untuk id
    public int getId() {
        return id;
    }

    // Setter untuk id
    public void setId(int id) {
        this.id = id;
    }

    // Getter untuk nama
    public String getNama() {
        return nama;
    }

    // Setter untuk nama
    public void setNama(String nama) {
        this.nama = nama;
    }

    @Override
    public String toString() {
        return "Penyakit{" +
                "id=" + id +
                ", nama='" + nama + '\'' +
                '}';
    }
}