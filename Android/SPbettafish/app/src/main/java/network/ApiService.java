package network;

import model.Gejala;
import model.HistoryItem;
import model.Penanganan;
import model.Penyakit;
import model.ResponseModel;
import model.SimpanHasilRequest;
import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Query;

import java.util.List;

public interface ApiService {

    // Endpoint untuk mengambil daftar penyakit
    @GET("penyakit_list.php")
    Call<List<Penyakit>> getPenyakitList();  // Mengambil data dalam bentuk list penyakit

    // Method untuk mendapatkan daftar gejala berdasarkan id_penyakit
    @GET("ambil_gejala.php")
    Call<List<Gejala>> getGejalaList(@Query("id_penyakit") int idPenyakit);

    // Endpoint untuk mendapatkan penanganan berdasarkan id_penyakit
    @GET("penanganan.php")
    Call<Penanganan> getPenanganan(@Query("id_penyakit") int penyakitId);

    // Endpoint untuk menyimpan hasil konsultasi menggunakan @Body
    @POST("simpan_hasil_konsultasi.php")
    Call<ResponseModel> simpanHasil(@Body SimpanHasilRequest simpanHasilRequest);

    @GET("getHistory.php")  // Gantilah dengan URL endpoint yang sesuai
    Call<List<HistoryItem>>  getHistory();
}
