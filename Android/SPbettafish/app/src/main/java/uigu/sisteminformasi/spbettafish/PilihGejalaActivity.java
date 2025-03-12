package uigu.sisteminformasi.spbettafish;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;

import java.util.ArrayList;
import java.util.List;

import model.Gejala;
import network.ApiService;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class PilihGejalaActivity extends AppCompatActivity {

    private LinearLayout gejalaContainer;
    private int penyakitId;
    private Button btnSubmit;
    private List<Gejala> gejalaList = new ArrayList<>();
    private List<Gejala> cachedGejalaList = new ArrayList<>(); // Cache untuk gejala

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_pilih_gejala);

        gejalaContainer = findViewById(R.id.gejalaContainer);
        btnSubmit = findViewById(R.id.btnSubmit);

        // Mendapatkan ID penyakit dari intent
        penyakitId = getIntent().getIntExtra("penyakitId", -1);

        if (penyakitId != -1) {
            getGejalaData(penyakitId);
        } else {
            Toast.makeText(this, "Gagal memuat ID penyakit", Toast.LENGTH_SHORT).show();
        }

        // Klik tombol submit untuk menghitung diagnosis
        btnSubmit.setOnClickListener(v -> {
            if (validateGejalaSelection()) {
                calculateDiagnosis();
            } else {
                Toast.makeText(PilihGejalaActivity.this, "Pilih semua kategori sebelum menghitung diagnosis!", Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void getGejalaData(int penyakitId) {
        if (!cachedGejalaList.isEmpty()) {
            gejalaList = cachedGejalaList;
            inflateGejalaViews();
            return;
        }

        Retrofit retrofit = new Retrofit.Builder()
                .baseUrl("http://192.168.1.100/sistempakar/betta_fish_api/") // URL backend API
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        ApiService apiService = retrofit.create(ApiService.class);
        Call<List<Gejala>> call = apiService.getGejalaList(penyakitId);

        call.enqueue(new Callback<List<Gejala>>() {
            @Override
            public void onResponse(Call<List<Gejala>> call, Response<List<Gejala>> response) {
                if (response.isSuccessful() && response.body() != null) {
                    cachedGejalaList = response.body(); // Simpan ke cache
                    gejalaList = cachedGejalaList;
                    inflateGejalaViews();
                } else {
                    Toast.makeText(PilihGejalaActivity.this, "Gagal memuat data gejala", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<List<Gejala>> call, Throwable t) {
                Toast.makeText(PilihGejalaActivity.this, "Gagal terhubung ke server", Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void inflateGejalaViews() {
        gejalaContainer.removeAllViews();
        for (Gejala gejala : gejalaList) {
            LayoutInflater inflater = getLayoutInflater();
            View gejalaView = inflater.inflate(R.layout.item_gejala, null);

            // Menampilkan nama gejala pada TextView
            TextView txvGejala = gejalaView.findViewById(R.id.tvNamaGejala);
            txvGejala.setText(gejala.getNama_gejala());

            // Mengambil referensi RadioGroup
            RadioGroup kategoriGroup = gejalaView.findViewById(R.id.kategoriGroup);

            // Menambahkan RadioButton ke dalam RadioGroup
            kategoriGroup.addView(createRadioButton("Tidak", 0));
            kategoriGroup.addView(createRadioButton("Tidak Tahu", 0.2));
            kategoriGroup.addView(createRadioButton("Sedikit Yakin", 0.4));
            kategoriGroup.addView(createRadioButton("Cukup Yakin", 0.6));
            kategoriGroup.addView(createRadioButton("Yakin", 0.8));
            kategoriGroup.addView(createRadioButton("Sangat Yakin", 1));

            // Menambahkan gejala ke dalam container
            gejalaContainer.addView(gejalaView);
        }
    }

    private boolean validateGejalaSelection() {
        for (int i = 0; i < gejalaContainer.getChildCount(); i++) {
            View gejalaView = gejalaContainer.getChildAt(i);
            RadioGroup kategoriGroup = gejalaView.findViewById(R.id.kategoriGroup);
            int selectedId = kategoriGroup.getCheckedRadioButtonId();

            if (selectedId == -1) {
                return false; // Jika ada kategori yang belum dipilih
            }
        }
        return true;
    }

    private void calculateDiagnosis() {
        double finalCF = 0.0;  // Mulai dengan CF = 0.0 untuk gejala pertama
        List<String> gejalaKategoriList = new ArrayList<>(); // Untuk menyimpan gejala dan kategori yang dipilih

        for (int i = 0; i < gejalaContainer.getChildCount(); i++) {
            View gejalaView = gejalaContainer.getChildAt(i);
            RadioGroup kategoriGroup = gejalaView.findViewById(R.id.kategoriGroup);
            int selectedId = kategoriGroup.getCheckedRadioButtonId();

            if (selectedId == -1) {
                // Pastikan pengguna memilih kategori terlebih dahulu
                Toast.makeText(PilihGejalaActivity.this, "Pilih kategori untuk semua gejala", Toast.LENGTH_SHORT).show();
                return;
            }

            RadioButton selectedButton = kategoriGroup.findViewById(selectedId);

            // CF User berdasarkan pilihan pengguna (dari tag RadioButton)
            double cfUser = Double.parseDouble(selectedButton.getTag().toString());

            // CF Pakar yang didapat dari data gejala
            double cfPakar = gejalaList.get(i).getNilai_cf();

            // Hitung CF Combine untuk setiap gejala
            double cfCombine = cfUser * cfPakar;

            // Gabungkan CF Combine dengan hasil sebelumnya
            if (finalCF == 0.0) {
                finalCF = cfCombine;  // Jika pertama kali, set CF Combine sebagai nilai awal
            } else {
                finalCF = finalCF + cfCombine * (1 - finalCF);  // Menggabungkan dengan CF sebelumnya
            }

            // Tambahkan gejala dan kategori ke daftar
            gejalaKategoriList.add("\"" + gejalaList.get(i).getNama_gejala() + "\":\"" + selectedButton.getText().toString() + "\"");
        }

        // Membuat JSON string dari gejala dan kategori
        String gejalaKategori = "{" + String.join(", ", gejalaKategoriList) + "}";

        // Log data yang akan dikirim
        Log.d("PilihGejalaActivity", "Data gejalaKategori: " + gejalaKategori);

        // Kirimkan hasil diagnosis dan penyakitId ke HasilDiagnosisActivity
        Intent intent = new Intent(PilihGejalaActivity.this, HasilDiagnosisActivity.class);
        intent.putExtra("finalCF", finalCF);
        intent.putExtra("penyakitId", penyakitId);
        intent.putExtra("gejalaKategori", gejalaKategori); // Kirim data gejala kategori
        startActivity(intent);
    }


    private RadioButton createRadioButton(String label, double value) {
        RadioButton radioButton = new RadioButton(this);
        radioButton.setText(label);
        radioButton.setTag(String.valueOf(value));
        return radioButton;
    }
}
