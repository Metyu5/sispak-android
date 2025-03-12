package uigu.sisteminformasi.spbettafish;

import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.animation.AlphaAnimation;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import model.Penanganan;
import model.SimpanHasilRequest;
import network.ApiService;
import model.ResponseModel;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class HasilDiagnosisActivity extends AppCompatActivity {

    private TextView txvHasilDiagnosis, txvPersentase, txvPenanganan, tvNamaPengguna, tvNamaPenyakit;
    private Button btnKembali, btnSimpan;
    private double finalCF;
    private int penyakitId;
    private Map<String, String> gejalaKategori = new HashMap<>(); // Inisialisasi sebagai HashMap kosong
    private String namaPengguna; // Nama pengguna yang melakukan konsultasi
    private String namaPenyakit; // Nama penyakit yang didiagnosis
    private ImageView imageResults;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_hasil_diagnosis);

        // Menghubungkan tampilan dengan komponen layout
        txvHasilDiagnosis = findViewById(R.id.txvHasilDiagnosis);
        txvPersentase = findViewById(R.id.txvPersentase);
        txvPenanganan = findViewById(R.id.txvPenanganan);
        tvNamaPengguna = findViewById(R.id.tvNamaPengguna);
        tvNamaPenyakit = findViewById(R.id.tvNamaPenyakit);
        btnKembali = findViewById(R.id.btnKembali);
        btnSimpan = findViewById(R.id.btnSimpan);
        imageResults = findViewById(R.id.imageResults);

        // Ambil data dari Intent
        Intent intent = getIntent();
        finalCF = intent.getDoubleExtra("finalCF", 0);
        penyakitId = intent.getIntExtra("penyakitId", -1);
        String gejalaKategoriJson = intent.getStringExtra("gejalaKategori");

        // Deserialisasi gejalaKategoriJson menggunakan Gson
        if (gejalaKategoriJson != null && !gejalaKategoriJson.isEmpty()) {
            try {
                Type type = new TypeToken<Map<String, String>>(){}.getType();
                Gson gson = new Gson();
                gejalaKategori = gson.fromJson(gejalaKategoriJson, type);
            } catch (Exception e) {
                Log.e("HasilDiagnosisActivity", "Error parsing gejalaKategoriJson: " + e.getMessage());
                gejalaKategori = new HashMap<>(); // Jika terjadi error, inisialisasi dengan Map kosong
            }
        }

        // Ambil nama pengguna dari SharedPreferences
        SharedPreferences sharedPreferences = getSharedPreferences("user_data", MODE_PRIVATE);
        namaPengguna = sharedPreferences.getString("nama_pengguna", "User1");

        // Ambil nama penyakit yang dipilih sebelumnya dari SharedPreferences
        namaPenyakit = sharedPreferences.getString("nama_penyakit", "Penyakit Tidak Diketahui");

        // Menampilkan nama pengguna dan nama penyakit
        tvNamaPengguna.setText("Nama : " + namaPengguna);
        tvNamaPenyakit.setText("Penyakit : " + namaPenyakit);

        // Menampilkan hasil diagnosis
        double percentage = finalCF * 100;
        txvHasilDiagnosis.setText("Hasil Diagnosis: ");
        txvPersentase.setText(String.format("%.2f%%", percentage));

        // Mengubah warna berdasarkan persentase
        if (percentage < 50) {
            txvPersentase.setTextColor(getResources().getColor(android.R.color.holo_red_dark));
            imageResults.setImageResource(R.drawable.warning);
            showDefaultPenanganan(percentage);
        } else {
            txvPersentase.setTextColor(getResources().getColor(android.R.color.holo_green_dark));
            if (penyakitId != -1) {
                getPenangananData(penyakitId);
            } else {
                Toast.makeText(this, "Gagal memuat ID penyakit", Toast.LENGTH_SHORT).show();
            }
        }

        // Tombol kembali
        btnKembali.setOnClickListener(v -> onBackPressed());

        // Tombol simpan
        btnSimpan.setOnClickListener(v -> simpanHasilKonsultasi());

        // Animasi
        fadeInAnimation(txvHasilDiagnosis);
        fadeInAnimation(txvPersentase);
        fadeInAnimation(txvPenanganan);
        fadeInAnimation(btnKembali);
    }

    private void fadeInAnimation(View view) {
        AlphaAnimation fadeIn = new AlphaAnimation(0, 1);
        fadeIn.setDuration(1000);  // Durasi animasi 1 detik
        fadeIn.setFillAfter(true);  // Menjaga posisi setelah animasi selesai
        view.startAnimation(fadeIn);
    }

    private void showDefaultPenanganan(double percentage) {
        String defaultPenanganan = "Anda Mendapatkan Hasil Diagnosis: " + String.format("%.2f%%", percentage) + "\n" +
                "Tindakan yang disarankan:\n" +
                "1. Periksa kualitas air secara rutin.\n" +
                "2. Pastikan pakan yang diberikan sesuai dengan kebutuhan ikan.\n" +
                "3. Segera konsultasikan dengan ahli ikan untuk penanganan lebih lanjut.";
        txvPenanganan.setText(defaultPenanganan);
    }

    private void getPenangananData(int penyakitId) {
        Retrofit retrofit = new Retrofit.Builder()
                .baseUrl("http://192.168.1.100/sistempakar/betta_fish_api/")
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        ApiService apiService = retrofit.create(ApiService.class);
        Call<Penanganan> call = apiService.getPenanganan(penyakitId);

        call.enqueue(new Callback<Penanganan>() {
            @Override
            public void onResponse(Call<Penanganan> call, Response<Penanganan> response) {
                if (response.isSuccessful() && response.body() != null) {
                    Penanganan penanganan = response.body();
                    String penangananText = "Anda Mendapatkan Hasil Diagnosis: " + txvPersentase.getText().toString() + "\n" +
                            "Penanganan yang disarankan:\n" +
                            penanganan.getPenanganan();
                    txvPenanganan.setText(penangananText);
                } else {
                    Toast.makeText(HasilDiagnosisActivity.this, "Gagal memuat data penanganan", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<Penanganan> call, Throwable t) {
                Toast.makeText(HasilDiagnosisActivity.this, "Gagal terhubung ke server", Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void simpanHasilKonsultasi() {
        ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Menyimpan hasil konsultasi...");
        progressDialog.setCancelable(false);
        progressDialog.show();

        Retrofit retrofit = new Retrofit.Builder()
                .baseUrl("http://192.168.1.100/sistempakar/betta_fish_api/")
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        ApiService apiService = retrofit.create(ApiService.class);

        SimpanHasilRequest simpanHasilRequest = new SimpanHasilRequest();
        simpanHasilRequest.setNamaPengguna(namaPengguna);
        simpanHasilRequest.setNamaPenyakit(namaPenyakit);

        StringBuilder gejalaStringBuilder = new StringBuilder();
        for (Map.Entry<String, String> entry : gejalaKategori.entrySet()) {
            gejalaStringBuilder.append(entry.getKey()).append(": ").append(entry.getValue()).append("\n");
        }
        // Hanya jika setGejalaKategori() mengharapkan Map
        simpanHasilRequest.setGejalaKategori(gejalaKategori);



        String hasilDiagnosaString = String.format("%.2f%%", finalCF * 100);
        simpanHasilRequest.setHasilDiagnosa(hasilDiagnosaString);

        String tanggalDiagnosa = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(new Date());
        simpanHasilRequest.setTanggalDiagnosa(tanggalDiagnosa);

        Call<ResponseModel> call = apiService.simpanHasil(simpanHasilRequest);

        call.enqueue(new Callback<ResponseModel>() {
            @Override
            public void onResponse(Call<ResponseModel> call, Response<ResponseModel> response) {
                progressDialog.dismiss();
                if (response.isSuccessful() && response.body() != null) {
                    if ("success".equals(response.body().getStatus())) {
                        Toast.makeText(HasilDiagnosisActivity.this, "Data berhasil disimpan", Toast.LENGTH_SHORT).show();
                    } else {
                        Toast.makeText(HasilDiagnosisActivity.this, "Gagal menyimpan data: " + response.body().getMessage(), Toast.LENGTH_SHORT).show();
                    }
                } else {
                    Toast.makeText(HasilDiagnosisActivity.this, "Respons tidak valid", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<ResponseModel> call, Throwable t) {
                progressDialog.dismiss();
                Toast.makeText(HasilDiagnosisActivity.this, "Gagal terhubung ke server: " + t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }
}
